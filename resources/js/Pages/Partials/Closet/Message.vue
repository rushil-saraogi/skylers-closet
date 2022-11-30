<template>
    <div>
        <!-- Show tagged item if any -->
        <ItemMessageCard
            v-if="item"
            :item="item"
            class="-mb-4 opacity-50"
        />

        <div class="flex gap-2 sm:gap-3 z-10 relative">
            <!-- Left side -->
            <img
                v-if="user.profile_photo_url"
                :src="user.profile_photo_url"
                class="h-8 w-8 rounded-full object-cover"
            />

            <!-- Right side -->
            <div class="flex-1">
                <div
                    class="p-3 bg-indigo-50 flex flex-col justify-start rounded-lg"
                >
                    <div class="text-sm">
                        <span class="text-gray-700">{{
                            user.name
                        }}</span>
                        <span class="text-gray-500 ml-2">{{
                            formatDate(created_at)
                        }}</span>
                    </div>
                    <div class="mt-2">
                        {{ message_body }}
                    </div>
                </div>

                <div class="flex justify-end mt-2 text-sm">
                    <div
                        v-if="!replies || !replies.length"
                        class="hover:cursor-pointer"
                        @click="toggleReplyInputFor()"
                    >
                        Reply
                    </div>
                    <div
                        v-else
                        class="hover:cursor-pointer"
                        @click="toggleRepliesFor(index)"
                    >
                        {{ replies.length }}
                        {{ replies.length === 1 ? "reply" : "replies" }}
                    </div>
                </div>

                <!-- Replies -->
                <div
                    v-if="showReplies"
                >
                    <div
                        v-for="reply in replies"
                        :key="reply.id"
                        class="ml-6 mt-2 p-3 bg-gray-100 rounded-lg"
                    >
                        <div class="text-sm">
                            <span class="text-gray-700">{{
                                reply.user.name
                            }}</span>
                            <span class="text-gray-500 ml-2">{{
                                formatDate(reply.created_at)
                            }}</span>
                        </div>
                        <div class="mt-2">
                            {{ reply.message_body }}
                        </div>
                    </div>
                </div>

                <input-group
                    type="text"
                    v-if="showReplyInput"
                    v-model="this.replyForm.message_body"
                    class="mt-2"
                    placeholder="Add a comment..."
                    :error="error"
                    v-on:keyup.enter.prevent="submitReply"
                />
            </div>
        </div>
    </div>
</template>

<script>
import InputGroup from "@/Jetstream/InputGroup.vue";
import ItemMessageCard from "./ItemMessageCard.vue";

export default {
    props: [
        'id',
        'item',
        'user',
        'created_at',
        'message_body',
        'replies',
        'closet_id'
    ],

    components: {
        InputGroup,
        ItemMessageCard,
    },

    data() {
        return {
            replyForm: this.$inertia.form({
                message_body: "",
                parent_message_id: "",
            }),
            shouldShowReplies: false,
            shouldShowReplyInput: false,
        };
    },

    computed: {
        showReplies() {
            return this.replies && this.replies.length > 0 && this.shouldShowReplies;
        },

        showReplyInput() {
            return this.shouldShowReplyInput || this.shouldShowReplies;
        }
    },

    methods: {
        toggleReplyInputFor() {
            this.shouldShowReplyInput = !this.shouldShowReplyInput;
        },

        toggleRepliesFor(index) {
            this.shouldShowReplies = !this.shouldShowReplies;
        },

        formatDate(date) {
            return new Date(date).toLocaleString();
        },

        submitReply() {
            if (!this.replyForm.message_body) {
                return;
            }

            const onSuccess = () => {
                this.replyForm.reset();
                this.$emit("submit:reply");
                this.shouldShowReplies = true;
            };

            this.replyForm.parent_message_id = this.id;

            this.replyForm.post(
                this.route("create-message", [this.closet_id]),
                {
                    onSuccess,
                }
            );
        },
    }
};
</script>
