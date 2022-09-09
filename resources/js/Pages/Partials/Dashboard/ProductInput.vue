<template>
    <div>
        <form @submit.prevent="submit" class="">
            <div class="">
                <jet-label for="slug" value="Add to your closet" />
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
    </div>
</template>

<script>
import { mapWritableState, mapActions} from 'pinia';
import { useStore } from '@/store';
import JetLabel from "@/Jetstream/Label.vue";
import InputGroup from "@/Jetstream/InputGroup.vue";
import { isValidURL } from "@/Util/Url";
import LinksApi from "@/API/LinksApi";

export default {
    props: {
        name: {
            type: String,
            default: "",
        },
        items: {
            type: Array,
            default: [],
        },
    },

    emits: ["response:meta"],

    computed: {
        ...mapWritableState(useStore, ['isLoadingItem'])
    },

    data() {
        return {
            itemUrl: '',
            inputTimeoutRef: null,
            errors: {},
        };
    },

    components: {
        JetLabel,
        InputGroup
    },

    methods: {
        ...mapActions(useStore, ['removeSaveModeItem']),

        handleURLInputChange() {
            clearTimeout(this.inputTimeoutRef);
            this.$emit('change:itemUrl', this.itemUrl);

            this.inputTimeoutRef = setTimeout(async () => {
                try {
                    if (isValidURL(this.itemUrl)) {
                        this.isLoadingItem = true;
                        this.removeSaveModeItem();
                        const response = await LinksApi.getMetaData(
                            this.itemUrl
                        );
                        this.$emit('response:meta', response);
                    }
                } catch (e) {
                    console.error("Could not fetch Meta data");
                } finally {
                    this.isLoadingItem = false;
                }
            }, 750);
        },
    },
};
</script>
