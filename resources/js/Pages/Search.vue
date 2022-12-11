<template>
    <app-layout title="Search">
        <div class="w-full">

            <!-- Search input -->
            <div class="w-full">
                <input-group
                    type="text"
                    v-model="searchForm.query"
                    class="w-full"
                    placeholder="Search for items, brands or categories..."
                    :error="error"
                    v-on:keyup.enter.prevent="submit"
                    autocomplete="off"
                >
                    <template #icon>
                        <MagnifyingGlassIcon class="h-5 w-5 text-gray-600" />
                    </template>
                </input-group>
                <div v-if="(searchForm.query.length > 2)" class="text-sm text-gray-500 mt-2">
                    Press Enter to search
                </div>
            </div>

            <!-- Search results -->
            <div>
                <!-- Items -->
                <div class="mt-8">
                    <div class="text-xl font-bold">Items</div>
                    <div class="mt-4">
                        <div v-if="(searchResults.length === 0)" class="text-gray-500">
                            No items found
                        </div>
                        <ul class="grid gap-3 sm:gap-6 grid-col-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 mt-5 sm:mt-8 w-full">
                            <li v-for="(item, index) in searchResults.items" :key="index">
                                <item-tile
                                    v-bind="item"
                                    :pub-mode="true"
                                />
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Closets -->
                <div class="mt-8">
                    <div class="text-xl font-bold">Closets</div>
                    <div class="mt-4">
                        <div v-if="(searchResults.length === 0)" class="text-gray-500">
                            No closets found
                        </div>
                        <ul class="grid gap-3 sm:gap-6 grid-col-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 mt-5 sm:mt-8 w-full">
                            <li v-for="(closet, index) in searchResults.closets" :key="index">
                                <closet-tile
                                    v-bind="closet"
                                />
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { MagnifyingGlassIcon } from '@heroicons/vue/24/outline';
    import InputGroup from "@/Jetstream/InputGroup.vue";
    import AppLayout from '@/Layouts/AppLayout.vue'
    import JetButton from '@/Jetstream/Button';
    import SearchApi from "@/API/SearchApi";
    import ItemTile from '@/Common/Tiles/ItemTile.vue';
    import ClosetTile from '@/Common/Tiles/ClosetTile.vue';



    export default {
        props: [],

        components: {
            AppLayout,
            JetButton,
            InputGroup,
            MagnifyingGlassIcon,
            ItemTile,
            ClosetTile
        },

        mounted() {
        },

        data() {
            return {
                error: null,
                searchForm: this.$inertia.form({
                    query: "",
                }),
                searchResults: [],
            }
        },

        computed: {
            queryIsValid() {
                return this.searchForm.query.length > 2;
            },
        },

        methods: {
            async submit() {
                if (this.queryIsValid) {
                    this.error = null;
                    this.searchResults = await SearchApi.search(this.searchForm.query);
                    console.log(this.searchResults);
                } else {
                    this.error = "Please enter at least 3 characters";
                }
            },
        },
    }
</script>
