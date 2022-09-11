<template>
    <app-layout title="Feed">
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

        <div class="w-full">
            <div>
                <ImageHeader
                    :headerText="user.name"
                    subHeaderText="Lets give them taglines?"
                    :image="user.profile_photo_url"
                />
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout.vue'
    import JetButton from '@/Jetstream/Button';
    import ImageHeader from '@/Jetstream/ImageHeader.vue';

    export default {
        props: ['user'],

        components: {
            AppLayout,
            JetButton,
            ImageHeader
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
