<template>
    <app-layout title="Gig Ads">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gig Playbooks
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6">
                <div class="px-4 py-5 sm:p-6 bg-white shadow sm:rounded-lg">
                    <jet-search-bar v-model="form.search" placeholder="Search by job title"
                                    @clickSearch="searchRecord" @clickClearSearch="clearSearchRecord" />
                    <table class="w-full table-auto mt-4">
                        <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Job Title</th>
                            <th class="py-3 px-6 text-left">Gigger</th>
                            <th class="py-3 px-6 text-left">Job Duration</th>
                            <th class="py-3 px-6 text-left">Status</th>
                            <th class="py-3 px-6 text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                        <tr class="border-b border-gray-200 hover:bg-gray-100" v-if="!!gigPlaybookList.data && !gigPlaybookList.data.length">
                            <td class="py-3 px-6 text-left whitespace-nowrap">No records found.</td>
                        </tr>
                        <tr class="border-b border-gray-200 hover:bg-gray-100" v-for="row in gigPlaybookList.data">
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium">{{ row.job_title }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex">
                                    <jet-responsive-link as="button" @click="viewGigger(row)">
                                        <span class="inline-flex items-center font-medium">
                                            <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 mr-3">
                                                <img class="h-8 w-8 rounded-full object-cover" :src="row.gigger.profile_photo_url" :alt="row.gigger.name" />
                                            </div>{{ row.gigger.name }}
                                        </span>
                                    </jet-responsive-link>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex items-center">
                                    <span class="font-medium">{{ moment(row.job_start_date).format("DD MMM YYYY") }} to {{ moment(row.job_end_date).format("DD MMM YYYY") }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex items-center">
                                    <span class="font-medium">{{ row.status }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center">
                                    <jet-icon name="contract-icon" tooltip="View Contract" @click="viewContract(row)" />
                                    <jet-icon name="task-list-icon" tooltip="View Tasks" @click="viewTasks(row)"
                                              v-if="!['Pending Contract Signing', 'Contract Rejected'].includes(row.status)" />
                                    <jet-icon name="review-icon" tooltip="View Review Write-up" @click="viewReview(row)"
                                              v-if="['Pending Review', 'Closed'].includes(row.status)" />
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <jet-pagination :links="gigPlaybookList.links" />
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetIcon from '@/Jetstream/Icon'
    import JetPagination from '@/Jetstream/Pagination'
    import JetResponsiveLink from '@/Jetstream/ResponsiveLink'
    import JetSearchBar from '@/Jetstream/SearchBar'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
    import moment from "moment"

    export default defineComponent({
        components: {
            AppLayout,
            JetButton,
            JetIcon,
            JetPagination,
            JetResponsiveLink,
            JetSearchBar,
            JetSecondaryButton,
        },

        props: [
            'search',
            'gigPlaybookList',
        ],

        data() {
            return {
                moment: moment,

                form: this.$inertia.form({
                    search: this.search,
                    id: null,
                    user_id: null,
                })
            }
        },

        methods: {
            searchRecord() {
                this.form.get(route('gigHost.gigPlaybook.list'))
            },

            clearSearchRecord() {
                this.form.search = null
                this.searchRecord()
            },

            viewGigger(row) {
                this.form.user_id = row.gigger.id
                this.form.get(route('user-page.view'))
            },

            viewContract(row) {
                this.form.id = row.id
                this.form.get(route('gigHost.gigPlaybook.viewContract'))
            },

            viewTasks(row) {
                this.form.id = row.id
                this.form.get(route('gigHost.gigPlaybook.viewTasks'))
            },

            viewReview(row) {
                this.form.id = row.id
                this.form.get(route('gigHost.gigPlaybook.viewReview'))
            }
        }
    })
</script>
