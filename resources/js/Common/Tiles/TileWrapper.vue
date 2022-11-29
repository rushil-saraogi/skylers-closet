<template>
    <div
        class="bg-white border shadow-3xl hover:shadow-4xl transition-all md:max-w-xs flex flex-col justify-between duration-200 rounded-lg relative hover:cursor-grab h-full"
        :class="containerClasses"
        @mouseenter="isHovering = true"
        @mouseleave="isHovering = false"
    >
        <slot />

        <quick-controls :show="shouldShowControls">
            <quick-controls-option
                v-if="!pubMode"
                :outlined="true"
                icon="PencilIcon"
                tooltip="Edit Item"
                @click="$emit('click:edit')"
            />
            <quick-controls-option
                v-if="!pubMode"
                icon="TrashIcon"
                :outlined="true"
                tooltip="Delete Item"
                @click="$emit('click:delete')"
            />
            <quick-controls-option
                v-if="withChatLink"
                icon="ChatBubbleBottomCenterIcon"
                :outlined="true"
                tooltip="Comment"
                @click="$emit('click:message')"
            />
            <quick-controls-option
                v-if="pubMode"
                icon="HeartIcon"
                :outlined="!isSaved"
                tooltip="Save Item"
                :class="{ 'text-red-400': isSaved }"
                @click="$emit('click:save')"
            />
            <Link v-if="closetLink" :href="closetLink" class="flex-1 flex justify-center items-center">
                <quick-controls-option
                    icon="PuzzlePieceIcon"
                    :outlined="true"
                    tooltip="View Closet"
                />
            </Link>
        </quick-controls>
    </div>
</template>

<script>
import QuickControls from "@/Jetstream/QuickControls.vue";
import QuickControlsOption from "@/Jetstream/QuickControlsOption.vue";
import { Link } from "@inertiajs/inertia-vue3";

export default {
    components: {
        QuickControls,
        QuickControlsOption,
        Link,
    },

    emit: ["click:edit", "click:delete", "click:saveItem"],

    props: {
        hideControls: {
            type: Boolean,
            default: false,
        },
        inSaveMode: {
            type: Boolean,
            default: false,
        },
        pubMode: {
            type: Boolean,
            default: false,
        },
        isSaved: {
            type: Boolean,
            default: false,
        },
        withChatLink: {
            type: Boolean,
            default: false,
        },
        closetLink: {
            type: String,
            default: "",
        },
    },

    data() {
        return {
            isHovering: false,
        };
    },

    computed: {
        containerClasses() {
            return {
                // 'scale-105': this.isHovering,
                "hover:cursor-pointer": this.isHovering && this.pubMode,
            };
        },

        shouldShowControls() {
            return !this.hideControls;
        },
    },
};
</script>
