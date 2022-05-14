<template xmlns="http://www.w3.org/1999/html">
    <app-layout title="Gig Interviews">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gig Interview for {{ applicant.name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6">
                <div class="px-4 py-5 sm:p-6 bg-white shadow sm:rounded-tl-md sm:rounded-tr-md">
                    <div class="flex justify-end mb-2 mr-2">
                        <jet-icon name="add-icon" tooltip="Add Interview Schedule" @click="openAddInterviewModal" v-if="interview.status === 'Pending'" />
                    </div>
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
                                    <jet-icon v-if="row.status == 'Draft'" name="delete-icon" tooltip="Delete Interview Schedule" @click="openDeleteInterviewModal(row)" />
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
                    <jet-button v-if="gigAd.status == 'Published' && gigApp.status === 'Shortlisted' && interview.status == 'Pending' && interview.schedules.length > 0"
                                class="ml-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="submitInterview">
                        Send Invite
                    </jet-button>
                </div>
            </div>
        </div>

        <div v-if="interview.status != 'Pending'">
            <div class="max-w-7xl mx-auto sm:px-6">
                <div class="px-4 py-5 sm:p-6 bg-white shadow"
                     :class="gigAd.status == 'Published' && gigApp.status === 'Shortlisted' && interview.status == 'Confirmed'
                        ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md'">
                    <div v-if="gigApp.status === 'Shortlisted' && interview.status == 'Confirmed'">
                        <jet-label value="Provide write-up about the interview" />
                        <jet-rich-text-editor class="mt-1 block w-full" v-model="form.comment" />
                        <jet-input-error :message="form.errors.comment" class="mt-2" />
                    </div>
                    <div v-else>
                        <jet-label value="Write-up about the interview" />
                        <div v-html="form.comment" />
                    </div>
                </div>
                <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md"
                     v-if="gigAd.status == 'Published' && gigApp.status === 'Shortlisted' && interview.status == 'Confirmed'">
                    <jet-button class="ml-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="rejectApplicant">
                        Reject
                    </jet-button>
                    <jet-button class="ml-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="acceptApplicant">
                        Accept
                    </jet-button>
                </div>
            </div>
        </div>

        <jet-dialog-modal :show="isOpenAddInterviewSchedModal" @close="closeAddInterviewModal">
            <template #title>
                Schedule an Interview
            </template>

            <template #content>
                <div>
                    <jet-label value="Pick start date and time" />
                    <date-picker v-model:value="form.interview_start" value-type="YYYY-MM-DD HH:mm:ss" format="DD MMM YYYY hh:mm A" type="datetime" />
                    <jet-input-error :message="form.errors.interview_start" class="mt-2" />
                </div>
                <div class="mt-2">
                    <jet-label value="Pick end date and time" />
                    <date-picker v-model:value="form.interview_end" value-type="YYYY-MM-DD HH:mm:ss" format="DD MMM YYYY hh:mm A" type="datetime" />
                    <jet-input-error :message="form.errors.interview_end" class="mt-2" />
                </div>
            </template>

            <template #footer>
                <jet-secondary-button @click="closeAddInterviewModal">
                    Cancel
                </jet-secondary-button>

                <jet-button class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="scheduleInterview">
                    Submit
                </jet-button>
            </template>
        </jet-dialog-modal>

        <jet-dialog-modal :show="isOpenDeleteInterviewSchedModal" @close="closeDeleteInterviewModal">
            <template #title>
                Delete Interview Schedule
            </template>

            <template #content>
                Are you sure you want to delete the interview schedule?
            </template>

            <template #footer>
                <jet-secondary-button @click="closeDeleteInterviewModal">
                    Cancel
                </jet-secondary-button>

                <jet-button class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="deleteInterview">
                    Delete
                </jet-button>
            </template>
        </jet-dialog-modal>
    </app-layout>
</template>

<script>
    import { defineComponent, ref } from 'vue'
    import { Link } from '@inertiajs/inertia-vue3'
    import AppLayout from '@/Layouts/AppLayout'
    import DatePicker from 'vue-datepicker-next'
    import JetButton from '@/Jetstream/Button'
    import JetDialogModal from '@/Jetstream/DialogModal'
    import JetIcon from '@/Jetstream/Icon'
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
            DatePicker,
            Link,
            JetButton,
            JetDialogModal,
            JetLabel,
            JetRichTextEditor,
            JetIcon,
            JetInputError,
            JetSecondaryButton,
        },

        props: [
            'search',
            'gigAd',
            'gigApp',
            'applicant',
            'interview',
        ],

        data() {
            return {
                moment: moment,

                isOpenAddInterviewSchedModal: false,
                isOpenDeleteInterviewSchedModal: false,

                form: this.$inertia.form({
                    search: this.search,
                    id: this.gigAd.id,
                    gig_app_id: this.gigApp.id,
                    user_id: this.applicant.id,
                    interview_id: this.interview.id,
                    comment: this.interview.comment,
                    schedule_id: null,
                    interview_start: null,
                    interview_end: null,
                })
            }
        },

        methods: {
            cancel() {
                this.form.get(route('gigHost.gigApp.list'));
            },

            openAddInterviewModal() {
                this.isOpenAddInterviewSchedModal = true
            },

            closeAddInterviewModal() {
                this.form.interview_start = null
                this.form.interview_end = null
                this.form.clearErrors()
                this.isOpenAddInterviewSchedModal = false
            },

            scheduleInterview() {
                this.form.post(route('gigHost.gigInterview.createSchedule'), {
                    errorBag: 'gigInterviewScheduleError',
                    preserveScroll: true,
                    onSuccess: () => {
                        this.closeAddInterviewModal()
                        this.showSuccessMessage('Created')
                    }
                });
            },

            openDeleteInterviewModal(row) {
                this.form.schedule_id = row.id
                this.isOpenDeleteInterviewSchedModal = true
            },

            closeDeleteInterviewModal() {
                this.form.schedule_id = null
                this.form.clearErrors()
                this.isOpenDeleteInterviewSchedModal = false
            },

            deleteInterview() {
                this.form.post(route('gigHost.gigInterview.deleteSchedule'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.closeDeleteInterviewModal()
                        this.showSuccessMessage('Deleted')
                    }
                });
            },

            submitInterview() {
                this.form.post(route('gigHost.gigInterview.sendInvite'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.showSuccessMessage('Sent invite.')
                    }
                });
            },

            acceptApplicant() {
                this.form.post(route('gigHost.gigInterview.acceptApplicant'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.showSuccessMessage('Applicant accepted.')
                    }
                });
            },

            rejectApplicant() {
                this.form.post(route('gigHost.gigInterview.rejectApplicant'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.showSuccessMessage('Applicant rejected.')
                    }
                });
            }
        }
    })
</script>
