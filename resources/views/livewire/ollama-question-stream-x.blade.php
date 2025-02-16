<?php

use Illuminate\Support\Str;
use Livewire\Volt\Component;

use Cloudstudio\Ollama\Facades\Ollama;

new class extends Component {

    public $query = "";
    public $response = "";


    function processMarkdownChunks(string $input): string {
        $result = "";
        $buffer = $input;
    
        // Check for unclosed markdown tags (like incomplete code blocks or lists)
        while (true) {
            // Check for incomplete triple backticks for code blocks
            if (substr_count($buffer, '```') % 2 != 0) {
                break;
            }
    
            // Check for incomplete headings, bold, italic, or strikethrough markers
            if (preg_match('/(^|\n)#+\s[^\n]*$/', $buffer) || preg_match('/(\*\*|__|_\*|\*|~)\S*$/', $buffer)) {
                break;
            }
    
            // Convert the complete portion of the buffer to HTML
            $completePart = preg_replace('/(\*\*|__|_\*|\*|~)\S*$/', '', $buffer);
            $result .= Str::markdown($completePart);
            $buffer = substr($buffer, strlen($completePart));
            break;
        }
    
        // Convert any remaining buffer if it's complete
        if ($buffer !== '') {
            $result .= Str::markdown($buffer);
        }
    
        return $result;
    }

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
                // extract chunk from stream
                $chunk = $data['response'];
                // add chunk to response
                $this->response .= $chunk;

                $this->stream(
                    to: 'chat',
                    content: $this->processMarkdownChunks($this->response),
                    replace: true // replace existing content with new updated content                    
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

