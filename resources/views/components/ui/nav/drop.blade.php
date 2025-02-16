@props([
    'position' => 'right',
    'label' => null,
    'title' => null,
])

@php
    if (isset($title) && isset($label)) {
        throw new \Exception('You can only use title or label, not both');
    }
@endphp

<div x-data="{ open: false }" class="relative text-left">

    <a x-on:click="open=true"
        class="relative flex items-center gap-1 transition-colors duration-300 text-gray-700 hover:text-gray-900 hover:rounded-md hover:font-semibold hover:bg-gray-200 whitespace-no-wrap py-2 px-4"
        href="#">

        @if ($title)
            {{ $title }}
        @elseif($label)
            {{ $label }}
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="h-4 w-4 fill-current ">
                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
            </svg>
        @endif

    </a>

    <ul x-show="open" x-on:click.away="open=false "
        class="{{ $position == 'left' ? 'right-0' : 'left-0' }} absolute mt-1 w-60 min-w-max divide-y divide-gray-100 rounded-md bg-white px-1.5 py-1.5 text-gray-700 shadow-lg text-sm">
        {{ $slot }}
    </ul>
</div>
