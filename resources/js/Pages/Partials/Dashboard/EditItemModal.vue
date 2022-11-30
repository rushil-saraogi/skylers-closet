<template>
    <dialog-modal :show="show" @close="$emit('click:close')">
        <template #title> Edit Item </template>

        <template #content>
            <form @submit.prevent="submit" class="mt-4">
                <jet-label for="itemTitle" value="Title" />
                <input-group
                    type="text"
                    id="itemTitle"
                    class="mt-1 block w-full"
                    v-model="form.title"
                    placeholder="Item title"
                    :error="error"
                />

                <jet-label class="mt-4" for="itemModel" value="Model" />
                <input-group
                    type="text"
                    id="itemModel"
                    class="mt-1 block w-full"
                    v-model="form.model"
                    placeholder="Model"
                    :error="error"
                />

                <jet-label class="mt-4" for="itemBrand" value="Brand" />
                <input-group
                    type="text"
                    id="itemBrand"
                    class="mt-1 block w-full"
                    v-model="form.brand"
                    placeholder="Brand"
                    :error="error"
                />

                <jet-label class="mt-4" for="itemPrice" value="Price ($)" />
                <input-group
                    type="number"
                    id="itemPrice"
                    class="mt-1 block w-full"
                    v-model="form.price"
                    placeholder="Price"
                    :error="error"
                >
                    <template v-slot:icon>
                        <CurrencyDollarIcon class="h-6 w-6 text-gray-400"/>
                    </template>
                </input-group>
            </form>
            <!-- <p class="text-sm text-gray-500 mt-2 ml-1">
                Needs to be atleast 3 characters long
            </p> -->
        </template>

        <template #footer>
            <jet-secondary-button @click="$emit('click:close')" class="mb-3 sm:mb-0">
                Nevermind
            </jet-secondary-button>

            <jet-button
                class="sm:ml-2"
                @click="submit"
                :class="{ 'opacity-25': loading }"
                :disabled="loading"
            >
                Save
            </jet-button>
        </template>
    </dialog-modal>
</template>

<script>
import { mapState, mapActions } from "pinia";
import { useStore } from "@/store";
import DialogModal from "@/Jetstream/DialogModal.vue";
import InputGroup from "@/Jetstream/InputGroup.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetButton from "@/JetStream/Button.vue";
import JetSecondaryButton from "@/JetStream/SecondaryButton.vue";
import { CurrencyDollarIcon } from "@heroicons/vue/20/solid";

export default {
    components: {
        JetButton,
        JetSecondaryButton,
        DialogModal,
        InputGroup,
        JetLabel,
        CurrencyDollarIcon
    },

    data() {
        return {
            form: this.$inertia.form({
                title: "",
                model: "",
                brand: "",
                price: 0,
                image: "",
                video_url: "",
            }),
            error: null,
        };
    },

    watch: {
        show(newVal) {
            if (newVal) {
                this.initializeForm();
            }
        },
    },

    emits: ["click:confirm", "click:close"],

    props: {
        show: Boolean,
        loading: Boolean,
        selected: {
            type: Object,
            default: null,
        },
    },

    computed: {
        ...mapState(useStore, ["selectedCloset"]),
    },

    methods: {
        initializeForm() {
            if (this.selected) {
                this.form.title = this.selected.title || "";
                this.form.asin = this.selected.asin || "";
                this.form.model = this.selected.model || "";
                this.form.brand = this.selected.brand || "";
                this.form.price = this.selected.price || "";
                this.form.image = this.selected.image || "";
                this.form.video_url = this.selected.video_url || "";
            }
        },

        submit() {
            const onFinish = () => {
                this.form.reset();
                this.$emit('click:close');
            }

            this.form.put(
                this.route('update-item', [this.selectedCloset.id, this.selected.id]), { onFinish }
            );
        },
    },
};
</script>
