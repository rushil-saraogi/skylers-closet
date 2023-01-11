<template>
    <div class="text-center flex flex-col items-center">
        <BuildingIllustration class=" h-48 w-72" />
        <div class="text-4xl font-bold text-gray-800 mt-8">
            Let's get started!
        </div>

        <div class="text-gray-800 mt-2">
            What is the name of your glorious establishment?
        </div>

        <input-group
            type="text"
            class="mt-3 block w-full"
            v-model="name"
            placeholder="Hotel Name"
            id="hotelNameInput"
            :error="error"
        />

        <div class="text-gray-600 text-sm mt-3">
            You can always change this later
        </div>

        <jet-button
            class="mt-6"
            :disabled="!validForm"
            @click="$emit('submit:step', name)"
        >Done</jet-button>
    </div>
</template>

<script>

import JetButton from "@/Jetstream/Button";
import InputGroup from '@/Jetstream/InputGroup.vue'
import ApplicationMark from '@/Jetstream/ApplicationMark.vue';
import BuildingIllustration from './BuildingIllustration.vue';

export default {
    props: [
        'step'
    ],

    components: {
        JetButton,
        InputGroup,
        ApplicationMark,
        BuildingIllustration
    },

    mounted() {
        this.initializeForm();
    },

    data() {
        return {
            name: '',
            error: null,
        }
    },

    computed: {
        validForm() {
            return this.name.length > 3;
        }
    },

    methods: {
        initializeForm() {
            this.$nextTick(() => {
                document.getElementById("hotelNameInput").focus();
            });
        },
    },
};
</script>
