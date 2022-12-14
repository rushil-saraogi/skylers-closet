<template>
    <div class="w-full">
        <div>
            <div
                v-if="(items.length > 1)"
                class="p-3 bg-gray-500/10 hover:bg-gray-500/20 mb-2 sm:mb-3 text-gray-600 font-semibold flex items-center justify-center rounded hover:cursor-pointer"
            >
                <HandRaisedIcon class="h-4 w-4 text-gray-600 mr-2" />
                Drag and drop items to reorder!
            </div>
            <div
                class="p-3 bg-blue-500/10 hover:bg-blue-500/20 text-gray-600 hover:shadow-inner transition font-semibold flex items-center justify-center rounded hover:cursor-pointer"
                @click="toggleAddItemModal(true)"
            >
                Add an item to your closet
            </div>
        </div>
        <div class="mt-3 sm:mt-6">
            <!-- <CoverImage v-if="wallpaper" :url="wallpaper" class="mt-3 mb-3 sm:mt-6 sm:mb-6" /> -->

            <div v-if="items.length === 0">
                <empty-state message="Let's try adding an item" />
            </div>

            <tile-layout
                :title="name"
                :items="items"
                :pub-mode="false"
                @click:delete="toggleDeleteItemModal"
                @update:layout="handleLayoutUpdate"
                @click:edit="toggleEditItemModal"
            />
        </div>

        <floating-buttons>
            <floating-button tooltip="Add Item" type="primary" @click="toggleAddItemModal(true)" icon="add" />
            <!-- <floating-button tooltip="Add cover image" @click="toggleWallpaperModal(true)" icon="wallpaper" /> -->
        </floating-buttons>

        <delete-item-modal
            :show="shouldShowDeleteModal"
            @click:confirm="handleDeleteConfirm"
            @click:close="toggleDeleteItemModal(false)"
        />

        <edit-item-modal
            :show="shouldShowEditItemModal"
            :selected="selectedForEditing"
            @click:close="toggleEditItemModal(false)"
        />

        <add-item-modal
            :show="shouldShowAddItemModal"
            :closet-id="this.id"
            @click:close="toggleAddItemModal(false)"
        />

        <wallpaper-modal
            :show="shouldShowWallpaperModal"
            :initial-selection="wallpaper"
            @click:close="toggleWallpaperModal(false)"
            @click:submit="handleWallpaperSelect"
        />
    </div>
</template>

<script>
import { mapActions, mapState } from 'pinia';
import { useStore } from '@/store';
import { HandRaisedIcon } from '@heroicons/vue/24/outline';
import { Link } from "@inertiajs/inertia-vue3";
import ZeroState from "@/Jetstream/ZeroState.vue";
import FloatingButtons from '@/Jetstream/FloatingButtons.vue'
import EmptyState from '@/Jetstream/EmptyState.vue';
import FloatingButton from '@/Jetstream/FloatingButton.vue'
import CoverImage from "@/Common/CoverImage.vue";
import TileLayout from "@/Common/Tiles/TileLayout.vue";
import { updateQueryStringParameter } from '@/Util/Url'
import DeleteItemModal from "./DeleteItemModal.vue";
import WallpaperModal from '@/Common/Tiles/WallpaperModal.vue'
import EditItemModal from './EditItemModal.vue';
import AddItemModal from './AddItemModal.vue';

export default {
    components: {
        AddItemModal,
        Link,
        ZeroState,
        DeleteItemModal,
        TileLayout,
        FloatingButtons,
        FloatingButton,
        WallpaperModal,
        EditItemModal,
        EmptyState,
        CoverImage,
        HandRaisedIcon
    },

    props: {
        id: {
            type: String,
            default: "",
        },
        user_id: {
            type: String,
            default: "",
        },
        wallpaper: {
            type: String,
            default: "",
        },
        name: {
            type: String,
            default: "",
        },
        public: {
            type: Boolean,
            default: true
        },
        items: {
            type: Array,
            default: [],
        },
    },

    emits: ["click:create-page", "click:delete-page"],

    data() {
        return {
            shouldShowDeleteModal: false,
            shouldShowWallpaperModal: false,
            shouldShowEditItemModal: false,
            shouldShowAddItemModal: false,
            selectedForDeletion: null,
            selectedForEditing: null,
            newItem: null,
            searcUrl: '',

            form: this.$inertia.form({
                id: this.id,
                name: this.name,
                user_id: this.user_id,
                public: this.public,
                wallpaper: this.wallpaper,
            }),
        };
    },

    computed: {
        ...mapState(useStore, []),

        coverImageStyles() {
            if (this.wallpaper) {
                // Change width of wallpaper image to match viewport
                const wallpaperUrl = updateQueryStringParameter(this.wallpaper, 'w', window.innerWidth);

                return {
                    'background-image':`url(${wallpaperUrl})`
                }
            }
            
            return {};
        },
    },

    methods: {
        ...mapActions(useStore, ['setSaveModeItem', 'removeSaveModeItem']),

        setForm() {
            this.form.id = this.id;
            this.form.user_id = this.user_id;
            this.form.wallpaper = this.wallpaper;
            this.form.name = this.name;
            this.form.public = this.public;
        },

        toggleDeleteItemModal(show, selected = null) {
            this.shouldShowDeleteModal = show;
            this.selectedForDeletion = selected;
        },

        toggleEditItemModal(show, selected = null) {
            this.shouldShowEditItemModal = show;
            this.selectedForEditing = selected;
        },

        toggleAddItemModal(show) {
            this.shouldShowAddItemModal = show;
        },

        toggleWallpaperModal(show) {
                this.shouldShowWallpaperModal = show;
        },

        handleWallpaperSelect(selected) {
            this.setForm();
            this.form.wallpaper = selected;
            this.saveCloset();
        },

        handleDeleteConfirm() {
            this.shouldShowDeleteModal = false;

            this.$inertia.delete(
                this.route('delete-item', [this.id, this.selectedForDeletion.id])
            );
        },

        saveCloset() {
            this.form.put(this.route('update-closet', this.id));
        },
    },
};
</script>
