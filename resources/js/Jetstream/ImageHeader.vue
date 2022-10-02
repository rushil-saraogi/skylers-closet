<template>
    <div class="flex flex-col items-center" :class="{ [classes]: classes }">
        <!-- Image -->
        <Link v-if="imageLink && image" :href="link">
            <img
                :src="image"
                class="h-24 w-24 rounded-full"
            />
        </Link>
        <img v-else-if="image" :src="image" class="h-24 w-24 rounded-full" />

        <!-- Header -->
        <div class="text-4xl font-bold mt-5">{{ headerText }}</div>

        <!-- Subheader -->
        <Link v-if="subheaderLink && subHeaderText" :href="subheaderLink">
            <div class="mt-2 text-gray-600 hover:text-gray-900">
                {{ subHeaderText }}
            </div>
        </Link>
        <div v-else-if="subHeaderText" class="mt-2 text-gray-600">
            {{ subHeaderText }}
        </div>

        <!-- CTA -->
        <slot name="cta"></slot>
    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
    components: { Link },

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
        imageLink: {
            type: String,
            required: false,
            default: "",
        },
        subheaderLink: {
            type: String,
            required: false,
            default: "",
        },
        cta: {
            type: String,
            default: "",
        },
        ctaVariant: {
            type: String,
            default: "",
        },
        classes: String,
    },
};
</script>
