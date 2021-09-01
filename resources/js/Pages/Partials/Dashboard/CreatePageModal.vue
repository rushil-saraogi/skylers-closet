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
                Let's get started by naming the page so we have something to use in your URL
            </p>

            <form @submit.prevent="submit" class="mt-3">
                <input-group
                    id="slug"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.slug"
                    required
                    autofocus
                    autocomplete="off"
                    @keyup="handleSlugInputChange"
                    :isLoading="checkingIfSlugIsAvailable"
                    placeholder="Ex - alex-jones, movie-list"
                    :error="error"
                >
                    <template v-slot:icon>
                        <CheckCircleIcon v-if="isSlugAvailable && isSlugValid" class="h-6 w-6 text-green-300"/>
                        <XCircleIcon v-else class="h-6 w-6 text-gray-300"/>
                    </template>
                </input-group>
                <p class="text-sm text-gray-500 mt-3">Page slugs need to be atleast <b>3</b> characters long and can include <b>underscores and dashes</b></p>
            </form>

            <div class="bg-gray-100 p-3 mt-4 rounded text-gray-600">
                <div class="font-mono text-sm text-gray-600">https://www.cover-story.com/{{form.slug}}</div>
            </div>
        </template>

        <template #footer>
            <jet-secondary-button class="mt-3 sm:mt-0 sm:ml-3">Nevermind</jet-secondary-button>
            <jet-button @click="submit" :disabled="isSubmitDisabled" class="sm:ml-3">Create</jet-button>
        </template>
    </dialog-modal>
</template>

<script>
import DialogModal from '@/Jetstream/DialogModal.vue';
import JetButton from '@/Jetstream/Button.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import IconPageAdd from '@/icons/IconPageAdd'
import InputGroup from '@/Jetstream/InputGroup.vue'
import JetLabel from '@/Jetstream/Label.vue'
import PagesApi from '@/API/PagesApi';
import { CheckCircleIcon, XCircleIcon } from '@heroicons/vue/solid'
import { isValidSlug } from '@/Util/Slug';

export default {
    props: ['show'],

    emits: ['click:close'],

    components: {
        DialogModal,
        JetButton,
        JetSecondaryButton,
        IconPageAdd,
        IconPageAdd,
        InputGroup,
        JetLabel,
        CheckCircleIcon,
        XCircleIcon
    },

    data() {
        return {
            form: this.$inertia.form({
                slug: '',
            }),
            isSlugAvailable: false,
            isSlugValid: false,
            inputTimeoutRef: null,
            checkingIfSlugIsAvailable: false,
            error: null,
        }
    },

    computed: {
        isSubmitDisabled() {
            return !this.isSlugAvailable || !this.isSlugValid || this.checkingIfSlugIsAvailable;
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('create-page'), {
                onFinish: () => this.form.reset('slug'),
            })
        },

        validateSlug() {

        },

        handleSlugInputChange() {
            clearTimeout(this.inputTimeoutRef);
    
                this.inputTimeoutRef = setTimeout(async () => {
                    try {
                        this.error = '';
                        this.isSlugValid = isValidSlug(this.form.slug)

                        if (!this.isSlugValid) return;

                        this.checkingIfSlugIsAvailable = true;
                        const { isAvailable } = await PagesApi.isSlugAvailable(this.form.slug);
                        this.isSlugAvailable = isAvailable;

                        if (!this.isSlugAvailable) {
                            this.error = "Sorry! Look's like that one is taken!"
                        }
                    } catch(e) {
                        console.error(e);
                    } finally {
                        this.checkingIfSlugIsAvailable = false;
                    }
                }, 750);
        }
    }
}
</script>