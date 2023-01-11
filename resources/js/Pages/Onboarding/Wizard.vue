<template>
    <div class="h-screen w-screen fixed top-0 left-0 bg-white flex items-center justify-center z-20">
        <step-1 v-if="step === 1" @submit:step="submitStep1"></step-1>
    </div>
</template>

<script>
import JetButton from "@/Jetstream/Button";
import Step1 from "./Step1.vue";

export default {
    props: {
        step: {
            type: Number,
            required: true,
        },

        user: {
            type: Object,
            required: true,
        },
    },

    components: {
        JetButton,
        Step1,
    },

    mounted() {
    },

    data() {
        return {
            form: this.$inertia.form({
                name: ''
            }),
        };
    },

    computed: {
    },

    methods: {
        submitStep1(value) {
            this.form.name = value;

            this.form.post(route('create-hotel'), {
                preserveScroll: true,
                onSuccess: () => {
                    this.form.reset('password');
                    this.completeOnboarding();
                },
            });
        },

        completeOnboarding() {
            this.$inertia.put(
                this.route('complete-onboarding', [this.user.id]), {});
        },
    },
};
</script>
