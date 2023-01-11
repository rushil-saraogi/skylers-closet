<template>
    <Tooltip :text="tooltip">
        <button v-if="variant === 'filled'" class="p-1.5 flex h-9 w-9 border justify-center items-center bg-white hover:bg-gray-100 rounded-full">
            <slot></slot>
        </button>
        <button v-else class="p-1 hover:background flex h-9 w-9 justify-center items-center hover:bg-gray-100 hover:bg-opacity-90 rounded-full">
            <slot></slot>
        </button>
    </Tooltip>
</template>

<script>
    import Tooltip from './Tooltip.vue';

    export default {
        props: ['icon', 'color', 'variant', 'tooltip'],

        emits: ['update:modelValue'],

        components: { Tooltip },

        methods: {
            focus() {
                this.$refs.input.focus()
            }
        },
    }
</script>

