<?php

use Illuminate\Support\Str;
use Livewire\Volt\Component;
use Gemini\Laravel\Facades\Gemini;

new class extends Component {

    public $query = "";
    public $response = "";

    public function search()
    {
        // clear existing response
        $this->reset('response');
        try {
            $stream = Gemini::geminiPro()->streamGenerateContent($this->query);
            foreach ($stream as $response) {
                $chunk = $response->text();
                $this->stream(
                    to: 'chat',
                    content: Str::inlineMarkdown($chunk),
                    replace: false
                );
                // append chunk to response
                $this->response .= $chunk;
            }
            // reset the query 
            $this->reset('query');
            
        } catch (\Exception $e) {
            $this->response = $e->getMessage();
        }
    }
}; ?>


<section>   
    <x-ui.header>
        <x-ui.title>Gemini Question (stream)</x-ui.title>
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

