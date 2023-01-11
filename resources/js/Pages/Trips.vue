<template>
    <app-layout title="Trips">
        <div class="w-full">
            <tabs
                :items="TRIP_FILTERS"
                :selected="activeTab"
                @click:tab="handleTabClick"
            />
            <div v-if="filteredTrips.length > 0" class="w-full">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold">Active Trips</h2>
                    <jet-button
                        class="ml-2 flex items-center"
                        @click="toggleCreateTripModal(true)"
                    >
                        <PlusIcon class="h-4 w-4 text-white mr-2" />
                        Add Trip
                    </jet-button>
                </div>

                <list
                    :items="filteredTrips.map(trip => ({}))"
                    class="mt-3 shadow-3xl"
                    @click:item="handleTripClick"
                />
            </div>
            <div v-else>
                <zero-state
                    class="mt-6"
                    header="No Trips Yet"
                    cta="Create Trip"
                    @cta:click="toggleCreateTripModal(true)"
                />
            </div>
            <create-trip-modal
                :show="shouldShowCreateTripModal"
                :selected="selectedToEdit"
                :hotels="hotels"
                @click:close="toggleCreateTripModal(false)"
            />
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import { TRIP_FILTERS } from "@/constants";
import Tabs from "@/Jetstream/Tabs.vue";
import JetButton from "@/Jetstream/Button";
import List from "@/Jetstream/List.vue";
import ZeroState from "@/Jetstream/ZeroState.vue";
import CreateTripModal from "@/Pages/Trips/CreateTripModal.vue";

export default {
    props: [
        'auth',
        'hotels'
    ],

    components: {
        AppLayout,
        JetButton,
        List,
        Tabs,
        ZeroState,
        CreateTripModal
    },

    mounted() {
    },

    data() {
        return {
            activeTrips: [],
            upcomingTrips: [],
            pastTrips: [],
            shouldShowCreateTripModal: false,
            TRIP_FILTERS,
            activeTab: TRIP_FILTERS[0].value,
        };
    },

    computed: {
        filteredTrips() {
            switch (this.activeTab) {
                case 'all':
                    return [];
                case 'active':
                    return [];
                case 'upcoming':
                    return [];
                case 'past':
                    return [];
                case 'cancelled':
                    return [];
                default:
                    return [];
            }
        }
    },

    methods: {
        toggleCreateTripModal(show, selected = null) {
            this.selectedToEdit = selected;
            this.shouldShowCreateTripModal = show;
        },

        handleTripClick() {
            console.log('handleTripClick');
        },

        handleTabClick(tab) {
            this.activeTab = tab;
        }
    },
};
</script>
