<template>
    <dialog-modal :show="show" @close="$emit('click:close')">
        <template #title>
            <div>Save to closet</div>
        </template>

        <template #content>
            <div>
                <closet-list
                    :closets="closets"
                    @click:closet="(closet) => {
                        isAlreadySaved(closet)
                            ? $emit('remove:item', closet)
                            : $emit('save:item', closet);
                    }"
                >
                    <template #icon="iconProps">
                        <Tooltip
                            text="Saved to closet"
                            v-if="isAlreadySaved(iconProps.closet)"
                        >
                            <HeartIcon class="h-5 w-5 text-red-500" />
                        </Tooltip>
                        <Tooltip
                            text="Add item to closet"
                            v-else
                        >
                            <PlusIcon class="h-5 w-5 text-gray-500" />
                        </Tooltip>
                    </template>
                </closet-list>
            </div>
        </template>
    </dialog-modal>
</template>

<script>
import { HeartIcon, PlusIcon } from '@heroicons/vue/20/solid'
import DialogModal from "@/Jetstream/DialogModal.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import ClosetList from "../Dashboard/ClosetList.vue";
import Tooltip from '@/Jetstream/Tooltip.vue';

export default {
    props: ["show", "closets", "selected"],

    emits: ["click:close"],

    components: {
        DialogModal,
        JetButton,
        JetSecondaryButton,
        ClosetList,
        HeartIcon,
        Tooltip,
        PlusIcon
    },

    methods: {
        isAlreadySaved(closet) {
            return closet.items.map(item => item.url).includes(this.selected.url);
        }
    }
};
</script>
