<template>
    <div class="hover:cursor-pointer hover:bg-gray-100 flex-1 p-4 flex justify-center items-center" :v-bind="$attrs">
        <Component :is="Icons[icon]"
            class="h-5 min-w-5 text-gray-400"
        />
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
