<template>
    <div>
        <div v-if="as === 'link'" :class="gridContainerClasses">
            <Link
                v-for="category in categories"
                :class="[getCategoryClasses(category), gridItemClasses]"
                :key="category.id"
                :href="route('explore', {'category': category.id})"
            >
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
import { mapState } from "pinia";
import { useStore } from "@/store";

export default {
    components: {
        Link,
    },

    data() {
        return {
            gridContainerClasses: "grid gap-4 w-full md:grid-cols-4 sm:grid-cols-3 grid-col-2",
            gridItemClasses: "bg-gray-100 p-4 rounded-lg font-semibold hover:bg-red-100 hover:cursor-pointer transition",
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
                "bg-red-200": isSelected,
            };
        },
    }
};
</script>
