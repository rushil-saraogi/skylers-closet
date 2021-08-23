<template>
    <div class="border border-gray-300 flex flex-col justify-center items-center py-8 px-3">
        <jet-header v-if="header" type="h3" classes="mb-1">{{ header }}</jet-header>
        <div class="text-gray-600 mb-4" v-if="copy">{{ copy }}</div>
        <jet-button @click="$emit('cta:click')">{{ cta }}</jet-button>
    </div>
</template>

<script>
    import JetButton from './Button.vue';
    import JetHeader from './Header.vue';

    export default {
        components: { JetButton, JetHeader },

        props: {
            header: String,
            copy: String,
            cta: {
                type: String,
                required: true,
            },
        }
    }
</script>
