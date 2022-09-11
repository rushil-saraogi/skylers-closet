<template>
    <div>
        <!-- background overlay -->
        <transition
            enter-active-class="transition ease-in duration-200"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
        >
            <div
                v-if="show" class="bg-black fixed top-0 left-0 h-full w-full opacity-50"
                @click="toggleBoard(false)"
            />
        </transition>
        
        <div
            class="bg-white py-3 px-4 rounded fixed bottom-0 mx-auto inset-x-0 max-w-4xl w-full shadow"
            :style="messageBoardStyles"
            @click="toggleBoard(true)"
        >
            <div class="w-full">
                <div
                    class="h-1.5 w-8 bg-gray-300 hover:bg-gray-400 hover:cursor-pointer rounded-full m-auto"
                />
            </div>

            <div class="mt-3">
                <!-- Create a new post -->
                <div class="bg-indigo-100 p-4 rounded">
                    <ItemMessageCard
                        v-if="taggedItem"
                        :item="taggedItem"
                        class="-mb-4 opacity-50"
                        :dismissable="true"
                        @click:dismiss="$emit('delete:tag')"
                    />

                    <div class="flex items-center">
                        <div class="flex-1">
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

                        <IconButton
                            @click="submit"
                            icon="send"
                            class="mt-1 ml-3 z-10 relative"
                            variant="filled"
                        />
                    </div>
                </div>

                <div
                    v-if="closet && messages"
                    class="mt-6 flex flex-col gap-5 overflow-scroll message-scroll"
                >
                    <MessageBlock
                        v-for="message in messages"
                        :key="message.id"
                        v-bind="message"
                    />
                </div>
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
    },

    components: {
        JetButton,
        InputGroup,
        ItemMessageCard,
        IconButton,
        MessageBlock,
    },

    mounted() {},

    data() {
        return {
            postForm: this.$inertia.form({
                message_body: "",
                item_id: "",
            }),

            show: false,
        };
    },

    watch: {
        taggedItem(newVal) {
            if (newVal) {
                this.postForm.item_id = newVal.id;
                this.toggleBoard(true);
                return;
            }

            this.postForm.item_id = "";
        },

        show(neVal) {
            if (neVal) {
                this.$nextTick(() => {
                    document.getElementById("messageInput").focus();
                });
            }
        }
    },

    computed: {
        messageBoardStyles() {
            const top = this.show ? "15%" : "calc(100vh - 150px)";

            return {
                top,
                transition: "0.3s ease 0s",
                transitionProperty: "top",
            };
        },
    },

    methods: {
        // ...mapActions(useStore, ['selectCloset', 'setClosets']),

        toggleBoard(show) {
            this.show = show;
        },

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
    max-height: 70vh;
}
</style>
