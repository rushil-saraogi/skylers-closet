<template>
    <grid-layout
        v-if="layout && layout.length"
        :layout="layout"
        :colNum="colNum"
        :row-height="GRID_CONSTANTS.rowHeight"
        :is-draggable="draggable"
        :is-resizable="resizable"
        :responsive="responsive"
        :vertical-compact="true"
        :use-css-transforms="true"
        :prevent-collision="false"
        :breakpoints="breakpoints"
        @layout-updated="handleLayoutUpdate"
    >
        <grid-item
            v-for="(item, index) in layout"
            :key="index"
            :static="item.static"
            :x="item.x"
            :y="item.y"
            :w="item.w"
            :h="item.h"
            :i="item.i"
        >
            <div class="w-full h-full">
                <link-tile
                    @click:edit="$emit('click:edit-tile', tiles[index])"
                    @click:delete="toggleDeleteLinkModal(true, index)"
                    v-if="tiles[index].type === TILE_TYPE_LINK"
                    :data="tiles[index].data"
                    :gridPosition="item"
                    :pub-mode="pubMode"
                />
                <text-tile
                    @click:edit="$emit('click:edit-tile', tiles[index])"
                    @click:delete="toggleDeleteLinkModal(true, index)"
                    v-if="tiles[index].type === TILE_TYPE_TEXT"
                    :data="tiles[index].data"
                    :gridPosition="item"
                    :pub-mode="pubMode"
                />
                <map-tile
                    @click:edit="$emit('click:edit-tile', tiles[index])"
                    @click:delete="toggleDeleteLinkModal(true, index)"
                    v-if="tiles[index].type === TILE_TYPE_MAP"
                    :data="tiles[index].data"
                    :gridPosition="item"
                    :pub-mode="pubMode"
                />
            </div>
        </grid-item>
    </grid-layout>

    <delete-link-modal
        :show="shouldShowDeleteModal"
        @click:confirm="handleDeleteConfirm"
        @click:close="toggleDeleteLinkModal(false)" 
    />
</template>

<script>
    import { breakpoints } from '@/constants.js';
    import LinkTile from './LinkTile';
    import TextTile from './TextTile';
    import MapTile from './MapTile';
    import DeleteLinkModal from './DeleteLinkModal.vue';
    import { GRID_CONSTANTS, TILE_TYPE_LINK, TILE_TYPE_TEXT, TILE_TYPE_MAP} from './constants';

    export default {
        components: { LinkTile, DeleteLinkModal, TextTile, MapTile },

        emits: ['click:edit-tile', 'update:layout', 'click:delete-tile'],

        data() {
            return {
                layout: [],
                draggable: !this.pubMode,
                resizable: !this.pubMode,
                responsive: false,
                index: 0,
                breakpoints,
                colNum: 2,
                shouldShowDeleteModal: false,
                selectedForDeletion: null,
                GRID_CONSTANTS,
                TILE_TYPE_LINK,
                TILE_TYPE_TEXT,
                TILE_TYPE_MAP,
            }
        },

        props: {
            tiles: {
                type: Array,
                default: [],
            },
            columns: {
                type: Number,
                default: 2,
            },
            initialLayout: {
                type: Array,
                default: null
            },
            pubMode: {
                type: Boolean,
                default: false
            },
        },

        mounted() {
            this.resetLayout();
        },

        watch: {
            tiles(newVal, oldVal) {
                if (newVal.length > oldVal.length) {
                    this.addItems(newVal.length - oldVal.length);
                }
            },

            initialLayout() {
                this.resetLayout();
            }
        },

        methods: {
            addItems: function (n = 1) {
                for (let i = 0; i < n; i++) {
                    this.layout.push({
                        x: (this.layout.length * 2) % (this.colNum),
                        y: this.layout.length + this.colNum, // puts it at the bottom
                        w: 1,
                        h: 4,
                        i: this.layout.length,
                    });
                }
            },

            removeItem: function (index) {
                this.layout.splice(index, 1);
            },

            handleDeleteConfirm() {
                this.removeItem(this.selectedForDeletion);
                this.$emit('click:delete-tile', this.tiles[this.selectedForDeletion].id);
                this.toggleDeleteLinkModal(false);
            },

            handleLayoutUpdate(newLayout) {
                this.$emit('update:layout', newLayout);
            },

            toggleDeleteLinkModal(show, selected = null) {
                this.selectedForDeletion = selected;
                this.shouldShowDeleteModal = show;
            },

            resetLayout() {
                this.layout = this.initialLayout || [];

                if (this.initialLayout && this.initialLayout.length < this.tiles.length) {
                    this.addItems(this.tiles.length - this.initialLayout.length);
                }

                if (!this.initialLayout) {
                    this.addItems(this.tiles.length);
                }
            }
        }
    }
</script>
