<template>
    <Tooltip
        :text="tooltip"
    >
        <button class="p-2 flex justify-center items-center h-12 w-12 rounded-full" :class="classes">
            <span class="material-icons text-2xl">{{ icon }}</span>
        </button>
    </Tooltip>
</template>

<script>
    import Tooltip from './Tooltip.vue';

    export default {
        props: {
            icon: String,
            tooltip: String,
            type: {
                type: String,
                default: 'default'
            }
        },

        components: { Tooltip },

        emits: ['update:modelValue'],

        methods: {
            focus() {
                this.$refs.input.focus()
            }
        },

        computed: {
            classes() {
                return {
                    'bg-white': this.type === 'default',
                    'hover:bg-gray-200': this.type === 'default',
                    'text-gray-500': this.type === 'default',
                    'bg-gray-700': this.type === 'primary',
                    'hover:bg-gray-900': this.type === 'primary',
                    'text-white': this.type === 'primary',
                }
            }
        }
    }
</script>

