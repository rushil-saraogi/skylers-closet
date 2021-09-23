<template>
    <div class="rounded h-5 w-5" :class="classes" />
</template>

<script>

export default {
    props: {
        color: {
            type: String,
            default: 'black'
        }
    },

    computed: {
        classes() {
            // Adding full color names for Tailwind's JIT mode to work
            return { 
                'bg-red-700': this.color === 'red-700',
                'bg-red-500': this.color === 'red-500',
                'bg-gray-700': this.color === 'gray-700',
                'bg-indigo-600': this.color === 'indigo-600',
                'bg-red-500': this.color === 'red-500',
                'bg-blue-500': this.color === 'blue-500',
                'bg-pink-400': this.color === 'pink-400',
                'bg-green-500': this.color === 'green-500'
            }
        }
    }
}
</script>