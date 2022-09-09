<template>
    <jet-dropdown align="right" width="48">
        <template #trigger>
            <button
                v-if="selected.name"
                class="flex text-md border border-gray-200 rounded-full items-center focus:outline-none focus:border-gray-300 transition px-3 py-2"
            >
                {{ selected.name }}

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
            </button>
        </template>

        <template #content>
            <!-- Account Management -->
            <div class="block px-4 py-2 text-xs text-gray-400">
                Switch Closet
            </div>

            <jet-dropdown-link
                v-for="item in list" :key="item.id"
                :is-active="item.id === selected.id"
                :href="route('dashboard', {'closet': item.id})"
            >
                {{ item.name }}
            </jet-dropdown-link>
        </template>
    </jet-dropdown>
</template>

<script>
import JetDropdown from "@/Jetstream/Dropdown.vue";
import JetDropdownLink from "@/Jetstream/DropdownLink.vue";

export default {
    components: {
        JetDropdown,
        JetDropdownLink,
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
