<template>
    <tile-wrapper
        :hide-controls="true"
    >
        <div class="flex flex-col items-center justify-center flex-1 p-6">
            <loader classes="h-16 w-16" />
        </div>
    </tile-wrapper>
</template>

<script>
import Loader from '@/Jetstream/Loader.vue';
import TileWrapper from "./TileWrapper.vue";

export default {
    components: {
        TileWrapper,
        Loader
    },
};
</script>
