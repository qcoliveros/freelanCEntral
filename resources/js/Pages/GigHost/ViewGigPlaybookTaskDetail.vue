<template>
    <app-layout title="Gig Playbook">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gig Playbook Task
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6">
                <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                    <view-gig-task-detail :gigTask="gigTask" />
                </div>
                <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                    <jet-secondary-button @click="cancel">
                        Cancel
                    </jet-secondary-button>
                    <jet-button class="ml-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                                @click="close" v-if="['Completed', 'On-hold'].includes(gigTask.status)">
                        Close
                    </jet-button>
                </div>

                <manage-gig-task-comment :gigPlaybook="gigPlaybook" :gigTask="gigTask" :gigTaskComments="gigTaskComments" />
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout'
    import JetButton from '@/Jetstream/Button'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import ManageGigTaskComment from '@/Pages/Shared/ManageGigTaskComment'
    import ToastMessage from '../../../mixins/toast-message'
    import ViewGigTaskDetail from '@/Pages/Shared/ViewGigTaskDetail'

    export default defineComponent({
        mixins: [ ToastMessage ],

        components: {
            AppLayout,
            JetButton,
            JetSecondaryButton,
            ManageGigTaskComment,
            ViewGigTaskDetail,
        },

        props: [
            'search',
            'gigPlaybook',
            'gigTask',
            'gigTaskComments',
        ],

        data() {
            return {
                form: this.$inertia.form({
                    search: this.search,
                    id: this.gigPlaybook.id,
                    task_id: this.gigTask ? this.gigTask.id : null,
                })
            }
        },

        methods: {
            cancel() {
                this.form.get(route('gigHost.gigPlaybook.viewTasks'));
            },

            close() {
                this.form.post(route('gigHost.gigPlaybook.closeTask'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.showSuccessMessage('Closed')
                    }
                });
            }
        }
    })
</script>
