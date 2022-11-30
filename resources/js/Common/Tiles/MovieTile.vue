<template>
    <tile-wrapper
        v-bind="$props"
    >
        <div
            class="flex flex-col items-center justify-between h-full p-4"
        >
            <!-- Item image -->
            <a :href="url" v-if="image" target="_blank" class="flex-1 flex items-center justify-center w-full">
                <img v-if="image" class="max-h-32 object-cover" :src="image" />
            </a>
            <slot v-else-if="$slots.placeholder" name="placeholder"></slot>
            <a :href="url" v-else target="_blank" class="flex flex-col w-full items-center justify-center h-full bg-gray-100">
                <PhotoIcon class="h-8 w-8 text-gray-400" />
            </a>
            <!-- / Item Image -->

            <div class="flex justify-center flex-col items-center w-full">
                <div
                    v-if="title"
                    class="text-gray-600 mt-5 line-clamp-1 text-sm"
                >
                    {{ title }}
                </div>
                <div v-if="price" class="font-bold text-xl text-zinc-700">
                    ${{ price }}
                </div>
            </div>
        </div>
    </tile-wrapper>
</template>

<script>
import Badge from '@/Jetstream/Badge.vue';
import TileWrapper from "./TileWrapper.vue";
import { PhotoIcon } from '@heroicons/vue/24/outline';

export default {
    components: {
        TileWrapper,
        Badge,
        PhotoIcon,
    },

    emit: ["click:edit", "click:delete"],

    props: {
        title: {
            type: String,
            default: "",
        },
        image: {
            type: String,
            default: "",
        },
        url: {
            type: String,
            default: "",
        },
        price: {
            type: Number,
            default: 0,
        },
        pubMode: {
            type: Boolean,
            default: false,
        },
    },

    data() {
        return {
            isHovering: false,
        };
    },
};
</script>
