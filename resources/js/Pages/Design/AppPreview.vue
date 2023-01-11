<template>
    <component :is="selectedLayout" />
</template>

<script>
import Layout1 from './layouts/Layout1.vue';

const layouts = [
    Layout1,
];

export default {
    props: [
        'layout'
    ],

    components: {
        Layout1,
    },

    computed: {
        selectedLayout() {
            return layouts[this.layout];
        }
    },
};
</script>
