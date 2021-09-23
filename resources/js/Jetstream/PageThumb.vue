<template>
    <div
        class="rounded-md p-4 font-mono bg-white shadow hover:shadow-md hover:cursor-pointer transition flex flex-col justify-between"
        :class="classes"
        @mouseenter="isHovering = true"
        @mouseleave="isHovering = false"
    >
        <div :style="thumbnailStyles" class="min-h-36 min-w-56 w-full relative rounded-t bg-gray-100">
            <quick-controls
                :show="isHovering"
                theme="dark"
            >
                <quick-controls-option
                    theme="dark"
                    icon="PencilIcon"
                    @click="$emit('click:edit')"
                />
                <quick-controls-option
                    icon="TrashIcon"
                    @click.stop="$emit('click:delete-page')"
                    theme="dark"
                />
            </quick-controls>
        </div>
        <div class="mt-4">
            <div v-if="page.active" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                ACTIVE
            </div>
            <div v-else class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                DISABLED
            </div>
            <div
                class="text-gray-600 mt-2"
            >
                /{{ page.slug }}
            </div>
        </div>
    </div>

</template>

<script>
    import QuickControls from '@/Jetstream/QuickControls.vue';
    import QuickControlsOption from '@/Jetstream/QuickControlsOption.vue';
    import { updateQueryStringParameter } from '@/Util/Url';

    export default {
        components: {
            QuickControls,
            QuickControlsOption
        },

        props: {
            page: {
                type: Object,
                required: true,
            }
        },

        emits: ['click:edit', 'click:delete-page'],

        data() {
            return {
                isHovering: false,
            }
        },
        computed: {
            hasContent() {
                return !!this.$slots.default;
            },
            classes() {
                return {
                }
            },

            thumbnailStyles() {
                if (!this.page.wallpaper) return {}

                const wallpaperUrl = updateQueryStringParameter(this.page.wallpaper, 'w', 400);

                return { 
                    background:`url(${wallpaperUrl})`,
                    backgroundSize: 'cover',
                    backgroundPosition: 'center'
                };
            }
        }
    }
</script>
