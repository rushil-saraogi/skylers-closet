<template>
    <div>
        <div v-if="as === 'link'" :class="gridContainerClasses">
            <Link
                v-for="category in categories"
                :class="[getCategoryClasses(category), gridItemClasses]"
                :key="category.id"
                :href="route('explore', {'category': category.id})"
            >
                <component
                    v-if="icons[category.name]"
                    :is="icons[category.name]"
                    class="h-5 w-5 mr-2"
                />
                {{ category.name }}
            </Link>
        </div>
        <div v-else :class="gridContainerClasses">
            <div
                v-for="category in categories"
                :key="category.id"
                :class="[getCategoryClasses(category), gridItemClasses]"
                @click="$emit('click:item', category.id)"
            >
                {{ category.name }}
            </div>
        </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
import { 
    ShoppingBagIcon,
    DevicePhoneMobileIcon,
    HomeIcon,
    BookOpenIcon,
    TagIcon,
    ClockIcon,
    FilmIcon
} from '@heroicons/vue/24/outline';
import { mapState } from "pinia";
import { useStore } from "@/store";

const icons = {
    'Mixed Bag': ShoppingBagIcon,
    'Tech': DevicePhoneMobileIcon,
    'Home': HomeIcon,
    'Books': BookOpenIcon,
    'Fashion': TagIcon,
    'Watches': ClockIcon,
    'Movies': FilmIcon
}

export default {
    components: {
        Link,
    },

    data() {
        return {
            icons,
            gridContainerClasses: "grid gap-3 sm:gap-4 w-full grid-cols-2 sm:grid-cols-3 md:grid-cols-4",
            gridItemClasses: "bg-gray-500/10 p-4 rounded-lg font-semibold hover:bg-indigo-600/20 hover:cursor-pointer transition flex items-center",
        }
    },

    computed: {
        ...mapState(useStore, ["categories"]),
    },

    props: {
        selected: {
            type: Object,
            default: {},
        },
        as: {
            type: String,
            default: "",
        },
    },

    methods: {
        getCategoryClasses(category) {
            const isSelected = this.selected && this.selected === category.id;

            return {
                "bg-indigo-600/20": isSelected,
            };
        },
    }
};
</script>
