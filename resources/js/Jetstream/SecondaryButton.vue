<template>
    <button
        :type="type"
        :class="{ 'w-full': flush }"
        class="inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-indigo-50 text-base font-semibold text-indigo-700 hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-300 sm:w-auto sm:text-sm"
    >
        <slot></slot>
    </button>
</template>

<script>
    export default {
        props: {
            type: {
                type: String,
                default: 'button',
            },
            flush: {
                type: Boolean,
                default: true,
            },
        }
    }
</script>
