<template>
    <div class="w-full flex gap-3 flex-wrap">
        <div
            :key="index"
            v-for="(layout, index) in layouts"
            class="hover:cursor-pointer hover: transition"
            :class="{
                'bg-indigo-600/20': isSelected(index),
            }"
            @click="$emit('click:item', layout)"
        >
            <component :is="layouts[index]" />
        </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
import Layout1Icon from './layouts/LayoutIcons/Layout1Icon.vue';
import Layout2Icon from './layouts/LayoutIcons/Layout2Icon.vue';

const layouts = [
    Layout1Icon,
    Layout2Icon
]

export default {
    components: {
        Link,
    },

    data() {
        return {
            layouts,
        }
    },

    props: {
        selected: {
            type: Number,
            default: 0,
        },
    },

    methods: {
        isSelected(index) {
            return this.selected && this.selected === layout;
        }
    }
};
</script>
