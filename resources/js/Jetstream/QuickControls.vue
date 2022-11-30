<template>
    <div v-if="show" class="flex w-full items-center border-solid border-0 border-t border-gray-100">
        <slot></slot>
    </div>
</template>
<script>
import { themes } from "./constants";

export default {
    props: {
        show: {
            type: Boolean,
            default: false,
        },
        theme: {
            type: String,
            default: themes.light,
        },
    },
};
</script>
