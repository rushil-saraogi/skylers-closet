import { defineStore } from "pinia";

export const useStore = defineStore("main", {
    state: () => {
        return {
            closets: [],
            selectedCloset: {},
            categories: [],
            selectedCategory: {},
        };
    },

    actions: {
        selectCloset(closet) {
            this.selectedCloset = { ...closet };
        },

        setClosets(closets) {
            this.closets = [ ...closets ];
        },

        setCategories(categories) {
            this.categories = [ ...categories ];
        },

        selectCategory(category) {
            this.selectedCategory = category;
        }
    },
});
