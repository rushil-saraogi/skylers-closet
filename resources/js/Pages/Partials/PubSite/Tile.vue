<template>
    <div
        class="h-full w-full transition-all duration-200"
        :class="containerClasses"
        @mouseenter="isHovering = true"
        @mouseleave="isHovering = false"
    >
        <div v-if="data" class="h-full w-full relative overflow-y-hidden" ref="sliderContainer">
            <div
                class="w-full flex flex-col transform transition-transform duration-300 ease-in-out"
                :style="slidingContainerStyles"
            >
                <div
                    class="w-full flex flex-col justify-between p-4"
                    :style="tileScreenStyles"
                >
                    <div>
                        <tile-icon v-if="icon" :icon="icon" class="h-7 w-7" />
                    </div>
                    <div class="flex justify-between items-center min-h-7">
                        <div class="text-white font-semibold">{{ name }}</div>
                        <transition
                            enter-active-class="transition ease-in duration-200"
                            enter-from-class="-translate-x-2 opacity-0"
                            enter-to-class="translate-0 opacity-100"
                        >
                            <ChevronRightIcon
                                v-show="isHovering"
                                class="h-7 w-7 text-white"
                            />
                        </transition>
                    </div>
                </div>
                <div
                    v-if="animated"
                    class="h-full w-full p-4"
                    :style="tileScreenStyles"
                >
                    <div class="text-white font-semibold line-clamp-2">{{ ogTitle || title }}</div>
                    <div class="text-white mt-1 text-sm line-clamp-2">{{ ogDescription || description }}</div>
                </div>
            </div>
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
    import { DEFAULT_COLOR, ICON_MAPPING, GRID_CONSTANTS } from './constants.js';

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
            gridPosition: {
                type: Object,
                default: {},
            }
        },

        data() {
            return {
                ICON_MAPPING,
                isHovering: false,
                showSecondaryView: false,
                secondaryViewTimeout: null,
            }
        },


        mounted() {
            if (this.animated) {
                this.toggleSecondaryView();
            }
        },

        computed: {
            title() {
                return get(this, 'data.title', '');
            },

            ogTitle() {
                return get(this, 'data.og_title', '');
            },

            description() {
                return get(this, 'data.description', '');
            },

            ogDescription() {
                return get(this, 'data.og_description', '');
            },

            image() {
                return get(this, 'data.image', '');
            },

            name() {
                return get(this, 'data.name', '');
            },

            color() {
                return get(this, 'data.color', DEFAULT_COLOR);
            },

            animated() {
                return get(this, 'data.animated', false);
            },

            icon() {
                return get(this, 'data.icon');
            },

            isGithubLink() {
                // Implement link checks
                return false
            },

            shouldShowControls() {
                return !this.inPreviewMode && this.isHovering;
            },

            containerClasses() {
                return {
                    'h-32': this.inPreviewMode,
                    'w-80': this.inPreviewMode,
                    [`bg-${this.color || DEFAULT_COLOR}`]: true,
                    'scale-105': this.isHovering
                }
            },

            slidingContainerStyles() {
                const slideHeight = this.showSecondaryView
                    ? this.$refs.sliderContainer.clientHeight
                    : 0;

                return {
                    'transform': `translate3d(0, -${slideHeight}px, 0)`,
                }
            },

            tileScreenStyles() {
                if (this.inPreviewMode) {
                    return { height: '8rem' };
                }

                // I have NO idea where the extra height is coming from
                return {
                    height: `${(GRID_CONSTANTS.rowHeight * this.gridPosition.h) + ((this.gridPosition.h - 1) * 10)}px`
                }
            }
        },

        methods: {
            toggleSecondaryView() {
                this.secondaryViewTimeout = setInterval(() => {
                    this.showSecondaryView = !this.showSecondaryView;
                }, this.getRandomInt(5000, 8000));
            },

            getRandomInt(min, max) {
                min = Math.ceil(min);
                max = Math.floor(max);
                return Math.floor(Math.random() * (max - min) + min);
            }
        },

        watch: {
            animated(newVal) {
                if (!newVal) {
                    clearInterval(this.secondaryViewTimeout);
                    this.showSecondaryView = false;
                    return;
                }

                this.toggleSecondaryView();
            }
        }
    }
</script>
