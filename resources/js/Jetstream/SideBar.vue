<template>
    <div class="rounded-3xl shadow-3xl bg-white border">
        <div class="p-3.5">
            <jet-dropdown align="left" width="60">
                <template #trigger>
                    <div class="p-3 border w-full rounded flex items-center justify-between hover:bg-gray-50 cursor-pointer">
                        <div>
                            {{ currentRouteName}}
                        </div>
                        <div>
                            <ChevronDownIcon class="h-5 w-5" />
                        </div>
                    </div>
                </template>

                <template #content>
                    <div class="w-72 p-4 grid grid-cols-3">
                        <nav-icon-link
                            v-for="(link, index) in navigationLinks" :key="index"
                            v-bind="link"
                        />
                    </div>
                </template>
            </jet-dropdown>
        </div>
        <slot />
    </div>
</template>

<script>
    import JetDropdown from '@/Jetstream/Dropdown.vue'
    import JetDropdownLink from '@/Jetstream/DropdownLink.vue'
    import NavIconLink from '@/Jetstream/NavIconLink.vue'
    import { ChevronDownIcon } from '@heroicons/vue/20/solid'

    const navigationLinks = [
        {
            routeName: 'room-service',
            icon: 'restaurant',
            label: 'Room Service',
        },
        {
            routeName: 'outlets',
            icon: 'storefront',
            label: 'Outlets',
        },
        {
            routeName: 'house-keeping',
            icon: 'dry_cleaning',
            label: 'House Keeping',
        },
        {
            routeName: 'outlets',
            icon: 'storefront',
            label: 'Outlets',
        },
    ]

    export default {
        name: 'SideBar',
        
        components: {
            JetDropdown,
            JetDropdownLink,
            NavIconLink,
            ChevronDownIcon,
        },

        data() {
            return {
                navigationLinks,
            }
        },

        computed: {
            currentRouteName() {
                const routeLabels = {
                    'home': 'Home',
                    'room-service': 'Room Service',
                    'outlets': 'Outlets',
                    'house-keeping': 'House Keeping',
                };

                return routeLabels[route().current()];
            },
        }
    }
</script>

<style scoped>
</style>
