<template>
    <div class="w-full" :style="pageContainerStyles">
        <div>
            <product-input
                @response:meta="setSaveModeItem"
                @change:itemUrl="handleUrlChange"
            />
        </div>
        <div class="mt-7">
            <div v-if="fullItemList.length === 0">
                <smiley-with-message message="This closet looks pretty empty" />
            </div>
            <tile-layout
                :title="name"
                :items="fullItemList"
                :pub-mode="false"
                @click:edit-item="(selected) => toggleEditItem(true, selected)"
                @click:delete="toggleDeleteItemModal"
                @update:layout="handleLayoutUpdate"
                @click:edit="toggleEditItemModal"
            />
        </div>

        <floating-buttons>
            <floating-button tooltip="Edit wallpaper" @click="toggleWallpaperModal(true)" icon="wallpaper" />
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
import { Link } from "@inertiajs/inertia-vue3";
import ZeroState from "@/Jetstream/ZeroState.vue";
import FloatingButtons from '@/Jetstream/FloatingButtons.vue'
import SmileyWithMessage from '@/Jetstream/SmileyWithMessage.vue';
import FloatingButton from '@/Jetstream/FloatingButton.vue'
import TileLayout from "@/Common/Tiles/TileLayout.vue";
import { updateQueryStringParameter } from '@/Util/Url'
import DeleteItemModal from "./DeleteItemModal.vue";
import WallpaperModal from '@/Common/Tiles/WallpaperModal.vue'
import ProductInput from "./ProductInput.vue";
import EditItemModal from './EditItemModal.vue';

export default {
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
        active: {
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
            selectedForDeletion: null,
            selectedForEditing: null,
            newItem: null,
            searcUrl: '',

            form: this.$inertia.form({
                id: this.id,
                name: this.name,
                user_id: this.user_id,
                active: this.active,
                wallpaper: this.wallpaper,
            }),
        };
    },

    computed: {
        ...mapState(useStore, ['saveModeItem']),

        fullItemList() {
            return this.saveModeItem
                ? [this.saveModeItem, ...this.items]
                : this.items;
        },

        pageContainerStyles() {
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

    components: {
        Link,
        ZeroState,
        DeleteItemModal,
        TileLayout,
        FloatingButtons,
        FloatingButton,
        ProductInput,
        WallpaperModal,
        EditItemModal,
        SmileyWithMessage,
    },

    methods: {
        ...mapActions(useStore, ['setSaveModeItem', 'removeSaveModeItem']),

        handlePageClick(page) {
            this.$inertia.visit(route("page-editor", page.id));
        },

        setForm() {
            this.form.id = this.id;
            this.form.user_id = this.user_id;
            this.form.wallpaper = this.wallpaper;
            this.form.name = this.name;
            this.form.active = this.active;
        },

        toggleDeleteItemModal(show, selected = null) {
            this.shouldShowDeleteModal = show;
            this.selectedForDeletion = selected;
        },

        toggleEditItemModal(show, selected = null) {
            this.shouldShowEditItemModal = show;
            this.selectedForEditing = selected;
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

        handleUrlChange(url) {
            if (!url) {
                this.removeSaveModeItem();
            }
        }
    },
};
</script>
