@props(['hover' => false])
<tr {{$attributes->merge(['class' => $hover ? 'hover:bg-gray-50' : 'py-3'])}}>
    {{$slot}}
</tr>

