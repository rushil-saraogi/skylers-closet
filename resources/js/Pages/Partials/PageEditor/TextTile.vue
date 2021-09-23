<template>
    <div
        class="h-full w-full transition-all duration-200"
        :class="containerClasses"
        @mouseenter="isHovering = true"
        @mouseleave="isHovering = false"
    >
        <div v-if="data" class="h-full w-full overflow-y-hidden p-3 bg-gray-900">
            <h2 class="text-3xl font-extrabold tracking-tight sm:text-4xl" :class="textClasses">
                {{ text }}
            </h2>
        </div>
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
            data: {
                type: Object,
                default: null,
            },
            inPreviewMode: {
                type: Boolean,
                default: false,
            },
            theme: {
                type: String,
                validator: function (value) {
                    return Object.values(TEXT_TILE_THEMES).indexOf(value) !== -1
                },
                default: TEXT_TILE_THEMES.dark
            },
            gridPosition: {
                type: Object,
                default: {},
            },
            pubMode: {
                type: Boolean,
                default: false
            },
        },

        data() {
            return {
                isHovering: false,
            }
        },

        computed: {
            text() {
                return get(this, 'data.text', '');
            },

            theme() {
                return get(this, 'data.theme', TEXT_TILE_THEMES.dark);
            },

            shouldShowControls() {
                return !this.inPreviewMode && this.isHovering && !this.pubMode;
            },

            containerClasses() {
                return {
                    'h-32': this.inPreviewMode,
                    'w-80': this.inPreviewMode,
                    'bg-black bg-opacity-20': this.inPreviewMode || !this.pubMode,
                }
            },

            textClasses() {
                return {
                    'text-white': this.theme === TEXT_TILE_THEMES.dark,
                    'text-black': this.theme === TEXT_TILE_THEMES.light,
                }
            }
        },
    }
</script>
