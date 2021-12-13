<template>
    <div class="flex items-center">
        <input :name="name" :value="value" v-model="proxyChecked" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" />
        <label v-if="label" for="push-everything" class="ml-2 block text-sm font-medium text-gray-700">
            {{ label }}
        </label>
    </div>
</template>

<script>
export default {
    emits: ['update:checked'],

    props: {
        checked: {
            type: [Array, Boolean],
            default: false,
        },
        value: {
            default: null,
        },
        label: {
            type: String,
            default: null
        },
        name: {
            type: String,
            required: true
        },
    },

    computed: {
        proxyChecked: {
            get() {
                return this.checked;
            },

            set(val) {
                this.$emit("update:checked", val);
            },
        },
    },
}
</script>
