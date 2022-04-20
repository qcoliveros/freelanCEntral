<template>
    <app-layout title="Gig Ads">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                View Gig Ad
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
                                {{ gigAd.job_title }}
                            </div>

                            <!-- Description -->
                            <div class="mt-4">
                                <jet-label for="description" value="Job Description" />
                                {{ gigAd.job_function.name }}
                            </div>

                            <!-- Job Function -->
                            <div class="mt-4">
                                <jet-label for="job_function_id" value="Job Function" />
                                {{ gigAd.job_function.name }}
                            </div>

                            <!-- Other Job Function -->
                            <div class="mt-4" v-if="gigAd.job_function_id == '22'">
                                <jet-label for="other_job_function" value="Others (please specify)" />
                                {{ gigAd.other_job_function }}
                            </div>

                            <!-- Commitment Time -->
                            <div class="mt-4">
                                <jet-label value="Time Commitment Required (hours per week)" />
                                {{ gigAd.commitment_time }}
                            </div>

                            <!-- Job Duration -->
                            <div class="mt-4">
                                <jet-label value="Job Duration" />
                                {{ moment(gigAd.job_start_date).format("DD MMM YYYY") }} to {{ moment(gigAd.job_end_date).format("DD MMM YYYY") }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                    <jet-secondary-button @click="cancel">
                        Cancel
                    </jet-secondary-button>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import JetLabel from '@/Jetstream/Label.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import moment from "moment";

export default defineComponent({
    components: {
        AppLayout,
        JetLabel,
        JetSecondaryButton,
    },

    props: {
        gigAd: Object,
    },

    data() {
        return {
            moment: moment,

            form: this.$inertia.form({
                _method: 'POST',
                id: null,
            })
        }
    },

    methods: {
        cancel() {
            this.form.get(route('gigHost.gigAd.list'));
        },
    }
})
</script>
