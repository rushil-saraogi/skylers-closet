<template>
    <div
        class="bg-white transition-all duration-200 min-h-48 rounded-lg overflow-hidden relative shadow-sm hover:cursor-grab"
        :class="containerClasses"
        @click="$emit('click:tile')"
        @mouseenter="isHovering = true"
        @mouseleave="isHovering = false"
    >   
        <div :class="contentWrapperStyles" class="h-full">
            <slot />
        </div>

        <quick-controls
            :show="shouldShowControls"
        >
            <quick-controls-option icon="PencilIcon" @click="$emit('click:edit')" />
            <quick-controls-option icon="TrashIcon" @click="$emit('click:delete')" />
        </quick-controls>

        <quick-controls
            :show="inSaveMode"
        >
            <quick-controls-option
                icon="CheckIcon"
                text="Save Item"
                @click="$emit('click:save-item')"
            />
        </quick-controls>
    </div>
</template>

<script>
    import QuickControls from '@/Jetstream/QuickControls.vue';
    import QuickControlsOption from '@/Jetstream/QuickControlsOption.vue';

    export default {
        components: {
            QuickControls,
            QuickControlsOption,
        },

        emit: ['click:edit', 'click:delete', 'click:saveItem'],

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
                default: false
            },
            isClickable: {
                type: Boolean,
                default: false,
            },
        },

        data() {
            return {
                isHovering: false,
            }
        },

        computed: {
            containerClasses() {
                return {
                    // 'scale-105': this.isHovering && this.isClickable,
                    'hover:cursor-pointer': this.isHovering && this.isClickable
                }
            },

            shouldShowControls() {
                return this.isHovering &&
                    !this.pubMode &&
                    !this.inSaveMode &&
                    !this.hideControls;
            },

            contentWrapperStyles() {
                return {
                    'opacity-50': this.inSaveMode
                }
            }
        },
    }
</script>
