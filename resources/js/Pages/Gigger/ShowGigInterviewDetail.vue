<template xmlns="http://www.w3.org/1999/html">
    <app-layout title="Gig Interviews">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gig Interview for {{ gigAd.job_title }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6">
                <div class="px-4 py-5 sm:p-6 bg-white shadow sm:rounded-tl-md sm:rounded-tr-md">
                    <table class="w-full table-auto">
                        <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Interview Schedule</th>
                            <th class="py-3 px-6 text-left">Status</th>
                            <th class="py-3 px-6 text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                        <tr class="border-b border-gray-200 hover:bg-gray-100" v-if="!!interview.schedules && !interview.schedules.length">
                            <td class="py-3 px-6 text-left whitespace-nowrap">No records found.</td>
                        </tr>
                        <tr class="border-b border-gray-200 hover:bg-gray-100" v-for="row in interview.schedules">
                            <td class="py-3 px-6 text-center">
                                <div class="flex items-center">
                                    <span class="font-medium">
                                        {{ moment.parseZone(row.interview_start).format("DD MMM YYYY hh:mm A") }} to {{ moment.parseZone(row.interview_end).format("DD MMM YYYY hh:mm A") }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex items-center">
                                    <span class="font-medium">{{ row.status }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center">
                                    <jet-icon v-if="interview.status == 'Sent Invite' && row.status == 'Sent'"
                                              name="accept-icon" tooltip="Accept Interview Schedule" @click="acceptInterview(row)" />
                                    <jet-icon v-if="interview.status == 'Sent Invite' && row.status == 'Sent'"
                                              name="reject-icon" tooltip="Reject Interview Schedule" @click="rejectInterview(row)" />
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                    <jet-secondary-button @click="cancel">
                        Cancel
                    </jet-secondary-button>
                    <jet-button v-if="gigAd.status == 'Published' && gigApp.status === 'Shortlisted' && interview.status == 'Sent Invite' && showSubmit"
                                class="ml-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="submitInterview">
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
    import JetIcon from '@/Jetstream/Icon'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'
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
            JetIcon,
            JetInputError,
            JetSecondaryButton,
        },

        props: [
            'gigAd',
            'gigApp',
            'applicant',
            'interview',
        ],

        computed: {
            showSubmit() {
                if (this.interview.schedules !== null
                    && this.interview.schedules.filter(element => ['Accepted','Rejected'].includes(element.status)).length != 0)
                {
                    return true
                }

                return false
            }
        },

        data() {
            return {
                moment: moment,

                form: this.$inertia.form({
                    search: this.search,
                    id: this.gigAd.id,
                    gig_app_id: this.gigApp.id,
                    user_id: this.applicant.id,
                    interview_id: this.interview.id,
                    schedule_id: null,
                })
            }
        },

        methods: {
            cancel() {
                this.form.get(route('gigger.gigApp.list'));
            },

            acceptInterview(row) {
                this.form.schedule_id = row.id
                this.form.post(route('gigger.gigInterview.acceptSchedule'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.showSuccessMessage('Accepted')
                    }
                });
            },

            rejectInterview(row) {
                this.form.schedule_id = row.id
                this.form.post(route('gigger.gigInterview.rejectSchedule'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.showSuccessMessage('Rejected')
                    }
                });
            },

            submitInterview() {
                this.form.post(route('gigger.gigInterview.submit'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.showSuccessMessage('Submitted')
                    }
                });
            }
        }
    })
</script>
