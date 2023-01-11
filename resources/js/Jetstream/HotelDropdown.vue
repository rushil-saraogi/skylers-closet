<template>
    <jet-dropdown align="right">
        <template #trigger>
            <div
                class="flex text-md border border-gray-300 rounded-md shadow-sm items-center hover:cursor-pointer justify-between focus:outline-none focus:border-gray-300 transition px-3 py-2"
            >
                {{ selected.name || 'Select hotel' }}

                <svg
                    class="ml-2 -mr-0.5 mt-0.1 h-4 w-4"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                >
                    <path
                        fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd"
                    />
                </svg>
            </div>
        </template>

        <template #content>
            <div class="block px-4 py-2 text-xs text-gray-400">
                Select hotel
            </div>

            <div
                v-for="item in list" :key="item.id"
                class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition hover:cursor-pointer "
                :class="{
                    'bg-gray-100': item.id === selected.id
                }"
                @click="$emit('click:hotel', item)"
            >
                {{ item.name }}
            </div>
        </template>
    </jet-dropdown>
</template>

<script>
import JetDropdown from "@/Jetstream/Dropdown.vue";

export default {
    components: {
        JetDropdown,
    },

    props: {
        selected: {
            type: Object,
            default: {},
        },

        list: {
            type: Array,
            default: []
        }
    },
};
</script>
