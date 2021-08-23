<template>
    <div class="rounded-md min-h-48 font-mono p-4 hover:cursor-pointer transition" :class="classes">
        <span v-if="hasContent" class="text-gray-600"><slot ></slot></span>
        <span v-else class="material-icons text-4xl text-gray-500">add</span>
    </div>

</template>

<script>
    export default {
        computed: {
            hasContent() {
                return !!this.$slots.default;
            },
            classes() {
                return {
                    'bg-white shadow hover:shadow-md': this.hasContent,
                    'flex justify-center items-center hover:bg-gray-200 border border-gray-300': !this.hasContent
                }
            }
        }
    }
</script>
