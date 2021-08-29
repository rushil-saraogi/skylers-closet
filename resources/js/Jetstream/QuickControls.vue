<template>
    <div
        v-if="show"
        class="h-full w-full flex justify-center items-center absolute top-0 left-0"
    >   
        <div class="bg-opacity-10 rounded-full flex gap-4 p-2" :class="wrapperClasses">
            <slot></slot>
        </div>
    </div>
</template>
<script>

import { themes } from './constants';

export default {
    props: {
        show: {
            type: Boolean,
            default: false
        },
        theme: {
            type: String,
            default: themes.light
        }
    },

    computed: {
        wrapperClasses() {
            return this.theme === themes.light ? 'bg-white' : 'bg-black';
        }
    }
}
</script>
