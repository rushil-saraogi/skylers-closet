<template>
    <jet-confirmation-modal :show="show" @close="$emit('click:close')">
        <template #title>
            Delete Tile
        </template>

        <template #content>
            Are you sure you want to delete this tile? This cannot be undone.
        </template>

        <template #footer>
            <jet-secondary-button @click="$emit('click:close')">
                Nevermind
            </jet-secondary-button>

            <jet-danger-button class="ml-2" @click="$emit('click:confirm')" :class="{ 'opacity-25': loading }" :disabled="loading">
                Delete Link
            </jet-danger-button>
        </template>
    </jet-confirmation-modal>
</template>

<script>
import JetDangerButton from '@/JetStream/DangerButton.vue';
import JetConfirmationModal from '@/JetStream/ConfirmationModal.vue';
import JetSecondaryButton from '@/JetStream/SecondaryButton.vue'

export default {
    components: {
        JetDangerButton,
        JetConfirmationModal,
        JetSecondaryButton,
    },

    emits: ['click:confirm', 'click:close'],

    props: {
        show: Boolean,
        loading: Boolean
    }
}
</script>