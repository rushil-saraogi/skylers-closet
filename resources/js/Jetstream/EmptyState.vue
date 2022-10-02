<template>
    <div class="h-80 flex items-center justify-center">
        <!-- Smiley with text -->
        <div
            v-if="type === 'smiley'"
            class="flex flex-col items-center justify-center"
        >
            <div class="text-9xl text-gray-400">
                {{ smileys[Math.floor(Math.random() * smileys.length)] }}
            </div>
            <div class="font-semibold mt-4 text-gray-500">{{ message }}</div>
        </div>

        <!-- Tumbleweed -->
        <div class="flex flex-col items-center justify-center" v-else>
            <div class="rounded-full bg-gray-50 p-6 inline-block">
                <img src="/images/tumbleweed.png" class="h-20 grayscale" />
            </div>
            <div class="font-semibold mt-4 text-gray-500">{{ message }}</div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        message: {
            type: String,
            default: "",
        },
        type: {
            type: String,
            default: "",
        },
    },

    data() {
        return {
            smileys: ["(ㆆ_ㆆ)", "( ˘︹˘ )", "(─‿‿─)"],
        };
    },
};
</script>
