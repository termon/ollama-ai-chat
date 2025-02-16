@props(['name'])

<div x-data="{
    id: '',
    name: '{{ $name }}',
    show: false,
    showIfActive(active) { this.show = ($el.dataset.name === this.activeTab); }
}" x-init="() => {
    showIfActive();
    $watch('activeTab', () => showIfActive());
}" x-show="show" role="tabpanel" data-name="{{ $name }}"
    {{ $attributes }}>
    {{ $slot }}
</div>
