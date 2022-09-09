<template>
    <tile-wrapper
        :hide-controls="true"
    >
        <div class="h-full w-full overflow-y-hidden p-5 bg-gray-900 flex">
            <div>
                <h2 class="text-3xl text-white font-extrabold tracking-tight sm:text-4xl">
                    Let's start here
                </h2>
                <p class="mt-2 text-white">Try adding something to your closet</p>
            </div>
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
            pubMode: {
                type: Boolean,
                default: false
            },
        },

        computed: {
        },
    }
</script>
