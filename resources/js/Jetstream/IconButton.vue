<template>
    <button v-if="variant === 'filled'" class="p-1 flex h-9 w-9 justify-center items-center bg-gray-700 hover:bg-gray-800 rounded-full">
        <span class="material-icons text-base text-white">{{ icon }}</span>
    </button>
    <button v-else class="p-1 hover:background flex h-10 w-10 justify-center items-center hover:bg-gray-100 hover:bg-opacity-90 rounded-full">
        <span class="material-icons text-xl text-gray-400">{{ icon }}</span>
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
        }
    }
</script>

