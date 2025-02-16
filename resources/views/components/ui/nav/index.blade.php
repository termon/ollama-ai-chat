<nav {{ $attributes->merge(['class' => 'flex justify-between items-center bg-gray-50 px-4 py-2 border-b border-gray-200']) }}>

    <div class="flex gap-1 lg:gap-2 items-center">
        {{ $slot }}
    </div>

    @isset($center)
        <div class="flex gap-1 lg:gap-2 items-center">
            {{ $center }}
        </div>
    @endisset

    @isset($right)
        <div class="flex gap-1 lg:gap-2 items-center">
            {{ $right }}
        </div>
    @endisset

</nav>
