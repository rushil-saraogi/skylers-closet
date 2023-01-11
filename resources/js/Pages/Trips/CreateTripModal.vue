<template>
    <dialog-modal :show="show" @close="$emit('click:close')">
        <template #title>
            <div class="flex justify-between">
                <div>
                    <div v-if="selected">Edit Trip</div>
                    <div v-else>Add Trip</div>
                </div>
                <div v-if="selected">
                    <IconButton
                        @click="toggleDeleteTripModal"
                        variant="filled"
                    >
                        <TrashIcon class="h-5 w-5 text-gray-600" />
                    </IconButton>
                </div>
            </div>
        </template>

        <template #content>
            <div>
                <div class="mt-3">
                    <jet-label
                        for="startDate"
                        value="Trip Dates"
                    />
                    <Datepicker
                        v-model="dateRange"
                        class="mt-2 shadow-sm border-gray-300 text-sm"
                        range
                        auto-apply
                        placeholder="Check in - Check out"
                        input-class-name="date-input"
                        :enable-time-picker="false"
                    />

                    <jet-label value="Room Number" class="mt-4" />
                    <input-group
                        type="number"
                        class="mt-1 block w-full"
                        v-model="form.room_number"
                        placeholder="Ex - 101, 102, 103"
                        :error="error"
                    />


                    <jet-label value="Guests" class="mt-4" />

                    <div class="flex flex-col gap-1">
                        <div class="flex gap-3 items-center" v-for="(guest, index) in guests" :key="index">
                            <div class="flex gap-3 flex-1">
                                <input-group
                                    type="email"
                                    class="mt-1 block w-full"
                                    v-model="guest.email"
                                    placeholder="Email"
                                    :error="error"
                                />
                                <input-group
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="guest.name"
                                    placeholder="Name (Optional)"
                                    :error="error"
                                />
                            </div>
                            <IconButton
                                @click="removeGuest(index)"
                            >
                                <TrashIcon class="h-5 w-5 text-gray-500" />
                            </IconButton>
                        </div>
                    </div>
                    

                    <secondary-button
                        @click="addGuest"
                        class="mt-3"
                    >
                        Add Guest
                    </secondary-button>

                    <jet-label for="hotel" value="Hotel" class="mt-4" />

                    <hotel-dropdown
                        class="mt-2"
                        :list="hotels"
                        :selected="selectedHotel"
                        @click:hotel="handleHotelSelect"
                    />
                </div>
                <delete-trip-modal
                    :show="shouldShowDeleteModal"
                    @click:confirm="deleteTrip"
                    @click:close="toggleDeleteEmployeeModal(false)"
                />
            </div>
        </template>

        <template #footer>
            <jet-secondary-button @click="$emit('click:close')" class="mt-3 sm:mt-0 sm:ml-3">Nevermind</jet-secondary-button>
            <jet-button @click="submit" :disabled="isSubmitDisabled" class="sm:ml-4 mt-3 sm:mt-0">
                {{ selected ? 'Save' : 'Create' }}
            </jet-button>
        </template>
    </dialog-modal>
</template>

<script>
import DialogModal from '@/Jetstream/DialogModal.vue';
import JetButton from '@/Jetstream/Button.vue'
import SecondaryButton from '@/Jetstream/SecondaryButton.vue'
import InputGroup from '@/Jetstream/InputGroup.vue'
import DeleteTripModal from './DeleteTripModal.vue'
import JetLabel from '@/Jetstream/Label.vue'
import HotelDropdown from '@/Jetstream/HotelDropdown.vue'
import IconButton from '@/Jetstream/IconButton.vue';
import { TrashIcon } from '@heroicons/vue/24/outline';

export default {
    props: ['show', 'selected', 'hotels'],

    emits: ['click:close'],

    components: {
        DialogModal,
        JetButton,
        SecondaryButton,
        InputGroup,
        JetLabel,
        IconButton,
        TrashIcon,
        DeleteTripModal,
        HotelDropdown,
    },

    data() {
        return {
            form: this.$inertia.form({
                starts_at: '',
                ends_at: '',
                hotel_id: '',
                guests: [],
                room_number: null,
            }),
            guests: [
                {
                    name: '',
                    email: '',
                }
            ],
            dateRange: null,
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
            return !this.dateRange ||
            !this.guests[0]?.email ||
            !this.form.room_number ||
            !this.selectedHotel; 
        }
    },

    methods: {
        submit() {
            const onSuccess = () => {
                this.form.reset();
                this.$emit('click:close');
            }

            this.form.hotel_id = this.selectedHotel.id;
            [this.form.starts_at, this.form.ends_at] = this.dateRange;
            this.form.guests = this.guests;

            if (this.selected) {
                this.form.put(this.route('update-trip', [this.selected.id]), { onSuccess });
                return;
            }

            this.form.post(route('create-trip'), {
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

        handleHotelSelect(selected) {
            this.selectedHotel = selected;
        },

        addGuest() {
            this.guests.push({
                name: '',
                email: '',
            });
        },

        removeGuest(index) {
            if (this.guests.length === 1) {
                this.guests = [
                    {
                        name: '',
                        email: '',
                    }
                ];
                return;
            }

            this.guests.splice(index, 1);
        },

        initializeForm() {
            this.form.name = this.selected ? this.selected.name : '';
        }
    }
}
</script>

<style scoped>
    .date-input {
        font-size: 10px;
    }
</style>