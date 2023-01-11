<template>
    <div class="grid grid-cols-3 grid-rows-6 gap-3">
        <div v-for="(option, index) in options" :key="index" class="flex flex-col items-center p-5">
            <div class="bg-indigo-500 flex items-center justify-center p-5 rounded-lg">
                <span class="material-icons text-2xl text-white">{{ option.icon }}</span>
            </div>
            <div class="text-white text-sm mt-2 text-center">
                {{ option.label }}
            </div>
        </div>
    </div>
    
</template>

<script>
import JetButton from "@/Jetstream/Button";

const options = [
    {
        icon: 'restaurant',
        label: 'Room Service'
    },
    {
        icon: 'local_cafe',
        label: 'Coffee Shop'
    },
    {
        icon: 'dry_cleaning',
        label: 'House Keeping'
    },
]

export default {
    props: [
        'layout'
    ],

    components: {
        JetButton,
    },

    mounted() {
    },

    data() {
        return {
            options
        };
    },

    computed: {
    },

    methods: {
    },
};
</script>
