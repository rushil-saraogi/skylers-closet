<template>
    <slot class="fill-current" :class="svgClasses"></slot>
</template>

<script>
export default {
    props: {
        color: {
            type: String,
            default: 'white'
        }
    },

    computed: {
        svgClasses() {
            return {
                [`text-${this.color}`]: this.color
            }
        }
    }
}
</script>