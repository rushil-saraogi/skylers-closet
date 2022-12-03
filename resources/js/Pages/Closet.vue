<template>
    <app-layout title="Closet">
        <div class="relative flex flex-col w-full">
            <div class="flex flex-col items-center text-center">
                <div>
                    <div class="text-3xl sm:text-4xl font-bold mt-3 sm:mt-5">{{ closet.name }}</div>

                    <div class="mt-2 text-gray-600">
                        By
                        <Link
                            class="hover:text-gray-900"
                            :href="route('user-profile', [closet.user.id])"
                        >
                            {{ authorName }}
                        </Link>
                    </div>

                    <SecondaryButton v-if="!isUsersCloset" :flush="false"  class="mt-4" @click="followCloset">
                        <div class="flex items-center" v-if="isFollowingCloset">
                            <HeartIconFilled
                                class="h-5 w-5 text-red-400"
                                @click="likeCloset"
                            />
                            <span class="ml-1.5 font-semibold">Liked</span>
                        </div>
                        <div class="flex items-center" v-else>
                            <HeartIconOutline
                                class="h-5 w-5 text-red-400"
                                @click="likeCloset"
                            />
                            <span class="ml-1.5 font-semibold">Like</span>
                        </div>
                    </SecondaryButton>
                </div>

                <div class="flex flex-col gap-6 w-full">
                    <div>
                        <!-- <CoverImage v-if="closet.wallpaper" :url="closet.wallpaper"  class="mt-4 sm:mt-8" /> -->

                        <div v-if="!closet.items.length">
                            <empty-state message="Nothing here yet" />
                        </div>

                        <ul
                            class="grid gap-3 sm:gap-6 grid-col-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 mt-5 sm:mt-8 w-full"
                        >
                            <li v-for="(item, index) in closet.items" :key="index">
                                <item-tile
                                    v-bind="item"
                                    :pub-mode="true"
                                    :is-saved="isItemSaved(item)"
                                    :with-chat-link="true"
                                    @click:message="tagItemForMessage(item)"
                                    @click:save="saveItemClick(item)"
                                />
                            </li>
                        </ul>
                    </div>
                    <message-board
                        class="sm:mt-2s"
                        :tagged-item="taggedItem"
                        :messages="messages"
                        :closet="closet"
                        @submit:message="tagItemForMessage(null)"
                        @delete:tag="tagItemForMessage(null)"
                    />
                </div>
            </div>

            <save-item-modal
                :show="showSaveItemModal"
                :selected="savingItem"
                :closets="user_closets"
                @click:close="toggleSaveItemModal(false)"
                @save:item="saveItem"
                @remove:item="undoSave"
            />
        </div>
    </app-layout>
</template>

<script>
import { Inertia } from '@inertiajs/inertia'
import { Link } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Jetstream/Button";
import EmptyState from '@/Jetstream/EmptyState.vue';
import ItemTile from "@/Common/Tiles/ItemTile.vue";
import MessageBoard from "./Partials/Closet/MessageBoard.vue";
import FloatingButtons from '@/Jetstream/FloatingButtons.vue'
import FloatingButton from '@/Jetstream/FloatingButton.vue'
import ImageHeader from "@/Jetstream/ImageHeader.vue";
import ButtonVue from "@/Jetstream/Button.vue";
import SecondaryButton from "@/Jetstream/SecondaryButton.vue";
import IconButton from "@/Jetstream/IconButton.vue";
import { HeartIcon as HeartIconOutline } from "@heroicons/vue/24/outline";
import { HeartIcon as HeartIconFilled } from "@heroicons/vue/20/solid";
import SaveItemModal from './Partials/Closet/SaveItemModal.vue';
import ItemsApi from '../API/ItemsApi';
import CoverImage from '../Common/CoverImage.vue';

export default {
    props: ["closet", "messages", "auth", "user_closets"],

    components: {
        Link,
        AppLayout,
        JetButton,
        ItemTile,
        MessageBoard,
        ImageHeader,
        FloatingButtons,
        FloatingButton,
        ButtonVue,
        SecondaryButton,
        IconButton,
        HeartIconOutline,
        HeartIconFilled,
        EmptyState,
        SaveItemModal,
        CoverImage
    },

    mounted() {},

    computed: {
        authorName() {
            return this.closet?.user?.name;
        },

        isLoggedIn() {
            return this.auth?.user;
        },

        isUsersCloset() {
            return this.isLoggedIn && this.closet.user_id === this.auth.user.id;
        },

        isFollowingCloset() {
            if (!this.isLoggedIn) {
                return false;
            }

            const followers = this.closet?.followers || [];

            return followers
                .map((follower) => follower.id)
                .includes(this.auth.user.id);
        },

        allUserItems() {
            if (!this.isLoggedIn || !this.user_closets) {
                return [];
            }

            return this.user_closets.reduce((acc, closet) => {
                return [...acc, ...closet.items];
            }, []);
        },
    },

    data() {
        return {
            taggedItem: null,
            showSaveItemModal: false,
            savingItem: null,
        };
    },

    methods: {
        tagItemForMessage(item) {
            this.taggedItem = item;
        },

        toggleSaveItemModal(show) {
            this.showSaveItemModal = show;
        },

        saveItemClick(item) {
            this.savingItem = item;
            this.toggleSaveItemModal(true);
        },

        async saveItem(closet) {
            await ItemsApi.saveItem(closet.id, this.savingItem.id);
            Inertia.reload({ only: ['user_closets'] });
        },

        async undoSave(closet) {
            await ItemsApi.deleteByUrl(closet.id, this.savingItem.id);
            Inertia.reload({ only: ['user_closets'] });
        },

        isItemSaved(item) {
            return this.allUserItems.map(item =>item.url).includes(item.url);
        },

        followCloset() {
            this.$inertia.post(
                this.route("follow-closet", [this.closet.id])
            );
        },
    },
};
</script>
