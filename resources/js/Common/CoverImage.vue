<template>
    <div :style="coverImageStyles" class="w-full h-56 bg-center" />
</template>

<script>
import { updateQueryStringParameter } from '@/Util/Url'

export default {
    props: ['url'],

    computed: {
        coverImageStyles() {
            console.log(this.$props);
            const wallpaperUrl = updateQueryStringParameter(this.url, 'w', window.innerWidth);

            return {
                'background-image':`url(${wallpaperUrl})`
            }

        }
    }
};
</script>
