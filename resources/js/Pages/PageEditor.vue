<template>
    <app-layout title="Page Editor">
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ form.slug }}
                </h2>
                <div>
                    <jet-secondary-button @click="toggleEditTileModal(true)" class="mr-3">Add Tile</jet-secondary-button>
                    <jet-button @click="savePage">Save</jet-button>
                </div>
            </div>
        </template>

        <div class="max-w-3xl mx-auto mt-10">
            <link-layout
                v-if="page.links"
                :links="page.links"
                :initial-layout="form.layout"
                @click:edit-tile="(selected) => toggleEditTileModal(true, selected)"
                @click:delete-tile="deleteTile"
                @update:layout="handleLayoutUpdate"
            />
        </div>

        <edit-tile-modal
            :show="shouldShowEditTileModal"
            :page-id="page.id"
            :selected-tile="selectedTile"
            @click:close="toggleEditTileModal(false)"
        />
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetCheckbox from '@/Jetstream/Checkbox.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import IconButton from '@/Jetstream/IconButton.vue'
    import LinkLayout from './Partials/PubSite/LinkLayout.vue'
    import EditTileModal from './Partials/PubSite/EditTileModal.vue'

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
        },

        data() {
            return {
                form: this.$inertia.form({
                    id: this.page.id,
                    slug: this.page.slug,
                    layout: this.page.layout
                }),
                shouldShowEditTileModal: false,
                selectedTile: null,
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

            handleLayoutUpdate(newLayout) {
                this.form.layout = newLayout;
            },

            savePage() {
                this.form.put(this.route('update-page', this.page.id));
            },
        }
    }
</script>
