<template>
    <div class="flex flex-col">
        <div class="flex-1 bg-[url('/images/samples/room-1.jpeg')] bg-center bg-cover overflow-hidden">
            <div class="w-full h-full bg-black/60 flex flex-col items-start justify-between p-4">
                <div class="self-center">
                    <img src="/images/samples/hotel-logo.png" class="h-10" />
                </div>
                <div class="mt-8">
                    <div class="text-white font-bold text-3xl">
                        Welcome Rushil Saraogi
                    </div>
                    <div class="text-white opacity-80 text-lg">
                        Room 202
                    </div>
                </div>
            </div>
        </div>
        <div class="flex-1">
            <icon-grid />
        </div>
    </div>
</template>

<script>
import JetButton from "@/Jetstream/Button";
import IconGrid from '../IconGrid.vue';


export default {
    props: [],

    components: {
        JetButton,
        IconGrid,
    },

    mounted() {
    },

    data() {
        return {

        };
    },

    methods: {
    },
};
</script>
