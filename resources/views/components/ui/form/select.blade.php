@props([
    'label' => null,
    'name',
    'value' => null,
    'options' => [],
])

@isset($label)
    <x-ui.form.label for="{{ $name }}">
        {{ $label }}
    </x-ui.form.label>
@endisset

<select id="{{ $name }}" name="{{ $name }}"
    {{ $attributes->merge(['class' => 'border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5']) }}>
    <option {{ $value ? null : 'selected' }}>Choose option...</option>
    @foreach ($options as $key => $val)
        <option value="{{ $key }}" {{ $key == $value ? 'selected' : '' }}>{{ $val }}</option>
    @endforeach
</select>

@error($name)
    <x-ui.form.error>
        {{ $message }}
    </x-ui.form.error>
@enderror
