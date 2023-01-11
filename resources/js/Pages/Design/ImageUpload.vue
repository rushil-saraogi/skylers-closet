<template>
    <div class="w-full">
        <input
            type="file"
            class="hidden"
            ref="imageUpload"
            @change="updateImagePreview"
        />
        <div
            class="w-full cursor-pointer border rounded p-2"
        >
            <div v-if="!imagePreview" class="flex items-center justify-between">
                <div class="flex items-center text-gray-500">
                    <AddPhotoIcon class="h-8 w-8 text-gray-400" />
                    <div class="ml-3">
                        Logo
                    </div>
                </div>
                <div>
                    <jet-button-secondary @click="selectImage">Add</jet-button-secondary>
                </div>
            </div>
            <div v-else v-show="imagePreview" class="flex gap-4 items-center justify-between">
                <span
                    class="block rounded w-full h-10"
                    :style="
                        'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' +
                        imagePreview +
                        '\');'
                    "
                >
                </span>

                <div class="flex gap-2 items-center">
                    <jet-button-secondary
                        @click="clearImage"
                        v-show="imagePreview"
                    >Remove</jet-button-secondary>
                    <jet-button-secondary
                        @click="clearImage"
                        v-show="imagePreview"
                    >Replace</jet-button-secondary>
                </div>
                
            </div>
        </div>
    </div>
</template>

<script>
import JetButtonSecondary from "@/Jetstream/SecondaryButton.vue";
import AddPhotoIcon from '@/icons/AddPhotoIcon.vue';

export default {
    components: {
        JetButtonSecondary,
        AddPhotoIcon
    },

    data() {
        return {
            imagePreview: null,
        }
    },

    props: {
    },

    methods: {
        selectImage() {
            this.$refs.imageUpload.click();
        },

        updateImagePreview() {
            const photo = this.$refs.imageUpload.files[0];

            if (!photo) return;

            const reader = new FileReader();

            reader.onload = (e) => {
                this.imagePreview = e.target.result;
            };

            reader.readAsDataURL(photo);
        },

        uploadImage() {
            const photo = this.$refs.imageUpload.files[0];

            if (!photo) return;

            const formData = new FormData();

            formData.append('logo', photo);

            axios.post('/logo', formData)
                .then(response => {
                    this.imagePreview = response.data.path;
                });
        },

        clearImage() {
            this.imagePreview = null;
        }
    }
};
</script>
