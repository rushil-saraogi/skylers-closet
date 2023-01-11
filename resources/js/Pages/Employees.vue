<template>
    <app-layout title="Trips">
        <div class="w-full mt-4">
            <div v-if="employees.length > 0" class="w-full">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold">Employees</h2>
                    <jet-button
                        class="ml-2 flex items-center"
                        @click="toggleCreateUserModal(true)"
                    >
                        <PlusIcon class="h-4 w-4 text-white mr-2" />
                        Add User
                    </jet-button>
                </div>


                <list
                    :items="employees.map(employee => ({
                        header: employee.name,
                        subheader: employee.email,
                        badge: employee.role,
                    }))"
                    class="mt-3 shadow-3xl"
                    @click:item="handleEmployeeClick"
                />
            </div>
            <div v-else>
                <zero-state
                    header="No Employees"
                    copy="A hotel without employees is going to seem a little haunted."
                    cta="Add"
                    @cta:click="toggleCreateUserModal(true)"
                />
            </div>

            <create-user-modal
                :show="shouldShowCreateUserModal"
                :selected="selectedToEdit"
                :hotels="hotels"
                @click:close="toggleCreateUserModal(false)"
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
    props: [
        'auth',
        'hotels',
        'employees'
    ],

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
            shouldShowCreateUserModal: false,
            selectedToEdit: null,
        };
    },

    computed: {

    },

    methods: {
        handleEmployeeClick() {
            console.log('handle employee click');
        },

        toggleCreateUserModal(show, selected = null) {
            this.selectedToEdit = selected;
            this.shouldShowCreateUserModal = show;
        },
    },
};
</script>
