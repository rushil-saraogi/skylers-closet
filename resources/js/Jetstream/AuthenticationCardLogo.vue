<template>
    <Link :href="'/'">
        <img src="images/logo.svg" class="h-24" />
    </Link>
</template>

<script>
    import { Link } from '@inertiajs/inertia-vue3';

    export default {
        components: {
            Link,
        },
    }
</script>
