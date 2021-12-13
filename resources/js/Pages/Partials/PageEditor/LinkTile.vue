<template>
    <tile-wrapper
        @click:edit="$emit('click:edit')"
        @click:delete="$emit('click:delete')"
        @click:tile="handleTileClick"
        :inPreviewMode="inPreviewMode"
        :pubMode="pubMode"
        :isClickable="true"
    >
        <div v-if="data" class="h-full w-full relative overflow-y-hidden" ref="sliderContainer">
            <div
                class="w-full flex flex-col transform transition-transform duration-300 ease-in-out"
                :style="slidingWrapperStyles"
                ref="sliderWrapper"
            >
                <!-- Main screen -->
                <div :style="ogImageStyles">
                    <div :style="tileScreenStyles" class="w-full flex flex-col justify-between p-4">
                        <div>
                            <tile-icon v-if="icon" :icon="icon" class="h-6 w-6" />
                        </div>
                        <div class="flex justify-between items-center min-h-7">
                            <div class="text-white font-bold text-lg">{{ name }}</div>
                            <transition
                                enter-active-class="transition ease-in duration-200"
                                enter-from-class="-translate-x-3 opacity-0"
                                enter-to-class="translate-0 opacity-100"
                            >
                                <ChevronRightIcon
                                    v-show="isHovering"
                                    class="h-7 w-7 text-white"
                                />
                            </transition>
                        </div>
                    </div>
                </div>

                <!-- OG-Image screen -->
                <div
                    v-if="animated && image"
                    class="h-full w-full"
                    :style="{ ...tileScreenStyles, ...ogImageStyles }"
                >   
                </div>

                <!-- Meta data screen -->
                <div
                    v-if="animated"
                    class="h-full w-full p-4 flex gap-3"
                    :style="tileScreenStyles"
                >   
                    <div>
                        <div class="text-white font-semibold line-clamp-2">{{ ogTitle || title }}</div>
                        <div class="text-white mt-1 text-sm line-clamp-2">{{ ogDescription || description }}</div>
                    </div>
                </div>
            </div>
        </div>
    </tile-wrapper>
</template>

<script>
    import { get } from 'lodash';
    import IconButton from '@/Jetstream/IconButton.vue';
    import { ChevronRightIcon, PencilIcon, TrashIcon } from '@heroicons/vue/solid'
    import IconGithub from '@/icons/IconGithub';
    import QuickControls from '@/Jetstream/QuickControls.vue';
    import TileIcon from './TileIcon.vue';
    import TileWrapper from './TileWrapper.vue';
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
            TileIcon,
            TileWrapper
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
            },
            pubMode: {
                type: Boolean,
                default: false
            },
        },

        data() {
            return {
                ICON_MAPPING,
                isHovering: false,
                activeScreen: 0,
                animationTimeout: null,
            }
        },


        mounted() {
            this.resetAnimation();
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
                return get(this, 'data.og_image', '');
            },

            name() {
                return get(this, 'data.name', '');
            },

            color() {
                return get(this, 'data.color', DEFAULT_COLOR);
            },

            animated() {
                // return get(this, 'data.animated', false);
                // Temporarily turning off animation
                return false;
            },

            icon() {
                return get(this, 'data.icon');
            },

            shouldShowControls() {
                return !this.inPreviewMode && this.isHovering && !this.pubMode;
            },

            containerClasses() {
                return {
                    [`bg-${this.color || DEFAULT_COLOR}`]: true,
                }
            },

            slidingWrapperStyles() {
                const slideHeight = this.activeScreen > 0
                    ? this.activeScreen * this.$refs.sliderContainer.clientHeight
                    : 0;

                return {
                    'transform': `translate3d(0, -${slideHeight}px, 0)`,
                }
            },

            tileScreenStyles() {
                const styles = {};

                if (this.image) {
                    styles.backgroundImage = 'linear-gradient(to bottom, rgba(0, 0, 0, 0.65), rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.65))'
                }

                styles.height = this.inPreviewMode
                    ? '12rem'
                    // I have NO idea where the extra height is coming from
                    : `${(GRID_CONSTANTS.rowHeight * this.gridPosition.h) + ((this.gridPosition.h - 1) * 10)}px`

                return styles;
            },

            ogImageStyles() {
                if (!this.image) return {};

                return { 
                    background:`url(${this.image})`,
                    backgroundSize: 'cover',
                    backgroundPosition: 'center'
                };
            }
        },

        methods: {
            resetAnimation() {
                if (!this.animated) {
                    this.stopAnimation();
                    return;
                }

                this.startAnimation();
            },

            startAnimation() {
                this.animationTimeout = setInterval(() => {
                    this.activeScreen = (this.activeScreen + 1) % 3;
                }, this.getRandomInt(5000, 10000));
            },

            stopAnimation() {
                clearInterval(this.animationTimeout);
                this.activeScreen = 0;
            },

            getRandomInt(min, max) {
                min = Math.ceil(min);
                max = Math.floor(max);
                return Math.floor(Math.random() * (max - min) + min);
            },

            handleTileClick() {
                if (!this.pubMode) return;
                window.open(this.data.url, "_blank");
            },
        },

        watch: {
            animated() {
                this.resetAnimation();
            },
        }
    }
</script>
