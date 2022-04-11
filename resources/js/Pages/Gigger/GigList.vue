<template>
    <app-layout title="Gigs">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gigs
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6">
                <div class="px-4 py-5 sm:p-6 bg-white shadow sm:rounded-lg">
                    <table class="w-full table-auto">
                        <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Job Title</th>
                            <th class="py-3 px-6 text-left">Duration</th>
                            <th class="py-3 px-6 text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                        <tr class="border-b border-gray-200 hover:bg-gray-100"
                            v-if="!!$page.props.gigList && !$page.props.gigList.length">
                            <td class="py-3 px-6 text-left whitespace-nowrap">No records found.</td>
                        </tr>
                        <tr class="border-b border-gray-200 hover:bg-gray-100" v-for="row in $page.props.gigList">
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium">{{ row.job_title }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex items-center">
                                    <span class="font-medium">{{ moment(row.start_date).format("YYYY MMM") }} to {{ moment(row.end_date).format("YYYY MMM") }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center">
                                    <jet-icon name="view-icon" tooltip="View Gig Details" @click="viewRecord(row)" />
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import JetIcon from '@/Jetstream/Icon'
    import moment from "moment"

    export default defineComponent({
        components: {
            AppLayout,
            JetIcon,
        },

        data() {
            return {
                moment: moment,
            }
        }
    })
</script>
