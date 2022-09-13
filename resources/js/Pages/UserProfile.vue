<template>
    <app-layout title="Feed">
        <div class="w-full">
            <div>
                <ImageHeader
                    :headerText="user.name"
                    :image="user.profile_photo_url"
                    cta="Follow"
                    @click:cta="followUser"
                />
            </div>
            <div
                class="mt-10 grid gap-6 md:grid-cols-3 sm:grid-cols-2 grid-col-1"
            >
                <ClosetTile
                    v-for="closet in user.closets"
                    :key="closet.id"
                    v-bind="closet"
                />
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Jetstream/Button";
import ImageHeader from "@/Jetstream/ImageHeader.vue";
import ClosetTile from '../Common/Tiles/ClosetTile.vue';

export default {
    props: ["user", "auth"],

    components: {
        AppLayout,
        JetButton,
        ImageHeader,
        ClosetTile,
    },

    mounted() {
        // this.setClosets(this.closets);
    },

    data() {
        return {
            form: this.$inertia.form({}),
        }
    },

    methods: {
        // ...mapActions(useStore, ['selectCloset', 'setClosets']),

        followUser() {
            this.form.post(this.route('follow', [this.user.id]));
        }
    },
};
</script>
