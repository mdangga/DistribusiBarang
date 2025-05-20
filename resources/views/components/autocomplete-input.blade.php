<div 
  x-data="autocomplete('{{ $endpoint }}', '{{ $formField ?? 'nama_barang' }}', '{{ $idField ?? 'id' }}')"
  class="relative"
  @click.outside="close"
>
  <!-- Hidden input untuk ID -->
  <input type="hidden" name="{{ $name }}_id" x-model="selectedId">

  <!-- Input pencarian -->
  <input type="text"
    x-model="search"
    @input.debounce.300ms="fetchData"
    @keydown.arrow-down.prevent="move(1)"
    @keydown.arrow-up.prevent="move(-1)"
    @keydown.enter.prevent="select"
    class="w-full border px-3 py-2 rounded"
    placeholder="{{ $placeholder }}"
    autocomplete="off"
  >

  <!-- List hasil -->
  <ul 
    x-show="open && results.length"
    x-cloak
    class="absolute z-10 w-full bg-white border rounded mt-1 max-h-48 overflow-auto shadow"
  >
    <template x-for="(item, index) in results" :key="index">
      <li 
        @click="selectItem(item)"
        :class="selected === index ? 'bg-blue-100 font-semibold' : ''"
        class="px-3 py-2 hover:bg-blue-50 cursor-pointer"
        x-text="item[formField]"
      ></li>
    </template>
  </ul>
</div>

<script>
function autocomplete(endpoint, formField, idField) {
  return {
    search: '',
    results: [],
    selectedId: null,
    selected: -1,
    open: false,
    formField: formField,
    idField: idField,

    async fetchData() {
      if (this.search.length < 1) {
        this.results = []
        this.open = false
        return
      }

      try {
        const res = await fetch(`${endpoint}?term=${encodeURIComponent(this.search)}`)
        this.results = await res.json()
        this.open = true
        this.selected = -1
      } catch (e) {
        console.error('Fetch error:', e)
      }
    },

    move(step) {
      if (!this.results.length) return
      this.selected = (this.selected + step + this.results.length) % this.results.length
    },

    select() {
      if (this.selected >= 0) {
        this.selectItem(this.results[this.selected])
      }
    },

    selectItem(item) {
      this.search = item[this.formField]
      this.selectedId = item[this.idField]
      this.open = false
      this.results = []
    },

    close() {
      this.open = false
    }
  }
}
</script>

<style>
[x-cloak] { display: none; }
</style>
