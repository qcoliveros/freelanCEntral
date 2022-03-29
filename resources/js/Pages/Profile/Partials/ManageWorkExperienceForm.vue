<template>
    <jet-action-section>
        <template #title>
            Experience
        </template>

        <template #description>
            Manage your work experience.
        </template>

        <template #content>
            <div class="w-full">
                <div class="flex justify-end mb-2 mr-2">
                    <jet-icon name="add-icon" tooltip="Add Work Experience" @click="add" />
                </div>
                <div class="bg-white rounded">
                    <table class="w-full table-auto">
                        <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Title</th>
                            <th class="py-3 px-6 text-left">Company Name</th>
                            <th class="py-3 px-6 text-left">Duration</th>
                            <th class="py-3 px-6 text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                        <tr class="border-b border-gray-200 hover:bg-gray-100"
                            v-if="!!workExperiences && !workExperiences.length">
                            <td class="py-3 px-6 text-left whitespace-nowrap">No records found.</td>
                        </tr>
                        <tr class="border-b border-gray-200 hover:bg-gray-100" v-for="row in workExperiences">
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium">{{ row.title }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-left">
                                <div class="flex items-center">
                                    <span>{{ row.company_name }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex items-center">
                                    <span v-if="!!row.end_date">{{ row.start_date }} - {{ row.end_date }}</span>
                                    <span v-else>{{ row.start_date }} to Present</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center">
                                    <jet-icon name="edit-icon" tooltip="Edit Work Experience" @click="edit(row)" />
                                    <jet-icon name="delete-icon" tooltip="Remove Work Experience" />
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <jet-dialog-modal :show="isOpenModal" @close="closeModal">
                <template #title>
                    Add Work Experience
                </template>

                <template #content>
                    <!-- Is present? -->
                    <div>
                        <jet-checkbox name="is_present" id="is_present" v-model:checked="form.is_present" />
                        <span class="font-medium text-sm text-gray-700"> Is present work?</span>
                    </div>

                    <!-- Title -->
                    <div class="mt-2">
                        <jet-label for="title" value="Title" />
                        <jet-input id="title" type="text" class="mt-1 block w-full" v-model="form.title" autocomplete="title" />
                        <jet-input-error :message="form.errors.title" class="mt-2" />
                    </div>

                    <!-- Employment Type -->
                    <div class="mt-2">
                        <jet-label for="employment_type" value="Employment Type" />
                        <multiselect id="employment_type" v-model="form.employment_type" :options="$page.props.employmentTypes" :searchable="true" />
                        <jet-input-error :message="form.errors.employment_type" class="mt-2" />
                    </div>

                    <!-- Company Name -->
                    <div class="mt-2">
                        <jet-label for="company_name" value="Company Name" />
                        <jet-input id="company_name" type="text" class="mt-1 block w-full" v-model="form.company_name" autocomplete="company-name" />
                        <jet-input-error :message="form.errors.company_name" class="mt-2" />
                    </div>

                    <!-- Location -->
                    <div class="mt-2">
                        <jet-label for="location" value="Location" />
                        <multiselect id="location" v-model="form.location" :options="$page.props.countries" :searchable="true" />
                        <jet-input-error :message="form.errors.location" class="mt-2" />
                    </div>

                    <!-- Start/End Date -->
                    <div class="mt-2">
                        <div class="grid grid-cols-2 md:grid-cols-2 md:gap-2">
                            <div class="flex-col">
                                <jet-label for="start_date" value="Start Date" />
                                <date-picker v-model:value="form.start_date" />
                            </div>

                            <div>
                                <jet-label for="end_date" value="End Date" />
                                <date-picker v-model:value="form.end_date" />
                            </div>
                        </div>
                    </div>

                    <!-- Industry -->
                    <div class="mt-2">
                        <jet-label for="industry" value="Industry" />
                        <multiselect id="industry" v-model="form.location" :options="$page.props.industries" :searchable="true" />
                        <jet-input-error :message="form.errors.industry" class="mt-2" />
                    </div>

                    <div class="mt-2">
                        <jet-label for="description" value="Description" />
                        <jet-textarea id="description" class="mt-1 block w-full" v-model="form.description" autocomplete="description" />
                        <jet-input-error :message="form.errors.description" class="mt-2" />
                    </div>
                </template>

                <template #footer>
                    <jet-secondary-button @click="closeModal">
                        Cancel
                    </jet-secondary-button>

                    <jet-button class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Save
                    </jet-button>
                </template>
            </jet-dialog-modal>
        </template>
    </jet-action-section>
</template>

<script>
import { defineComponent } from 'vue'
import DatePicker from 'vue-datepicker-next'
import JetActionMessage from '@/Jetstream/ActionMessage.vue'
import JetActionSection from '@/Jetstream/ActionSection.vue'
import JetButton from '@/Jetstream/Button.vue'
import JetCheckbox from '@/Jetstream/Checkbox'
import JetDialogModal from '@/Jetstream/DialogModal.vue'
import JetIcon from '@/Jetstream/Icon'
import JetInput from '@/Jetstream/Input.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetLabel from '@/Jetstream/Label.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import JetTextarea from "@/Jetstream/Textarea"
import Multiselect from "@vueform/multiselect"

export default defineComponent({
    components: {
        DatePicker,
        JetActionMessage,
        JetActionSection,
        JetButton,
        JetCheckbox,
        JetDialogModal,
        JetIcon,
        JetInput,
        JetInputError,
        JetLabel,
        JetSecondaryButton,
        JetTextarea,
        Multiselect,
    },

    props: ['workExperiences'],

    data() {
        return {
            isOpenModal: false,

            form: this.$inertia.form({
                title: null,
                employment_type: null,
                company_name: null,
                location: null,
                start_date: null,
                end_date: null,
                is_present: null,
                industry: null,
                description: null,
            })
        }
    },

    methods: {
        openModal() {
            this.isOpenModal = true
        },

        closeModal() {
            this.isOpenModal = false
            this.form.reset()
        },

        add() {
            this.openModal()
        },

        edit(row) {
            this.openModal()
        },

        deleteRow(row) {

        }
    },
})
</script>
