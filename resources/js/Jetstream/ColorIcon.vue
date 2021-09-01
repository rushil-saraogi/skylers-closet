<template>
    <div :class="`rounded h-5 w-5 bg-${color}`" />
</template>

<script>

export default {
    props: {
        color: {
            type: String,
            default: 'black'
        }
    },
}
</script>