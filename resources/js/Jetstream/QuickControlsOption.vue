<template>
    <Component :is="Icons[icon]"
        class="h-5 w-5 hover:cursor-pointer opacity-50 hover:opacity-70"
        :class="wrapperClasses"
        :v-bind="$attrs"
    />
</template>
<script>
import * as Icons from '@heroicons/vue/solid'
import { themes } from './constants';

export default {
    props: {
        icon: {
            type: String,
            required: true,
        },
        theme: {
            type: String,
            default: themes.light,
        }
    },

    data() {
        return {
            Icons,
        }
    },

    computed: {
        wrapperClasses() {
            return this.theme === themes.light ? 'text-white' : 'text-black';
        }
    }
}
</script>
