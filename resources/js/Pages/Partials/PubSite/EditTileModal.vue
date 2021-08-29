<template>
    <dialog-modal :show="show" @close="$emit('click:close')">
        <template #title>
            Edit Tile
        </template>

        <template #content>
            <form @submit.prevent="submit" class="grid gap-4 grid-cols-2">
                <div class="col-span-2">
                    <jet-label for="slug" value="Enter a link" />
                    <input-group
                        type="text"
                        id="slug"
                        class="mt-1 block w-full"
                        icon="link"
                        @keyup="handleURLInputChange"
                        v-model="form.url"
                        required 
                        autofocus 
                        placeholder="Ex - https://www.linkedin.com/alex-jones..."
                        :isLoading="loadingMetaData"
                        :error="errors?.url"
                    />
                </div>
                <div class="col-span-2">
                    <jet-label for="name" value="Give the link a name" />
                    <input-group
                        type="text"
                        class="mt-1 block w-full" 
                        v-model="form.name"
                        required
                        placeholder="Ex - LinkedIn, GitHub"
                        :error="errors?.name"
                    />
                </div>
                <div class="col-span-2 md:col-span-1">
                    <list-box
                        class="w-full"
                        label="Tile Color"
                        :options="TILE_COLORS"
                        :selected="form.color"
                        @change="(val) => setFormValue(val, 'color')"
                        :error="errors?.color"
                    />
                </div>
                <div class="col-span-2 md:col-span-1">
                    <list-box
                        class="w-full"
                        label="Icon"
                        :options="TILE_ICONS"
                        :selected="form.icon"
                        @change="(val) => setFormValue(val, 'icon')"
                        :error="errors?.icon"
                    />
                </div>
                <div class="col-span-2">
                    <label class="flex items-center">
                        <jet-checkbox name="animated" v-model:checked="form.animated" />
                        <span class="ml-2 text-sm text-gray-600">Animated</span>
                    </label>
                </div>
            </form>

            <div class="mt-7 mb-3 flex justify-center">
                <tile :data="form.data()" :in-preview-mode="true" />
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
    import { isValidURL } from '@/Util/Url';
    import LinksApi from '@/API/LinksApi';
    import Loader from '@/Jetstream/Loader.vue';
    import Tile from './Tile.vue';
    import ListBox from '@/Jetstream/ListBox.vue';
    import { TILE_COLORS, TILE_ICONS } from './constants';

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
            Tile,
            ListBox,
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

        computed: {
            isSubmitDisabled() {
                return this.form.processing || this.loadingMetaData;
            }
        },

         data() {
            return {
                form: this.$inertia.form({
                    url: '',
                    name: '',
                    icon: '',
                    color: '',
                    title: '',
                    animated: false,
                    og_title: '',
                    description: '',
                    og_description: '',
                    og_image: '',
                }),
                errors: {},
                inputTimeoutRef: null,
                loadingMetaData: false,
                metaData: null,
                TILE_COLORS,
                TILE_ICONS
            }
        },

        watch: {
            metaData(metaData) {
                this.form.title = metaData.title;
                this.form.description = metaData.description;
                this.form.og_title = metaData.og_title;
                this.form.og_description = metaData.og_description;
                this.form.og_image = metaData.og_image;
            },

            show() {
                this.form.reset();

                if (this.selectedTile) {
                    this.form.url = this.selectedTile.url;
                    this.form.color = this.selectedTile.color;
                    this.form.name = this.selectedTile.name;
                    this.form.icon = this.selectedTile.icon;
                    this.form.animated = !!this.selectedTile.animated;
                    this.handleURLInputChange();
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
                    this.form.put(this.route('update-link', [
                        this.pageId,
                        this.selectedTile.id
                    ]), { onFinish });
                    return;
                }

                this.form.post(this.route('create-link', this.pageId), { onFinish })
            },

            handleURLInputChange() {
                clearTimeout(this.inputTimeoutRef);
    
                this.inputTimeoutRef = setTimeout(async () => {
                    try {
                        if (isValidURL(this.form.url)) {
                            this.loadingMetaData = true;
                            this.metaData = await LinksApi.getMetaData(this.form.url);
                        }
                    } catch(e) {
                        console.error('Could not fetch Meta data');
                    } finally {
                        this.loadingMetaData = false;
                    }
                }, 750);
            },

            validate() {
                this.errors = {};

                if (!this.form.url) {
                    this.errors.url = "We'll need a URL";
                }

                if (!this.form.name) {
                    this.errors.name = "We'll need a name";
                }


                if (!this.form.icon) {
                    this.errors.icon = 'How about an icon?';
                }


                if (!this.form.color) {
                    this.errors.color = "It'll look a lot better with some color";
                }

                return Object.keys(this.errors).length === 0;
            },

            setFormValue(value, field) {
                this.form[field] = value;
            }
        }
    }
</script>
