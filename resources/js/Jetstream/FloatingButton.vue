<template>
    <Tooltip
        :text="tooltip"
    >
        <div class="relative">
            <div
                v-if="notificationText"
                class="text-sm bg-indigo-600 font-semibold h-6 w-6 text-white flex items-center justify-center rounded-full absolute -top-2 -right-2 ">
                {{ notificationText }}
            </div>
            <button class="p-2 flex justify-center items-center h-12 w-12 rounded-lg bg-white border" :class="classes">
                <span class="material-icons text-2xl">{{ icon }}</span>
            </button>
        </div>
    </Tooltip>
</template>

<script>
    import Tooltip from './Tooltip.vue';

    export default {
        props: {
            icon: String,
            tooltip: String,
            notificationText: String,
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
                    'hover:bg-gray-100': this.type === 'default',
                    'text-gray-500': this.type === 'default',
                    'bg-gray-700': this.type === 'primary',
                    'hover:bg-gray-900': this.type === 'primary',
                    'text-white': this.type === 'primary',
                }
            }
        }
    }
</script>

