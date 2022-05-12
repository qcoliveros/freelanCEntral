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
                        <jet-icon name="add-icon" tooltip="Add Interview Schedule" @click="openAddInterviewModal" v-if="gigApp.status === 'Shortlisted'" />
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
                        <tr class="border-b border-gray-200 hover:bg-gray-100" v-if="!!interviewList.data && !interviewList.data.length">
                            <td class="py-3 px-6 text-left whitespace-nowrap">No records found.</td>
                        </tr>
                        <tr class="border-b border-gray-200 hover:bg-gray-100" v-for="row in interviewList.data">
                            <td class="py-3 px-6 text-center">
                                <div class="flex items-center">
                                    <span class="font-medium">{{ moment.parseZone(row.interview_date).format("DD MMM YYYY hh:mm A") }}</span>
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
                    <jet-button v-if="gigAd.status == 'Published' && gigApp.status === 'Shortlisted' && countDraftInterviewSchedule > 0"
                                class="ml-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="submitInterview">
                        Submit
                    </jet-button>
                </div>
            </div>
        </div>

        <jet-dialog-modal :show="isOpenAddInterviewModal" @close="closeAddInterviewModal">
            <template #title>
                Schedule an Interview
            </template>

            <template #content>
                <div>
                    <jet-label value="Pick a date and time" />
                    <date-picker v-model:value="form.interview_date" value-type="YYYY-MM-DD HH:mm:ss" format="DD MMM YYYY hh:mm A" type="datetime" />
                    <jet-input-error :message="form.errors.interview_date" class="mt-2" />
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

        <jet-dialog-modal :show="isOpenDeleteInterviewModal" @close="closeDeleteInterviewModal">
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
            JetIcon,
            JetInputError,
            JetSecondaryButton,
        },

        props: [
            'search',
            'gigAd',
            'gigApp',
            'applicant',
            'interviewList',
        ],

        data() {
            return {
                moment: moment,

                isOpenAddInterviewModal: false,
                isOpenDeleteInterviewModal: false,

                form: this.$inertia.form({
                    search: this.search,
                    id: this.gigAd.id,
                    gig_app_id: this.gigApp.id,
                    user_id: this.applicant.id,
                    interview_id: null,
                    interview_date: null,
                })
            }
        },

        computed: {
            countDraftInterviewSchedule() {
                if (this.interviewList.data !== null) {
                    const draftInterviewList = this.interviewList.data.filter(element => element.status == 'Draft')
                    return draftInterviewList.length
                }

                return 0
            }
        },

        methods: {
            cancel() {
                this.form.get(route('gigHost.gigApp.list'));
            },

            openAddInterviewModal() {
                this.isOpenAddInterviewModal = true
            },

            closeAddInterviewModal() {
                this.form.interview_date = null
                this.form.clearErrors()
                this.isOpenAddInterviewModal = false
            },

            scheduleInterview() {
                this.form.post(route('gigHost.gigInterview.schedule'), {
                    errorBag: 'gigInterviewError',
                    preserveScroll: true,
                    onSuccess: () => {
                        this.closeAddInterviewModal()
                        this.showSuccessMessage('Scheduled')
                    }
                });
            },

            openDeleteInterviewModal(row) {
                this.form.interview_id = row.id
                this.isOpenDeleteInterviewModal = true
            },

            closeDeleteInterviewModal() {
                this.form.interview_id = null
                this.form.clearErrors()
                this.isOpenDeleteInterviewModal = false
            },

            deleteInterview() {
                this.form.post(route('gigHost.gigInterview.delete'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.closeDeleteInterviewModal()
                        this.showSuccessMessage('Deleted')
                    }
                });
            },

            submitInterview() {
                this.form.post(route('gigHost.gigInterview.submit'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.showSuccessMessage('Submitted')
                    }
                });
            }
        }
    })
</script>
