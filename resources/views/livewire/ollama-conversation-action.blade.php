<?php

use Illuminate\Support\Str;
use Livewire\Volt\Component;

use Cloudstudio\Ollama\Facades\Ollama;

function get_weather($location) {
    return "The temperature in " . $location . " is 23degrees ";
}

new 
class extends Component {
    
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

    public function get_weather($location) {
        return "The temperature in " . $location . " is 23degrees ";
    }

    private function getHistory() {
        return $this->history;
    }

    private function handleToolCalls($response) {
        $toolCalls = $response['message']['tool_calls'] ?? [];
    
        foreach ($toolCalls as $call) {
            $functionName = $call['function']['name'] ?? null;
            $arguments = $call['function']['arguments'] ?? [];
    
            // Check if the function exists
            if (function_exists($functionName)) {
                $result = call_user_func_array($functionName, $arguments);
                return $result;
            } else {
                return "Error: Function '$functionName' not found.";
            }
        }
    }

    
    public function search()
    {
        // clear existing response
        $this->reset('response');
             
        try {
            $this->addToHistory(query:$this->query );

            $result = Ollama:: agent("You are a general purpose AI.")
                                ->model('llama3.2')                              
                                ->prompt($this->query)
                                ->chat($this->getHistory());
             
           
            $this->response = $result['message']['content'];            
            $this->addToHistory(response:$this->response );

            // reset the query 
            $this->reset('query');   
        } catch(\Exception $e) {
            $this->response = $e->getMessage();
        }    
    }

    public function tool_search()
    {
        // clear existing response
        $this->reset('response');
        $tools = [
            [
                "type"     => "function",
                "function" => [
                    "name"        => "get_weather",
                    "description" => "Get the current weather for a location",
                    "parameters"  => [
                        "type"       => "object",
                        "properties" => [
                            "location" => [
                                "type"        => "string",
                                "description" => "The location to get the weather for, e.g. London",
                            ],
                        ],
                        "required"   => ["location"],
                    ],
                ],
            ],
        ];
    
        $prompt = "You are a general purpose AI.";
       
        try {
            
            $this->addToHistory(query:$this->query );

            $result = Ollama:: agent($prompt)
                                ->model('llama3.2')
                                ->tools($tools)
                                ->prompt($this->query)
                                ->chat($this->getHistory());
             
           
            $this->response = $result['message']['content'];
            if ($this->response == "")
               $this->response = $this->handleToolCalls($result);
            
            $this->addToHistory(response:$this->response );

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
            <x-ui.form.textarea rows="5" label="Query" name="query" required class="mb-3" wire:model="query" />
            <x-ui.button variant="dark" type="submit">Submit</x-ui.button>
        </form>
    </x-ui.card>
    
            
</section>



