<template>
    <Link
        class="bg-white min-h-48 rounded-lg overflow-hidden relative border shadow-3xl hover:shadow-4xl transition"
        :key="category.id"
        :href="route('show-closet', { closet: id })"
    >
        <div class="flex flex-col items-center p-5">
            <img v-if="getClosetImage()" class="max-h-40 max-w-40" :src="getClosetImage()" />
            <div v-else class="h-40 w-full flex items-center rounded-sm justify-center bg-gray-100 text-gray-600">
                😕 <span class="ml-1.5">Empty Closet</span>
            </div>

            <div v-if="name" class="text-gray-600 font-semibold text-xl mt-5 line-clamp-1">
                {{ name }}
            </div>
            <div v-if="name" class="text-gray-400 text-sm mt-0.5 line-clamp-1">
                By {{ user.name }}
            </div>
            <Badge
                v-if="category.name"
                class="mt-2.5"
            >
                {{ category.name }}
            </Badge>
        </div>
    </Link>
</template>

<script>
import { InboxIcon } from '@heroicons/vue/20/solid'
import { Link } from "@inertiajs/inertia-vue3";
import Badge from '@/Jetstream/Badge.vue';

export default {
    components: {
        Link,
        Badge,
        InboxIcon
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
        user: {
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
