<template>
    <div class="rounded" :class="[`bg-${color}`]" />
</template>

<script>
export default {
    props: {
        color: {
            type: String,
            required: true
        }
    }
}
</script>