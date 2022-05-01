<template>
    <app-layout title="Gigs">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Find Gig
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6">
                <div class="px-4 py-5 sm:p-6 bg-white shadow sm:rounded-lg">
                    <jet-search-bar v-model="form.search" v-if="$page.props.user.roles.includes('Gigger')"
                                    placeholder="Search by job title"
                                    @clickSearch="searchRecord" @clickClearSearch="clearSearchRecord" />
                    <table class="w-full table-auto mt-4">
                        <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Job Title</th>
                            <th class="py-3 px-6 text-left">Gig Host</th>
                            <th class="py-3 px-6 text-left">Published Date</th>
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
                                    <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 mr-3" >
                                        <img class="h-10 w-10 rounded-full object-cover" :src="row.gig_host.profile_photo_url" :alt="row.gig_host.name" />
                                    </div>
                                    <span class="font-medium">{{ row.gig_host.name }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium">{{ moment(row.publish_date).format("DD MMM YYYY") }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center">
                                    <jet-icon name="view-icon" tooltip="View Gig Ad" @click="viewRecord(row)" />
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <jet-pagination :links="gigAdList.links" />

        <jet-dialog-modal :show="isOpenDetailModal" @close="closeDetailModal">
            <template #title>
                <span class="text-xl">{{ gigAd.job_title }}</span>
                <div class="mt-0">
                    <jet-label isInline="true" value="Posted Date" />
                    <span class="text-sm">{{ moment(gigAd.publish_date).format("DD MMM YYYY") }}</span>
                </div>
            </template>

            <template #content>
                <!-- Description -->
                <div>
                    <jet-label value="Job Description" />
                    <div v-html="gigAd.description" />
                </div>

                <!-- Job Function -->
                <div class="mt-4">
                    <jet-label isInline="true" value="Job Function" />
                    {{ gigAd.job_function }}
                </div>

                <!-- Other Job Function -->
                <div class="mt-4" v-if="gigAd.job_function == 'Other'">
                    <jet-label isInline="true" value="Others (please specify)" />
                    {{ gigAd.other_job_function }}
                </div>

                <!-- Commitment Time -->
                <div class="mt-4">
                    <jet-label isInline="true" value="Time Commitment Required (hours per week)" />
                    {{ gigAd.commitment_time }}
                </div>

                <!-- Job Duration -->
                <div class="mt-4">
                    <jet-label isInline="true" value="Job Duration" />
                    {{ moment(gigAd.job_start_date).format("DD MMM YYYY") }} to {{ moment(gigAd.job_end_date).format("DD MMM YYYY") }}
                </div>

                <!-- About Gig Host -->
                <div class="mt-4">
                    <jet-label value="About Gig Host" />
                    <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 mr-3" >
                        <img class="h-10 w-10 rounded-full object-cover" :src="gigAd.gig_host.profile_photo_url" :alt="gigAd.gig_host.name" />
                    </div>
                    {{ gigAd.gig_host.name }}
                </div>
                <div class="mt-4">
                    <div v-html="modifyEmbeddedVideo(gigAd.gig_host.about)" />
                </div>
            </template>

            <template #footer>
                <jet-secondary-button @click="closeDetailModal">
                    Cancel
                </jet-secondary-button>

                <jet-button class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="apply(gigAd.id)">
                    Apply
                </jet-button>
            </template>
        </jet-dialog-modal>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout'
    import JetButton from '@/Jetstream/Button.vue'
    import JetDialogModal from '@/Jetstream/DialogModal'
    import JetIcon from '@/Jetstream/Icon'
    import JetLabel from '@/Jetstream/Label.vue'
    import JetPagination from '@/Jetstream/Pagination'
    import JetSearchBar from '@/Jetstream/SearchBar'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
    import EmbeddedMedia from "../../../mixins/embedded-media"
    import moment from "moment"

    export default defineComponent({
        mixins: [ EmbeddedMedia ],

        components: {
            AppLayout,
            JetButton,
            JetDialogModal,
            JetIcon,
            JetLabel,
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

                isOpenDetailModal: false,
                gigAd: new Object(),

                form: this.$inertia.form({
                    search: this.search,
                    id: null,
                })
            }
        },

        methods: {
            searchRecord() {
                this.form.get(route('gigger.gigAd.find'))
            },

            clearSearchRecord() {
                this.form.search = null
                this.searchRecord()
            },

            openDetailModal() {
                this.isOpenDetailModal = true
            },

            closeDetailModal() {
                this.isOpenDetailModal = false
            },

            viewRecord(row) {
                Object.assign(this.gigAd, row)
                this.openDetailModal()
            },

            apply(row) {

            }
        }
    })
</script>
