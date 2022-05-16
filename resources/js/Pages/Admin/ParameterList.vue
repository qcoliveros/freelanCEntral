<template>
    <app-layout title="Parameter List">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Parameter List <span v-if="parameterName != null">for {{ parameterName }}</span>
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6">
                <div class="px-4 py-5 sm:p-6 bg-white shadow sm:rounded-lg">
                    <jet-search-bar v-model="form.search" placeholder="Search by name"
                                    @clickSearch="searchRecord" @clickClearSearch="clearSearchRecord" />
                    <div class="flex justify-end mb-2 mr-2">
                        <jet-icon name="add-icon" tooltip="Add Parameter" @click="addRecord" />
                    </div>
                    <table class="w-full table-auto">
                        <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Parameter Name</th>
                            <th class="py-3 px-6 text-left w-3/6" v-if="hasDescription">Parameter Description</th>
                            <th class="py-3 px-6 text-center w-1/6">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                        <tr class="border-b border-gray-200 hover:bg-gray-100" v-if="!!parameterItemList.data && !parameterItemList.data.length">
                            <td class="py-3 px-6 text-left whitespace-nowrap">No records found.</td>
                        </tr>
                        <tr class="border-b border-gray-200 hover:bg-gray-100" v-for="row in parameterItemList.data">
                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="font-medium">{{ row.name }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-left whitespace-wrap" v-if="hasDescription">
                                <div class="flex items-center">
                                    <span class="font-medium">{{ row.description }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center">
                                    <jet-icon name="edit-icon" tooltip="Update Parameter" @click="editRecord(row)" />
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <jet-pagination :links="parameterItemList.links" />
    </app-layout>

    <jet-dialog-modal :show="isOpenModal" @close="closeModal">
        <template #title>
            <span v-if="isEditMode">Update Parameter</span>
            <span v-else>Add Parameter</span>
        </template>
        <template #content>
            <!-- Name -->
            <div>
                <jet-label for="name" value="Parameter Name" />
                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autocomplete="name" />
                <jet-input-error :message="form.errors.name" class="mt-2" />
            </div>
            <div class="mt-2" v-if="hasDescription">
                <jet-label for="description" value="Description" />
                <jet-textarea id="description" class="mt-1 block w-full" v-model="form.description" autocomplete="description" />
                <jet-input-error :message="form.errors.description" class="mt-2" />
            </div>
        </template>
        <template #footer>
            <jet-secondary-button @click="closeModal">
                Cancel
            </jet-secondary-button>
            <jet-button class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="saveRecord">
                Save
            </jet-button>
        </template>
    </jet-dialog-modal>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import JetButton from '@/Jetstream/Button'
    import JetDialogModal from '@/Jetstream/DialogModal'
    import JetIcon from '@/Jetstream/Icon'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'
    import JetPagination from '@/Jetstream/Pagination'
    import JetSearchBar from '@/Jetstream/SearchBar'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import JetTextarea from '@/Jetstream/Textarea'
    import ToastMessage from '../../../mixins/toast-message'

    export default defineComponent({
        mixins: [ ToastMessage ],

        components: {
            AppLayout,
            JetButton,
            JetDialogModal,
            JetIcon,
            JetInput,
            JetInputError,
            JetLabel,
            JetPagination,
            JetSearchBar,
            JetSecondaryButton,
            JetTextarea,
        },

        props: [
            'idx',
            'search',
            'hasDescription',
            'parameterName',
            'parameterItemList'
        ],

        data() {
            return {
                isOpenModal: false,
                isEditMode: false,

                form: this.$inertia.form({
                    idx: this.idx,
                    search: this.search,
                    has_description: this.hasDescription,
                    id: null,
                    name: null,
                    description: null,
                })
            }
        },

        methods: {
            searchRecord() {
                this.form.get(route('admin.parameter.list'))
            },

            clearSearchRecord() {
                this.form.search = null
                this.searchRecord()
            },

            closeModal() {
                this.isOpenModal = false
                this.isEditMode = false

                this.form.id = null
                this.form.name = null
                this.form.description = null

                this.form.clearErrors()
            },

            addRecord() {
                this.isOpenModal = true
            },

            editRecord(row) {
                Object.assign(this.form, row)

                this.isOpenModal = true
                this.isEditMode = true
            },

            saveRecord() {
                this.form.post(route('admin.parameter.save'), {
                    errorBag: 'parameterError',
                    preserveScroll: true,
                    onSuccess: () => {
                        this.closeModal()
                        this.showSuccessMessage('Saved')
                    }
                });
            }
        }
    })
</script>
