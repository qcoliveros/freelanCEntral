<template>
    <app-layout title="Gig Ads">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <span v-if="isEdit">Update Gig Playbook Task</span>
                <span v-else>Add Gig Playbook Task</span>
                for {{ gigPlaybook.job_title }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6">
                <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                    <div class="md:grid md:grid-cols-4 md:gap-2">
                        <div class="md:mt-0 md:col-span-3">
                            <!-- Title -->
                            <div>
                                <jet-label for="title" value="Task Title" />
                                <jet-input id="title" type="text" class="mt-1 block w-full" v-model="form.title" autocomplete="title" />
                                <jet-input-error :message="form.errors.title" class="mt-2" />
                            </div>

                            <!-- Description -->
                            <div class="mt-4">
                                <jet-label for="description" value="Task Description" />
                                <jet-rich-text-editor class="mt-1 block w-full" v-model="form.description" />
                                <jet-input-error :message="form.errors.description" class="mt-2" />
                            </div>

                            <!-- Duration -->
                            <div class="mt-4">
                                <jet-label value="Task Duration" />
                                <div class="flex flex-row gap-2">
                                    <date-picker v-model:value="form.start_date" value-type="YYYY-MM-DD" format="DD MMM YYYY" placeholder="Start Date" />
                                    <date-picker v-model:value="form.end_date" value-type="YYYY-MM-DD" format="DD MMM YYYY" placeholder="End Date" />
                                </div>
                                <jet-input-error :message="form.errors.start_date" class="mt-2" />
                                <jet-input-error :message="form.errors.end_date" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                    <jet-secondary-button class="mr-2" @click="cancel">
                        Cancel
                    </jet-secondary-button>
                    <jet-button class="mr-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="save">
                        Save
                    </jet-button>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout'
    import DatePicker from 'vue-datepicker-next'
    import JetButton from '@/Jetstream/Button'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'
    import JetRichTextEditor from '@/Jetstream/RichTextEditor'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import ToastMessage from '../../../mixins/toast-message'

    export default defineComponent({
        mixins: [ ToastMessage ],

        components: {
            AppLayout,
            DatePicker,
            JetButton,
            JetInput,
            JetInputError,
            JetLabel,
            JetRichTextEditor,
            JetSecondaryButton,
        },

        props: [
            'search',
            'gigPlaybook',
            'gigTask',
            'gigTaskComments',
            'isEdit',
        ],

        data() {
            return {
                form: this.$inertia.form({
                    search: this.search,
                    id: this.gigPlaybook.id,
                    task_id: this.gigTask ? this.gigTask.id : null,
                    title: this.gigTask ? this.gigTask.title : null,
                    description: this.gigTask ? this.gigTask.description : null,
                    start_date: this.gigTask ? this.gigTask.start_date : null,
                    end_date: this.gigTask ? this.gigTask.end_date : null,
                    status: this.gigTask ? this.gigTask.status : null,
                })
            }
        },

        methods: {
            cancel() {
                this.form.get(route('gigHost.gigPlaybook.viewTasks'));
            },

            save() {
                this.form.post(route('gigHost.gigPlaybook.saveTask'), {
                    errorBag: 'gigPlaybookTaskError',
                    preserveScroll: true,
                    onSuccess: () => {
                        this.showSuccessMessage('Saved')
                    }
                });
            }
        }
    })
</script>
