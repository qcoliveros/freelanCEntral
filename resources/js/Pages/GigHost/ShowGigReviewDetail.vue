<template xmlns="http://www.w3.org/1999/html">
    <app-layout title="Gig Review">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gig Playbook Gigger Review
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6">
                <div class="px-4 py-5 sm:p-6 bg-white shadow sm:rounded-tl-md sm:rounded-tr-md">
                    <div class="mb-4" v-if="gigReview.review_date != null">
                        <jet-label is-inline="true" value="Review Date" /> {{ moment(gigReview.review_date).format("DD MMM YYYY")  }}
                    </div>
                    <div v-if="gigReview.status == 'Draft'">
                        <jet-label value="Provide your review for gigger's work." />
                        <jet-rich-text-editor class="mt-1 block w-full" v-model="form.review" />
                        <jet-input-error :message="form.errors.review" class="mt-2" />
                    </div>
                    <div v-else>
                        <div v-html="form.review" />
                    </div>
                </div>
                <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                    <jet-secondary-button @click="cancel">
                        Cancel
                    </jet-secondary-button>
                    <jet-button class="ml-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                                @click="save" v-if="gigReview.status == 'Draft'">
                        Save as Draft
                    </jet-button>
                    <jet-button class="ml-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                                @click="submit" v-if="gigReview.status == 'Draft'">
                        Submit
                    </jet-button>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent, ref } from 'vue'
    import { Link } from '@inertiajs/inertia-vue3'
    import AppLayout from '@/Layouts/AppLayout'
    import JetButton from '@/Jetstream/Button'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'
    import JetRichTextEditor from '@/Jetstream/RichTextEditor'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import moment from 'moment'
    import ToastMessage from "../../../mixins/toast-message"

    export default defineComponent({
        mixins: [ ToastMessage ],

        components: {
            AppLayout,
            Link,
            JetButton,
            JetLabel,
            JetRichTextEditor,
            JetInputError,
            JetSecondaryButton,
        },

        props: [
            'search',
            'gigPlaybook',
            'gigReview',
        ],

        data() {
            return {
                moment: moment,

                form: this.$inertia.form({
                    search: this.search,
                    id: this.gigPlaybook.id,
                    review_id: this.gigReview.id,
                    review: this.gigReview.review,
                })
            }
        },

        methods: {
            cancel() {
                this.form.get(route('gigHost.gigPlaybook.list'));
            },

            save() {
                this.form.post(route('gigHost.gigPlaybook.saveReview'), {
                    errorBag: 'gigPlaybookReviewError',
                    preserveScroll: true,
                    onSuccess: () => {
                        this.showSuccessMessage('Saved')
                    }
                });
            },

            submit() {
                this.form.post(route('gigHost.gigPlaybook.submitReview'), {
                    errorBag: 'gigPlaybookReviewError',
                    preserveScroll: true,
                    onSuccess: () => {
                        this.showSuccessMessage('Submitted')
                    }
                });
            }
        }
    })
</script>
