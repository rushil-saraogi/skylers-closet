<template>
    <app-layout title="Explore">
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Explore
                </h2>
                <!-- <div>
                    <jet-button @click="toggleCreateClosetModal(true)">Create new closet</jet-button>
                </div> -->
            </div>
        </template>

        <div class="w-full">
            <CategorySelect
                :selected="selected.id"
                as="link"
            />
            <div class="mt-10 grid gap-6 md:grid-cols-3 sm:grid-cols-2 grid-col-1">
                <ClosetTile
                    v-for="closet in closets"
                    :key="closet.id"
                    v-bind="closet"
                />
            </div>
        </div>
    </app-layout>
</template>

<script>
import { mapActions } from "pinia";
import { useStore } from "@/store";
import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Jetstream/Button";
import CategorySelect from './Partials/Dashboard/CategorySelect.vue';
import ClosetTile from '@/Common/Tiles/ClosetTile.vue';

export default {
    props: ["categories", "selected", "closets"],

    components: {
        AppLayout,
        JetButton,
        CategorySelect,
        ClosetTile,
    },

    mounted() {
        this.setCategories(this.categories);
        this.selectCategory(this.selected);
    },

    data() {
        return {};
    },

    methods: {
        ...mapActions(useStore, ['selectCategory', 'setCategories']),
    },
};
</script>
