<template>
    <div class="border border-gray-200 bg-opacity-80 shadow-sm rounded bg-white flex flex-col justify-center items-center py-8 px-16">
        <jet-header v-if="header" type="h3">{{ header }}</jet-header>
        <div class="text-gray-600 mt-1" v-if="copy">{{ copy }}</div>
        <jet-button class="mt-4" @click="$emit('cta:click')">{{ cta }}</jet-button>
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
