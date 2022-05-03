<template>
    <app-layout title="Gigs">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gig Applications
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6">
                <div class="px-4 py-5 sm:p-6 bg-white shadow sm:rounded-lg">
                    <table class="w-full table-auto">
                        <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Job Title</th>
                            <th class="py-3 px-6 text-left">Gig Host</th>
                            <th class="py-3 px-6 text-left">Date Applied</th>
                            <th class="py-3 px-6 text-left">Application Status</th>
                            <th class="py-3 px-6 text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                        <tr class="border-b border-gray-200 hover:bg-gray-100" v-if="!!gigAppList.data && !gigAppList.data.length">
                            <td class="py-3 px-6 text-left whitespace-nowrap">No records found.</td>
                        </tr>
                        <tr class="border-b border-gray-200 hover:bg-gray-100" v-for="row in gigAppList.data">
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex">
                                    <jet-responsive-link as="button" @click="openGigAdModal(row)">
                                        <span class="font-medium">{{ row.gig_ad.job_title }}</span>
                                    </jet-responsive-link>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex">
                                    <jet-responsive-link as="button" @click="openGigHostModal(row)">
                                        <span class="inline-flex items-center font-medium">
                                            <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 mr-3">
                                                <img class="h-8 w-8 rounded-full object-cover" :src="row.gig_ad.gig_host.profile_photo_url" :alt="row.gig_ad.gig_host.name" />
                                            </div>{{ row.gig_ad.gig_host.name }}</span>
                                    </jet-responsive-link>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex items-center">
                                    <span class="font-medium">{{ moment(row.applied_date).format("DD MMM YYYY") }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex items-center">
                                    <span class="font-medium">{{ row.status }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center">
                                    <jet-icon name="view-icon" tooltip="View Gig Details" @click="openGigAdModal(row)" />
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <jet-pagination :links="gigAppList.links" />

        <jet-dialog-modal :show="isOpenGigAdModal" @close="closeGigAdModal">
            <template #title>
                <span class="text-xl">{{ gigApp.gig_ad.job_title }}</span>
                <div class="mt-0">
                    <span v-if="gigApp.gig_ad.close_date == null">
                        <jet-label isInline="true" value="Posted Date" />&nbsp;
                        <span class="text-sm">{{ moment(gigApp.gig_ad.publish_date).format("DD MMM YYYY") }}</span>
                    </span>
                    <span v-else>
                        <jet-label isInline="true" value="Closed Date" />&nbsp;
                        <span class="text-sm">{{ moment(gigApp.gig_ad.close_date).format("DD MMM YYYY") }}</span>
                    </span>
                </div>
            </template>

            <template #content>
                <!-- Description -->
                <div>
                    <jet-label value="Job Description" />
                    <div v-html="gigApp.gig_ad.description" />
                </div>

                <!-- Job Function -->
                <div class="mt-4">
                    <jet-label isInline="true" value="Job Function" />&nbsp;
                    {{ gigApp.gig_ad.job_function }}
                </div>

                <!-- Other Job Function -->
                <div class="mt-4" v-if="gigApp.gig_ad.job_function == 'Other'">
                    <jet-label isInline="true" value="Others (please specify)" />&nbsp;
                    {{ gigApp.gig_ad.other_job_function }}
                </div>

                <!-- Commitment Time -->
                <div class="mt-4">
                    <jet-label isInline="true" value="Time Commitment Required (hours per week)" />&nbsp;
                    {{ gigApp.gig_ad.commitment_time }}
                </div>

                <!-- Job Duration -->
                <div class="mt-4">
                    <jet-label isInline="true" value="Job Duration" />&nbsp;
                    {{ moment(gigApp.gig_ad.job_start_date).format("DD MMM YYYY") }} to {{ moment(gigApp.gig_ad.job_end_date).format("DD MMM YYYY") }}
                </div>
            </template>

            <template #footer>
                <jet-secondary-button @click="closeGigAdModal">
                    Cancel
                </jet-secondary-button>

                <jet-button class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                            @click="withdraw(gigApp.id)" v-if="gigApp.status == 'Submitted' && gigApp.gig_ad.close_date == null">
                    Withdraw
                </jet-button>
            </template>
        </jet-dialog-modal>

        <jet-dialog-modal :show="isOpenGigHostModal" @close="closeGigHostModal">
            <template #title>
                About Gig Host
            </template>

            <template #content>
                <div>
                    <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 mr-3">
                        <img class="h-10 w-10 rounded-full object-cover" :src="gigApp.gig_ad.gig_host.profile_photo_url" :alt="gigApp.gig_ad.gig_host.name" />
                    </div>
                    {{ gigApp.gig_ad.gig_host.name }}
                </div>
                <div class="mt-4">
                    <div v-html="modifyEmbeddedVideo(gigApp.gig_ad.gig_host.about)" />
                </div>
            </template>

            <template #footer>
                <jet-secondary-button @click="closeGigHostModal">
                    Cancel
                </jet-secondary-button>

                <jet-button class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="followGigHost(gigApp.gig_ad.gig_host.id)">
                    Follow
                </jet-button>
            </template>
        </jet-dialog-modal>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout'
    import EmbeddedMedia from '../../../mixins/embedded-media'
    import JetButton from '@/Jetstream/Button'
    import JetDialogModal from '@/Jetstream/DialogModal'
    import JetIcon from '@/Jetstream/Icon'
    import JetLabel from '@/Jetstream/Label'
    import JetPagination from '@/Jetstream/Pagination'
    import JetResponsiveLink from '@/Jetstream/ResponsiveLink'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import moment from 'moment'
    import ToastMessage from '../../../mixins/toast-message'

    export default defineComponent({
        mixins: [
            EmbeddedMedia,
            ToastMessage
        ],

        components: {
            AppLayout,
            JetButton,
            JetDialogModal,
            JetIcon,
            JetLabel,
            JetPagination,
            JetResponsiveLink,
            JetSecondaryButton,
        },

        props: [ 'gigAppList' ],

        data() {
            return {
                moment: moment,

                isOpenGigAdModal: false,
                isOpenGigHostModal: false,
                gigApp: new Object(),

                form: this.$inertia.form({
                    id: null,
                    follow_user_id: null,
                })
            }
        },

        methods: {
            openGigAdModal(row) {
                Object.assign(this.gigApp, row)
                this.isOpenGigAdModal = true
            },

            closeGigAdModal() {
                Object.assign(this.gigApp, null)
                this.isOpenGigAdModal = false
            },

            withdraw(gigAppId) {
                this.form.id = gigAppId
                this.form.post(route('gigger.gigApp.withdraw'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.closeGigAdModal()
                        this.showSuccessMessage('Application withdrawn')
                    },
                    onError: (errors) => {
                        this.showErrorMessage(errors.withdrawApplicationError)
                    }
                });
            },

            openGigHostModal(row) {
                Object.assign(this.gigApp, row)
                this.isOpenGigHostModal = true
            },

            closeGigHostModal() {
                Object.assign(this.gigApp, null)
                this.isOpenGigHostModal = false
            },

            followGigHost(gigHostId) {
                this.form.follow_user_id = gigHostId
                this.form.post(route('user-circle.follow'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.closeGigHostModal()
                        this.showSuccessMessage('Following')
                    },
                    onError: (errors) => {
                        this.showErrorMessage(errors.followUserError)
                    }
                });
            }
        }
    })
</script>
