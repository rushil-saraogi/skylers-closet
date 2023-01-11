<template>
    <div class="flex flex-col items-center w-full">
        <div class="flex gap-2">
            <div
                v-for="(item, index) in items"
                :key="index"
                @click="$emit('click:tab', item.value)"
                class="px-4 py-2 opacity-60 text-sm hover:bg-gray-100 rounded-xl cursor-pointer"
                :class="{
                    'opacity-100': selected === item.value,
                    'bg-indigo-600': selected === item.value,
                    'text-white': selected === item.value,
                    'hover:bg-indigo-800': selected === item.value,
                }"
            >
                {{ item.label }}
            </div>
        </div>
    </div>
</template>
<script>


export default {
    emits: ['click'],

    props: {
        items: {
            type: Array,
            default: []
        },
        selected: {
            type: String,
            default: null
        } 
    }
}
</script>
