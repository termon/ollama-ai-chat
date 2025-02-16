@props([
    'size' => 'xl',
])
@php
    $classes = match ($size) {
        'xl' => 'text-2xl',
        'lg' => 'text-xl',
        'md' => 'text-base',
        'sm' => 'text-sm',
        default => throw new \Exception("Title: No such size {$size}"),
    };
@endphp
<h1 {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</h1>
