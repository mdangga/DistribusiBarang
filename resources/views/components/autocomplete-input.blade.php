<!-- components/autocomplete.blade.php -->
<div x-data="autocomplete({
    endpoint: '{{ $endpoint }}',
    formField: '{{ $formField ?? 'nama_barang' }}',
    idField: '{{ $idField ?? 'id' }}',
    minChars: {{ $minChars ?? 1 }},
    debounce: {{ $debounce ?? 300 }}
})" class="relative" @click.outside="close">
    <!-- Hidden Input untuk ID -->
    <input type="hidden" :name="`{{ $name }}_${idField}`" x-model="selectedId">

    <!-- Input Pencarian -->
    <input type="text" x-model="search" @input.debounce="fetchData" @keydown.arrow-down.prevent="move(1)"
        @keydown.arrow-up.prevent="move(-1)" @keydown.enter.prevent="select" class="w-full border px-3 py-2 rounded"
        placeholder="{{ $placeholder }}" autocomplete="off">

    <!-- Loading Indicator -->
    <div x-show="loading" class="absolute inset-y-0 right-3 flex items-center">
        <svg class="animate-spin h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
            </circle>
            <path class="opacity-75" fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
            </path>
        </svg>
    </div>

    <!-- List Hasil -->
    <ul x-show="open && results.length" x-cloak
        class="absolute z-10 w-full bg-white border rounded mt-1 max-h-48 overflow-auto shadow">
        <template x-for="(item, index) in results" :key="index">
            <li @click="selectItem(item)" @mouseenter="selected = index" @mouseleave="selected = -1"
                :class="{
                    'bg-blue-100': selected === index,
                    'font-semibold': selectedItemIds.includes(item[idField])
                }"
                class="px-3 py-2 hover:bg-blue-50 cursor-pointer" x-text="item[formField]"></li>
        </template>

        <!-- Empty State -->
        <li x-show="!results.length && search.length >= minChars && !loading" class="px-3 py-2 text-gray-500 italic">
            No results found for "<span x-text="search"></span>"
        </li>
    </ul>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('autocomplete', (config) => ({
            // Konfigurasi
            endpoint: config.endpoint,
            formField: config.formField,
            idField: config.idField,
            minChars: config.minChars,
            debounce: config.debounce,

            // State
            search: '',
            results: [],
            selectedId: null,
            selected: -1,
            open: false,
            loading: false,
            selectedItemIds: [],

            // Methods
            async fetchData() {
                if (this.search.length < this.minChars) {
                    this.results = [];
                    this.open = false;
                    return;
                }

                this.loading = true;

                try {
                    const response = await fetch(
                        `${this.endpoint}?term=${encodeURIComponent(this.search)}`);

                    if (!response.ok) throw new Error(response.statusText);

                    this.results = await response.json();
                    this.open = true;
                    this.selected = -1;

                } catch (error) {
                    console.error('Autocomplete error:', error);
                    this.results = [];
                } finally {
                    this.loading = false;
                }
            },

            move(step) {
                if (!this.results.length) return;
                this.selected = (this.selected + step + this.results.length) % this.results.length;

                // Auto scroll
                this.$nextTick(() => {
                    const selectedEl = this.$el.querySelector(
                        `li:nth-child(${this.selected + 1})`);
                    selectedEl?.scrollIntoView({
                        block: 'nearest'
                    });
                });
            },

            select() {
                if (this.selected >= 0) {
                    this.selectItem(this.results[this.selected]);
                }
            },

            selectItem(item) {
                this.search = item[this.formField];
                this.selectedId = item[this.idField];
                this.open = false;

                // Dispatch event dengan data lengkap
                this.$dispatch('autocomplete-selected', {
                    selected: item,
                    field: '{{ $name }}'
                }, {
                    bubbles: true
                });
            },

            close() {
                this.open = false;
            }
        }));
    });
</script>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>
