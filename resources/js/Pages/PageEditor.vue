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
                    <jet-secondary-button @click="openSite" class="mr-3">Preview</jet-secondary-button>
                    <jet-button>Publish</jet-button>
                </div>
            </div>
        </template>

        <div class="w-full bg-center bg-cover p-10" :style="pageContainerStyles">
            <div class="mx-auto max-w-md phone overflow-scroll p-3">
                <tile-layout
                    v-if="page.tiles.length"
                    :title="page.title"
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
                <div @click="toggleSelectTileModal(true)" class="h-40 bg-gray-300/80 rounded-lg w-full duration-200 mt-3 items-center flex justify-center hover:bg-gray-400/50 hover:cursor-pointer">
                    <PlusIcon class="h-10 w-10 text-gray-600" />
                </div>
            </div>
        </div>

        <floating-buttons>
            <floating-button tooltip="Edit wallpaper" @click="toggleWallpaperModal(true)" icon="wallpaper" />
            <floating-button tooltip="Add Location" @click="toggleMapModal(true)" icon="location_on" />
            <floating-button tooltip="Add Text" @click="toggleTextTileModal(true)" icon="title" />
            <floating-button tooltip="Add Link" @click="toggleEditLinkTileModal(true)" icon="link" />
        </floating-buttons>

        <add-tile-modal
            :show="shouldShowAddTileModal"
            :page-id="page.id"
            :selected-tile="selectedTile"
            @click:close="toggleMapModal(false)"
        />
        
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

        <select-tile-modal
            :show="shouldShowSelectTileModal"
            @click:close="toggleSelectTileModal(false)"
        />
    </app-layout>
</template>

<script>
    import { PlusIcon } from '@heroicons/vue/solid'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetCheckbox from '@/Jetstream/Checkbox.vue'
    import FloatingButtons from '@/Jetstream/FloatingButtons.vue'
    import FloatingButton from '@/Jetstream/FloatingButton.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import TileLayout from '../Common/Tiles/TileLayout.vue'
    import ZeroState from '@/Jetstream/ZeroState.vue';
    import LinkTileModal from '@/Common/Tiles/LinkTileModal.vue'
    import TextTileModal from '@/Common/Tiles/TextTileModal.vue'
    import MapTileModal from '@/Common/Tiles/MapTileModal.vue'
    import WallpaperModal from '@/Common/Tiles/WallpaperModal.vue'
    import SelectTileModal from '@/Common/Tiles/SelectTileModal.vue'
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
            TileLayout,
            LinkTileModal,
            TextTileModal,
            WallpaperModal,
            SelectTileModal,
            FloatingButtons,
            FloatingButton,
            ZeroState,
            MapTileModal,
            PlusIcon
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
                shouldShowSelectTileModal: false,
                shouldShowAddTileModal: false,
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
            },
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

            toggleSelectTileModal(show) {
                this.shouldShowSelectTileModal = show;
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
        }
    }
</script>

<style scoped>
.phone {
    border: 20px solid black;
    border-radius: 40px;
    height: 800px;
}
</style>