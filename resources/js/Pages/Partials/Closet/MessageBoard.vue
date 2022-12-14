<template>
    <!-- Start of board -->
    <div
        class="w-full flex flex-col bg-white p-3 sm:p-5 rounded-lg border shadow-sm relative"
        :class="{ [classes]: classes }"
    >
        <div class="w-full">
            <div class="bg-gray-100 p-2.5 sm:p-4 rounded">
                <!-- Tagged item preview -->
                <ItemMessageCard
                    v-if="taggedItem"
                    :item="taggedItem"
                    class="-mb-4 opacity-70"
                    :dismissable="true"
                    @click:dismiss="$emit('delete:tag')"
                />

                <div class="flex items-center">
                    <div class="flex-1" @click="$emit('toggle', true)">
                        <!-- Message input -->
                        <input-group
                            type="text"
                            v-model="postForm.message_body"
                            placeholder="Add a comment..."
                            id="messageInput"
                            :error="error"
                            v-on:keyup.enter.prevent="submit"
                            autocomplete="off"
                        />
                    </div>

                    <IconButton @click="submit" class="mt-1 ml-3 z-10 relative">
                        <PaperAirplaneIcon
                            class="h-5 w-5 -mr-1 text-gray-600"
                        />
                    </IconButton>
                </div>
            </div>
        </div>

        <div class="mt-3 sm:mt-4 flex-1 overflow-scroll">
            <div
                v-if="closet && messages.length"
                class="flex flex-col gap-3 sm:gap-5 pb-8 sm:pb-0 overflow-scroll message-scroll"
            >
                <MessageBlock
                    v-for="message in messages"
                    :key="message.id"
                    v-bind="message"
                />
            </div>
            <div
                v-else
                class="w-full h-full flex flex-col items-center justify-center"
            >
                <EmptyIllustration />
                <div class="font-semibold mt-4">No comments yet</div>
            </div>
        </div>
    </div>
</template>

<script>
import JetButton from "@/Jetstream/Button";
import InputGroup from "@/Jetstream/InputGroup.vue";
import ItemMessageCard from "./ItemMessageCard.vue";
import IconButton from "@/Jetstream/IconButton.vue";
import MessageBlock from "./Message.vue";
import EmptyIllustration from "@/Illustrations/Empty.vue";
import { PaperAirplaneIcon } from "@heroicons/vue/24/outline";

export default {
    props: {
        messages: {
            type: Array,
            default: [],
        },
        taggedItem: {
            type: Object,
            default: null,
        },
        closet: {
            type: Object,
            default: {},
        },
        classes: {
            type: String,
            defualt: "",
        },
        show: {
            type: Boolean,
            default: false,
        },
    },

    components: {
        JetButton,
        InputGroup,
        ItemMessageCard,
        IconButton,
        MessageBlock,
        EmptyIllustration,
        PaperAirplaneIcon,
    },

    mounted() {},

    data() {
        return {
            postForm: this.$inertia.form({
                message_body: "",
                item_id: "",
            }),
        };
    },

    watch: {
        taggedItem(newVal) {
            if (newVal && newVal.id) {
                this.postForm.item_id = newVal.id;
                return;
            }

            this.postForm.item_id = "";
        },

        show(newVal) {
            if (newVal) {
                this.$nextTick(() => {
                    document.getElementById("messageInput").focus();
                    document.body.style.overflow = "hidden";
                });
            } else {
                document.body.style.overflow = null;
            }
        },
    },

    methods: {
        submit() {
            if (!this.postForm.message_body) {
                return;
            }

            const onSuccess = () => {
                this.postForm.reset();
                this.$emit("submit:message");
            };

            this.postForm.post(this.route("create-message", [this.closet.id]), {
                onSuccess,
            });
        },
    },
};
</script>

<style scoped>
.message-scroll {
    max-height: 100%;
}
</style>
