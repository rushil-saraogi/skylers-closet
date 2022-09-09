import { defineStore } from "pinia";

export const useStore = defineStore("main", {
    state: () => {
        return {
            closets: [],
            selectedCloset: {},
            saveModeItem: null,
            isLoadingItem: false,
        };
    },

    actions: {
        addSaveModeItemToCloset(item, index) {
            this.selectedCloset.items.unshift(item);
            this.updateCloset(this.selectedCloset);
        },

        removeItemFromSelectedCloset(index) {
            this.selectedCloset.items.splice(index, 1);
        },

        updateCloset(updatedCloset) {
            this.closets = this.closets.map(closet => closet.id === updatedCloset.id
                ? { ...updatedCloset }
                : closet
            );
        },

        setSaveModeItem(item) {
            this.saveModeItem = {
                ...item,
                inSaveMode: true,
            };
        },

        removeSaveModeItem() {
            this.saveModeItem = null;
        },

        selectCloset(closet) {
            this.selectedCloset = { ...closet };
        },

        setClosets(closets) {
            this.closets = [...closets];
        },
    },
});
