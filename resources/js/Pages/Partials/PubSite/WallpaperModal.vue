<template>
    <dialog-modal :show="show" @close="$emit('click:close')">
        <template #title>
            Add Wallpaper
        </template>

        <template #content>
            <div class="grid gap-2 grid-cols-2 sm:grid-cols-3">
                <thumbnail
                    v-for="(thumbnail, index) in thumbnails"
                    :key="index"
                    :src="thumbnail"
                    :selected="thumbnail === selected"
                    @click="handleThumbnailClick(thumbnail)"
                />
            </div>
        </template>

        <template #footer>
            <jet-secondary-button @click="$emit('click:close')">
                Nevermind
            </jet-secondary-button>

            <jet-button @click="submit" class="ml-2" :disabled="isSubmitDisabled">
                Save
            </jet-button>
        </template>
    </dialog-modal>
</template>

<script>
    import DialogModal from '@/Jetstream/DialogModal.vue';
    import JetButton from '@/Jetstream/Button.vue'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton';
    import Loader from '@/Jetstream/Loader.vue';
    import Thumbnail from '@/Jetstream/Thumbnail.vue';

    export default {
        components: {
            DialogModal,
            JetButton,
            JetSecondaryButton,
            Loader,
            Thumbnail,
        },

        emits: ['click:close'],

        props: {
            show: {
                type: Boolean,
                default: false
            },
            initialSelection: {
                type: String,
                default: null,
            }
        },

        mounted() {
            if (this.initialSelection) {
                this.selected = this.initialSelection;
            }
        },

        computed: {
            isSubmitDisabled() {
                return false;
            }
        },

         data() {
            return {
                thumbnails: [
                    'https://images.unsplash.com/photo-1586302836983-d1efb5eee221?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=80',
                    'https://images.unsplash.com/photo-1612890837837-cb120add26f5?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=80',
                    'https://images.unsplash.com/photo-1563366598-5d464ebe190a?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=300&q=80',
                    'https://images.unsplash.com/photo-1626755684260-6d01215551f6?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=80',
                    'https://images.unsplash.com/photo-1613153262491-c1a4acb9795e?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=300&q=80'
                ],
                selected: null,
            }
        },

        watch: {
        },

        methods: {
            submit() {
                this.$emit('click:submit', this.selected);
                this.$emit('click:close');
            },

            handleThumbnailClick(selected) {
                this.selected = selected;
            }
        }
    }
</script>
