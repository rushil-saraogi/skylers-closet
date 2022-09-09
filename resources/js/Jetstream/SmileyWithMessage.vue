<template>
    <div class="flex flex-col items-center justify-center">
        <div class="text-9xl text-gray-400">
            {{ smileys[ Math.floor(Math.random() * smileys.length) ] }}
        </div>
        <div v-if="message" class="text-xl mt-12 text-gray-500">
            {{ message }}
        </div>
    </div>
</template>

<script>
export default {
    props: {
        message: {
            type: String,
            default: ''
        }
    },

    data() {
        return {
            smileys: [
                '(ㆆ_ㆆ)',
                '( ˘︹˘ )',
                '(─‿‿─)',
            ]
        }
    }
}
</script>
