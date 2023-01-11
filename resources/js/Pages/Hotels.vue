<template>
    <app-layout title="Trips">
        <div v-if="hotels && hotels.length > 0" class="w-full">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold">Hotels</h2>
                <jet-button
                    class="ml-2 flex items-center"
                    @click="toggleCreateHotelModal(true)"
                >
                    <PlusIcon class="h-4 w-4 text-white mr-2" />
                    Add Hotel
                </jet-button>
            </div>


            <list
                :items="hotels.map(hotel => ({
                    header: hotel.name
                }))"
                class="mt-3 shadow-3xl"
                @click:item="handleHotelClick"
            />
        </div>
    </app-layout>
</template>

<script>
import { PlusIcon } from '@heroicons/vue/24/outline';
import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Jetstream/Button";
import List from "@/Jetstream/List.vue";

export default {
    props: [
        'auth',
        'hotels',
    ],

    components: {
        AppLayout,
        JetButton,
        List,
        PlusIcon,
    },

    mounted() {
    },

    data() {
        return {
            shouldShowCreateHotelModal: false,
            selectedToEdit: null,
        };
    },

    computed: {

    },

    methods: {
        handleHotelClick() {
            console.log('handle hotel click');
        },

        toggleCreateEmployeeModal(show, selected = null) {
            this.selectedToEdit = selected;
            this.shouldShowCreateHotelModal = show;
        },
    },
};
</script>
