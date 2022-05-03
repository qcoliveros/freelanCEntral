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
                                    @clickSearch="searchGigAd" @clickClearSearch="clearSearchGigAd" />
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
                                <div class="flex">
                                    <jet-responsive-link as="button" @click="openGigAdModal(row)">
                                        <span class="font-medium">{{ row.job_title }}</span>
                                    </jet-responsive-link>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex">
                                    <jet-responsive-link as="button" @click="openGigHostModal(row)">
                                        <span class="inline-flex items-center font-medium">
                                            <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 mr-3" >
                                                <img class="h-8 w-8 rounded-full object-cover" :src="row.gig_host.profile_photo_url" :alt="row.gig_host.name" />
                                            </div>{{ row.gig_host.name }}</span>
                                    </jet-responsive-link>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex">
                                    <span class="font-medium">{{ moment(row.publish_date).format("DD MMM YYYY") }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center">
                                    <jet-icon name="view-icon" tooltip="View Gig Ad" @click="openGigAdModal(row)" />
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <jet-pagination :links="gigAdList.links" />

        <jet-dialog-modal :show="isOpenGigAdModal" @close="closeGigAdModal">
            <template #title>
                <span class="text-xl">{{ gigAd.job_title }}</span>
                <div class="mt-0">
                    <jet-label isInline="true" value="Posted Date" />&nbsp;
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
                    <jet-label isInline="true" value="Job Function" />&nbsp;
                    {{ gigAd.job_function }}
                </div>

                <!-- Other Job Function -->
                <div class="mt-4" v-if="gigAd.job_function == 'Other'">
                    <jet-label isInline="true" value="Others (please specify)" />&nbsp;
                    {{ gigAd.other_job_function }}
                </div>

                <!-- Commitment Time -->
                <div class="mt-4">
                    <jet-label isInline="true" value="Time Commitment Required (hours per week)" />&nbsp;
                    {{ gigAd.commitment_time }}
                </div>

                <!-- Job Duration -->
                <div class="mt-4">
                    <jet-label isInline="true" value="Job Duration" />&nbsp;
                    {{ moment(gigAd.job_start_date).format("DD MMM YYYY") }} to {{ moment(gigAd.job_end_date).format("DD MMM YYYY") }}
                </div>
            </template>

            <template #footer>
                <jet-secondary-button @click="closeGigAdModal">
                    Cancel
                </jet-secondary-button>

                <jet-button class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="applyGigAd(gigAd.id)">
                    Apply
                </jet-button>
            </template>
        </jet-dialog-modal>

        <jet-dialog-modal :show="isOpenGigHostModal" @close="closeGigHostModal">
            <template #title>
                About Gig Host
            </template>

            <template #content>
                <div>
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
                <jet-secondary-button @click="closeGigHostModal">
                    Cancel
                </jet-secondary-button>

                <jet-button class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="followGigHost(gigAd.gig_host.id)">
                    Follow
                </jet-button>
            </template>
        </jet-dialog-modal>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout'
    import JetButton from '@/Jetstream/Button'
    import JetDialogModal from '@/Jetstream/DialogModal'
    import JetIcon from '@/Jetstream/Icon'
    import JetLabel from '@/Jetstream/Label.vue'
    import JetPagination from '@/Jetstream/Pagination'
    import JetResponsiveLink from '@/Jetstream/ResponsiveLink'
    import JetSearchBar from '@/Jetstream/SearchBar'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import EmbeddedMedia from "../../../mixins/embedded-media"
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

                isOpenGigAdModal: false,
                isOpenGigHostModal: false,
                gigAd: new Object(),

                form: this.$inertia.form({
                    search: this.search,
                    gig_ad_id: null,
                    follow_user_id: null,
                })
            }
        },

        methods: {
            searchGigAd() {
                this.form.get(route('gigger.gigAd.find'))
            },

            clearSearchGigAd() {
                this.form.search = null
                this.searchGigAd()
            },

            openGigAdModal(row) {
                Object.assign(this.gigAd, row)
                this.isOpenGigAdModal = true
            },

            closeGigAdModal() {
                Object.assign(this.gigAd, null)
                this.isOpenGigAdModal = false
            },

            applyGigAd(gigAdId) {
                this.form.gig_ad_id = gigAdId
                this.form.post(route('gigger.gigAd.apply'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.closeGigAdModal()
                        this.showSuccessMessage('Application submitted')
                    },
                    onError: (errors) => {
                        this.showErrorMessage(errors.submitApplicationError)
                    }
                });
            },

            openGigHostModal(row) {
                Object.assign(this.gigAd, row)
                this.isOpenGigHostModal = true
            },

            closeGigHostModal() {
                Object.assign(this.gigAd, null)
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
