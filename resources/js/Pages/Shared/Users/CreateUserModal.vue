<template>
    <dialog-modal :show="show" @close="$emit('click:close')">
        <template #title>
            <div class="flex justify-between">
                <div>
                    <div v-if="selected">Edit employee</div>
                    <div v-else>Add employee</div>
                </div>
                <div v-if="selected">
                    <IconButton
                        @click="toggleDeleteEmployeeModal"
                        variant="filled"
                    >
                        <TrashIcon class="h-5 w-5 text-gray-600" />
                    </IconButton>
                </div>
            </div>
        </template>

        <template #content>
            <div>
                <form class="mt-3">
                    <jet-label for="employeeName" value="Name" />
                    <input-group
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        placeholder="Name"
                        id="employeeNameInput"
                        :error="error"
                    />
                    <p class="text-sm text-gray-500 mt-2 ml-1">
                        Needs to be atleast 3 characters long
                    </p>

                    <jet-label for="email" value="Email" class="mt-4" />
                    <input-group
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        placeholder="Email"
                        :error="error"
                    />

                    <jet-label for="hotel" value="Assign to hotel" class="mt-4" />

                    <hotel-dropdown
                        class="mt-2"
                        :list="hotels"
                        :selected="selectedHotel"
                        @click:hotel="handleHotelSelect"
                    />

                    <jet-label class="mt-4" for="closetCategoryDropdown" value="Role" />
                    <RoleSelect
                        :selected="form.role"
                        class="mt-2"
                        @click:role="handleRoleSelect"
                    />
                    <div class="text-sm text-gray-500 mt-2 ml-1">
                        <div v-if="form.role === ROLES.EMPLOYEE">Employees can manage trips and guest information.</div>
                        <div v-if="form.role === ROLES.ADMIN">Admins can do anything a employee can do, plus manage employees and settings (including app design).</div>
                        <div v-if="form.role === ROLES.OWNER">An owner will have full access to the system. Be careful who you give this role to.</div>
                    </div>
                </form>
                <delete-user-modal
                    :show="shouldShowDeleteModal"
                    @click:confirm="deleteEmployee"
                    @click:close="toggleDeleteEmployeeModal(false)"
                />
            </div>
        </template>

        <template #footer>
            <jet-secondary-button @click="$emit('click:close')" class="mt-3 sm:mt-0 sm:ml-3">Nevermind</jet-secondary-button>
            <jet-button @click="submit" :disabled="isSubmitDisabled" class="sm:ml-3 mt-3 sm:mt-0">
                {{ selected ? 'Save' : 'Create' }}
            </jet-button>
        </template>
    </dialog-modal>
</template>

<script>
import DialogModal from '@/Jetstream/DialogModal.vue';
import JetButton from '@/Jetstream/Button.vue'
import { DEFAULT_ROLE, ROLES } from '@/constants';
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import InputGroup from '@/Jetstream/InputGroup.vue'
import DeleteUserModal from './DeleteUserModal.vue'
import JetLabel from '@/Jetstream/Label.vue'
import HotelDropdown from '@/Jetstream/HotelDropdown.vue'
import RoleSelect from './RoleSelect.vue';
import IconButton from '@/Jetstream/IconButton.vue';
import { TrashIcon } from '@heroicons/vue/24/outline';

export default {
    props: ['show', 'selected', 'hotels'],

    emits: ['click:close'],

    components: {
        DialogModal,
        JetButton,
        JetSecondaryButton,
        InputGroup,
        JetLabel,
        RoleSelect,
        IconButton,
        TrashIcon,
        DeleteUserModal,
        HotelDropdown
    },

    data() {
        return {
            form: this.$inertia.form({
                name: '',
                email: '',
                role: '',
                hotel_id: '',
            }),
            ROLES,
            selectedHotel: this.hotels[0],
            error: null,
            shouldShowDeleteModal: false,
        }
    },

    watch: {
        show(newVal) {
            if (newVal) {
                this.initializeForm()
            }
        }
    },

    computed: {
        isSubmitDisabled() {
            return this.form.name.length < 3 || !this.form.email || !this.form.role;
        }
    },

    methods: {
        submit() {
            const onSuccess = () => {
                this.form.reset();
                this.$emit('click:close');
            }

            this.form.hotel_id = this.selectedHotel.id;

            if (this.selected) {
                this.form.put(this.route('update-user', [this.selected.id]), { onSuccess });
                return;
            }

            this.form.post(route('create-user'), {
                preserveScroll: true,
                onSuccess
            });
        },

        deleteEmployee() {
            this.toggleDeleteEmployeeModal(false);

            if (!this.selected) {
                return;
            }

            this.$emit('click:close');

            this.$inertia.delete(
                this.route('delete-closet', [this.selected.id])
            );
        },

        toggleDeleteEmployeeModal(value) {
            this.shouldShowDeleteModal = value || !this.shouldShowDeleteModal;
        },

        handleRoleSelect(selected) {
            this.form.role = selected;
        },

        handleHotelSelect(selected) {
            this.selectedHotel = selected;
        },

        initializeForm() {
            this.$nextTick(() => {
                document.getElementById("employeeNameInput").focus();
            });

            this.form.name = this.selected ? this.selected.name : '';
            this.form.role = this.selected ? this.selected.role : DEFAULT_ROLE;
        }
    }
}
</script>