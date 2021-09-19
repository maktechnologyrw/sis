@php
if (isset($value)) {
    $value = "value: '$value'";
} else {
    $value = '';
}
@endphp
<div class="form-control">
    <label class="label">
        <span class="label-text dark:text-gray-300">{{ $label }}</span>
    </label>
    <div x-data="select({ data: {{ json_encode($data) }}, emptyOptionsMessage: '{{ $emptyMessage }}', name: '{{ $name }}', placeholder: '{{ $placeholder }}', keyIndex: '{{ $keyIndex }}', valueIndex: '{{ $valueIndex }}', wireBoundBy: '{{ $wireBoundBy }}', {{ $value }}})"
        x-init="init()" @click.away="closeListbox()" @keydown.escape="closeListbox()" class="relative">
        <span :class="{'rounded-b-none': open}"
            class="inline-block w-full select-input border border-gray-300 dark:border-gray-600 shadow-sm">
            <button x-ref="button" @click="toggleListboxVisibility()" :aria-expanded="open" aria-haspopup="listbox"
                :class="{ 'rounded-md': ! open, 'rounded-t-md': open }"
                class="relative z-0 w-full h-full py-2 pl-3 pr-10 text-left transition duration-150 ease-in-out bg-white cursor-default focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5 dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:focus:shadow-outline-gray">
                <span x-show="! open" x-text="value in options ? options[value][valueIndex] : placeholder"
                    :class="{ 'text-gray-500': ! (value in options) }" class="block truncate font-semibold"></span>

                <input x-ref="search" x-show="open" x-model="search" @keydown.enter.stop.prevent="selectOption()"
                    @keydown.arrow-up.prevent="focusPreviousOption()" @keydown.arrow-down.prevent="focusNextOption()"
                    type="search" {{-- x-bind:value="{ value ? options[value][valueIndex] : '' }" --}}
                    class="w-full h-full rounded-md form-control focus:outline-none dark:focus:outline-none dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700" />

                <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                        <path d="M7 7l3-3 3 3m0 6l-3 3-3-3" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                    </svg>
                </span>
            </button>
        </span>

        <div x-show="open" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" x-cloak
            class="absolute z-10 w-full bg-white rounded-t-none rounded-b-md shadow-lg border-b border-l border-r border-t-0 dark:border-gray-600 dark:bg-gray-700">
            <ul x-ref="listbox" @keydown.enter.stop.prevent="selectOption()"
                @keydown.arrow-up.prevent="focusPreviousOption()" @keydown.arrow-down.prevent="focusNextOption()"
                role="listbox" :aria-activedescendant="focusedOptionIndex ? name + 'Option' + focusedOptionIndex : null"
                tabindex="-1"
                class="py-1 overflow-auto text-base leading-6 rounded-t-none rounded-b-md shadow-xs max-h-60 focus:outline-none sm:text-sm sm:leading-5">
                <template x-for="(key, index) in Object.keys(options)" :key="index">
                    <li :id="name + 'Option' + focusedOptionIndex" @click="selectOption()"
                        @mouseenter="focusedOptionIndex = index" @mouseleave="focusedOptionIndex = null" role="option"
                        :aria-selected="focusedOptionIndex === index"
                        :class="{ 'text-white bg-indigo-600': index === focusedOptionIndex, 'text-gray-900': index !== focusedOptionIndex }"
                        class="relative py-2 pl-3 text-gray-900 cursor-default select-none pr-9">
                        <span x-text="Object.values(options)[index][valueIndex]"
                            :class="{ 'font-semibold': index === focusedOptionIndex, 'font-normal': index !== focusedOptionIndex }"
                            class="block font-normal truncate dark:text-white"></span>

                        <span x-show="key === value"
                            :class="{ 'text-white': index === focusedOptionIndex, 'text-indigo-600': index !== focusedOptionIndex }"
                            class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600">
                            <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </span>
                    </li>
                </template>

                <div x-show="! Object.keys(options).length" x-text="emptyOptionsMessage"
                    class="px-3 py-2 text-gray-900 cursor-default select-none dark:text-gray-300"></div>
            </ul>
        </div>

        <script>
            function select(config) {
                return {
                    data: config.data,

                    emptyOptionsMessage: config.emptyOptionsMessage ?? 'No results match your search.',

                    focusedOptionIndex: null,

                    name: config.name,

                    open: false,

                    options: {},

                    placeholder: config.placeholder ?? 'Select an option',

                    search: '',

                    value: config.value,

                    keyIndex: config.keyIndex,

                    valueIndex: config.valueIndex,

                    wireBoundBy: config.wireBoundBy,

                    closeListbox: function() {
                        this.open = false

                        this.focusedOptionIndex = null

                        // this.search = ''
                    },

                    focusNextOption: function() {
                        if (this.focusedOptionIndex === null) return this.focusedOptionIndex = Object.keys(this.options)
                            .length - 1

                        if (this.focusedOptionIndex + 1 >= Object.keys(this.options).length) return

                        this.focusedOptionIndex++

                        this.$refs.listbox.children[this.focusedOptionIndex].scrollIntoView({
                            block: "center",
                        })
                    },

                    focusPreviousOption: function() {
                        if (this.focusedOptionIndex === null) return this.focusedOptionIndex = 0

                        if (this.focusedOptionIndex <= 0) return

                        this.focusedOptionIndex--

                        this.$refs.listbox.children[this.focusedOptionIndex].scrollIntoView({
                            block: "center",
                        })
                    },

                    init: function() {
                        this.options = this.data

                        if (this.wireBoundBy) {
                            this.value = this.$wire.get(this.wireBoundBy);
                        }

                        if (this.value) {
                            this.data.forEach((element, itemIndex) => {
                                console.log({
                                    name: this.name,
                                    data: this.data,
                                    element
                                })
                                if (element[this.keyIndex] == this.value) {
                                    this.search = this.data[itemIndex][this.valueIndex];

                                    this.options = Object.keys(this.data)
                                        .filter((key) => this.data[key][this.valueIndex].toLowerCase().includes(
                                            this.data[itemIndex][this.valueIndex].toLowerCase()))
                                        .reduce((options, key) => {
                                            options[key] = this.data[key]
                                            return options
                                        }, {})

                                    this.value = itemIndex;
                                }
                            });
                            this.$wire.set(this.wireBoundBy, this.data[this.value][this.keyIndex]);
                            console.log({
                                val: this.$wire.get(this.wireBoundBy)
                            })
                        } else {
                            this.value = null
                        }

                        this.$watch('search', ((value) => {
                            if (!this.open || !value) return this.options = this.data

                            // console.log({ value });

                            this.options = Object.keys(this.data)
                                .filter((key) => this.data[key][this.valueIndex].toLowerCase().includes(value
                                    .toLowerCase()))
                                .reduce((options, key) => {
                                    options[key] = this.data[key]
                                    return options
                                }, {})
                        }))
                    },

                    selectOption: function() {
                        if (!this.open) return this.toggleListboxVisibility()

                        this.value = Object.keys(this.options)[this.focusedOptionIndex]

                        this.$wire.set(this.wireBoundBy, this.data[this.value][this.keyIndex]);
                        this.search = this.data[this.value][this.valueIndex];

                        this.closeListbox()
                    },

                    toggleListboxVisibility: function() {
                        if (this.open) return this.closeListbox()

                        this.focusedOptionIndex = Object.keys(this.options).indexOf(this.value)

                        if (this.focusedOptionIndex < 0) this.focusedOptionIndex = 0

                        this.open = true

                        this.$nextTick(() => {
                            this.$refs.search.focus()

                            this.$refs.listbox.children[this.focusedOptionIndex].scrollIntoView({
                                block: "center"
                            })
                        })
                    },
                }
            }
        </script>
    </div>
</div>
