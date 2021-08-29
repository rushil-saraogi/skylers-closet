<template>
    <component :is="ICON_MAPPING[icon].icon" class="h-7 w-7 text-white" />
</template>

<script>

import { ICON_MAPPING } from './constants';

export default {
    props: {
        icon: {
            type: String,
            required: true,
        },
    },

    data() {
        return {
            ICON_MAPPING
        }
    }
}
</script>
