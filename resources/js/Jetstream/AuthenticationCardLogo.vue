<template>
    <Link :href="'/'">
        <img src="images/LinkLogo.png" class="h-20" />
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
