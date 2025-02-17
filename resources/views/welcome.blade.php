<x-layouts.app>

    <x-ui.tabs active="Question">
        <x-ui.tabs.tab name="Gemini QS">
            <livewire:gemini-question-stream/>
        </x-ui.tabs.tab>
        <x-ui.tabs.tab name="Gemini C">
            <livewire:gemini-conversation/>
        </x-ui.tabs.tab>
        <x-ui.tabs.tab name="Ollama QS">
            <livewire:ollama-question-stream/>
        </x-ui.tabs.tab>
        <x-ui.tabs.tab name="Ollama CS">
            <livewire:ollama-conversation-stream/>
        </x-ui.tabs.tab>
        <x-ui.tabs.tab name="Counter">
            <livewire:counter/>
        </x-ui.tabs.tab>
    </x-ui.tabs.tab>

</x-layouts.app>