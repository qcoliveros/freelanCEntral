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
                                    <jet-responsive-link as="button" @click="viewGigAd(row)">
                                        <span class="font-medium">{{ row.job_title }}</span>
                                    </jet-responsive-link>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex">
                                    <jet-responsive-link as="button" @click="viewGigHost(row)">
                                        <span class="inline-flex items-center font-medium">
                                            <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 mr-3">
                                                <img class="h-8 w-8 rounded-full object-cover" :src="row.gig_host.profile_photo_url" :alt="row.gig_host.name" />
                                            </div>{{ row.gig_host.name }}
                                        </span>
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
                                    <jet-icon name="view-icon" tooltip="View Gig Ad" @click="viewGigAd(row)" />
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
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout'
    import JetIcon from '@/Jetstream/Icon'
    import JetPagination from '@/Jetstream/Pagination'
    import JetResponsiveLink from '@/Jetstream/ResponsiveLink'
    import JetSearchBar from '@/Jetstream/SearchBar'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import moment from 'moment'

    export default defineComponent({
        components: {
            AppLayout,
            JetIcon,
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

                form: this.$inertia.form({
                    search: this.search,
                    id: null,
                    user_id: null,
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

            viewGigHost(row) {
                this.form.user_id = row.gig_host.id
                this.form.get(route('user-page.view'));
            },

            viewGigAd(row) {
                this.form.id = row.id
                this.form.get(route('gigger.gigAd.view'));
            }
        }
    })
</script>
