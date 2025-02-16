<?php

use Livewire\Volt\Component;

new class extends Component {
    public $count = 0;

    public function increment()
    {
        $this->count++;
    }

    public function decrement()
    {
        $this->count--;
    }
} ?>

<section>
    <x-ui.header>
        <div class="flex items-center gap-1">
            <x-ui.title>Counter</x-ui.title>
            <x-ui.title size="sm">(Example Livewire/Volt Component)</x-ui.title>
        </div>
    </x-ui.header>

    <x-ui.card>
        <div class="flex gap-2">
            <x-ui.button wire:click="increment">+</x-ui.button>
            <span class="text-2xl font-bold">{{ $count }}</span>
            <x-ui.button wire:click="decrement">-</x-ui.button>
        </div>
    </x-ui.card>
</section>