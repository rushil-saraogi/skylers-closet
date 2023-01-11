<template>
    <app-layout title="Home">
        <onboarding-wizard
            v-if="shouldShowOnboarding"
            :step="onboardingStep"
            :user="auth.user"
        />
        <div v-else class="w-full">
            <h1>
                Logged in: Welcome to your app!
            </h1>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Jetstream/Button";

export default {
    props: [
        'auth'
    ],

    components: {
        AppLayout,
        JetButton,
    },

    mounted() {
    },

    data() {
        return {

        };
    },

    computed: {
        shouldShowOnboarding() {
            return !this?.auth?.user?.onboarded;
        },

        onboardingStep() {
            return this?.auth?.user?.onboarding_step;
        }
    },

    methods: {
        uploadLogo() {
            console.log('upload logo');
        }
    },
};
</script>
