@props(['active'])

<div x-data="{
    activeTab: '{{ $active }}',
    tabs: [],
    tabHeadings: [],
    toggleTabs() {
        this.tabs.forEach(
            tab => tab.data.showIfActive(this.activeTab)
        );
    }
}" x-init="() => {
    tabHeadings = [...$refs.tabs.children].map((tab) => tab.dataset.name);
}"
    class="flex flex-col gap-2 overflow-x-auto border-b border-neutral-300 dark:border-neutral-700">
    <div class="mb-3" role="tablist">
        <template x-for="(tab, index) in tabHeadings" :key="index">
            <button x-text="tab" @click="activeTab = tab; toggleTabs();"
                :class="tab === activeTab ?
                    'font-bold text-black border-b-2 border-black dark:border-white dark:text-white' :
                    'text-neutral-600 font-medium dark:text-neutral-300 dark:hover:border-b-neutral-300 dark:hover:text-white hover:border-b-2 hover:border-b-neutral-800 hover:text-neutral-900 hover:cursor-pointer'"
                class="h-min px-4 py-2" type="button" role="tab" role="tab"
                :aria-selected="(tab === activeTab).toString()" :aria-controls="`tab-panel-${index + 1}`"></button>
        </template>
    </div>

    <div x-ref="tabs" {{ $attributes }}>
        {{ $slot }}
    </div>
</div>
