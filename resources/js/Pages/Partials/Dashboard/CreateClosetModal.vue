<template>
    <dialog-modal :show="show" @close="$emit('click:close')">
        <template #title>
            <div v-if="selected">Edit closet name</div>
            <div v-else>Create a new closet</div>
        </template>

        <template #content>
            <form @submit.prevent="submit" class="mt-3">
                <input-group
                    type="text"
                    class="mt-4 block w-full"
                    v-model="form.name"
                    placeholder="Name"
                    id="closetNameInput"
                    :error="error"
                />
            </form>
            <p class="text-sm text-gray-500 mt-2 ml-1">
                Needs to be atleast 3 characters long
            </p>
        </template>

        <template #footer>
            <jet-secondary-button @click="$emit('click:close')" class="mt-3 sm:mt-0 sm:ml-3">Nevermind</jet-secondary-button>
            <jet-button @click="submit" :disabled="isSubmitDisabled" class="sm:ml-3">Create</jet-button>
        </template>
    </dialog-modal>
</template>

<script>
import DialogModal from '@/Jetstream/DialogModal.vue';
import JetButton from '@/Jetstream/Button.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import InputGroup from '@/Jetstream/InputGroup.vue'
import JetLabel from '@/Jetstream/Label.vue'

export default {
    props: ['show', 'selected'],

    emits: ['click:close'],

    components: {
        DialogModal,
        JetButton,
        JetSecondaryButton,
        InputGroup,
        JetLabel,
    },

    data() {
        return {
            form: this.$inertia.form({
                name: '',
            }),
            error: null,
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
            return this.form.name.length < 3;
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

        initializeForm() {
            // How is there no better way to do this :(
            this.$nextTick(() => {
                document.getElementById("closetNameInput").focus();
            });

            this.form.name = this.selected ? this.selected.name : '';
        }
    }
}
</script>