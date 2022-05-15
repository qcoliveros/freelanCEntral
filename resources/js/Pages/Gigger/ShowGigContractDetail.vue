<template xmlns="http://www.w3.org/1999/html">
    <app-layout title="Gig Interviews">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gig Playbook Contract
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6">
                <div class="px-4 py-5 sm:p-6 bg-white shadow sm:rounded-tl-md sm:rounded-tr-md">
                    <div class="mb-4" v-if="gigContract.signed_date != null">
                        <jet-label is-inline="true" value="Contract Signed Date" /> {{ moment(gigContract.signed_date).format("DD MMM YYYY")  }}
                    </div>
                    <div>
                        <jet-label value="Contract clause." />
                        <div v-html="gigContract.clause" />
                    </div>
                </div>
                <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                    <jet-secondary-button @click="cancel">
                        Cancel
                    </jet-secondary-button>
                    <jet-button v-if="gigContract.status == 'Pending'"
                                class="ml-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="reject">
                        Reject
                    </jet-button>
                    <jet-button v-if="gigContract.status == 'Pending'"
                                class="ml-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="accept">
                        Accept
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
            'gigContract',
        ],

        data() {
            return {
                moment: moment,

                form: this.$inertia.form({
                    search: this.search,
                    id: this.gigPlaybook.id,
                    contract_id: this.gigContract.id,
                })
            }
        },

        methods: {
            cancel() {
                this.form.get(route('gigger.gigPlaybook.list'));
            },

            accept() {
                this.form.post(route('gigger.gigPlaybook.acceptContract'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.showSuccessMessage('Accepted')
                    }
                });
            },

            reject() {
                this.form.post(route('gigger.gigPlaybook.rejectContract'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.showSuccessMessage('Rejected')
                    }
                });
            }
        }
    })
</script>
