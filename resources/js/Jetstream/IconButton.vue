<template>
    <button class="p-1 hover:background flex h-10 w-10 justify-center items-center hover:bg-gray-100 hover:bg-opacity-90 rounded-full">
        <span class="material-icons text-xl text-gray-400">{{ icon }}</span>
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

