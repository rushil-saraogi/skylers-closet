<template>
    <vue-sortable
        :options="options"
        @sortable:stop="handleItemMoved"
    >
        <vue-draggable-container
            tag="ul"
            class="grid gap-6 md:grid-cols-3 sm:grid-cols-2 grid-col-1"
        >
            <li v-if="isLoadingItem">
                <LoaderTile />
            </li>

            <li 
                v-else
                v-for="(item, index) in items"
                ref="item"
                :key="index"
                class="item"
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
            activeItem: null,
            form: this.$inertia.form({
                title: "",
                url: "",
                brand: "",
                price: "",
                manufacturer: "",
                asin: "",
                rating: "",
                image: "",
                item_order: null,
            }),

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
        ...mapActions(useStore, ["removeSaveModeItem"]),

        handleItemMoved(e) {
            if (e.data.newIndex === e.data.oldIndex) {
                return;
            }

            const onFinish = () => this.form.reset();

            this.setFromData(this.activeItem);
            
            this.form.item_order = this.items.length - e.data.newIndex - 1;

            this.form.put(
                this.route("update-item", [this.selectedCloset.id, this.activeItem.id]),
                { onFinish }
            );
        },

        setFromData(data) {
            this.form.title = data.title;
            this.form.url = data.url;
            this.form.brand = data.brand;
            this.form.price = data.price;
            this.form.asin = data.asin;
            this.form.rating = data.rating;
            this.form.image = data.image;
        },

        setActiveItem(item) {
            this.activeItem = item;
        },

        saveItem(item) {
            const onFinish = () => {
                this.form.reset();
                this.removeSaveModeItem();
            };

            this.setFromData(item);
            this.form.post(
                this.route("create-item", [this.selectedCloset.id]),
                { onFinish }
            );
        },
    },
};
</script>

<style scoped>
.item {
    max-width: 390px;
}
</style>