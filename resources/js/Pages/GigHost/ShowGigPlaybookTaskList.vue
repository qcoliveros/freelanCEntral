<template>
    <app-layout title="Gig Playbook">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gig Playbook Tasks
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6">
                <div class="px-4 py-5 sm:p-6 bg-white shadow sm:rounded-tl-md sm:rounded-tr-md">
                    <div class="flex justify-end mb-2 mr-2">
                        <jet-icon name="add-icon" tooltip="Add Task" @click="addTask" v-if="gigPlaybook.status == 'Contract Accepted'" />
                    </div>
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
                                    <jet-icon name="view-icon" tooltip="View Task" @click="viewTask(row)" v-if="row.status != 'Draft'" />
                                    <jet-icon name="edit-icon" tooltip="Update Task" @click="editTask(row)" v-if="row.status == 'Draft'" />
                                    <jet-icon name="delete-icon" tooltip="Delete Task" @click="confirmDeleteTask(row)" v-if="row.status == 'Draft'" />
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
                    <jet-button class="ml-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                                @click="submit" v-if="gigPlaybook.status == 'Contract Accepted' && showSubmit">
                        Submit
                    </jet-button>
                </div>
            </div>
        </div>
        <jet-pagination :links="gigTaskList.links" />

        <jet-dialog-modal :show="isOpenConfirmDeleteTask" @close="closeconfirmDeleteTask">
            <template #title>
                Delete Task
            </template>

            <template #content>
                Are you sure you want to delete your gig task?
            </template>

            <template #footer>
                <jet-secondary-button @click="closeconfirmDeleteTask">
                    Cancel
                </jet-secondary-button>

                <jet-button class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="deleteTask">
                    Delete
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
    import JetPagination from '@/Jetstream/Pagination'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import moment from "moment"

    export default defineComponent({
        components: {
            AppLayout,
            JetButton,
            JetDialogModal,
            JetIcon,
            JetPagination,
            JetSecondaryButton,
        },

        props: [
            'search',
            'gigPlaybook',
            'gigTaskList',
        ],

        computed: {
            showSubmit() {
                if (this.gigTaskList.data !== null
                    && this.gigTaskList.data.filter(element => ['Draft'].includes(element.status)).length != 0)
                {
                    return true
                }

                return false
            }
        },

        data() {
            return {
                moment: moment,
                isOpenConfirmDeleteTask: false,

                form: this.$inertia.form({
                    search: this.search,
                    id: this.gigPlaybook.id,
                    task_id: null,
                })
            }
        },

        methods: {
            cancel() {
                this.form.get(route('gigHost.gigPlaybook.list'));
            },

            viewTask(row) {
                this.form.task_id = row.id
                this.form.get(route('gigHost.gigPlaybook.viewTask'))
            },

            addTask() {
                this.form.get(route('gigHost.gigPlaybook.createTask'))
            },

            confirmDeleteTask(row) {
                this.form.task_id = row.id
                this.isOpenConfirmDeleteTask = true
            },

            closeconfirmDeleteTask() {
                this.isOpenConfirmDeleteTask = false
                this.form.task_id = null
            },

            deleteTask() {
                this.form.delete(route('gigHost.gigPlaybook.deleteTask'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.closeconfirmDeleteTask()
                        this.showSuccessMessage('Deleted')
                    }
                });
            },

            editTask(row) {
                this.form.task_id = row.id
                this.form.get(route('gigHost.gigPlaybook.editTask'))
            },

            submit() {
                this.form.post(route('gigHost.gigPlaybook.submitTasks'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.showSuccessMessage('Submitted')
                    }
                });
            }
        }
    })
</script>
