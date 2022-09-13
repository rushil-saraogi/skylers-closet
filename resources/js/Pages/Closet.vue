<template>
    <app-layout title="Closet">
        <div class="relative flex flex-col w-full">
            <ImageHeader
                :headerText="closet.name"
                :subHeaderText="authorName"
                :image="userProfileImage"
                :link="route('user-profile', [closet.user.id])"
            />
            <ul class="grid gap-6 md:grid-cols-3 sm:grid-cols-2 grid-col-1 mt-10">
                <li v-for="(item, index) in closet.items" :key="index">
                    <item-tile
                        v-bind="item"
                        :pub-mode="true"
                        @click:message="tagItemForMessage(item)"
                    />
                </li>
            </ul>
            <message-board
                class="mt-8"
                :tagged-item="taggedItem"
                :messages="messages"
                :closet="closet"
                @click:toggle-board="handleMessageBoardToggleClick"
                @submit:message="tagItemForMessage(null)"
                @delete:tag="tagItemForMessage(null)"
            />
        </div>

    </app-layout>
</template>

<script>
import { mapActions } from "pinia";
import { useStore } from "@/store";
import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Jetstream/Button";
import ItemTile from "@/Common/Tiles/ItemTile.vue";
import MessageBoard from "./Partials/Closet/MessageBoard.vue";
import ImageHeader from '@/Jetstream/ImageHeader.vue';

export default {
    props: ["closet", "messages"],

    components: {
        AppLayout,
        JetButton,
        ItemTile,
        MessageBoard,
        ImageHeader
    },

    mounted() {},

    computed: {
        userProfileImage() {
            return this.closet?.user?.profile_photo_url;
        },

        authorName() {
            return this.closet?.user?.name;
        }
    },

    data() {
        return {
            taggedItem: null,
        };
    },

    methods: {
        ...mapActions(useStore, []),

        tagItemForMessage(item) {
            this.taggedItem = item;
        },
    },
};
</script>
