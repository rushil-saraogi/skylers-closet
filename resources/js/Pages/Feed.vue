<template>
    <app-layout title="Feed">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4 md:mt-6">
                <div class="grid gap-3 md:gap-6 md:grid-cols-5 sm:grid-cols-3 grid-cols-2 justify-items-center w-full">
                    <item-tile
                        v-for="item in items.data"
                        v-bind="item"
                        class="w-full"
                        :key="item.id"
                        :pub-mode="true"
                        :with-closet-link="true"
                        :closet-link="route('show-closet', item.closet.id)"
                        @click:save="saveItemClick(item)"
                    />
                </div>

                <save-item-modal
                    :show="showSaveItemModal"
                    :selected="savingItem"
                    :closets="user_closets"
                    @click:close="toggleSaveItemModal(false)"
                    @save:item="saveItem"
                    @remove:item="undoSave"
                />
            </div>
    </app-layout>
</template>

<script>
    import { Inertia } from '@inertiajs/inertia'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import JetButton from '@/Jetstream/Button';
    import ItemTile from '@/Common/Tiles/ItemTile.vue';
    import SaveItemModal from './Partials/Closet/SaveItemModal.vue';
    import ItemsApi from '../API/ItemsApi';

    export default {
        props: ['items', 'user_closets'],

        components: {
            AppLayout,
            JetButton,
            ItemTile,
            SaveItemModal
        },

        mounted() {
        },

        data() {
            return {
                showSaveItemModal: false,
                savingItem: null,
            }
        },

        methods: {
            // ...mapActions(useStore, ['selectCloset', 'setClosets']),

            async saveItem(closet) {
                await ItemsApi.saveItem(closet.id, this.savingItem.id);
                Inertia.reload({ only: ['user_closets'] });
            },

            toggleSaveItemModal(show) {
                this.showSaveItemModal = show;
            },

            async undoSave(closet) {
                await ItemsApi.deleteByUrl(closet.id, this.savingItem.id);
                Inertia.reload({ only: ['user_closets'] });
            },

            saveItemClick(item) {
                this.savingItem = item;
                this.toggleSaveItemModal(true);
            },
        }
    }
</script>
