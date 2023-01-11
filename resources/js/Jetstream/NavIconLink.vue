<template>
    <div class="flex justify-start items-center flex-col">
        <Link :href="route(routeName)" :active="route().current(routeName)">
            <div class="h-16 w-16 flex items-center justify-center bg-teal-400 hover:bg-teal-500 transition rounded">
                <span class="material-icons text-3xl text-white">{{ icon }}</span>
            </div>
        </Link>
        <div class="text-center text-sm mt-1.5">{{ label }}</div>
    </div>
</template>

<script>
    import { Link } from '@inertiajs/inertia-vue3'

    export default {
        components: {
            Link
        },

        emits: ['click'],

        props: {
            icon: {
                type: String,
                required: true
            },
            routeName: {
                type: String,
                required: true
            },
            label: {
                type: String,
                required: true,
            },
        },

        data() {
            return {
            }
        },
    }
</script>
