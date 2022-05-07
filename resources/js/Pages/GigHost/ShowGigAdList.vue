<template>
    <app-layout title="Gig Ads">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gig Ads
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6">
                <div class="px-4 py-5 sm:p-6 bg-white shadow sm:rounded-lg">
                    <jet-search-bar v-model="form.search" placeholder="Search by job title"
                                    @clickSearch="searchRecord" @clickClearSearch="clearSearchRecord" />

                    <div class="flex justify-end mb-2 mr-2">
                        <jet-icon name="add-icon" tooltip="Post Gig Ad" @click="addRecord" />
                    </div>
                    <table class="w-full table-auto">
                        <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Job Title</th>
                            <th class="py-3 px-6 text-left">Job Duration</th>
                            <th class="py-3 px-6 text-left">Published Date</th>
                            <th class="py-3 px-6 text-left">Closed Date</th>
                            <th class="py-3 px-6 text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                        <tr class="border-b border-gray-200 hover:bg-gray-100" v-if="!!gigAdList.data && !gigAdList.data.length">
                            <td class="py-3 px-6 text-left whitespace-nowrap">No records found.</td>
                        </tr>
                        <tr class="border-b border-gray-200 hover:bg-gray-100" v-for="row in gigAdList.data">
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium">{{ row.job_title }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex items-center">
                                    <span class="font-medium">{{ moment(row.job_start_date).format("DD MMM YYYY") }} to {{ moment(row.job_end_date).format("DD MMM YYYY") }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium" v-if="!!row.publish_date">{{ moment(row.publish_date).format("DD MMM YYYY") }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium" v-if="!!row.close_date">{{ moment(row.close_date).format("DD MMM YYYY") }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center">
                                    <jet-icon v-if="row.status != 'Closed'" name="edit-icon" tooltip="Update Gig Ad" @click="editRecord(row)" />
                                    <jet-icon v-if="row.status == 'Closed'" name="view-icon" tooltip="View Gig Ad" @click="viewRecord(row)" />
                                    <jet-icon v-if="row.status == 'Draft'" name="delete-icon" tooltip="Remove Gig Ad" @click="confirmDeleteRecord(row)" />
                                    <jet-icon v-if="row.status != 'Draft'" name="applicants-icon" tooltip="View Applicants" @click="viewApplicants(row)" />
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <jet-pagination :links="gigAdList.links" />
    </app-layout>

    <jet-dialog-modal :show="isOpenConfirmDeleteRecord" @close="closeConfirmDeleteRecord">
        <template #title>
            Delete Gig Ad
        </template>

        <template #content>
            Are you sure you want to delete your gig ad?
        </template>

        <template #footer>
            <jet-secondary-button @click="closeConfirmDeleteRecord">
                Cancel
            </jet-secondary-button>

            <jet-button class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="deleteRecord">
                Delete
            </jet-button>
        </template>
    </jet-dialog-modal>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetDialogModal from '@/Jetstream/DialogModal.vue'
    import JetIcon from '@/Jetstream/Icon'
    import JetPagination from '@/Jetstream/Pagination'
    import JetSearchBar from '@/Jetstream/SearchBar'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
    import moment from "moment"
    import ToastMessage from "../../../mixins/toast-message"

    export default defineComponent({
        mixins: [ ToastMessage ],

        components: {
            AppLayout,
            JetButton,
            JetDialogModal,
            JetIcon,
            JetPagination,
            JetSearchBar,
            JetSecondaryButton,
        },

        props: [
            'search',
            'gigAdList',
        ],

        data() {
            return {
                moment: moment,
                isOpenConfirmDeleteRecord: false,

                form: this.$inertia.form({
                    search: this.search,
                    id: null,
                })
            }
        },

        methods: {
            addRecord() {
                this.form.get(route('gigHost.gigAd.create'));
            },

            editRecord(row) {
                Object.assign(this.form, row)
                this.form.get(route('gigHost.gigAd.edit'));
            },

            viewRecord(row) {
                Object.assign(this.form, row)
                this.form.get(route('gigHost.gigAd.view'));
            },

            confirmDeleteRecord(row) {
                Object.assign(this.form, row)
                this.isOpenConfirmDeleteRecord = true
            },

            closeConfirmDeleteRecord() {
                this.isOpenConfirmDeleteRecord = false
                this.form.reset()
            },

            deleteRecord() {
                this.form.delete(route('gigHost.gigAd.delete'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.closeConfirmDeleteRecord()
                        this.showSuccessMessage('Deleted')
                    }
                });
            },

            searchRecord() {
                this.form.get('/gigHost/gig-ad-list')
            },

            clearSearchRecord() {
                this.form.search = null
                this.searchRecord()
            },

            viewApplicants(row) {
                Object.assign(this.form, row)
                this.form.get(route('gigHost.gigApp.list'));
            }
        }
    })
</script>
