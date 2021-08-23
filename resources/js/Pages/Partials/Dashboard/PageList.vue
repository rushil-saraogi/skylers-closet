<template>
    <div class="w-full">
        <div v-if="data && data.length" class="grid gap-5 grid-cols-1 sm:grid-cols-2 md:grid-cols-4">
            <div v-for="page in data" :key="page.id">
                <Link :href="`${route('page-editor')}/${page.id}`">
                    <page-thumb>
                        /{{ page.slug }}
                    </page-thumb>
                </Link>
            </div>
        </div>
        <zero-state
            v-else
            header="Get started"
            copy="Start here by creating a page!"
            cta="Create Page"
            @cta:click="$emit('click:create-page')"
        />
    </div>
</template>

<script>
    import { Link } from '@inertiajs/inertia-vue3';
    import PageThumb from '@/Jetstream/PageThumb.vue';
    import ZeroState from '@/Jetstream/ZeroState.vue';

    export default {
        props: {
            data: Array
        },

        emits: ['click:create-page'],

        components: {
            PageThumb,
            Link,
            ZeroState,
        },
    }
</script>
