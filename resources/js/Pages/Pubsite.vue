<template>
    <div>
        Pubsite here for {{ page }}
    </div>
</template>

<script>
    import LinkLayout from './Partials/PubSite/LinkLayout.vue';

    export default {
        props: ['page'],

        components: {
            LinkLayout
        },
        data() {
            return {
            }
        },
        methods: {
        }
    }
</script>
