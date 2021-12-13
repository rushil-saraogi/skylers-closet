<template>
    <dialog-modal :show="show" @close="$emit('click:close')">
        <template #title>
            Map Tile
        </template>

        <template #content>
            <form @submit.prevent="submit" class="grid gap-2 grid-cols-2">
                <div class="col-span-2 relative">
                    <input-group
                        type="text"
                        class="mt-1 block w-full" 
                        id="location-autocomplete"
                        v-model="form.location"
                        required
                        placeholder="Location"
                        :error="errors?.location"
                        @focus="placeSearchInFocus = true;"
                        @blur="placeSearchInFocus = false;"
                    />
                    <ul
                        class="absolute bg-white rounded z-10 w-full mt-1 shadow-md"
                        v-show="showGoogleMapsResults"
                        @mouseenter="mouseOverResults = true"
                        @mouseleave="mouseOverResults = false"
                    >
                        <li
                            v-for="(result, i) in searchResults"
                            :key="i"
                            class="hover:cursor-pointer hover:bg-gray-50 p-2"
                            @click="() => handleLocationClick(result)"
                        >
                            {{ result }}
                        </li>
                    </ul>
                </div>
                <div class="col-span-2">
                    <input-group
                        type="text"
                        class="block w-full" 
                        v-model="form.name"
                        required
                        placeholder="Name"
                        :error="errors?.name"
                    />
                </div>
            </form>
            <div class="mt-7 mb-3 flex justify-center">
                <map-tile :data="form.data()" :in-preview-mode="true" />
            </div>
        </template>

        <template #footer>
            <jet-secondary-button @click="$emit('click:close')">
                Nevermind
            </jet-secondary-button>

            <jet-button @click="submit" class="ml-2" :class="{ 'opacity-25': form.processing }">
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
    import Loader from '@/Jetstream/Loader.vue';
    import MapTile from './MapTile.vue';
    import { TILE_TYPE_MAP } from './constants';

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
            MapTile,
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
                    location: '',
                    name: '',
                }),
                errors: {},
                searchResults: [],
                searchTimeoutRef: null,
                placeSearchInFocus: false,
                mouseOverResults: false,
            }
        },

        watch: {
            show() {
                this.form.reset();

                if (this.selectedTile) {
                    this.form.location = this.selectedTile.data.location;
                    this.form.name = this.selectedTile.data.name;
                }
            },

            ['form.location']: function (newValue) {
                clearTimeout(this.searchTimeoutRef);

                if (newValue < 3) {
                    this.searchResults = [];
                    return;
                }

                this.searchTimeoutRef = setTimeout(async () => {
                    window.googlePlaceService.getPlacePredictions({
                        input: newValue,
                        types: ['(cities)']
                    }, this.displaySuggestions)
                }, 750);
            }
        },

        computed: {
            showGoogleMapsResults() {
                if (
                    this.searchResults.length === 1 &&
                    this.searchResults[0] === this.form.location
                ) {
                    return false;
                }

                return (this.placeSearchInFocus || this.mouseOverResults) && this.searchResults.length;
            }
        },

        methods: {
            submit() {
                const onFinish = () => {
                    this.form.reset();
                    this.$emit('click:close');
                }

                if (!this.validate()) return;
                debugger;

                if (this.selectedTile) {
                    this.form.put(this.route('update-tile', [
                        this.pageId,
                        this.selectedTile.id
                    ]), { onFinish });
                    return;
                }

                this.form.post(this.route('create-tile', [this.pageId, TILE_TYPE_MAP]), { onFinish })
            },

            validate() {
                this.errors = {};

                if (!this.form.location) {
                    this.errors.location = "We'll need a location";
                }

                if (!this.form.name) {
                    this.errors.name = "Why not tell people what this is";
                }

                return Object.keys(this.errors).length === 0;
            },

            setFormValue(value, field) {
                this.form[field] = value;
            },

            displaySuggestions (predictions, status) {
                if (status !== window.google.maps.places.PlacesServiceStatus.OK) {
                    this.searchResults = []
                    return
                }
                this.searchResults = predictions.map(prediction => prediction.description) 
            },

            handleLocationClick(location) {
                this.form.location = location;
                this.searchResults = [];
            },
        },
    }
</script>
