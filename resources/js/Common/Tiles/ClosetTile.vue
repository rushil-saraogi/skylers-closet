<template>
    <!-- TODO: Looks too much like the item tile! -->
    <Link
        class="bg-white min-h-48 rounded-lg overflow-hidden relative shadow-sm"
        :key="category.id"
        :href="route('show-closet', { closet: id })"
    >
        <div class="flex flex-col items-center p-6">
            <img class="max-h-40 max-w-40" :src="getClosetImage()" />
            <div v-if="name" class="text-gray-600 font-semibold text-left text-xl mt-5 line-clamp-2">
                {{ name }}
            </div>
            <div
                v-if="category.name"
                class="bg-blue-300 text-sm mt-3 font-bold flex items-center justify-center rounded-md px-2 py-1"
            >
                {{ category.name }}
            </div>
        </div>
    </Link>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
    components: {
        Link,
    },

    emit: ["click:edit", "click:delete"],

    props: {
        id: {
            type: String,
            default: "",
        },
        name: {
            type: String,
            default: "",
        },
        items: {
            type: Array,
            default: [],
        },
        category: {
            type: Object,
            default: {},
        },
        pubMode: {
            type: Boolean,
            default: false,
        },
    },

    data() {
        return {};
    },

    mounted() {},

    computed: {},

    methods: {
        getClosetImage() {
            for (const item of this.items) {
                if (item.image) {
                    return item.image;
                }
            }

            return ""; // TODO add a default image here based on category
        },
    },
};
</script>
