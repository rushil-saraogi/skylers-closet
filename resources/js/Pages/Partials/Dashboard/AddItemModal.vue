<template>
    <dialog-modal :show="show" @close="$emit('click:close')">
        <template #title>
            <div>Add Item</div>
        </template>

        <template #content>
            <form class="">
                <input
                    type="file"
                    class="hidden"
                    ref="customImage"
                    @change="updateImagePreview"
                />
                <div>
                    <jet-label
                        for="slug"
                        value="Drop in a URL to add to your closet"
                    />
                    <input-group
                        type="text"
                        id="productUrl"
                        class="block w-full mt-2"
                        icon="link"
                        @keyup="handleURLInputChange"
                        v-model="itemUrl"
                        required
                        autofocus
                        placeholder="https://www.amazon.com/gp/product..."
                        :error="errors?.url"
                    />
                </div>
            </form>

            <div class="mt-4">
                <loader-tile v-if="isLoadingItem" class="m-auto" />
                <item-tile
                    v-if="isMetaDataAvailable && !isLoadingItem"
                    v-bind="metaData"
                    :hide-controls="true"
                    class="m-auto"
                >
                    <template #placeholder>
                        <div class="w-full">
                            <div class="mt-2" v-show="customImagePreview">
                                <span
                                    class="block rounded w-full h-52"
                                    :style="
                                        'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' +
                                        customImagePreview +
                                        '\');'
                                    "
                                >
                                </span>
                            </div>
                            <div
                                v-show="!customImagePreview"
                                @click="selectCustomImage"
                                class="flex flex-col w-full items-center justify-center h-52 bg-gray-50 border-2 rounded border-dashed p-6"
                            >
                                <div class="flex items-center justify-center flex-col max-w-sm text-gray-500">
                                    <AddPhotoIcon class="h-12 w-12 text-gray-400" />
                                    <span class="mt-2 text-center">
                                        We couldn't find an image at the URL.
                                        Click or drag and drop an image to add
                                        your own.
                                    </span>
                                </div>
                            </div>
                        </div>
                    </template>
                </item-tile>
            </div>
        </template>

        <template #footer>
            <jet-secondary-button
                @click="$emit('click:close')"
                class="mt-3 sm:mt-0 sm:ml-3"
                >Nevermind</jet-secondary-button
            >
            <jet-button
                @click="saveItem"
                :disabled="!isMetaDataAvailable"
                class="sm:ml-3"
            >
                Save
            </jet-button>
        </template>
    </dialog-modal>
</template>

<script>
import { mapState } from "pinia";
import { useStore } from "@/store";
import DialogModal from "@/Jetstream/DialogModal.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import InputGroup from "@/Jetstream/InputGroup.vue";
import JetLabel from "@/Jetstream/Label.vue";
import { isValidURL } from "@/Util/Url";
import LinksApi from "@/API/LinksApi";
import ItemTile from "@/Common/Tiles/ItemTile.vue";
import LoaderTile from "@/Common/Tiles/LoaderTile.vue";
import AddPhotoIcon from '../../../icons/AddPhotoIcon.vue';

export default {
    props: ["show"],

    emits: ["click:close"],

    components: {
        DialogModal,
        JetButton,
        JetSecondaryButton,
        InputGroup,
        JetLabel,
        ItemTile,
        LoaderTile,
        AddPhotoIcon
    },

    data() {
        return {
            form: this.$inertia.form({
                title: "",
                url: "",
                brand: "",
                price: "",
                manufacturer: "",
                asin: "",
                rating: "",
                image: "",
                custom_image: "",
                item_order: null,
            }),
            itemUrl: "",
            metaData: {},
            inputTimeoutRef: null,
            error: null,
            isLoadingItem: false,
            customImage: null,
            customImagePreview: null,
        };
    },

    watch: {
        show(newVal) {
            if (newVal) {
                this.form.itemUrl = "";
            }
        },
    },

    computed: {
        ...mapState(useStore, ["selectedCloset"]),

        isMetaDataAvailable() {
            return Object.keys(this.metaData).length !== 0;
        },
    },

    methods: {
        saveItem() {
            const onFinish = () => {
                this.form.reset();
                this.$emit("click:close");
            };

            this.setFromData(this.metaData);
            this.form.post(
                this.route("create-item", [this.selectedCloset.id]),
                { onFinish }
            );
        },

        setFromData(data) {
            this.form.title = data.title;
            this.form.url = data.url || this.itemUrl;
            this.form.brand = data.brand;
            this.form.price = data.price;
            this.form.asin = data.asin;
            this.form.rating = data.rating;
            this.form.image = data.image;

            if (this.$refs.customImage) {
                this.form.custom_image = this.$refs.customImage.files[0]
            }
        },

        handleURLInputChange() {
            clearTimeout(this.inputTimeoutRef);

            this.inputTimeoutRef = setTimeout(async () => {
                try {
                    if (isValidURL(this.itemUrl)) {
                        this.isLoadingItem = true;
                        const response = await LinksApi.getMetaData(
                            this.itemUrl
                        );
                        this.metaData = response;
                    }
                } catch (e) {
                    console.error("Could not fetch Meta data");
                } finally {
                    this.isLoadingItem = false;
                }
            }, 750);
        },

        selectCustomImage() {
            this.$refs.customImage.click();
        },

        updateImagePreview() {
            const photo = this.$refs.customImage.files[0];

            if (!photo) return;

            const reader = new FileReader();

            reader.onload = (e) => {
                this.customImagePreview = e.target.result;
            };

            reader.readAsDataURL(photo);
        },
    },
};
</script>
