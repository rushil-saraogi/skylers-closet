<template>
    <app-layout title="Landing">
        <h1>Landing</h1>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Jetstream/Button";

export default {
    props: [
        'auth'
    ],

    components: {
        AppLayout,
        JetButton,
    },

    mounted() {
    },

    data() {
        return {

        };
    },

    computed: {
    },

    methods: {
    },
};
</script>
