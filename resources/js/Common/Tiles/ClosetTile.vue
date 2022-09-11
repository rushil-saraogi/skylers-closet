<template>
    <!-- TODO: Looks too much like the item tile! -->
    <Link
        class="bg-white min-h-48 rounded-lg overflow-hidden relative shadow-sm"
        :key="category.id"
        :href="route('show-closet', {'closet': id})"
    >
        <div class="flex flex-col items-center p-6">
            <div
                v-if="category.name"
                class="bg-green-300 font-bold flex items-center justify-center rounded-md absolute top-3 right-3 px-2 py-1"
            >
                {{ category.name }}
            </div>
            <img class="max-h-40 max-w-40" :src="getClosetImage()" />
            <div class="flex justify-between">
                <div
                    v-if="name"
                    class="text-gray-600 font-semibold text-lg mt-4"
                >
                    {{ name }}
                </div>
            </div>
        </div>
    </Link>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
    components: {
        Link
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
        return {
        };
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

            return ''; // TODO add a default image here based on category
        }
    },
};
</script>
