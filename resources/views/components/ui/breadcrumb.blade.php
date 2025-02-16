@props([
    'crumbs' => [],
])

<!-- Breadcrumb -->
<div {{ $attributes->merge(['class' => 'text-sm font-medium px-5 py-3 w-full text-gray-200 border border-gray-200 rounded-lg bg-gray-100 text-gray-900']) }}
    aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1">
        @foreach ($crumbs as $name => $link)
            <li class="inline-flex items-center gap-2">
                @if ($loop->first)
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                        </path>
                    </svg>
                @else
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd"></path>
                    </svg>
                @endif
                <a href="{{ $link }}" @class(['hover:underline hover:font-bold ' => !$loop->last])>
                    {{ $name }}
                </a>
            </li>
        @endforeach
    </ol>
</div>
