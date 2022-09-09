<template>
    <div class="hover:cursor-pointer opacity-80 hover:opacity-100 flex gap-2 items-center" :v-bind="$attrs">
        <Component :is="Icons[icon]"
            class="h-5 min-w-5 text-white"
        />
        <div v-if="text" class="text-white">{{ text }}</div>
    </div>
    
</template>
<script>
import * as Icons from '@heroicons/vue/solid'

export default {
    props: {
        icon: {
            type: String,
            required: true,
        },
        text: {
            type: String,
            default: '',
        }
    },

    data() {
        return {
            Icons,
        }
    },
}
</script>
