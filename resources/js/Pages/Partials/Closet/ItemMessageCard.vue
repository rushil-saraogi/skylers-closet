<template>
    <div class="py-2 px-6 border rounded bg-white relative">
        <div v-if="dismissable" class="absolute top-1 right-1">
            <XMarkIcon @click="$emit('click:dismiss')" class="h-4 w-4 text-gray-500 hover:cursor-pointer hover:text-gray-600" />
        </div>
        <div class="flex items-center">
            <img class="h-8 mr-4" v-if="item.image" :src="item.image" />
            <div>
                <div class="font-semibold text-md line-clamp-2">
                    {{ item.title }}
                </div>
                <div class="text-left">${{ item.price }}</div>
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
