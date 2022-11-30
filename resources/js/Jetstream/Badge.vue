<template>
    <div
        class="text-xs font-bold flex items-center justify-center rounded-xl px-2 py-1"
        :class="badgeClasses"
    >
        <slot></slot>
    </div>
</template>

<script>
    export default {
        props: ['variant'],

        computed: {
            badgeClasses() {
                const colors = {
                    info: 'bg-indigo-100 text-indigo-900',
                    success: 'bg-green-200 text-green-900',
                    danger: 'bg-red-200 text-red-900',
                    teal: 'bg-teal-200 text-teal-900',
                    gray: 'bg-gray-100 text-gray-500',
                };

                return {
                    [colors[this.variant || 'info']]: true,
                }
            }
        }
    }
</script>

