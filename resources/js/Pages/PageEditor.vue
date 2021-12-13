<template>
    <app-layout title="Page Editor">
        <template #header>
            <div class="flex items-center justify-between">
                <div class="flex items-center hover:cursor-pointer hover:bg-gray-100 px-2 py-1 rounded" @click="openSite">
                    <h2 class="font-semibold text-xl text-gray-800">
                        {{ form.slug }}
                    </h2>
                    <span class="material-icons text-base text-gray-500 ml-2 mt-1">launch</span>
                </div>
                
                <div>
                    <jet-secondary-button @click="openSite" class="mr-3">Go to site</jet-secondary-button>
                    <!-- <jet-button @click="toggleEditTileModal(true)">Add Tile</jet-button> -->
                </div>
            </div>
        </template>

        <div class="w-full bg-center bg-cover p-10" :style="pageContainerStyles">
            <div class="mx-auto border border-red-400" :class="tileWrapperClasses">
                <tile-layout
                    v-if="page.tiles.length"
                    :tiles="page.tiles"
                    :initial-layout="form.layout"
                    @click:edit-tile="(selected) => toggleEditTile(true, selected)"
                    @click:delete-tile="deleteTile"
                    @update:layout="handleLayoutUpdate"
                />
                <zero-state
                    v-else
                    header="Get started"
                    copy="Lets try creating your first tile"
                    cta="Create Tile"
                    @cta:click="toggleEditTile(true)"
                />
            </div>
        </div>

        <floating-buttons>
            <floating-button tooltip="Edit wallpaper" @click="toggleWallpaperModal(true)" icon="wallpaper" />
            <floating-button :tooltip="layoutButtonTooltip" @click="toggleMobileMode(!mobileModeActive)" :icon="layoutButtonIcon" />
            <floating-button tooltip="Add Location" @click="toggleMapModal(true)" icon="location_on" />
            <floating-button tooltip="Add Text" @click="toggleTextTileModal(true)" icon="title" />
            <floating-button tooltip="Add Link" @click="toggleEditLinkTileModal(true)" icon="link" />
        </floating-buttons>
        
        <link-tile-modal
            :show="shouldShowEditTileModal"
            :page-id="page.id"
            :selected-tile="selectedTile"
            @click:close="toggleEditLinkTileModal(false)"
        />

        <text-tile-modal
            :show="shouldShowTextTileModal"
            :page-id="page.id"
            :selected-tile="selectedTile"
            @click:close="toggleTextTileModal(false)"
        />

        <wallpaper-modal
            :show="shouldShowWallpaperModal"
            :initial-selection="page.wallpaper"
            @click:close="toggleWallpaperModal(false)"
            @click:submit="handleWallpaperSelect"
        />

        <map-tile-modal
            :show="shouldShowMapModal"
            :page-id="page.id"
            :selected-tile="selectedTile"
            @click:close="toggleMapModal(false)"
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
    import TileLayout from './Partials/PageEditor/TileLayout.vue'
    import ZeroState from '@/Jetstream/ZeroState.vue';
    import LinkTileModal from './Partials/PageEditor/LinkTileModal.vue'
    import TextTileModal from './Partials/PageEditor/TextTileModal.vue'
    import MapTileModal from './Partials/PageEditor/MapTileModal.vue'
    import WallpaperModal from './Partials/PageEditor/WallpaperModal.vue'
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
            TileLayout,
            LinkTileModal,
            TextTileModal,
            WallpaperModal,
            FloatingButtons,
            FloatingButton,
            ZeroState,
            MapTileModal
        },

        data() {
            return {
                form: this.$inertia.form({
                    id: this.page.id,
                    slug: this.page.slug,
                    layout: this.page.layout,
                    layout_sm: this.page.layout_sm,
                    wallpaper: this.page.wallpaper,
                }),
                shouldShowEditTileModal: false,
                shouldShowWallpaperModal: false,
                shouldShowTextTileModal: false,
                shouldShowMapModal: false,
                selectedTile: null,
                mobileModeActive: false,
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
            },

            layoutButtonTooltip() {
                return `${this.mobileModeActive ? 'Desktop' : 'Mobile'} mode`;
            },

            layoutButtonIcon() {
                return this.mobileModeActive ? 'desktop_mac' : 'smartphone';
            },

            tileWrapperClasses() {
                return {
                    'max-w-3xl': !this.mobileModeActive,
                    'max-w-lg': this.mobileModeActive
                }
            }
        },

        methods: {
            deleteTile(id) {
                this.form.put(this.route('update-page', this.page.id)); // Update the layout
                this.form.delete(this.route('delete-tile', [this.page.id, id])) // Then delete the tile
            },

            toggleEditLinkTileModal(show, selected = null) {
                this.selectedTile = selected;
                this.shouldShowEditTileModal = show;
            },

            toggleTextTileModal(show, selected = null) {
                this.selectedTile = selected;
                this.shouldShowTextTileModal = show;
            },

            toggleEditTile(show, selected) {
                if (!selected || selected.type === 'link') {
                    this.toggleEditLinkTileModal(show, selected);
                } else if (selected.type === 'text') {
                    this.toggleTextTileModal(show, selected);
                } else if (selected.type === 'map') {
                    this.toggleMapModal(show, selected);
                }
            },

            toggleWallpaperModal(show) {
                this.shouldShowWallpaperModal = show;
            },

            toggleMapModal(show, selected) {
                this.selectedTile = selected;
                this.shouldShowMapModal = show;
            },

            handleLayoutUpdate(newLayout) {
                this.form.layout = newLayout;
                this.savePage();
            },

            handleWallpaperSelect(selected) {
                this.form.wallpaper = selected;
                this.savePage();
            },

            savePage() {
                this.form.put(this.route('update-page', this.page.id));
            },

            openSite() {
                window.open(`/${this.page.slug}`, '_blank');
            },

            toggleMobileMode(active) {
                this.mobileModeActive = active;
            }
        }
    }
</script>
