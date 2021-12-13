<template>
    <div
        class="h-full w-full transition-all duration-200 rounded-lg overflow-hidden relative"
        :class="containerClasses"
        @click="$emit('click:tile')"
        @mouseenter="isHovering = true"
        @mouseleave="isHovering = false"
    >
        <slot />

        <quick-controls
            :show="shouldShowControls"
        >
            <quick-controls-option icon="PencilIcon" @click="$emit('click:edit')" />
            <quick-controls-option icon="TrashIcon" @click="$emit('click:delete')" />
        </quick-controls>
    </div>
</template>

<script>
    import { get } from 'lodash';
    import IconButton from '@/Jetstream/IconButton.vue';
    import { ChevronRightIcon, PencilIcon, TrashIcon } from '@heroicons/vue/solid'
    import IconGithub from '@/icons/IconGithub';
    import QuickControls from '@/Jetstream/QuickControls.vue';
    import TileIcon from './TileIcon.vue';
    import QuickControlsOption from '@/Jetstream/QuickControlsOption.vue';
    import { TEXT_TILE_THEMES } from './constants.js';

    export default {
        components: {
            IconButton,
            IconGithub,
            ChevronRightIcon,
            PencilIcon,
            TrashIcon,
            QuickControls,
            QuickControlsOption,
            TileIcon
        },

        emit: ['click:edit', 'click:delete'],

        props: {
            inPreviewMode: {
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
                    'min-h-48': this.inPreviewMode,
                    'w-80': this.inPreviewMode,
                    'bg-black bg-opacity-20': this.inPreviewMode || !this.pubMode,
                    'scale-105': this.isHovering && this.isClickable,
                    'hover:cursor-pointer': this.isHovering && this.isClickable
                }
            },

            shouldShowControls() {
                return !this.inPreviewMode && this.isHovering && !this.pubMode;
            },
        },
    }
</script>
