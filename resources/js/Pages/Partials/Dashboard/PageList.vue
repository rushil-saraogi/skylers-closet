<template>
    <div class="w-full">
        <div v-if="data && data.length" class="grid gap-5 grid-cols-1 sm:grid-cols-2 md:grid-cols-4">
            <div v-for="page in data" :key="page.id">
                <page-thumb
                    @click="handlePageClick(page)"
                    @click:delete-page="toggleDeletePageModal(true, page.id)"
                >
                    /{{ page.slug }}
                </page-thumb>
            </div>
        </div>
        <zero-state
            v-else
            header="Get started"
            copy="Start here by creating a page!"
            cta="Create Page"
            @cta:click="$emit('click:create-page')"
        />

        <delete-page-modal
            :show="shouldShowDeleteModal"
            @click:confirm="handleDeleteConfirm"
            @click:close="toggleDeletePageModal(false)" 
        />
    </div>
</template>

<script>
    import { Link } from '@inertiajs/inertia-vue3';
    import PageThumb from '@/Jetstream/PageThumb.vue';
    import ZeroState from '@/Jetstream/ZeroState.vue';
    import DeletePageModal from './DeletePageModal.vue';

    export default {
        props: {
            data: Array
        },

        emits: ['click:create-page', 'click:delete-page'],

        data() {
            return {
                shouldShowDeleteModal: false,
                selectedForDeletion: null,
            }
        },

        components: {
            PageThumb,
            Link,
            ZeroState,
            DeletePageModal,
        },

        methods: {
            handlePageClick(page) {
                this.$inertia.visit(route('page-editor', page.id));
            },

            toggleDeletePageModal(show, selected = null) {
                this.selectedForDeletion = selected;
                this.shouldShowDeleteModal = show;
            },

            handleDeleteConfirm() {
                this.$emit('click:delete-page', this.selectedForDeletion);
                this.shouldShowDeleteModal = false;
            }
        }
    }
</script>
