<template>
    <div class="fixed bottom-0 mx-auto inset-x-0 max-w-lg">
        <div v-for="(tab, index) in tabs" :key="index" class="p-4 bg-gray-100 border rounded-xl">
            <Tooltip
                :text="tab.tooltip"
            >
                <component
                    :is="tab.icon"
                    class="w-6 h-6 text-gray-500"
                    @click="tab.onClick"
                />
            </Tooltip>
        </div>
    </div>
</template>

<script>
import Tooltip from './Tooltip.vue';

export default {
    props: {
        tabs: {
            type: Array,
            default: []
        }
    },

    components: { Tooltip },

    data() {
        return {

        };
    },
};
</script>
