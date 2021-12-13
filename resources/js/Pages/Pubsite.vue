<template>
    <div class="bg-black h-screen w-screen">
        <transition enter-active-class="ease-out duration-1000"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100">
            <div v-show="loadedBackground" class="fixed inset-0 transform transition-all">
                <div class="h-screen w-screen z-0 absolute top-0 left-0" :style="backgroundStyles" />
            </div>
        </transition>
        
        <div class="max-w-3xl mx-auto z-10 pt-20">
            <tile-layout
                v-if="page.tiles"
                :tiles="page.tiles"
                :initial-layout="page.layout"
                :pub-mode="true"
            />
        </div>
        
    </div>
</template>

<script>
    import TileLayout from './Partials/PageEditor/TileLayout.vue';
    import { updateQueryStringParameter } from '@/Util/Url'

    export default {
        props: ['page'],

        components: {
            TileLayout
        },

        data() {
            return {
                loadedBackground: false,
                backgroundStyles: { 'background': '#000' }
            }
        },

        methods: {
            loadImage(src) {
                return new Promise(function(resolve, reject) {
                    const image = new Image();
                    image.addEventListener('load', resolve);
                    image.addEventListener('error', reject);
                    image.src = src;
                });
            },

            setWallpaper() {
                const wallpaperUrl = updateQueryStringParameter(this.page.wallpaper, 'w', window.innerWidth);

                this.loadImage(wallpaperUrl).then(() => {
                    this.backgroundStyles = { 'background':`url(${wallpaperUrl})` };
                    this.loadedBackground = true;
                });
            }
        },

        mounted() {
            if (this.page.wallpaper) {
                this.setWallpaper();
            }
        },
    }
</script>

