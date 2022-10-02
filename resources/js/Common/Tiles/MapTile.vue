<template>
    <tile-wrapper
        @click:edit="$emit('click:edit')"
        @click:delete="$emit('click:delete')"
        :inPreviewMode="inPreviewMode"
        :pubMode="pubMode"
    >
        <div
            class="overflow-hidden absolute h-full w-full top-0 left-0 bg-gray-200 rounded-lg"
        >
            <iframe
                width="100%"
                height="100%"
                loading="lazy"
                allowfullscreen
                :src="locationUrl">
            </iframe>
        </div>
    </tile-wrapper>
</template>

<script>
    import TileWrapper from './TileWrapper.vue';

    export default {
        components: {
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
        },

        computed: {
            locationUrl() {
                const defaultLocation = 'Space+Needle,Seattle+WA';
                return `https://www.google.com/maps/embed/v1/place?key=<<API_KEY>>&q=${encodeURIComponent(this.data?.location) || defaultLocation}`
            }
        },
    }
</script>
