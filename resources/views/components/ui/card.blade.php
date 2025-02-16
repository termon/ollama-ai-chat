<div {{ $attributes->merge(['class' => 'px-6 py-4 shadow-lg overflow-hidden sm:rounded-lg border border-gray-200']) }}>

    @isset($header)
        <div {{ $header->attributes->merge([])->except('class') }} }}
            {{ $header->attributes->class([
                'pt-4 pb-2 mb-2 border-b border-gray-800 ',
                'font-semibold' => !str_contains($header->attributes->get('class'), 'font-'),
                'text-xl' => !str_contains($header->attributes->get('class'), 'text-'),
            ]) }}>
            {{ $header }}
        </div>
    @endisset

    {{ $slot }}

    @isset($footer)
        <div {{ $footer->attributes->merge()->except('class') }}
            {{ $footer->attributes->class([
                'py-2 mt-2 border-t border-gray-800',
                'font-normal' => !str_contains($header->attributes->get('class'), 'font-'),
                'text-md' => !str_contains($header->attributes->get('class'), 'text-'),
            ]) }}>
            {{ $footer }}
        </div>
    @endisset

</div>
