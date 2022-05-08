<template>
    <div class="md:grid md:grid-cols-4 md:gap-2">
        <div class="md:mt-0 md:col-span-3">
            <!-- Posted Date -->
            <div>
                <jet-label for="job_title" value="Posted Date" />
                {{ moment(gigAd.publish_date).format("DD MMM YYYY") }}
            </div>

            <!-- Description -->
            <div class="mt-4">
                <jet-label for="description" value="Job Description" />
                <div v-html="gigAd.description" />
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
</template>

<script>
    import { defineComponent } from 'vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import moment from 'moment'

    export default defineComponent({
        components: {
            JetLabel,
        },

        props: [ 'gigAd' ],

        data() {
            return {
                moment: moment,
            }
        }
    })
</script>
