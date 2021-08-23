<template>
    <app-layout title="Page Editor">
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ form.slug }}
                </h2>
                <div>
                    <jet-button @click="toggleEditTileModal(true)">Add Tile</jet-button>
                </div>
            </div>
        </template>

        <div class="max-w-3xl mx-auto mt-10">
            <link-layout
                v-if="page.links"
                :links="page.links"
                :initial-layout="page.layout"
                @click:edit-tile="toggleEditTileModal(true)"
            />
        </div>

        <edit-tile-modal
            :show="shouldShowEditTileModal"
            :page-id="page.id"
            @click:close="toggleEditTileModal(false)"
        />
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetCheckbox from '@/Jetstream/Checkbox.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'
    import IconButton from '@/Jetstream/IconButton.vue'
    import LinkLayout from './Partials/PubSite/LinkLayout.vue'
    import EditTileModal from './Partials/PubSite/EditTileModal.vue'

    export default {
        props: {
            page: Object
        },

        components: {
            AppLayout,
            JetButton,
            JetInput,
            JetCheckbox,
            JetLabel,
            JetValidationErrors,
            IconButton,
            LinkLayout,
            EditTileModal,
        },

        data() {
            return {
                form: this.$inertia.form({
                    slug: this.page.slug,
                }),
                shouldShowEditTileModal: false,
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('create-page'), {
                    onFinish: () => this.form.reset('slug', 'links'),
                })
            },

            addLink() {
                this.form.links.push('');
            },

            deleteLink(index) {
                this.form.links.splice(index, 1);
            },

            shouldShowDeleteButton() {
                return this.form.links.length > 1;
            },

            shouldShowAddButton(index) {
                return index === this.form.links.length - 1;
            },

            toggleEditTileModal(show) {
                this.shouldShowEditTileModal = show;
            }
        }
    }
</script>
