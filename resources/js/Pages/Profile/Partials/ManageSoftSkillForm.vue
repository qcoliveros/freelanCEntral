<template>
    <jet-action-section>
        <template #title>
            Soft Skill
        </template>

        <template #description>
            Manage your soft skill.
        </template>

        <template #content>
            <div class="w-full">
                <div class="flex justify-end mb-2 mr-2">
                    <jet-icon name="add-icon" tooltip="Add Soft Skill" @click="addRecord" />
                </div>
                <div class="bg-white rounded">
                    <table class="w-full table-auto">
                        <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Skill</th>
                            <th class="py-3 px-6 text-left">Proficiency</th>
                            <th class="py-3 px-6 text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                        <tr class="border-b border-gray-200 hover:bg-gray-100"
                            v-if="!!softSkills && !softSkills.length">
                            <td class="py-3 px-6 text-left whitespace-nowrap">No records found.</td>
                        </tr>
                        <tr class="border-b border-gray-200 hover:bg-gray-100" v-for="row in softSkills">
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium">{{ row.skill.name }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-left">
                                <div class="flex items-center">
                                    <span>{{ row.proficiency.name }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center">
                                    <jet-icon name="edit-icon" tooltip="Edit Soft Skill" @click="editRecord(row)" />
                                    <jet-icon name="delete-icon" tooltip="Remove Soft Skill" @click="confirmDeleteModal(row)" />
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <jet-dialog-modal :show="isOpenDetailModal" @close="closeDetailModal">
                <template #title>
                    <span v-if="isEditMode">Update Soft Skill</span>
                    <span v-else>Add Soft Skill</span>
                </template>

                <template #content>
                    <!-- Skill -->
                    <div class="mt-2">
                        <jet-label for="skill_id" value="Soft Skill" />
                        <multiselect id="skill_id" v-model="form.skill_id" :options="$page.props.parameter.softSkills" :searchable="true" />
                        <jet-input-error :message="form.errors.skill_id" class="mt-2" />
                    </div>

                    <!-- Proficiency Level -->
                    <div class="mt-2">
                        <jet-label for="proficiency_id" value="Proficiency Level" />
                        <multiselect id="proficiency_id" v-model="form.proficiency_id" :options="$page.props.parameter.skillProficiencies" :searchable="true" />
                        <jet-input-error :message="form.errors.proficiency_id" class="mt-2" />
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
                    Delete Soft Skill
                </template>

                <template #content>
                    Are you sure you want to delete your soft skill?
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
    import JetActionMessage from '@/Jetstream/ActionMessage.vue'
    import JetActionSection from '@/Jetstream/ActionSection.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetDialogModal from '@/Jetstream/DialogModal.vue'
    import JetIcon from '@/Jetstream/Icon'
    import JetInputError from '@/Jetstream/InputError.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
    import JetTextarea from "@/Jetstream/Textarea"
    import Multiselect from "@vueform/multiselect"
    import ToastMessage from "../../../../mixins/toast-message";

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

        props: ['softSkills'],

        data() {
            return {
                isOpenDetailModal: false,
                isOpenConfirmDeleteModal: false,
                isEditMode: false,
                saveRoute: null,

                form: this.$inertia.form({
                    _method: 'POST',
                    id: null,
                    skill_id: null,
                    proficiency_id: null,
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
                this.saveRoute = 'user-soft-skill.store'
                if (this.isEditMode) {
                    this.saveRoute = 'user-soft-skill.update'
                }
                this.form.post(route(this.saveRoute), {
                    errorBag: 'softSkillError',
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
                this.form.delete(route('user-soft-skill.delete'), {
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
