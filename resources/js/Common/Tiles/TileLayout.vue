<template>
    <vue-sortable
        :options="options"
        @sortable:stop="handleItemMoved"
    >
        <vue-draggable-container
            tag="ul"
            class="grid gap-6 md:grid-cols-5 sm:grid-cols-3 grid-col-2 justify-items-center w-full"
        >
            <li 
                v-for="(item, index) in items"
                ref="item"
                :key="index"
                class="item w-full"
                @mousedown="setActiveItem(item)"
            >
                <item-tile
                    v-bind="item"
                    @click:delete="$emit('click:delete', true, item)"
                    @click:save-item="saveItem(item)"
                    @click:edit="$emit('click:edit', true, item)"
                />
            </li>
        </vue-draggable-container>
    </vue-sortable>
</template>

<script>
import { mapState, mapActions } from "pinia";
import { useStore } from "@/store";
import ItemTile from "./ItemTile";
import LoaderTile from "./LoaderTile";
import EmptyTile from "./EmptyTile.vue";
import DeleteLinkModal from "./DeleteLinkModal.vue";
import ItemsApi from '@/API/ItemsApi';

export default {
    components: {
        DeleteLinkModal,
        EmptyTile,
        ItemTile,
    LoaderTile,
    },

    emits: ["click:edit-tile", "update:layout", "click:delete-tile"],

    data() {
        return {
            form: this.$inertia.form({
                item_order: null,
            }),
            activeItem: null,
            options: {
                draggable: ".item",
                sortAnimation: {
                    duration: 200,
                    easingFunction: "ease-in-out",
                },
                // plugins: [Draggable.Plugins.SortAnimation],
            },
        };
    },

    props: {
        items: {
            type: Array,
            default: [],
        },
        pubMode: {
            type: Boolean,
            default: false,
        },
    },

    computed: {
        ...mapState(useStore, ["selectedCloset", "isLoadingItem"]),
    },

    methods: {
        ...mapActions(useStore, [""]),

        handleItemMoved(e) {
            if (e.data.newIndex === e.data.oldIndex) {
                return;
            }
            
            const newOrder = this.items.length - e.data.newIndex - 1;

            ItemsApi.updateItem({ item_order: newOrder }, this.selectedCloset.id, this.activeItem.id);
        },

        setActiveItem(item) {
            this.activeItem = item;
        },
    },
};
</script>

<style>
.item {
    max-width: 222px;
}

.item:hover {
    cursor: grab;
}

</style>