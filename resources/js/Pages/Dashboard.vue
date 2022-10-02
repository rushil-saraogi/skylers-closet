<template>
    <app-layout title="Dashboard">
        <template #header v-if="selected">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <closet-dropdown
                        v-if="this.closets.length > 1"
                        :selected="selected"
                        :list="closets"
                        :align="'left'"
                    />
                    <div
                        v-else
                        class="text-md font-semibold text-gray-800 leading-tight"
                    >
                        {{ selected.name }}
                    </div>
                    <icon-button
                        class="ml-1.5"
                        @click="toggleCreateClosetModal(true, selected)"
                    >
                        <PencilIcon class="h-5 w-5 text-gray-400" />
                    </icon-button>
                </div>

                <div>
                    <jet-button @click="toggleCreateClosetModal(true)"
                        >Create new closet</jet-button
                    >
                </div>
            </div>
        </template>

        <div class="w-full">
            <closet-editor v-if="selected" v-bind="selected" />

            <div v-else>
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold">Your closets</h2>
                    <div>
                        <jet-button @click="toggleCreateClosetModal(true)"
                            >Create new closet</jet-button
                        >
                    </div>
                </div>

                <closet-list
                    :closets="closets"
                    class="mt-3 shadow-3xl"
                    @click:closet="handleClosetClick"
                />
            </div>
        </div>

        <create-closet-modal
            :show="shouldShowCreateClosetModal"
            :selected="selectedToEdit"
            @click:close="toggleCreateClosetModal(false)"
        />
    </app-layout>
</template>

<script>
import { ChartSquareBarIcon, PencilIcon } from '@heroicons/vue/24/outline'
import { mapActions } from "pinia";
import { useStore } from "@/store";
import AppLayout from "@/Layouts/AppLayout.vue";
import ClosetEditor from "./Partials/Dashboard/ClosetEditor.vue";
import ClosetDropdown from "./Partials/Dashboard/ClosetDropdown.vue";
import CreateClosetModal from "./Partials/Dashboard/CreateClosetModal.vue";
import JetButton from "@/Jetstream/Button";
import TextTileModal from "@/Common/Tiles/TextTileModal.vue";
import SelectTileModal from "@/Common/Tiles/SelectTileModal.vue";
import IconButton from "@/Jetstream/IconButton.vue";
import ClosetList from "./Partials/Dashboard/ClosetList.vue";

export default {
    props: ["closets", "selected", "categories"],

    components: {
        AppLayout,
        ClosetEditor,
        CreateClosetModal,
        JetButton,
        TextTileModal,
        SelectTileModal,
        ClosetDropdown,
        IconButton,
        ClosetList,
        PencilIcon
    },

    mounted() {
        this.setClosets(this.closets);
        this.setCategories(this.categories);
        this.selectCloset(this.selected);
    },

    data() {
        return {
            shouldShowCreateClosetModal: false,
            selectedToEdit: null,
            tabs: [
                {
                    icon: ChartSquareBarIcon,
                    tooltip: "Closets",
                    onClick: () => console.log('Poo')
                }
            ]
        };
    },

    methods: {
        ...mapActions(useStore, [
            "selectCloset",
            "setClosets",
            "setCategories",
        ]),

        toggleCreateClosetModal(show, selected = null) {
            this.selectedToEdit = selected;
            this.shouldShowCreateClosetModal = show;
        },

        deleteCloset(id) {
            this.$inertia.delete(this.route("delete-closet", id));
        },

        handleClosetClick(closet) {
            this.$inertia.visit(route('dashboard', {'closet': closet.id}), { method: 'get' });
        }
    },
};
</script>
