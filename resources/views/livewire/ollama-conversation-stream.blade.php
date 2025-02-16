<?php

use Illuminate\Support\Str;
use Livewire\Volt\Component;

use Cloudstudio\Ollama\Facades\Ollama;

new class extends Component {

    public $query = "";
    public $response = "";
    public $history = [];
   
   private function addToHistory(string $query=null, string $response=null): void {
       if ($query !== null) {
           $this->history[] = ['content' => $query, 'role' => 'user'];           
       }
       if ($response !== null) {
          $this->history[] = ['content' => $response, 'role' => 'assistant'];
       }
   }

   private function getHistory() {
       return $this->history;
   }

    public function search()
    {
        // clear existing response
        $this->response = "";
      
        try {
            $this->addToHistory(query:$this->query );

            $stream = Ollama::agent("You are a helpful AI Assistant providing medical advice to patients. You should only provide advice that will not harm the patient")
                                ->prompt($this->query)
                                ->model('phi4')            
                                ->stream(true)
                                ->chat($this->getHistory());    
            
            $responses = Ollama::processStream($stream->getBody(), function($data)  {
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

            $this->addToHistory(response:$this->response );
           
            // reset the query 
            $this->reset('query');
            
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
        <x-slot:header>
        <h2>History</h2>
        </x-slot:header>
    
        @foreach ($history as $item )
            @if ($item['role'] == 'user')
                <div class="flex gap-2 items-center">
                    <span>User:</span>
                    <span class="bg-gray-100 p-1 mb-2">{!! Str::markdown($item['content']) !!}</span>  
                </div>
            @else  
                <div class="flex gap2">
                    <span>AI:</span>       
                    <span class="bg-gray-50 p-1">{!!  Str::markdown($item['content'])  !!}</span>
                </div>  
            @endif
        @endforeach

    </x-ui.card>
    <x-ui.card>       
        <form wire:submit="search" method="POST">
            <x-ui.form.textarea rows="5" label="Query" name="query" required class="mb-3" wire:model="query"/>
            <x-ui.button variant="dark" type="submit">Submit</x-ui.button>
        </form>
        <x-ui.card class="mt-3">
            <span wire:stream="chat">{!! Str::markdown($response) !!}</span> 
        </x-ui.card>
    </x-card> 
</section>  

