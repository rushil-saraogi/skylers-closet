<template>
    <grid-layout
        v-if="layout && layout.length"
        :layout="layout"
        :col-num="colNum"
        :row-height="30"
        :is-draggable="draggable"
        :is-resizable="resizable"
        :vertical-compact="true"
        :use-css-transforms="true"
        :prevent-collision="false"
        :responsive="false"
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
                @click:edit="$emit('click:edit-tile')"
                :data="links[index]"
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
</template>

<script>
    import Tile from './Tile';
    import ZeroState from '@/Jetstream/ZeroState.vue';

    export default {
        components: { Tile, ZeroState },

        emits: ['click:edit-tile'],

        data() {
            return {
                layout: [],
                draggable: true,
                resizable: true,
                index: 0,
                colNum: 4,
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
            initalLayout: {
                type: Array,
                default: []
            },
        },

        mounted() {
            for (const link of this.links) {
                this.addItem();
            }
            console.log(this.layout);
        },

        methods: {
            addItem: function () {
                // Add a new item. It must have a unique key!
                this.layout.push({
                    x: (this.layout.length * 2) % (this.colNum || 12),
                    y: this.layout.length + (this.colNum || 12), // puts it at the bottom
                    w: 2,
                    h: 2,
                    i: this.layout.length - 1,
                });
            },

            removeItem: function (val) {
                const index = this.layout.map(item => item.i).indexOf(val);
                this.layout.splice(index, 1);
            },
        }
    }
</script>

<style scoped>
/* 
    Vue Grid Layout needs classes to be overriden for styling
    Details here - https://jbaysolutions.github.io/vue-grid-layout/guide/styling.html#placeholder
*/
.vue-grid-layout {
    /* background: red; */
}
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