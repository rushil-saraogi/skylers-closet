<template>
    <tile-wrapper
        @click:edit="$emit('click:edit')"
        @click:delete="$emit('click:delete')"
        :inPreviewMode="inPreviewMode"
        :pubMode="pubMode"
    >
        <div v-if="data" :class="textWrapperClasses" class="h-full w-full overflow-y-hidden p-5 bg-gray-900 flex">
            <div>
                <h2 class="text-3xl font-extrabold tracking-tight sm:text-4xl">
                    {{ header }}
                </h2>
                <p class="mt-2">{{ body }}</p>
            </div>
        </div>
    </tile-wrapper>
</template>

<script>
    import { get } from 'lodash';
    import { TEXT_TILE_THEMES } from './constants.js';
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

        computed: {
            header() {
                return get(this, 'data.header', '');
            },

            body() {
                return get(this, 'data.body', '');
            },

            theme() {
                return get(this, 'data.theme', TEXT_TILE_THEMES.dark);
            },

            textWrapperClasses() {
                return {
                    'min-h-48ti': this.inPreviewMode,
                    'text-white': this.theme === TEXT_TILE_THEMES.dark,
                    'text-black': this.theme === TEXT_TILE_THEMES.light,
                }
            }
        },
    }
</script>
