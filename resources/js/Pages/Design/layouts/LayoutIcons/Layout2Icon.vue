<template>
    <layout-icon-base>
        <div class="flex gap-1 p-1.5 h-full w-full">
            <div class="bg-gray-100 p-1 h-full flex-1 grid grid-cols-3 grid-rows-3 gap-1">
                <div class="bg-gray-300 h-2 w-2"></div>
                <div class="bg-gray-300 h-2 w-2"></div>
                <div class="bg-gray-300 h-2 w-2"></div>
                <div class="bg-gray-300 h-2 w-2"></div>
                <div class="bg-gray-300 h-2 w-2"></div>
            </div>
            <div class="bg-gray-300 w-full h-full flex-1"></div>
        </div>
    </layout-icon-base>
</template>

<script>
import LayoutIconBase from './LayoutIconBase.vue'

export default {
    components: {
        LayoutIconBase
    },
};
</script>
