@props(['name'])

@php
    // get sort and direction from query string or set default values
    $sort = request()->input('sort') ?? 'id';
    $direction = request()->input('direction') ?? 'asc';

    // generate link url based on current sort and direction
    $url =
        $name == $sort && $direction == 'asc'
            ? request()->fullUrlWithQuery(['sort' => $name, 'direction' => 'desc'])
            : request()->fullUrlWithQuery(['sort' => $name, 'direction' => 'asc']);
@endphp

<div class="flex items-center">
    <span>{{ $slot }}</span>
    <a href="{{ $url }}">
        @if ($name == $sort && $direction == 'asc')
            <x-ui.svg variant="bars-up" size="sm" />
        @elseif ($name == $sort && $direction == 'desc')
            <x-ui.svg variant="bars-down" size="sm" />
        @else
            <x-ui.svg variant="bars" size="sm" />
        @endif
    </a>
</div>
