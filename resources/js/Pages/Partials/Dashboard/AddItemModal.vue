<template>
    <dialog-modal :show="show" @close="$emit('click:close')">
        <template #title>
            <div>Add Item</div>
        </template>

        <template #content>
            <form @submit.prevent="submit" class="">
            <div class="">
                <jet-label for="slug" value="Drop in a URL to add to your closet" />
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
                    :isLoading="isLoadingItem"
                    :error="errors?.url"
                />
            </div>
        </form>

        <div class="mt-4">
            <loader-tile v-if="isLoadingItem" />
            <item-tile
                v-if="isMetaDataAvailable && !isLoadingItem"
                v-bind="metaData"
                :hide-controls="true"
            />
        </div>
        </template>

        <template #footer>
            <jet-secondary-button @click="$emit('click:close')" class="mt-3 sm:mt-0 sm:ml-3">Nevermind</jet-secondary-button>
            <jet-button @click="submit" :disabled="!isMetaDataAvailable" class="sm:ml-3">
                Add
            </jet-button>
        </template>
    </dialog-modal>
</template>

<script>
import { mapState } from "pinia";
import { useStore } from "@/store";
import DialogModal from '@/Jetstream/DialogModal.vue';
import JetButton from '@/Jetstream/Button.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import InputGroup from '@/Jetstream/InputGroup.vue'
import JetLabel from '@/Jetstream/Label.vue'
import { isValidURL } from "@/Util/Url";
import LinksApi from "@/API/LinksApi";
import ItemTile from '@/Common/Tiles/ItemTile.vue';
import LoaderTile from '@/Common/Tiles/LoaderTile.vue';

export default {
    props: ['show'],

    emits: ['click:close'],

    components: {
        DialogModal,
        JetButton,
        JetSecondaryButton,
        InputGroup,
        JetLabel,
        ItemTile,
        LoaderTile
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
                item_order: null,
            }),
            itemUrl: '',
            metaData: {},
            inputTimeoutRef: null,
            error: null,
            isLoadingItem: false,
        }
    },

    watch: {
        show(newVal) {
            if (newVal) {
                // this.initializeForm()
            }
        }
    },

    computed: {
        ...mapState(useStore, ["selectedCloset"]),

        isMetaDataAvailable() {
            return Object.keys(this.metaData).length !== 0
        }
    },

    methods: {
        submit() {
            const onFinish = () => {
                this.form.reset();
                this.$emit('click:close');
            };

            this.setFromData(this.metaData);
            this.form.post(
                this.route("create-item", [this.selectedCloset.id]),
                { onFinish }
            );
        },

        setFromData(data) {
            this.form.title = data.title;
            this.form.url = data.url;
            this.form.brand = data.brand;
            this.form.price = data.price;
            this.form.asin = data.asin;
            this.form.rating = data.rating;
            this.form.image = data.image;
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
    }
}
</script>