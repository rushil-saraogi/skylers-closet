<template>
    <dialog-modal :show="show" @close="$emit('click:close')">
        <!-- <template v-slot:icon>
            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                <icon-page-add color="green" />
            </div>
        </template> -->

        <template #title>Create a new page</template>

        <template #content>
            <p class="text-sm text-gray-500">
                Let's get started by naming the page so we have something to use in your URL.
            </p>

            <form @submit.prevent="submit" class="mt-3">
                <jet-input
                    id="slug"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.slug"
                    required
                    autofocus
                    autocomplete="off"
                    placeholder="Ex - alex-jones, movie-list"
                />
                <p class="text-sm text-gray-500 mt-3">Don't worry, you can always change this later.</p>
            </form>

            <div class="bg-gray-100 p-3 mt-3 rounded text-gray-600">
                <div class="font-mono text-sm text-gray-600">https://www.cover-story.com/{{form.slug}}</div>
            </div>
        </template>

        <template #footer>
            <secondary-button class="mt-3 sm:mt-0 sm:ml-3">Nevermind</secondary-button>
            <jet-button @click="submit" class="sm:ml-3">Create</jet-button>
        </template>
    </dialog-modal>
</template>

<script>
import DialogModal from '@/Jetstream/DialogModal.vue';
import JetButton from '@/Jetstream/Button.vue'
import SecondaryButton from '@/Jetstream/SecondaryButton.vue'
import IconPageAdd from '@/icons/IconPageAdd'
import JetInput from '@/Jetstream/Input.vue'
import JetLabel from '@/Jetstream/Label.vue'

export default {
    props: ['show'],
    emits: ['click:close'],
    components: {
        DialogModal,
        JetButton,
        SecondaryButton,
        IconPageAdd,
        IconPageAdd,
        JetInput,
        JetLabel
    },
    data() {
        return {
            form: this.$inertia.form({
                slug: '',
            })
        }
    },
    methods: {
        submit() {
            this.form.post(this.route('create-page'), {
                onFinish: () => this.form.reset('slug'),
            })
        },
    }
}
</script>