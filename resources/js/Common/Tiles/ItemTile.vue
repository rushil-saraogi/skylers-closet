<template>
    <tile-wrapper
        @click:tile="handleProductClick"
        :pub-mode="pubMode"
        :in-save-mode="inSaveMode"
    >
        <div class="flex flex-col items-center p-6">
            <div
                v-if="price"
                class="bg-green-300 font-bold flex items-center justify-center rounded-md absolute top-3 right-3 px-2 py-1"
            >
                ${{ price }}
            </div>
            <img v-if="image" class="max-h-40 max-w-40" :src="image" />
            <div class="flex justify-between">
                <div
                    v-if="title"
                    class="text-gray-600 font-semibold text-lg mt-4"
                >
                    {{ title }}
                </div>
                <transition
                    enter-active-class="transition ease-in duration-200"
                    enter-from-class="-translate-x-3 opacity-0"
                    enter-to-class="translate-0 opacity-100"
                >
                    <ChevronRightIcon
                        v-show="isHovering"
                        class="h-7 w-7 text-black"
                    />
                </transition>
            </div>
        </div>
    </tile-wrapper>
</template>

<script>
import { ChevronRightIcon } from "@heroicons/vue/solid";
import TileWrapper from "./TileWrapper.vue";

export default {
    components: {
        TileWrapper,
        ChevronRightIcon,
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
        price: {
            type: Number,
            default: 0,
        },
        inSaveMode: {
            type: Boolean,
            default: false,
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

    mounted() {},

    computed: {},

    methods: {
        handleProductClick() {
            if (!this.pubMode) return;
            window.open(this.data.url, "_blank");
        },
    },
};
</script>
