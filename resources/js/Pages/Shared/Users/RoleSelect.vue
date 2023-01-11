<template>
    <div class="grid gap-3 sm:gap-4 w-full grid-cols-2 sm:grid-cols-3 md:grid-cols-4">
        <div
            v-for="([value, label], index) in Object.entries(ROLES)"
            :key="index"
            class= "p-4 rounded-lg font-semibold hover:bg-indigo-600/20 hover:cursor-pointer transition flex items-center"
            :class="{
                'bg-indigo-600/20': value === selected,
                'bg-gray-500/10': value !== selected,
            }"
            @click="$emit('click:role', value)"
        >
            {{ toTitleCase(label) }}
        </div>
    </div>
</template>

<script>
import { ROLES } from '@/constants';
import { toTitleCase } from '@/Util/String';

export default {
    data() {
        return {
            ROLES,
        }
    },

    props: {
        selected: {
            type: String,
            default: '',
        },
    },

    methods: {
        toTitleCase
    }
};
</script>
