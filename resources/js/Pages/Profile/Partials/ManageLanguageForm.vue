<template>
    <jet-action-section>
        <template #title>
           Language
        </template>

        <template #description>
            Manage your language.
        </template>

        <template #content>
            <div class="w-full">
                <div class="flex justify-end mb-2 mr-2">
                    <jet-icon name="add-icon" tooltip="Add Language" @click="addRecord" />
                </div>
                <div class="bg-white rounded">
                    <table class="w-full table-auto">
                        <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Language</th>
                            <th class="py-3 px-6 text-left">Speaking Proficiency</th>
                            <th class="py-3 px-6 text-left">Writing Proficiency</th>
                            <th class="py-3 px-6 text-left">Reading Proficiency</th>
                            <th class="py-3 px-6 text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                        <tr class="border-b border-gray-200 hover:bg-gray-100" v-if="!!languages && !languages.length">
                            <td class="py-3 px-6 text-left whitespace-nowrap">No records found.</td>
                        </tr>
                        <tr class="border-b border-gray-200 hover:bg-gray-100" v-for="row in languages">
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium">{{ row.language.name }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-left">
                                <div class="flex items-center">
                                    <span>{{ row.speaking_proficiency.name }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-left">
                                <div class="flex items-center">
                                    <span>{{ row.writing_proficiency.name }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-left">
                                <div class="flex items-center">
                                    <span>{{ row.reading_proficiency.name }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center">
                                    <jet-icon name="edit-icon" tooltip="Edit Language" @click="editRecord(row)" />
                                    <jet-icon name="delete-icon" tooltip="Remove Language" @click="confirmDeleteModal(row)" />
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <jet-dialog-modal :show="isOpenDetailModal" @close="closeDetailModal">
                <template #title>
                    <span v-if="isEditMode">Update Language</span>
                    <span v-else>Add Language</span>
                </template>

                <template #content>
                    <!-- Skill -->
                    <div class="mt-2">
                        <jet-label for="language_id" value="Language" />
                        <multiselect id="language_id" v-model="form.language_id" :options="$page.props.parameter.languages" :searchable="true" />
                        <jet-input-error :message="form.errors.language_id" class="mt-2" />
                    </div>

                    <!-- Speaking Proficiency -->
                    <div class="mt-2">
                        <jet-label for="speaking_proficiency_id" value="Speaking Proficiency Level" />
                        <multiselect id="speaking_proficiency_id" v-model="form.speaking_proficiency_id" :options="$page.props.parameter.languageProficiencies" :searchable="true" />
                        <jet-input-error :message="form.errors.speaking_proficiency_id" class="mt-2" />
                    </div>

                    <!-- Writing Proficiency -->
                    <div class="mt-2">
                        <jet-label for="writing_proficiency_id" value="Writing Proficiency Level" />
                        <multiselect id="writing_proficiency_id" v-model="form.writing_proficiency_id" :options="$page.props.parameter.languageProficiencies" :searchable="true" />
                        <jet-input-error :message="form.errors.writing_proficiency_id" class="mt-2" />
                    </div>

                    <!-- Speaking Proficiency -->
                    <div class="mt-2">
                        <jet-label for="reading_proficiency_id" value="Reading Proficiency Level" />
                        <multiselect id="reading_proficiency_id" v-model="form.reading_proficiency_id" :options="$page.props.parameter.languageProficiencies" :searchable="true" />
                        <jet-input-error :message="form.errors.reading_proficiency_id" class="mt-2" />
                    </div>

                    <!-- Description -->
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
                    Delete Language
                </template>

                <template #content>
                    Are you sure you want to delete your language?
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
    import JetActionMessage from '@/Jetstream/ActionMessage'
    import JetActionSection from '@/Jetstream/ActionSection'
    import JetButton from '@/Jetstream/Button'
    import JetDialogModal from '@/Jetstream/DialogModal'
    import JetIcon from '@/Jetstream/Icon'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import JetTextarea from "@/Jetstream/Textarea"
    import Multiselect from "@vueform/multiselect"
    import ToastMessage from "../../../../mixins/toast-message"

    export default defineComponent({
        mixins: [ ToastMessage ],

        components: {
            JetActionMessage,
            JetActionSection,
            JetButton,
            JetDialogModal,
            JetIcon,
            JetInputError,
            JetLabel,
            JetSecondaryButton,
            JetTextarea,
            Multiselect,
        },

        props: [ 'languages' ],

        data() {
            return {
                isOpenDetailModal: false,
                isOpenConfirmDeleteModal: false,
                isEditMode: false,
                saveRoute: null,

                form: this.$inertia.form({
                    id: null,
                    language_id: null,
                    speaking_proficiency_id: null,
                    writing_proficiency_id: null,
                    reading_proficiency_id: null,
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
                this.saveRoute = 'user-language.store'
                if (this.isEditMode) {
                    this.saveRoute = 'user-language.update'
                }
                this.form.post(route(this.saveRoute), {
                    errorBag: 'languageError',
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
                this.form.delete(route('user-language.delete'), {
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
