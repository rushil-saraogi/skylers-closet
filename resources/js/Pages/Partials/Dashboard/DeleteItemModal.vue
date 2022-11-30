<template>
    <jet-confirmation-modal :show="show" @close="$emit('click:close')">
        <template #title>
            Delete Item
        </template>

        <template #content>
            Are you sure you want to delete this item?
        </template>

        <template #footer>
            <jet-secondary-button class="mb-3 sm:mb-0" @click="$emit('click:close')">
                Nevermind
            </jet-secondary-button>

            <jet-danger-button class="sm:ml-2" @click="$emit('click:confirm')" :class="{ 'opacity-25': loading }" :disabled="loading">
                Delete Item
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