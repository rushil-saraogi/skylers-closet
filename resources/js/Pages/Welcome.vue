<template>
    <Head title="Welcome" />

    <div class="relative flex justify-center min-h-screen bg-white items-center">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 text-gray-800 text-center">
            <img src="images/logo.png" class="h-44 m-auto" />
            <div class="mt-4 flex gap-2 justify-center">
                <Link :href="route('login')">
                    <jet-button>Login</jet-button>
                </Link>
                <Link v-if="canRegister" :href="route('register')">
                    <secondary-button>Register</secondary-button>
                </Link>
            </div>
        </div>
    </div>
</template>

<script>
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import JetButton from '@/Jetstream/Button';
    import SecondaryButton from '@/Jetstream/SecondaryButton';

    export default {
        components: {
            Head,
            Link,
            JetButton,
            SecondaryButton
        },

        props: {
            canLogin: Boolean,
            canRegister: Boolean,
            laravelVersion: String,
            phpVersion: String,
        },

        mounted() {
            if (this.$page.props.user) {
                window.location.href = this.route('heme');
            }
        },
    }
</script>
