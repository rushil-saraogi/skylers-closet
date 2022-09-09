<template>
    <dialog-modal :show="show" @close="$emit('click:close')">
        <template #title>
            Tile type
        </template>

        <template #content>
            <div class="grid gap-4 grid-cols-3 grid-rows-3">
				<div v-for="(tile, index) in TILE_LIST" :key="index">
					<div class="h-28 bg-gray-200/70 rounded-lg duration-200 flex flex-col items-center justify-center hover:bg-gray-200 hover:cursor-pointer">
						<span class="material-icons text-3xl text-gray-500">{{ tile.icon }}</span>
                        <div class="text-xs font-mono mt-2">{{ tile.name }}</div>
					</div>
				</div>
			</div>
        </template>

        <template #footer>
            <jet-secondary-button @click="$emit('click:close')">
                Nevermind
            </jet-secondary-button>
        </template>
    </dialog-modal>
</template>

<script>
    import DialogModal from '@/Jetstream/DialogModal.vue';
    import JetButton from '@/Jetstream/Button.vue'
    import JetDropdown from '@/Jetstream/Dropdown.vue'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton';
    import JetLabel from '@/Jetstream/Label.vue'
    import Loader from '@/Jetstream/Loader.vue';
    import { TILE_LIST } from './constants';

    export default {
        components: {
            DialogModal,
            JetButton,
            JetLabel,
            Loader,
            JetSecondaryButton,
            JetDropdown,
        },

        emits: ['click:close'],

        props: {
            show: {
                type: Boolean,
                default: false
            },
            pageId: {
                type: Number,
                required: true,
            },
            selectedTile: {
                type: Object,
                default: null,
            },
        },

        data() {
            return {
                errors: {},
				TILE_LIST
            }
        },

        watch: {
            show() {
            },
        },

        computed: {

        },

        methods: {
            submit() {

            },
        },
    }
</script>
