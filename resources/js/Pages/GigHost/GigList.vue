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
                    <div class="flex justify-end mb-2 mr-2">
                        <jet-icon name="add-icon" tooltip="Post Gig Ad" @click="addRecord" />
                    </div>
                    <table class="w-full table-auto">
                        <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Job Title</th>
                            <th class="py-3 px-6 text-left">Job Duration</th>
                            <th class="py-3 px-6 text-left">Posted Date</th>
                            <th class="py-3 px-6 text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                        <tr class="border-b border-gray-200 hover:bg-gray-100"
                            v-if="!!$page.props.gigAdList && !$page.props.gigAdList.length">
                            <td class="py-3 px-6 text-left whitespace-nowrap">No records found.</td>
                        </tr>
                        <tr class="border-b border-gray-200 hover:bg-gray-100" v-for="row in $page.props.gigAdList">
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium">{{ row.job_title }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex items-center">
                                    <span class="font-medium">{{ moment(row.job_start_date).format("YYYY MMM DD") }} to {{ moment(row.job_end_date).format("YYYY MMM DD") }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium">{{ moment(row.posted_date).format("YYYY MMM DD") }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center">
                                    <jet-icon name="edit-icon" tooltip="Update Gig Ad" @click="editRecord(row)" />
                                    <jet-icon name="delete-icon" tooltip="Remove Gig Ad" @click="confirmDeleteModal(row)" />
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

                form: this.$inertia.form({
                    _method: 'POST',
                })
            }
        },

        methods: {
            addRecord() {
                this.form.get(route('gigHost.gig.create'));
            }
        }
    })
</script>
