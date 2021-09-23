<template>
    <div
        class="p-2 cursor-pointer rounded inline-block m-auto"
        :class="{
            'bg-blue-200': selected,
            'hover:bg-gray-200': !selected
        }"
        @click="$emit('click')"
    >
        <div v-if="src" class="h-32 w-44 bg-center bg-cover bg-gray-100" :style="{'background-image':`url(${src})`}"></div>
        <div class="h-32 w-44 flex items-center justify-center bg-gray-100" v-else>{{ placeholder }}</div>
    </div>
</template>
<script>

export default {
    emits: ['click'],

    props: {
        src: {
            type: String,
            default: null
        },
        selected: {
            type: Boolean,
            default: false,
        },
        placeholder: {
            type: String,
            default: '',
        }
    }
}
</script>
