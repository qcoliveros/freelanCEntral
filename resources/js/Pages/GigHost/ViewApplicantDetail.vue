<template xmlns="http://www.w3.org/1999/html">
    <app-layout title="Gig Ads">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gig Applicant for {{ gigAd.job_title }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6">
                <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                    <div class="md:grid md:grid-cols-4 md:gap-2">
                        <div class="mt-5 md:mt-0 md:col-span-3">
                            <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 mr-3">
                                <img class="h-16 w-16 rounded-full object-cover" :src="applicant.profile_photo_url" :alt="applicant.name" />
                            </div>

                            <div class="mt-4 font-bold">
                                {{ applicant.name }}
                            </div>
                            <div class="text-sm">
                                {{ applicant.email }} | {{ applicant.phone }} ({{ applicant.phone_type.name }})
                            </div>
                            <div class="text-sm" v-if="applicant.website_url != null">
                                <Link :href="applicant.website_url">{{ applicant.website_url }}</Link>
                            </div>

                            <div class="mt-4" v-if="applicant.about != null">
                                <div v-html="applicant.about" />
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
    import { Link } from '@inertiajs/inertia-vue3'
    import AppLayout from '@/Layouts/AppLayout'
    import JetLabel from '@/Jetstream/Label.vue'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import moment from 'moment'

    export default defineComponent({
        components: {
            AppLayout,
            Link,
            JetLabel,
            JetSecondaryButton,
        },

        props: [
            'gigAd',
            'applicant'
        ],

        data() {
            return {
                moment: moment,

                form: this.$inertia.form({
                    id: this.gigAd.id,
                })
            }
        },

        methods: {
            cancel() {
                this.form.get(route('gigHost.gigApp.list'));
            },
        }
    })
</script>
