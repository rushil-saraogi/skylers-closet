<template>
    <button class="p-1 hover:background flex justify-center items-center hover:bg-gray-100 hover:bg-opacity-90 rounded-md">
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

