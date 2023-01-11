<template>
    <app-layout title="Design">
        <div class="w-full flex gap-8">
            <side-bar class="max-w-xs">
                <div>
                    <div class="p-4 border-t border-gray-100">
                        <div>Select Layout</div>
                        <LayoutSelector class="mt-2" />
                    </div>

                    <div class="border-t border-gray-100 p-4">
                        <div>Primary Color</div>
                        <ColorSelector class="mt-2" />
                        <div class="text-sm mt-2 text-gray-600">Applies accross the app</div>
                    </div>

                    <div class="p-4 border-t border-gray-100">
                        <div>Logo</div>
                        <ImageUpload class="mt-2" />
                    </div>
                </div>
            </side-bar>
            <mobile-frame>
                <app-preview
                    :layout="0"
                />
            </mobile-frame>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Jetstream/Button";
import MobileFrame from "@/Jetstream/MobileFrame.vue";
import SideBar from "@/Jetstream/SideBar.vue";
import AppPreview from './Design/AppPreview.vue';
import LayoutSelector from './Design/LayoutSelector.vue';
import ColorSelector from './Design/ColorSelector.vue';
import ImageUpload from './Design/ImageUpload.vue';

export default {
    props: [
        'auth'
    ],

    components: {
        AppLayout,
        JetButton,
        MobileFrame,
        SideBar,
        AppPreview,
        LayoutSelector,
        ColorSelector,
        ImageUpload
    },

    mounted() {
    },

    data() {
        return {

        };
    },

    computed: {

    },

    methods: {
        uploadLogo() {
            console.log('upload logo');
        }
    },
};
</script>
