<template>
    <app-layout title="Feed">
        <template #header>
            <div class="flex items-center justify-between">
                <div class="flex">
                    <img :src="user.profile_photo_url" class="h-10 w-10 mt-1.5 rounded-full object-cover" />
                    <div class="ml-3">
                        <div class="text-lg font-semibold">{{ user.name }}</div>
                        <div class="text-gray-500">
                            {{ followerCount }} followers
                        </div>
                    </div>
                </div>

                <div>
                    <secondary-button
                        v-if="isFollowingUser"
                        @click="followUser"
                        class="mt-4"
                    >
                        Following
                    </secondary-button>
                    <jet-button v-else class="mt-4" @click="followUser">
                        Follow
                    </jet-button>
                </div>
            </div>
        </template>
        <div class="w-full">
            <jet-header type="h2" classes="font-semibold text-xl">Closets</jet-header>
            <div
                class="mt-5 grid gap-6 md:grid-cols-3 sm:grid-cols-2 grid-col-1"
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
import ClosetTile from '@/Common/Tiles/ClosetTile.vue';
import JetHeader from '@/Jetstream/Header.vue';
import SecondaryButton from '@/Jetstream/SecondaryButton.vue';

export default {
    props: ["user", "isFollowingUser", "followerCount"],

    components: {
        AppLayout,
        JetButton,
        ImageHeader,
        ClosetTile,
        JetHeader,
        SecondaryButton
    },

    methods: {
        followUser() {
            this.$inertia.post(
                this.route('follow', [this.user.id]), {});
        },
    },
};
</script>
