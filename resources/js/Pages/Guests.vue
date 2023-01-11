<template>
    <app-layout title="Trips">
        <div class="w-full mt-4">
            <div v-if="guests.length > 0" class="w-full">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold">Guests</h2>
                    <jet-button
                        class="ml-2 flex items-center"
                        @click="toggleCreateEmployeeModal(true)"
                    >
                        <PlusIcon class="h-4 w-4 text-white mr-2" />
                        Add Guest
                    </jet-button>
                </div>


                <list
                    :items="guests.map(guest => ({
                        header: guest.name,
                        subheader: guest.email,
                        badge: guest.role,
                    }))"
                    class="mt-3 shadow-3xl"
                    @click:item="handleEmployeeClick"
                />
            </div>
            <div v-else>
                <zero-state
                    header="No Guests"
                    copy="A hotel without guests is going to seem a little haunted."
                    cta="Add"
                    @cta:click="toggleCreateEmployeeModal(true)"
                />
            </div>

            <create-user-modal
                :show="shouldShowCreateGuestModal"
                :selected="selectedToEdit"
                :hotels="hotels"
                @click:close="toggleCreateEmployeeModal(false)"
            />
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Jetstream/Button";
import List from "@/Jetstream/List.vue";
import { PlusIcon } from '@heroicons/vue/24/outline';
import ZeroState from "@/Jetstream/ZeroState.vue";
import CreateUserModal from "@/Pages/Shared/Users/CreateUserModal.vue";

export default {
    props: {
        auth: {
            type: Object,
            required: true,
        },
        guests: {
            type: Array,
            default: [],
        },
        hotels: {
            type: Array,
            default: [],
        },
    },

    components: {
        AppLayout,
        JetButton,
        List,
        PlusIcon,
        ZeroState,
        CreateUserModal,
    },

    mounted() {
    },

    data() {
        return {
            shouldShowCreateGuestModal: false,
            selectedToEdit: null,
        };
    },

    computed: {

    },

    methods: {
        handleEmployeeClick() {
            console.log('handle employee click');
        },

        toggleCreateEmployeeModal(show, selected = null) {
            this.selectedToEdit = selected;
            this.shouldShowCreateGuestModal = show;
        },
    },
};
</script>
