<template>
    <app-layout title="Dashboard">
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Feed
                </h2>
                <!-- <div>
                    <jet-button @click="toggleCreateClosetModal(true)">Create new closet</jet-button>
                </div> -->
            </div>
        </template>

        <div class="py-12 px-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
                <h1>Here we feed</h1>
            </div>
        </div>

    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout.vue'
    import JetButton from '@/Jetstream/Button';

    export default {
        props: ['closets'],

        components: {
            AppLayout,
            JetButton,
        },

        mounted() {
            // this.setClosets(this.closets);
        },

        data() {
            return { }
        },

        computed: {
        },

        methods: {
            // ...mapActions(useStore, ['selectCloset', 'setClosets']),
        }
    }
</script>
