{{-- 
    overflow-hidden - clip any content within an element that overflows the bounds of that element
    overflow-x-auto - allow horizontal scrolling if needed 
    min-w-full      - element should take up full width of container
    align-middle    - align element in middle of container which is height of parent
--}}
<div {{$attributes->merge(['class' => 'p-1.5 overflow-hidden overflow-x-auto min-w-full align-middle border rounded-md border-gray-200'])}} >
    <table class="min-w-full divide-y divide-gray-200">

        @isset($thead)
            <thead {{ $thead->attributes->merge(['class' => 'bg-gray-50']) }}>
                {{ $thead }}
            </thead>
        @endisset

        @isset($tbody)
            <tbody {{ $tbody->attributes->merge(['class' =>'divide-y divide-gray-200 font-normal py-6'])}}>
                {{ $tbody }}
            </tbody>
        @endisset

    </table>

</div>

