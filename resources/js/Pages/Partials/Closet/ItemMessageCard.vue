<template>
    <div class="py-2 px-6 border rounded bg-gray-50 relative">
        <div v-if="dismissable" class="absolute top-1 right-1">
            <XMarkIcon @click="$emit('click:dismiss')" class="h-4 w-4 text-gray-500 hover:cursor-pointer hover:text-gray-600" />
        </div>
        <div class="flex items-center">
            <img class="h-8 mr-4" v-if="item.image" :src="item.image" />
            <div>
                <div class="font-semibold text-md">
                    {{ item.title }}
                </div>
                <div>${{ item.price }}</div>
            </div>
        </div>
    </div>
</template>

<script>
import { XMarkIcon } from '@heroicons/vue/20/solid'

export default {
    props: {
        item: {
            type: Object,
            default: {},
        },
        dismissable: {
            type: Boolean,
            default: false,
        },
    },

    components: {
        XMarkIcon
    }
};
</script>
