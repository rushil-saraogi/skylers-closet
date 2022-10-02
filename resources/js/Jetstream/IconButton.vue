<template>
    <button v-if="variant === 'filled'" class="p-1 flex h-9 w-9 justify-center items-center bg-gray-100 hover:bg-gray-100 rounded-full">
        <slot></slot>
    </button>
    <button v-else class="p-1 hover:background flex h-10 w-10 justify-center items-center hover:bg-gray-100 hover:bg-opacity-90 rounded-full">
        <slot></slot>
    </button>
</template>

<script>
    export default {
        props: ['icon', 'color', 'variant'],

        emits: ['update:modelValue'],

        methods: {
            focus() {
                this.$refs.input.focus()
            }
        },
    }
</script>

