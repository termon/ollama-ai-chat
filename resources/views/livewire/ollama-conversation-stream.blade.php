<?php

use Illuminate\Support\Str;
use Livewire\Volt\Component;

use Cloudstudio\Ollama\Facades\Ollama;

new class extends Component {

    public $query = "";
    public $response = "";
    public $history = [];

    private function addToHistory(string $query = null, string $response = null): void
    {
        if ($query !== null) {
            $this->history[] = ['content' => $query, 'role' => 'user'];
        }
        if ($response !== null) {
            $this->history[] = ['content' => $response, 'role' => 'assistant'];
        }
    }

    private function getHistory()
    {
        return $this->history;
    }

    public function search()
    {
        try {
            // add query to existing chat history
            $this->addToHistory(query: $this->query);

            $stream = Ollama::agent("You are a helpful AI Assistant providing medical advice to patients. You should only provide advice that will not harm the patient")
                ->prompt($this->query)
                ->model('phi4')
                ->stream(true)
                ->chat($this->getHistory());

            $responses = Ollama::processStream($stream->getBody(), function ($data) {
                // extract chunk from response
                $chunk = $data['message']['content'];

                // append chunk to response generated to date
                $this->response .= $chunk;

                $this->stream(
                    to: 'chat',
                    content: Str::markdown($this->response),
                    replace: true // replace with updated content so previous partial parsed content will be replaced
                );
            });
            // add response to current history 
            $this->addToHistory(response: $this->response);

            // reset the query & response
            $this->reset('query');
            $this->reset('response');
        } catch (\Exception $e) {
            $this->response = $e->getMessage();
        }
    }
}; ?>


<section>
    <x-ui.header>
        <div class="flex items-center gap-1">
            <x-ui.title>Lets Have a Conversation</x-ui.title>
            <x-ui.title size="sm">(Multi-turn Conversation Stream)</x-ui.title>
        </div>
    </x-ui.header>
    <x-ui.card class="my-3">

        @foreach ($history as $item )
            @if ($item['role'] == 'user')
                <div class="flex gap-2 items-center mb-2 w-full">
                    <x-ui.svg variant="user" />
                    <span class="bg-gray-50 rounded-md p-3">{!! Str::markdown($item['content']) !!}</span>
                </div>
            @else
                <div class="flex gap-2 items-center mb-2 w-full">
                    <x-ui.svg variant="eye" />
                    <span class="bg-gray-50 rounded-md p-3">{!! Str::markdown($item['content']) !!}</span>
                </div>
            @endif
            @if($item['role']!="user") <div class="border-b my-2 w-full"></div> @endif
        @endforeach

        <span class="my-5">
            <span wire:stream="chat">{!! Str::markdown($response) !!}</span>
        </span>

        <form wire:submit="search" method="POST" class="card rounded-md my-3">            
            <div class="flex gap-2 items-center mb-2 w-full">
                <x-ui.svg variant="user" />
                <x-ui.form.textarea rows="3" name="query" required class="mb-3" wire:model.live="query" />
            </div>    
            <x-ui.button variant="dark" type="submit">Submit</x-ui.button>
        </form>

    </x-ui.card>

</section>