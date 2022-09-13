<template>
    <tile-wrapper
        :hide-controls="hideControls"
        :pub-mode="pubMode"
    >
        <div
            class="flex flex-col items-center p-6"
            :class="{ 'hover:cursor-pointer': pubMode }"
            @click="handleItemClick"
        >
            <div
                v-if="price"
                class="bg-green-300 font-bold flex items-center justify-center rounded-md absolute top-3 right-3 px-2 py-1"
            >
                ${{ price }}
            </div>
            <img v-if="image" class="h-40 max-w-40" :src="image" />
            <div class="flex justify-between">
                <div
                    v-if="title"
                    class="text-gray-600 font-semibold mt-5 line-clamp-1"
                >
                    {{ title }}
                </div>
            </div>
        </div>
    </tile-wrapper>
</template>

<script>
import TileWrapper from "./TileWrapper.vue";

export default {
    components: {
        TileWrapper,
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
        hideControls: {
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

    methods: {
        handleItemClick() {
            if (!this.pubMode || !this.url) return;
            window.open(this.url, "_blank");
        },
    },
};
</script>
