@props(['label', 'value'])

<div {{ $attributes->merge(['class' => 'flex border-b border-slate-200 sm:py-2 md:py-3 rounded-md']) }}>
    @isset($label)
        <span class="font-bold text-black dark:text-white mr-5">
            {{ $label }}
        </span>
    @endisset

    <span class="text-slate-500 dark:text-slate-100 mr-5">
        {{ isset($value) ? $value : $slot }}
    </span>
</div>
