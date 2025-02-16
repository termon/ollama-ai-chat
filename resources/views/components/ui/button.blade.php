@props(['variant' => 'blue'])
@php
    $classes = match ($variant) {
        'blue'
            => 'py-1.5 px-4 text-sm transition-colors font-medium rounded-lg text-gray-100 bg-blue-700   border border-blue-800   hover:bg-blue-900   hover:text-white disabled:opacity-50 focus:outline-none focus:ring-2 focus:ring-blue-900   active:bg-blue-800',
        'red'
            => 'py-1.5 px-4 text-sm transition-colors font-medium rounded-lg text-gray-100 bg-red-700    border border-red-800    hover:bg-red-800    hover:text-white disabled:opacity-50 focus:outline-none focus:ring-2 focus:ring-red-900    active:bg-red-800',
        'green'
            => 'py-1.5 px-4 text-sm transition-colors font-medium rounded-lg text-gray-100 bg-green-700  border border-green-800  hover:bg-green-800  hover:text-white disabled:opacity-50 focus:outline-none focus:ring-2 focus:ring-green-900  active:bg-green-900',
        'yellow'
            => 'py-1.5 px-4 text-sm transition-colors font-medium rounded-lg text-gray-100 bg-yellow-600 border border-yellow-800 hover:bg-yellow-800 hover:text-white disabled:opacity-50 focus:outline-none focus:ring-2 focus:ring-yellow-900 active:bg-yellow-900',
        'dark'
            => 'py-1.5 px-4 text-sm transition-colors font-medium rounded-lg text-gray-100 bg-gray-900   border border-gray-200   hover:bg-gray-700   hover:text-white disabled:opacity-50 focus:outline-none focus:ring-2 focus:ring-gray-900   active:bg-gray-200',
        'light'
            => 'py-1.5 px-4 text-sm transition-colors font-medium rounded-lg text-gray-900 bg-gray-50    border border-gray-200   hover:bg-gray-100   hover:text-black disabled:opacity-50 focus:outline-none focus:ring-2 focus:ring-gray-200   active:bg-gray-200',
        'oblue'
            => 'py-1.5 px-4 text-sm transition-colors font-medium rounded-lg text-blue-600 bg-gray-50    border border-gray-200   hover:bg-blue-600   hover:text-white disabled:opacity-50 focus:outline-none focus:ring-2 focus:ring-blue-600   hover:border-blue-700',
        'ored'
            => 'py-1.5 px-4 text-sm transition-colors font-medium rounded-lg text-red-600  bg-gray-50    border border-gray-200   hover:bg-red-600    hover:text-white disabled:opacity-50 focus:outline-none focus:ring-2 focus:ring-red-600    hover:border-red-700',
        'link'
            => 'py-1.5 px-4 text-sm transition-colors font-medium text-gray-900 hover:text-bold hover:text-black hover:underline',
        'nav'
            => 'transition-colors duration-300 font-medium text-gray-700 hover:text-gray-900 hover:rounded-md hover:font-semibold block hover:bg-gray-200 whitespace-no-wrap py-2 px-4',
        'none' => '',
        default => throw new \Exception("No such button variant: $variant"),
    };
@endphp

<button {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>
