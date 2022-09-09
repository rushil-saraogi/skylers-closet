<template>
    <dialog-modal :show="show" @close="$emit('click:close')">
        <template #title>
            Select Tile Type
        </template>

        <template #content>
            
        </template>

        <template #footer>
            <jet-secondary-button @click="$emit('click:close')">
                Nevermind
            </jet-secondary-button>

            <jet-button @click="submit" class="ml-2">
                Save
            </jet-button>
        </template>
    </dialog-modal>
</template>

<script>
    import DialogModal from '@/Jetstream/DialogModal.vue';
    import JetButton from '@/Jetstream/Button.vue'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton';
    import LinkTile from './LinkTile.vue';
    import { TILE_COLORS } from './constants';
    import { TILE_ICONS } from './TileIcon.vue';
    import TileIcon from './TileIcon.vue';

    export default {
        components: {
            DialogModal,
            JetButton,
            JetSecondaryButton,
            LinkTile,
            TileIcon,
        },

        emits: ['click:close'],

        props: {
            show: {
                type: Boolean,
                default: false
            },
        },

         data() {
            return {
                TILE_COLORS,
                TILE_ICONS,
            }
        },

        methods: {
            submit() {
                console.log('submitted');
            },
        }
    }
</script>
