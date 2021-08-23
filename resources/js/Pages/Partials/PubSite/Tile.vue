<template>
    <div class="h-full w-full p-4 tile bg-gray-200" :class="containerClasses">
        <div v-if="data" class="h-full w-full flex flex-col justify-between">
            <div>
                <icon-github class="h-8 w-8" />
            </div>
            <div class="flex justify-between items-center">
                <div class="text-white font-semibold">{{ name }}</div>
                <div>
                    <icon-arrow-right color="white" />
                </div>
            </div>
        </div>
        <div v-if="shouldShowEditButton" class="h-full w-full flex justify-center items-center">
            <icon-button @click="$emit('click:edit')" icon="edit" class="tile-icon" />
        </div>
    </div>
</template>

<script>
    import { get } from 'lodash';
    import IconButton from '@/Jetstream/IconButton.vue';
    import IconArrowRight from '@/icons/IconArrowRight.vue';
    import IconGithub from '@/icons/IconGithub';

    const DEFAULT_COLOR = 'blue-400';

    export default {
        components: { IconButton, IconGithub, IconArrowRight },

        props: {
            data: {
                type: Object,
                default: null,
            },
            inPreviewMode: {
                type: Boolean,
                default: false,
            }
        },

        data() {
            return {
                color: DEFAULT_COLOR
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

            isGithubLink() {
                // Implement link checks
                return false
            },

            shouldShowEditButton() {
                return !this.data && !this.inPreviewMode;
            },

            containerClasses() {
                return {
                    'h-32': this.inPreviewMode,
                    'w-80': this.inPreviewMode,
                    [`bg-${this.color}`]: this.color && this.data,
                }
            }
        },

        methods: {},
    }
</script>
<style scoped>
.tile-icon {
    display: none;
}
.tile:hover .tile-icon {
    display: block;
}
</style>