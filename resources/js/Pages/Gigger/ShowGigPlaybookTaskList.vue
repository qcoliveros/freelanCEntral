<template>
    <app-layout title="Gig Ads">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gig Playbook Tasks
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6">
                <div class="px-4 py-5 sm:p-6 bg-white shadow sm:rounded-tl-md sm:rounded-tr-md">
                    <table class="w-full table-auto">
                        <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Task Title</th>
                            <th class="py-3 px-6 text-left">Task Duration</th>
                            <th class="py-3 px-6 text-left">Status</th>
                            <th class="py-3 px-6 text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                        <tr class="border-b border-gray-200 hover:bg-gray-100" v-if="!!gigTaskList.data && !gigTaskList.data.length">
                            <td class="py-3 px-6 text-left whitespace-nowrap">No records found.</td>
                        </tr>
                        <tr class="border-b border-gray-200 hover:bg-gray-100" v-for="row in gigTaskList.data">
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium">{{ row.title }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex items-center">
                                    <span class="font-medium">{{ moment(row.start_date).format("DD MMM YYYY") }} to {{ moment(row.end_date).format("DD MMM YYYY") }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex items-center">
                                    <span class="font-medium">{{ row.status }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center">
                                    <jet-icon name="view-icon" tooltip="View Task" @click="viewTask(row)" />
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
        <jet-pagination :links="gigTaskList.links" />
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout'
    import JetButton from '@/Jetstream/Button'
    import JetIcon from '@/Jetstream/Icon'
    import JetPagination from '@/Jetstream/Pagination'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import moment from "moment"

    export default defineComponent({
        components: {
            AppLayout,
            JetButton,
            JetIcon,
            JetPagination,
            JetSecondaryButton,
        },

        props: [
            'search',
            'gigPlaybook',
            'gigTaskList',
        ],

        data() {
            return {
                moment: moment,

                form: this.$inertia.form({
                    search: this.search,
                    id: this.gigPlaybook.id,
                    task_id: null,
                })
            }
        },

        methods: {
            cancel() {
                this.form.get(route('gigger.gigPlaybook.list'));
            },

            viewTask(row) {
                this.form.task_id = row.id
                this.form.get(route('gigger.gigPlaybook.viewTask'))
            }
        }
    })
</script>
