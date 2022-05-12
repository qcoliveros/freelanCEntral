<template>
    <app-layout title="Gig Applications">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gig Applicants for {{ gigAd.job_title }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6">
                <div class="px-4 py-5 sm:p-6 bg-white shadow sm:rounded-tl-md sm:rounded-tr-md">
                    <table class="w-full table-auto">
                        <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Applicant Name</th>
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
                                    <jet-responsive-link as="button" @click="viewApplicantPage(row)">
                                        <span class="inline-flex items-center font-medium">
                                            <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 mr-3">
                                                <img class="h-8 w-8 rounded-full object-cover" :src="row.applicant.profile_photo_url" :alt="row.applicant.name" />
                                            </div>
                                            {{ row.applicant.name }}
                                        </span>
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
                                    <jet-icon name="applicant-icon" tooltip="View Applicant Details" @click="viewApplicant(row)" />
                                    <jet-icon name="interview-icon" tooltip="View Interview Schedule"
                                              @click="viewGigInterview(row)" v-if="!['Submitted', 'Withdrawn'].includes(row.status)" />
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
                </div>
            </div>
        </div>

        <jet-pagination :links="gigAppList.links" />
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout'
    import JetIcon from '@/Jetstream/Icon'
    import JetPagination from '@/Jetstream/Pagination'
    import JetResponsiveLink from '@/Jetstream/ResponsiveLink'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import moment from 'moment'

    export default defineComponent({
        components: {
            AppLayout,
            JetIcon,
            JetPagination,
            JetResponsiveLink,
            JetSecondaryButton,
        },

        props: [
            'search',
            'gigAd',
            'gigAppList',
        ],

        data() {
            return {
                moment: moment,

                form: this.$inertia.form({
                    search: this.search,
                    id: this.gigAd.id,
                    gig_app_id: null,
                    user_id: null,
                })
            }
        },

        methods: {
            cancel() {
                this.form.get(route('gigHost.gigAd.list'));
            },

            viewApplicantPage(row) {
                this.form.user_id = row.applicant.id
                this.form.get(route('user-page.view'));
            },

            viewApplicant(row) {
                this.form.gig_app_id = row.id
                this.form.user_id = row.applicant.id
                this.form.get(route('gigHost.gigApplicant.view'));
            },

            viewGigInterview(row) {
                this.form.gig_app_id = row.id
                this.form.user_id = row.applicant.id
                this.form.get(route('gigHost.gigInterview.list'));
            }
        }
    })
</script>
