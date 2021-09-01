<template>
    <app-layout title="Page Editor">
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ form.slug }}
                </h2>
                <div>
                    <jet-secondary-button @click="openSite" class="mr-3">Go to site</jet-secondary-button>
                    <jet-button @click="savePage">Save</jet-button>
                </div>
            </div>
        </template>

        <div class="w-full bg-center bg-cover p-10 bg-black" :style="pageContainerStyles">
            <div class="max-w-3xl mx-auto">
                <link-layout
                    v-if="page.links"
                    :links="page.links"
                    :initial-layout="form.layout"
                    @click:edit-tile="(selected) => toggleEditTileModal(true, selected)"
                    @click:delete-tile="deleteTile"
                    @update:layout="handleLayoutUpdate"
                />
            </div>
        </div>

        <floating-buttons>
            <floating-button @click="toggleWallpaperModal(true)" icon="wallpaper" />
            <floating-button @click="toggleEditTileModal(true)" icon="add" />
        </floating-buttons>
        
        <edit-tile-modal
            :show="shouldShowEditTileModal"
            :page-id="page.id"
            :selected-tile="selectedTile"
            @click:close="toggleEditTileModal(false)"
        />

        <wallpaper-modal
            :show="shouldShowWallpaperModal"
            :initial-selection="page.wallpaper"
            @click:close="toggleWallpaperModal(false)"
            @click:submit="handleWallpaperSelect"
        />
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetCheckbox from '@/Jetstream/Checkbox.vue'
    import FloatingButtons from '@/Jetstream/FloatingButtons.vue'
    import FloatingButton from '@/Jetstream/FloatingButton.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import IconButton from '@/Jetstream/IconButton.vue'
    import LinkLayout from './Partials/PubSite/LinkLayout.vue'
    import EditTileModal from './Partials/PubSite/EditTileModal.vue'
    import WallpaperModal from './Partials/PubSite/WallpaperModal.vue'
    import { updateQueryStringParameter } from '@/Util/Url'

    export default {
        props: ['page'],

        components: {
            AppLayout,
            JetButton,
            JetSecondaryButton,
            JetInput,
            JetCheckbox,
            JetLabel,
            IconButton,
            LinkLayout,
            EditTileModal,
            WallpaperModal,
            FloatingButtons,
            FloatingButton,
        },

        data() {
            return {
                form: this.$inertia.form({
                    id: this.page.id,
                    slug: this.page.slug,
                    layout: this.page.layout,
                    wallpaper: this.page.wallpaper,
                }),
                shouldShowEditTileModal: false,
                shouldShowWallpaperModal: false,
                selectedTile: null,
            }
        },

        computed: {
            pageContainerStyles() {
                if (this.page.wallpaper) {
                    // Change width of wallpaper image to match viewport
                    const wallpaperUrl = updateQueryStringParameter(this.page.wallpaper, 'w', window.innerWidth);

                    return {
                        'background-image':`url(${wallpaperUrl})`
                    }
                }
                
                return {};
            }
        },

        methods: {
            deleteTile(id) {
                this.form.put(this.route('update-page', this.page.id)); // Update the layout
                this.form.delete(this.route('delete-link', [this.page.id, id])) // Then delete the tile
            },

            shouldShowDeleteButton() {
                return this.form.links.length > 1;
            },

            shouldShowAddButton(index) {
                return index === this.form.links.length - 1;
            },

            toggleEditTileModal(show, data = null) {
                this.selectedTile = data;
                this.shouldShowEditTileModal = show;
            },

            toggleWallpaperModal(show) {
                this.shouldShowWallpaperModal = show;
            },

            handleLayoutUpdate(newLayout) {
                this.form.layout = newLayout;
            },

            savePage() {
                this.form.put(this.route('update-page', this.page.id));
            },

            handleWallpaperSelect(selected) {
                this.form.wallpaper = selected;
                this.savePage();
            },

            openSite() {
                window.open(`/${this.page.slug}`, '_blank');
            },
        }
    }
</script>
