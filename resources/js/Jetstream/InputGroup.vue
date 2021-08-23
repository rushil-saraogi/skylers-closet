<template>
    <div>
        <div class="mt-1 relative rounded-md shadow-sm">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span v-if="icon" class="material-icons text-gray-500 sm:text-sm">
                    {{ icon }}
                </span>
            </div>
            <input
                v-bind="$attrs"
                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-9 pr-12 sm:text-sm border-gray-300 rounded-md"
                :class="inputClasses"
                :value="modelValue"
                @input="$emit('update:modelValue', $event.target.value)"
            >
            <div v-if="isLoading" class="absolute inset-y-0 right-0 flex items-center">
                <loader class="mr-2" />
            </div>
        </div>
    </div>
</template>

<script>
import Loader from './Loader.vue';

export default {
    inheritAttrs: false,
    components: { Loader },
    emits: ['update:modelValue'],
    props: ['isLoading', 'modelValue', 'icon'],
    computed: {
        inputClasses() {
            return {
                'pl-9': this.icon,
                'pl-4': !this.icon
            }
        }
    }
}
</script>
