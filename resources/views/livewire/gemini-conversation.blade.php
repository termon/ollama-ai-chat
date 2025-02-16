<?php

use Gemini\Enums\Role;
use Gemini\Data\Content;
use Illuminate\Support\Str;
use Livewire\Volt\Component;
use Gemini\Laravel\Facades\Gemini;


new 
class extends Component {
    
    public $query = "";
    public $response = "";

    public $history = [];
   
    private function addToHistory(string $query, string $response=null): void {
        $this->history[] = ['content' => $query, 'role' => Role::USER];           
        if ($response !== null) {
           $this->history[] = ['content' => $response, 'role' => Role::MODEL];
        }
    }

    private function getHistory(): array {
        return array_map(function ($item) {
                return Content::parse(part: $item['content'], role: $item['role']);           
        }, $this->history);
    }

    public function mount() {
        //$this->addToHistory("You are a helpful and polite AI assistant.");
    }

    public function search()
    {
        // clear existing response
        $this->reset('response');
        
        $this->chat = Gemini::chat()->startChat(history: $this->getHistory());
        
        try {
            $result = $this->chat->sendMessage($this->query);
            $this->response = $result->text();
            $this->addToHistory($this->query, $this->response);

            // reset the query 
            $this->reset('query');   
        } catch(\Exception $e) {
            $this->response = $e->getMessage();
        }    
    }
}; ?>


<section>
    <x-ui.header>
        <div class="flex items-center gap-1">
            <x-ui.title>Lets Have a Conversation</x-ui.title>
            <x-ui.title size="sm">(Multi-turn Conversation)</x-ui.title>
        </div>
    </x-ui.header>

    <x-ui.card class="my-3">
        <x-slot:header>
        <h2>History</h2>
        </x-slot:header>
    
        @foreach ($history as $item )
            @if ($item['role'] == Role::USER)
                <div class="flex gap-2 items-center">
                    <span>User:</span>
                    <span class="bg-gray-100 p-1 mb-2">{!! Str::markdown( $item['content'] ) !!}</span>  
                </div>
            @else  
                <div class="flex gap2">
                    <span>AI:</span>       
                    <span class="bg-gray-50 p-1">{!! Str::markdown( $item['content'] ) !!}</span>
                </div>  
            @endif
        @endforeach

    </x-ui.card>

    <x-ui.card>
        <form wire:submit="search" method="POST">
            <x-ui.form.textarea rows="5" label="Query" name="query" required class="mb-3" wire:model="query" />
            <x-ui.button variant="dark" type="submit">Submit</x-ui.button>
        </form>
    </x-ui.card>
    
            
</section>



