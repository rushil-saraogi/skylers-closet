<template>
    <h1 class="text-lg font-medium text-gray-900" :class="{ [classes]: classes }" v-if="type === 'h1'">
        <slot></slot>
    </h1>
    <h2 class="text-lg font-medium text-gray-900" :class="{ [classes]: classes }" v-if="type === 'h2'">
        <slot></slot>
    </h2>
    <h3 class="text-lg font-semibold text-gray-900" :class="{ [classes]: classes }" v-if="type === 'h3'">
        <slot></slot>
    </h3>
</template>

<script>
export default {

    props: {
        type: {
            type: String,
            required: true,
        },
        classes: String
    },
}
</script>
