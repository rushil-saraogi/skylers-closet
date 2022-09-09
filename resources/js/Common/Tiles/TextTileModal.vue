<template>
    <dialog-modal :show="show" @close="$emit('click:close')">
        <template #title>
            Text Tile
        </template>

        <template #content>
            <form @submit.prevent="submit" class="grid gap-2 grid-cols-2">
                <div class="col-span-2">
                    <input-group
                        type="text"
                        class="mt-1 block w-full" 
                        v-model="form.header"
                        required
                        placeholder="Header"
                        :error="errors?.header"
                    />
                </div>
                <div class="col-span-2">
                    <input-group
                        type="text"
                        class="block w-full" 
                        v-model="form.body"
                        required
                        placeholder="More text (optional)"
                        :error="errors?.body"
                    />
                </div>
                <div class="col-span-2">
                    <jet-label value="Theme" />
                    <div class="flex mt-2">
                        <jet-radio
                            name="theme"
                            label="Light"
                            class="mr-3"
                            v-model="form.theme"
                            :value="TEXT_TILE_THEMES.light"
                        />
                        <jet-radio
                            name="theme"
                            label="Dark"
                            v-model="form.theme"
                            :value="TEXT_TILE_THEMES.dark"
                        />
                    </div>
                </div>
            </form>
            <div class="mt-7 mb-3 flex justify-center">
                <text-tile :data="form.data()" :in-preview-mode="true" />
            </div>
        </template>

        <template #footer>
            <jet-secondary-button @click="$emit('click:close')">
                Nevermind
            </jet-secondary-button>

            <jet-button @click="submit" class="ml-2" :class="{ 'opacity-25': form.processing }" :disabled="isSubmitDisabled">
                Save
            </jet-button>
        </template>
    </dialog-modal>
</template>

<script>
    import DialogModal from '@/Jetstream/DialogModal.vue';
    import JetButton from '@/Jetstream/Button.vue'
    import JetDropdown from '@/Jetstream/Dropdown.vue'
    import JetCheckbox from '@/Jetstream/Checkbox.vue'
    import InputGroup from '@/Jetstream/InputGroup.vue'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton';
    import JetLabel from '@/Jetstream/Label.vue'
    import JetRadio from '@/Jetstream/RadioButton.vue'
    import Loader from '@/Jetstream/Loader.vue';
    import TextTile from './TextTile.vue';
    import { TILE_COLORS, TILE_TYPE_TEXT, TEXT_TILE_THEMES } from './constants';

    export default {
        components: {
            DialogModal,
            JetButton,
            JetLabel,
            JetCheckbox,
            InputGroup,
            Loader,
            JetSecondaryButton,
            JetDropdown,
            TextTile,
            JetRadio,
        },

        emits: ['click:close'],

        props: {
            show: {
                type: Boolean,
                default: false
            },
            pageId: {
                type: Number,
                required: true,
            },
            selectedTile: {
                type: Object,
                default: null,
            },
        },

        data() {
            return {
                form: this.$inertia.form({
                    header: '',
                    body: '',
                    theme: TEXT_TILE_THEMES.dark
                }),
                errors: {},
                TILE_COLORS,
                TEXT_TILE_THEMES,
            }
        },

        watch: {
            show() {
                this.form.reset();

                if (this.selectedTile) {
                    this.form.header = this.selectedTile.data.header;
                    this.form.body = this.selectedTile.data.body;
                }
            },
        },

        methods: {
            submit() {
                const onFinish = () => {
                    this.form.reset();
                    this.$emit('click:close');
                }

                if (!this.validate()) return;

                if (this.selectedTile) {
                    this.form.put(this.route('update-tile', [
                        this.pageId,
                        this.selectedTile.id
                    ]), { onFinish });
                    return;
                }

                this.form.post(this.route('create-tile', [this.pageId, TILE_TYPE_TEXT]), { onFinish })
            },

            validate() {
                this.errors = {};

                if (!this.form.header) {
                    this.errors.header = "We'll need something here";
                }

                return Object.keys(this.errors).length === 0;
            },
        }
    }
</script>
