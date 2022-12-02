<template>
    <Link class="p-3 rounded-full" :class="classes" v-bind="$props">
        <slot />
    </Link>
</template>

<script>
    import { Link } from '@inertiajs/inertia-vue3';

    export default {
        components: {
            Link,
        },
        props: ['active'],

        computed: {
            classes() {
                return this.active
                    ? 'opacity-100 transition'
                    : 'opacity-50 transition'
            }
        }
    }
</script>
