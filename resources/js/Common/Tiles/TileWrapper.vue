<template>
    <div
        class="bg-white transition-all flex flex-col justify-between duration-200 min-h-48 rounded-lg overflow-hidden relative shadow-sm hover:cursor-grab h-full"
        :class="containerClasses"
        @mouseenter="isHovering = true"
        @mouseleave="isHovering = false"
    >
        <slot />

        <quick-controls :show="shouldShowControls">
            <quick-controls-option
                v-if="!pubMode"
                icon="PencilIcon"
                @click="$emit('click:edit')"
            />
            <quick-controls-option
                v-if="!pubMode"
                icon="TrashIcon"
                @click="$emit('click:delete')"
            />
            <quick-controls-option
                v-if="pubMode"
                icon="ChatIcon"
                @click="$emit('click:message')"
            />
            <quick-controls-option
                v-if="pubMode"
                icon="HeartIcon"
                @click="$emit('click:like')"
            />
        </quick-controls>
    </div>
</template>

<script>
import QuickControls from "@/Jetstream/QuickControls.vue";
import QuickControlsOption from "@/Jetstream/QuickControlsOption.vue";

export default {
    components: {
        QuickControls,
        QuickControlsOption,
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
    },

    data() {
        return {
            isHovering: false,
        };
    },

    computed: {
        containerClasses() {
            return {
                // 'scale-105': this.isHovering && this.isClickable,
                "hover:cursor-pointer": this.isHovering && this.pubMode,
            };
        },

        shouldShowControls() {
            return !this.hideControls;
        },
    },
};
</script>
