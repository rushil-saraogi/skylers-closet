<template>
    <div class="flex flex-col items-center" :class="{ [classes]: classes }">
        <Link v-if="link && image" :href="link">
            <img
                :src="image"
                class="h-28 w-28 rounded-full border border-2 border-gray-100 hover:border-indigo-200"
            />
        </Link>
        <img v-else-if="image" :src="image" class="h-28 w-28 rounded-full" />
        <div class="text-4xl font-bold mt-5">{{ headerText }}</div>
        <div v-if="subHeaderText" class="mt-2 text-gray-600">
            {{ subHeaderText }}
        </div>
        <button-vue v-if="cta" @click="$emit('click:cta')" class="mt-4">{{
            cta
        }}</button-vue>
    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
import ButtonVue from "./Button.vue";

export default {
    components: { Link, ButtonVue },

    props: {
        headerText: {
            type: String,
            required: true,
        },
        subHeaderText: {
            type: String,
            required: false,
            default: "",
        },
        image: {
            type: String,
            required: false,
            default: "",
        },
        link: {
            type: String,
            required: false,
            default: "",
        },
        cta: {
            type: String,
            default: "",
        },
        classes: String,
    },
};
</script>
