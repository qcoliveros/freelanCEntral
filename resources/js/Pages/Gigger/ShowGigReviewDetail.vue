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
                    <div>
                        <div v-html="gigReview.review" />
                    </div>
                </div>
                <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                    <jet-secondary-button @click="cancel">
                        Cancel
                    </jet-secondary-button>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent, ref } from 'vue'
    import AppLayout from '@/Layouts/AppLayout'
    import JetLabel from '@/Jetstream/Label'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import moment from 'moment'

    export default defineComponent({
        components: {
            AppLayout,
            JetLabel,
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
                })
            }
        },

        methods: {
            cancel() {
                this.form.get(route('gigger.gigPlaybook.list'));
            }
        }
    })
</script>
