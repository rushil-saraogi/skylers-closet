<template>
    <div
        class="rounded-md min-h-48 font-mono p-4 hover:cursor-pointer transition relative"
        :class="classes"
        @mouseenter="isHovering = true"
        @mouseleave="isHovering = false"
    >
        <span v-if="hasContent" class="text-gray-600"><slot ></slot></span>
        <span v-else class="material-icons text-4xl text-gray-500">add</span>
        
        <quick-controls
            :show="isHovering"
            theme="dark"
        >
            <quick-controls-option
                theme="dark"
                icon="PencilIcon"
                @click="$emit('click:edit')"
            />
            <quick-controls-option
                icon="TrashIcon"
                @click.stop="$emit('click:delete-page')"
                theme="dark"
            />
        </quick-controls>
    </div>

</template>

<script>
    import QuickControls from '@/Jetstream/QuickControls.vue';
    import QuickControlsOption from '@/Jetstream/QuickControlsOption.vue';

    export default {
        components: {
            QuickControls,
            QuickControlsOption
        },

        emits: ['click:edit', 'click:delete-page'],

        data() {
            return {
                isHovering: false,
            }
        },
        computed: {
            hasContent() {
                return !!this.$slots.default;
            },
            classes() {
                return {
                    'bg-white shadow hover:shadow-md': this.hasContent,
                    'flex justify-center items-center hover:bg-gray-200 border border-gray-300': !this.hasContent
                }
            }
        }
    }
</script>
