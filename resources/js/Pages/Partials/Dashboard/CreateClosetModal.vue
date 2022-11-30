<template>
    <dialog-modal :show="show" @close="$emit('click:close')">
        <template #title>
            <div class="flex justify-between">
                <div>
                    <div v-if="selected">Edit closet</div>
                    <div v-else>Create a new closet</div>
                </div>
                <div v-if="selected">
                    <IconButton
                        @click="toggleDeleteClosetModal"
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
                    <jet-label for="closetNameInput" value="Name" />
                    <input-group
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        placeholder="Name"
                        id="closetNameInput"
                        :error="error"
                    />
                    <p class="text-sm text-gray-500 mt-2 ml-1">
                        Needs to be atleast 3 characters long
                    </p>

                    <jet-label class="mt-4" for="closetCategoryDropdown" value="Category" />
                    <CategorySelect
                        :selected="form.category_id"
                        class="mt-2"
                        @click:item="handleCategorySelect"
                    />
                </form>
                <delete-closet-modal
                    :show="shouldShowDeleteModal"
                    @click:confirm="deleteCloset"
                    @click:close="toggleDeleteClosetModal(false)"
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
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import InputGroup from '@/Jetstream/InputGroup.vue'
import DeleteClosetModal from './DeleteClosetModal.vue'
import JetLabel from '@/Jetstream/Label.vue'
import JetDropdown from '@/Jetstream/Dropdown.vue';
import CategorySelect from './CategorySelect.vue';
import IconButton from '@/Jetstream/IconButton.vue';
import { TrashIcon } from '@heroicons/vue/24/outline';

export default {
    props: ['show', 'selected'],

    emits: ['click:close'],

    components: {
        DialogModal,
        JetButton,
        JetSecondaryButton,
        InputGroup,
        JetLabel,
        JetDropdown,
        CategorySelect,
        IconButton,
        TrashIcon,
        DeleteClosetModal
    },

    data() {
        return {
            form: this.$inertia.form({
                name: '',
                category_id: '',
            }),
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
            return this.form.name.length < 3 || !this.form.category_id || !this.form.category_id;
        }
    },

    methods: {
        submit() {
            
            const onFinish = () => {
                this.form.reset('name');
                this.$emit('click:close');
            }

            if (this.selected) {
                this.form.put(this.route('update-closet', [this.selected.id]), { onFinish });
                return;
            }

            this.form.post(this.route('create-closet'), { onFinish });
        },

        deleteCloset() {
            this.toggleDeleteClosetModal(false);

            if (!this.selected) {
                return;
            }

            this.$emit('click:close');

            this.$inertia.delete(
                this.route('delete-closet', [this.selected.id])
            );
        },

        toggleDeleteClosetModal(value) {
            this.shouldShowDeleteModal = value || !this.shouldShowDeleteModal;
        },

        handleCategorySelect(selected) {
            this.form.category_id = selected;
        },

        initializeForm() {
            // How is there no better way to do this :(
            this.$nextTick(() => {
                document.getElementById("closetNameInput").focus();
            });

            this.form.name = this.selected ? this.selected.name : '';
            this.form.category_id = this.selected ? this.selected.category.id : {};
        }
    }
}
</script>