<template>
    <app-layout title="Explore">
        <div class="w-full">
            <CategorySelect
                :selected="selected.id"
                as="link"
            />
            <div v-if="(closets && closets.length)" class="mt-10 grid gap-6 md:grid-cols-3 sm:grid-cols-2 grid-col-1">
                <ClosetTile
                    v-for="closet in closets"
                    :key="closet.id"
                    v-bind="closet"
                />
            </div>
            <empty-state v-else message="Nothing here yet" />
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
import EmptyState from '../Jetstream/EmptyState.vue';

export default {
    props: ["categories", "selected", "closets"],

    components: {
        AppLayout,
        JetButton,
        CategorySelect,
        ClosetTile,
        EmptyState
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
