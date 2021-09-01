<template>
    <button class="p-2 hover:background flex justify-center items-center bg-white hover:bg-gray-200 h-12 w-12 rounded-full">
        <span class="material-icons text-2xl text-gray-400">{{ icon }}</span>
    </button>
</template>

<script>
    export default {
        props: ['icon'],

        emits: ['update:modelValue'],

        methods: {
            focus() {
                this.$refs.input.focus()
            }
        }
    }
</script>

