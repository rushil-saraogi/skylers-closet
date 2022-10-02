<template>
    <Tooltip :text="tooltip" position="bottom" class="flex-1">
        <div
            class="hover:cursor-pointer hover:bg-gray-50 p-3.5 flex justify-center items-center text-gray-400 hover:text-red-400"
            :v-bind="$attrs"
        >
            <Component
                :is="outlined ? OutlinedIcons[icon] : SolidIcons[icon]"
                class="h-5 min-w-5"
            />
        </div>
    </Tooltip>
</template>
<script>
import * as SolidIcons from "@heroicons/vue/20/solid";
import * as OutlinedIcons from "@heroicons/vue/24/outline";
import Tooltip from "./Tooltip.vue";

export default {
    components: {
        Tooltip,
    },

    props: {
        icon: {
            type: String,
            required: true,
        },
        text: {
            type: String,
            default: "",
        },
        outlined: {
            type: String,
            default: false,
        },
        tooltip: {
            type: String,
            default: "",
        },
    },

    data() {
        console.log(OutlinedIcons);
        return {
            SolidIcons,
            OutlinedIcons,
        };
    },
};
</script>
