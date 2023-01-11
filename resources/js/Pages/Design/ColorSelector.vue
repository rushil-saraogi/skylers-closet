<template>
    <div class="flex gap-2 flex-wrap">
        <div
            :key="index"
            v-for="(color, index) in colors"
            class="hover:cursor-pointer transition"
            :class="{
                'bg-indigo-600/20': isSelected(index),
            }"
            @click="$emit('click:item', layout)"
        >
            <div class="border rounded-sm hover:border-indigo-300">
                <div :class="color" class="h-7 w-9 m-1 rounded-sm overflow-hidden" />
            </div>
        </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

const colors = [
    'bg-indigo-600',
    'bg-red-600',
    'bg-teal-600',
    'bg-blue-600',
    'bg-green-600',
    'bg-yellow-600',
    'bg-slate-600',
]

export default {
    components: {
        Link,
    },

    data() {
        return {
            colors,
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
            return this.selected && this.selected === index;
        }
    }
};
</script>
