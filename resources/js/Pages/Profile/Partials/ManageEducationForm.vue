<template>
    <jet-action-section>
        <template #title>
            Education
        </template>

        <template #description>
            Manage your education.
        </template>

        <template #content>
            <div class="w-full">
                <div class="flex justify-end mb-2 mr-2">
                    <jet-icon name="add-icon" tooltip="Add Education" @click="addRecord" />
                </div>
                <div class="bg-white rounded">
                    <table class="w-full table-auto">
                        <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">School</th>
                            <th class="py-3 px-6 text-left">Degree</th>
                            <th class="py-3 px-6 text-left">Duration</th>
                            <th class="py-3 px-6 text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                        <tr class="border-b border-gray-200 hover:bg-gray-100"
                            v-if="!!educations && !educations.length">
                            <td class="py-3 px-6 text-left whitespace-nowrap">No records found.</td>
                        </tr>
                        <tr class="border-b border-gray-200 hover:bg-gray-100" v-for="row in educations">
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium">{{ row.school }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-left">
                                <div class="flex items-center">
                                    <span>{{ row.degree }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex items-center">
                                    <span v-if="!!row.end_date">{{ moment(row.start_date).format("MMM YYYY") }} to {{ moment(row.end_date).format("MMM YYYY") }}</span>
                                    <span v-else>{{ moment(row.start_date).format("MMM YYYY") }} to -</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center">
                                    <jet-icon name="edit-icon" tooltip="Edit Education" @click="editRecord(row)" />
                                    <jet-icon name="delete-icon" tooltip="Remove Education" @click="confirmDeleteModal(row)" />
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <jet-dialog-modal :show="isOpenDetailModal" @close="closeDetailModal">
                <template #title>
                    <span v-if="isEditMode">Update Education</span>
                    <span v-else>Add Education</span>
                </template>

                <template #content>
                    <!-- School -->
                    <div class="mt-2">
                        <jet-label for="school" value="School" />
                        <jet-input id="school" type="text" class="mt-1 block w-full" v-model="form.school" autocomplete="school" />
                        <jet-input-error :message="form.errors.school" class="mt-2" />
                    </div>

                    <!-- Degree -->
                    <div class="mt-2">
                        <jet-label for="degree" value="Degree" />
                        <jet-input id="degree" type="text" class="mt-1 block w-full" v-model="form.degree" autocomplete="degree" />
                        <jet-input-error :message="form.errors.degree" class="mt-2" />
                    </div>

                    <!-- Field of Study -->
                    <div class="mt-2">
                        <jet-label for="field" value="Field of Study" />
                        <jet-input id="field" type="text" class="mt-1 block w-full" v-model="form.field" autocomplete="field" />
                        <jet-input-error :message="form.errors.field" class="mt-2" />
                    </div>

                    <!-- Start/End Date -->
                    <div class="mt-2">
                        <div class="grid grid-cols-2 md:grid-cols-2 md:gap-2">
                            <div class="flex-col">
                                <jet-label for="start_date" value="Start Date" />
                                <date-picker v-model:value="form.start_date" value-type="YYYY-MM-DD" type="month" format="MMM YYYY" />
                                <jet-input-error :message="form.errors.start_date" class="mt-2" />
                            </div>

                            <div>
                                <jet-label for="end_date" value="End Date" />
                                <date-picker v-model:value="form.end_date" value-type="YYYY-MM-DD" type="month" format="MMM YYYY" />
                                <jet-input-error :message="form.errors.end_date" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Grade -->
                    <div class="mt-2">
                        <jet-label for="grade" value="Grade" />
                        <jet-input id="grade" type="text" class="mt-1 block w-full" v-model="form.grade" autocomplete="grade" />
                        <jet-input-error :message="form.errors.grade" class="mt-2" />
                    </div>

                    <div class="mt-2">
                        <jet-label for="description" value="Description" />
                        <jet-textarea id="description" class="mt-1 block w-full" v-model="form.description" autocomplete="description" />
                        <jet-input-error :message="form.errors.description" class="mt-2" />
                    </div>
                </template>

                <template #footer>
                    <jet-secondary-button @click="closeDetailModal">
                        Cancel
                    </jet-secondary-button>

                    <jet-button class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="saveRecord">
                        Save
                    </jet-button>
                </template>
            </jet-dialog-modal>

            <jet-dialog-modal :show="isOpenConfirmDeleteModal" @close="closeDeleteModal">
                <template #title>
                    Delete Education
                </template>

                <template #content>
                    Are you sure you want to delete your education?
                </template>

                <template #footer>
                    <jet-secondary-button @click="closeDeleteModal">
                        Cancel
                    </jet-secondary-button>

                    <jet-button class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="deleteRecord">
                        Delete
                    </jet-button>
                </template>
            </jet-dialog-modal>
        </template>
    </jet-action-section>
</template>

<script>
    import { defineComponent } from 'vue'
    import DatePicker from 'vue-datepicker-next'
    import JetActionSection from '@/Jetstream/ActionSection.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetDialogModal from '@/Jetstream/DialogModal.vue'
    import JetIcon from '@/Jetstream/Icon'
    import JetInput from '@/Jetstream/Input.vue'
    import JetInputError from '@/Jetstream/InputError.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
    import JetTextarea from "@/Jetstream/Textarea"
    import moment from "moment"
    import ToastMessage from "../../../../mixins/toast-message";

    export default defineComponent({
        mixins: [ ToastMessage ],

        components: {
            DatePicker,
            JetActionSection,
            JetButton,
            JetDialogModal,
            JetIcon,
            JetInput,
            JetInputError,
            JetLabel,
            JetSecondaryButton,
            JetTextarea,
        },

        props: ['educations'],

        data() {
            return {
                moment: moment,

                isOpenDetailModal: false,
                isOpenConfirmDeleteModal: false,
                isEditMode: false,
                saveRoute: null,

                form: this.$inertia.form({
                    id: null,
                    school: null,
                    degree: null,
                    field: null,
                    start_date: null,
                    end_date: null,
                    grade: null,
                    description: null,
                })
            }
        },

        methods: {
            openDetailModal() {
                this.isOpenDetailModal = true
            },

            closeDetailModal() {
                this.isOpenDetailModal = false
                this.isEditMode = false
                this.form.reset()
                this.form.clearErrors()
            },

            addRecord() {
                this.openDetailModal()
            },

            editRecord(row) {
                Object.assign(this.form, row)
                this.isEditMode = true
                this.openDetailModal()
            },

            saveRecord() {
                this.saveRoute = 'user-education.store'
                if (this.isEditMode) {
                    this.saveRoute = 'user-education.update'
                }
                this.form.post(route(this.saveRoute), {
                    errorBag: 'educationError',
                    preserveScroll: true,
                    onSuccess: () => {
                        this.closeDetailModal()
                        this.showSuccessMessage('Saved')
                    }
                });
            },

            confirmDeleteModal(row) {
                Object.assign(this.form, row)
                this.isOpenConfirmDeleteModal = true
            },

            closeDeleteModal() {
                this.isOpenConfirmDeleteModal = false
                this.form.reset()
            },

            deleteRecord() {
                this.form.delete(route('user-education.delete'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.closeDeleteModal()
                        this.showSuccessMessage('Deleted')
                    }
                });
            }
        },
    })
</script>
