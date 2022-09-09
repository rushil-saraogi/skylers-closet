<template>
    <app-layout title="Dashboard">
        <template #header>
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <closet-dropdown
                        v-if="this.closets.length > 1"
                        :selected="selectedCloset"
                        :list="closets"
                        :align="'left'"
                    />
                    <div v-else class="text-lg text-gray-800 leading-tight">
                        {{ selectedCloset.name }}
                    </div>
                    <icon-button
                        class="ml-2"
                        icon="edit"
                        @click="toggleCreateClosetModal(true, selectedCloset)"
                    />
                </div>

                <div>
                    <jet-button @click="toggleCreateClosetModal(true)"
                        >Create new closet</jet-button
                    >
                </div>
            </div>
        </template>

        <div class="w-full py-12 px-4 sm:px-6 lg:px-8">
            <closet v-bind="selectedCloset" />
        </div>

        <create-closet-modal
            :show="shouldShowCreateClosetModal"
            :selected="selectedClosetToEdit"
            @click:close="toggleCreateClosetModal(false)"
        />
    </app-layout>
</template>

<script>
import { mapActions } from "pinia";
import { useStore } from "@/store";
import AppLayout from "@/Layouts/AppLayout.vue";
import Closet from "./Partials/Dashboard/Closet.vue";
import ClosetDropdown from "./Partials/Dashboard/ClosetDropdown.vue";
import CreateClosetModal from "./Partials/Dashboard/CreateClosetModal.vue";
import JetButton from "@/Jetstream/Button";
import LinkTileModal from "@/Common/Tiles/LinkTileModal.vue";
import TextTileModal from "@/Common/Tiles/TextTileModal.vue";
import SelectTileModal from "@/Common/Tiles/SelectTileModal.vue";
import IconButton from "../Jetstream/IconButton.vue";

export default {
    props: ["closets", "selected"],

    components: {
        AppLayout,
        Closet,
        CreateClosetModal,
        JetButton,
        LinkTileModal,
        TextTileModal,
        SelectTileModal,
        ClosetDropdown,
        IconButton,
    },

    mounted() {
        this.setClosets(this.closets);
        this.selectCloset(this.selectedCloset);
    },

    data() {
        return {
            shouldShowCreateClosetModal: false,
            selectedClosetToEdit: null,
        };
    },

    computed: {
        selectedCloset() {
            return this.selected || this.closets[0];
        },
    },

    methods: {
        ...mapActions(useStore, ["selectCloset", "setClosets"]),

        toggleCreateClosetModal(show, selected = null) {
            this.selectedClosetToEdit = selected;
            this.shouldShowCreateClosetModal = show;
        },

        deleteCloset(id) {
            this.$inertia.delete(this.route("delete-closet", id));
        },
    },
};
</script>
