@props(['variant' => 'blue'])

@php
    $classes = match ($variant) {
        'blue' => 'text-sm font-medium px-2.5 py-0.5  rounded border border-blue-400   bg-blue-100   text-blue-800',
        'gray' => 'text-sm font-medium px-2.5 py-0.5  rounded border border-gray-500   bg-gray-100   text-gray-800',
        'light' => 'text-sm font-medium px-2.5 py-0.5 rounded border border-gray-100   bg-gray-50    text-gray-800',
        'red' => 'text-sm font-medium px-2.5 py-0.5 rounded border border-red-400    bg-red-100    text-red-800',
        'green' => 'text-sm font-medium px-2.5 py-0.5 rounded border border-green-400  bg-green-100  text-green-800',
        'yellow' => 'text-sm font-medium px-2.5 py-0.5 rounded border border-yellow-300 bg-yellow-100 text-yellow-800',
        'indigo' => 'text-sm font-medium px-2.5 py-0.5 rounded border border-indigo-400 bg-indigo-100 text-indigo-800',
        'purple' => 'text-sm font-medium px-2.5 py-0.5 rounded border border-purple-400 bg-purple-100 text-purple-800',
        'pink' => 'text-sm font-medium px-2.5 py-0.5 rounded border border-pink-400   bg-pink-100   text-pink-800',
        default => throw new \Exception("No such badge variant: $variant"),
    };
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>
