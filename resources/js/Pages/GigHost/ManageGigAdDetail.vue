<template>
    <app-layout title="Gig Ads">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <span v-if="$page.props.isEdit">Update Gig Ad</span>
                <span v-else>Create Gig Ad</span>
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6">
                <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                    <div class="md:grid md:grid-cols-4 md:gap-2">
                        <div class="mt-5 md:mt-0 md:col-span-3">
                            <!-- Job Title -->
                            <div>
                                <jet-label for="job_title" value="Job Title" />
                                <jet-input id="job_title" type="text" class="mt-1 block w-full" v-model="form.job_title" autocomplete="job_title" />
                                <jet-input-error :message="form.errors.job_title" class="mt-2" />
                            </div>

                            <!-- Description -->
                            <div class="mt-4">
                                <jet-label for="description" value="Job Description" />
                                <jet-textarea id="description" class="mt-1 block w-full" v-model="form.description" autocomplete="description" />
                                <jet-input-error :message="form.errors.description" class="mt-2" />
                            </div>

                            <!-- Job Function -->
                            <div class="mt-4">
                                <jet-label for="job_function_id" value="Job Function" />
                                <multiselect id="job_function_id" v-model="form.job_function_id" :options="$page.props.parameter.jobFunctions" :searchable="true" />
                                <jet-input-error :message="form.errors.job_function_id" class="mt-2" />
                            </div>

                            <!-- Other Job Function -->
                            <div class="mt-4" v-if="form.job_function_id == '22'">
                                <jet-label for="other_job_function" value="Others (please specify)" />
                                <jet-input id="other_job_function" type="text" class="mt-1 block w-full" v-model="form.other_job_function" autocomplete="other_job_function" />
                                <jet-input-error :message="form.errors.other_job_function" class="mt-2" />
                            </div>

                            <!-- Commitment Time -->
                            <div class="mt-4">
                                <jet-label value="Time Commitment Required (hours per week)" />
                                <jet-input id="commitment_time" type="text" class="mt-1 block w-full" v-model="form.commitment_time" autocomplete="commitment_time" />
                                <jet-input-error :message="form.errors.commitment_time" class="mt-2" />
                            </div>

                            <!-- Job Duration -->
                            <div class="mt-4">
                                <jet-label value="Job Duration" />
                                <div class="flex flex-row gap-2">
                                    <date-picker v-model:value="form.job_start_date" value-type="YYYY-MM-DD" format="DD/MM/YYYY" placeholder="Start Date" />
                                    <date-picker v-model:value="form.job_end_date" value-type="YYYY-MM-DD" format="DD/MM/YYYY" placeholder="End Date" />
                                </div>
                                <jet-input-error :message="form.errors.job_start_date" class="mt-2" />
                                <jet-input-error :message="form.errors.job_end_date" class="mt-2" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                    <jet-secondary-button class="mr-2" @click="cancel">
                        Cancel
                    </jet-secondary-button>
                    <jet-button v-if="form.publish_date === null" class="mr-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="saveRecord">
                        Save as Draft
                    </jet-button>
                    <jet-button v-else class="mr-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="closeRecord">
                        Close
                    </jet-button>
                    <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="publishRecord">
                        <span v-if="form.publish_date === null">Publish</span>
                        <span v-else>Republish</span>
                    </jet-button>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import DatePicker from 'vue-datepicker-next'
    import JetButton from '@/Jetstream/Button.vue'
    import JetCheckbox from "@/Jetstream/Checkbox"
    import JetInput from '@/Jetstream/Input.vue'
    import JetInputError from '@/Jetstream/InputError.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
    import JetTextarea from '@/Jetstream/Textarea.vue'
    import Multiselect from "@vueform/multiselect"
    import ToastMessage from "../../../mixins/toast-message"

    export default defineComponent({
        mixins: [ ToastMessage ],

        components: {
            AppLayout,
            DatePicker,
            JetButton,
            JetCheckbox,
            JetInput,
            JetInputError,
            JetLabel,
            JetSecondaryButton,
            JetTextarea,
            Multiselect,
        },

        props: [ 'gigAd' ],

        data() {
            return {
                form: this.$inertia.form({
                    id: this.gigAd ? this.gigAd.id : null,
                    job_title: this.gigAd ? this.gigAd.job_title : null,
                    description: this.gigAd ? this.gigAd.description : null,
                    job_function_id: this.gigAd ? this.gigAd.job_function_id : null,
                    other_job_function: this.gigAd ? this.gigAd.other_job_function : null,
                    commitment_time: this.gigAd ? this.gigAd.commitment_time : null,
                    commitment_duration: this.gigAd ? this.gigAd.commitment_duration : null,
                    job_start_date: this.gigAd ? this.gigAd.job_start_date : null,
                    job_end_date: this.gigAd ? this.gigAd.job_end_date : null,
                    is_draft: this.gigAd ? this.gigAd.is_draft : null,
                    publish_date: this.gigAd ? this.gigAd.publish_date : null,
                    close_date: this.gigAd ? this.gigAd.close_date : null,
                })
            }
        },

        methods: {
            cancel() {
                this.form.get(route('gigHost.gigAd.list'));
            },

            saveRecord() {
                this.form.post(route('gigHost.gigAd.save'), {
                    errorBag: 'gigError',
                    preserveScroll: true,
                    onSuccess: () => {
                        this.showSuccessMessage('Saved')
                    }
                });
            },

            publishRecord() {
                this.form.post(route('gigHost.gigAd.publish'), {
                    errorBag: 'gigError',
                    preserveScroll: true,
                    onSuccess: () => {
                        this.showSuccessMessage('Published')
                    }
                });
            },

            closeRecord() {
                this.form.post(route('gigHost.gigAd.close'), {
                    errorBag: 'gigError',
                    preserveScroll: true,
                    onSuccess: () => {
                        this.showSuccessMessage('Closed')
                    }
                });
            }
        }
    })
</script>
