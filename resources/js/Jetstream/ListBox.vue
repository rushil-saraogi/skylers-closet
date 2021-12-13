<template>
  <div>
    <Listbox v-model="selectedOption">
      <div class="relative mt-1">
        <ListboxButton
          class="relative w-full py-2 pl-3 pr-10 text-left border border-gray-300 bg-white rounded-md shadow-sm cursor-default focus:outline-none focus-visible:ring-2 focus-visible:ring-opacity-75 focus-visible:ring-white focus-visible:ring-offset-orange-300 focus-visible:ring-offset-2 focus-visible:border-indigo-500 sm:text-sm"
        >
          <div v-if="selectedOption" class="flex items-center">
            <span
              v-if="selectedOption.icon"
              class="mr-3"
            >
              <component
                :is="selectedOption.icon"
                class="w-4 h-4"
                aria-hidden="true"
                v-bind="selectedOption.iconProps || {}"
              />
            </span>
            <span class="block truncate">{{ selectedOption }}</span>
          </div>
          <span v-else class="block truncate text-gray-500">{{ label }}</span>
          <span
            class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none"
          >
            <SelectorIcon class="w-5 h-5 text-gray-400" aria-hidden="true" />
          </span>
        </ListboxButton>

        <div v-if="error" class="mt-1 text-red-500">{{ error }}</div>

        <transition
          leave-active-class="transition duration-100 ease-in"
          leave-from-class="opacity-100"
          leave-to-class="opacity-0"
        >
          <ListboxOptions
            class="absolute w-full py-1 z-10 mt-1 overflow-auto text-base bg-white rounded-md shadow-lg max-h-60 ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
          >
            <ListboxOption
              v-slot="{ active, selected }"
              v-for="(item, index) in options"
              :key="index"
              :value="item"
              as="template"
            >
              <li
                :class="[
                  active ? 'text-amber-900 bg-amber-100' : 'text-gray-900',
                  $slots.icon ? 'pl-10' : 'pl-4',
                  selected ? 'bg-gray-100' : 'bg-white',
                  'cursor-default select-none relative py-2 pr-4 hover:cursor-pointer hover:bg-gray-100',
                ]"
              >
                <span
                  :class="[
                    selected ? 'font-medium' : 'font-normal',
                    'block truncate',
                  ]"
                  >{{ item }}</span
                >
                <span
                  v-if="$slots.icon"
                  class="absolute inset-y-0 left-0 flex items-center pl-3 text-amber-600"
                >
                  <slot name="icon" :item="item"></slot>
                </span>
              </li>
            </ListboxOption>
          </ListboxOptions>
        </transition>
      </div>
    </Listbox>
  </div>
</template>

<script>
import {
  Listbox,
  ListboxLabel,
  ListboxButton,
  ListboxOptions,
  ListboxOption,
} from '@headlessui/vue'
import { CheckIcon, SelectorIcon } from '@heroicons/vue/solid'

export default {
  components: {
    Listbox,
    ListboxLabel,
    ListboxButton,
    ListboxOptions,
    ListboxOption,
    CheckIcon,
    SelectorIcon,
  },

  emits: ['change'],

  props: {
    options: {
      type: Array,
      default: []
    },

    label: {
      type: String,
      default: 'Select an option'
    },

    selected: {
      type: String,
      default: null,
    },

    error: {
      type: String,
      default: null
    }
  },

  data() {
    return {
      selectedOption: null
    }
  },

  mounted() {
    if (this.selected) {
      this.selectedOption = this.options.find(option => option === this.selected);
    }
  },

  watch: {
    selectedOption(newVal) {
      this.$emit('change', newVal);
    }
  }
}
</script>
