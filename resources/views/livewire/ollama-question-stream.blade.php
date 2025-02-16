<?php

use Illuminate\Support\Str;
use Livewire\Volt\Component;

use Cloudstudio\Ollama\Facades\Ollama;

new class extends Component {

    public $query = "";
    public $response = "";

    public function search()
    {
        // clear existing response
        $this->response = "";
      
        try {
            $stream = Ollama::agent("You are a helpful AI Assistant providing medical advice to patients. You should only provide advice that will not harm the patient")
            ->prompt($this->query)
            ->model('phi4')            
            ->stream(true)
            ->ask();

            $responses = Ollama::processStream($stream->getBody(), function($data)  {
                // extract chunk from response
                $chunk = $data['response'];
                
                // append chunk to response generated to date
                $this->response .= $chunk;

                $this->stream(
                    to: 'chat',                    
                    content: Str::markdown($this->response),
                    replace: true // replace with updated content so previous partial parsed content will be replaced
                ); 
            });
           
            // reset the query 
            $this->reset('query');
            
        } catch (\Exception $e) {
            $this->response = $e->getMessage();
        }
    }
}; ?>


<section>   
    <x-ui.header>
        <x-ui.title>Lets Have a Chat</x-ui.title>
    </x-ui.header>
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

