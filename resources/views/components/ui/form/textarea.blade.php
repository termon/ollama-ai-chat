@props([
    'label' => null,
    'name',
    'value' => null,
])

@isset($label)
    <x-ui.form.label for="{{ $name }}">
        {{ $label }}
    </x-ui.form.label>
@endisset

<textarea id="{{ $name }}" name="{{ $name }}"
    {{ $attributes->merge(['class' => 'border border-gray-300 rounded-md w-full p-2.5 text-gray-700 leading-tight focus:ring-blue-500 focus:border-blue-500']) }}>
{{ $value ?? $slot }}
</textarea>

@error($name)
    <x-ui.form.error>
        {{ $message }}
    </x-ui.form.error>
@enderror
