<template>
    <grid-layout
        v-if="layout && layout.length"
        :layout="layout"
        :col-num="colNum"
        :row-height="GRID_CONSTANTS.rowHeight"
        :is-draggable="draggable"
        :is-resizable="resizable"
        :vertical-compact="true"
        :use-css-transforms="true"
        :prevent-collision="false"
        :responsive="false"
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
            <tile
                @click:edit="$emit('click:edit-tile', links[index])"
                @click:delete="toggleDeleteLinkModal(true, index)"
                :data="links[index]"
                :gridPosition="item"
            />
        </grid-item>
    </grid-layout>
    <zero-state
        v-else
        header="Get started"
        copy="Lets try creating your first tile"
        cta="Create Tile"
        @cta:click="$emit('click:edit-tile')"
    />
    <delete-link-modal
        :show="shouldShowDeleteModal"
        @click:confirm="handleDeleteConfirm"
        @click:close="toggleDeleteLinkModal(false)" 
    />
</template>

<script>
    import Tile from './Tile';
    import ZeroState from '@/Jetstream/ZeroState.vue';
    import DeleteLinkModal from './DeleteLinkModal.vue';
    import { GRID_CONSTANTS } from './constants';

    export default {
        components: { Tile, ZeroState, DeleteLinkModal },

        emits: ['click:edit-tile', 'update:layout', 'click:delete-tile'],

        data() {
            return {
                layout: [],
                draggable: true,
                resizable: true,
                index: 0,
                colNum: 4,
                shouldShowDeleteModal: false,
                selectedForDeletion: null,
                GRID_CONSTANTS
            }
        },

        props: {
            links: {
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
        },

        mounted() {
            this.resetLayout();
        },

        watch: {
            links(newVal, oldVal) {
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
                        x: (this.layout.length * 2) % (this.colNum || 12),
                        y: this.layout.length + (this.colNum || 12), // puts it at the bottom
                        w: 2,
                        h: 4,
                        i: this.layout.length - 1,
                    });
                }
            },

            removeItem: function (index) {
                this.layout.splice(index, 1);
            },

            handleDeleteConfirm() {
                this.removeItem(this.selectedForDeletion);
                this.$emit('click:delete-tile', this.links[this.selectedForDeletion].id);
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

                if (this.initialLayout && this.initialLayout.length < this.links.length) {
                    this.addItems(this.links.length - this.initialLayout.length);
                }

                if (!this.initialLayout) {
                    this.addItems(this.links.length);
                }
            }
        }
    }
</script>

<style scoped>
/* 
    Vue Grid Layout needs classes to be overriden for styling
    Details here - https://jbaysolutions.github.io/vue-grid-layout/guide/styling.html#placeholder
*/
.vue-grid-item:not(.vue-grid-placeholder) {
    background: #E5E7EB;
}
.vue-grid-item.vue-grid-placeholder {
    background: #2563EB;
    opacity: 0.2;
}  
.vue-grid-item .resizing {
    opacity: 0.6;
}
.vue-grid-item .static {
    background: #cce;
}
.vue-grid-item .text {
    font-size: 24px;
    text-align: center;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    margin: auto;
    height: 100%;
    width: 100%;
}
.vue-grid-item .no-drag {
    height: 100%;
    width: 100%;
}
.vue-grid-item .minMax {
    font-size: 12px;
}
.vue-grid-item .add {
    cursor: pointer;
}
.vue-draggable-handle {
    position: absolute;
    width: 20px;
    height: 20px;
    top: 0;
    left: 0;
    background: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='10' height='10'><circle cx='5' cy='5' r='5' fill='#999999'/></svg>") no-repeat;
    background-position: bottom right;
    padding: 0 8px 8px 0;
    background-repeat: no-repeat;
    background-origin: content-box;
    box-sizing: border-box;
    cursor: pointer;
}
</style>