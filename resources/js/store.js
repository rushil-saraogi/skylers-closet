import { defineStore } from "pinia";
import ClosetsApi from './API/ClosetsApi';

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
        },

        // async getClosets() {
        //     if (this.closets.length) {
        //         return this.closets;
        //     }

        //     const closets = await ClosetsApi.getCurrentUsersClosets();
        //     this.setClosets(closets);
        //     return closets;
        // }
    },
});
