<template>
    <app-layout title="Dashboard">
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Your Pages
                </h2>
                <div>
                    <jet-button @click="toggleCreatePageModal(true)">Add Page</jet-button>
                </div>
            </div>
        </template>

        <div class="py-12 px-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
                <page-list :data="pages"
                    @click:create-page="toggleCreatePageModal(true)"
                    @click:delete-page="deletePage"
                />
            </div>
        </div>

        <create-page-modal
            :show="shouldShowCreatePageModal"
            @click:close="toggleCreatePageModal(false)" 
        />
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout.vue'
    import PageList from './Partials/Dashboard/PageList.vue'
    import CreatePageModal from './Partials/Dashboard/CreatePageModal.vue'
    import JetButton from '@/Jetstream/Button';

    export default {
        props: ['pages'],
        components: {
            AppLayout,
            PageList,
            CreatePageModal,
            JetButton,
        },
        data() {
            return {
                shouldShowCreatePageModal: false,
            }
        },
        methods: {
            toggleCreatePageModal(show) {
                this.shouldShowCreatePageModal = show;
            },

            deletePage(id) {
                this.$inertia.delete(this.route('delete-page', id));
            }
        }
    }
</script>
