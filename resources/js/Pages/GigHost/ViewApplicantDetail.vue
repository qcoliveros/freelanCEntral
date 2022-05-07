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
                    <div class="md:grid md:grid-cols-5 md:gap-2">
                        <div class="md:mt-0 md:col-span-4">
                            <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 mr-3">
                                <img class="h-20 w-20 rounded-full object-cover" :src="applicant.profile_photo_url" :alt="applicant.name" />
                            </div>

                            <div class="mt-2 font-bold">
                                {{ applicant.name }}
                            </div>
                            <div class="text-sm">
                                {{ applicant.email }} <span v-if="applicant.phone != null">| {{ applicant.phone }} ({{ applicant.phone_type.name }})</span>
                            </div>
                            <div class="text-sm" v-if="applicant.website_url != null">
                                <Link :href="applicant.website_url">{{ applicant.website_url }}</Link>
                            </div>

                            <MDBAccordion v-model="activeItem" flush class="mt-4">
                                <MDBAccordionItem headerTitle="About" collapseId="profile-about">
                                    <div v-html="applicant.about" />
                                </MDBAccordionItem>

                                <MDBAccordionItem headerTitle="Work Experience" collapseId="work-experience">
                                    <table class="w-full table-auto">
                                        <thead>
                                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                            <th class="py-3 px-6 text-left">Title</th>
                                            <th class="py-3 px-6 text-left">Company</th>
                                            <th class="py-3 px-6 text-left">Duration</th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-gray-600 text-sm font-light">
                                        <tr class="border-b border-gray-200 hover:bg-gray-100" v-if="!!applicant.workExperiences && !applicant.workExperiences.length">
                                            <td class="py-3 px-6 text-left whitespace-nowrap">No records found.</td>
                                        </tr>
                                        <tr class="border-b border-gray-200" v-for="row in applicant.workExperiences">
                                            <td class="py-3 px-6 text-center">
                                                <div class="flex items-center">
                                                    <span class="font-medium">{{ row.title }}</span>
                                                </div>
                                            </td>
                                            <td class="py-3 px-6 text-center">
                                                <div class="flex items-center">
                                                    <span>{{ row.company_name }}</span>
                                                </div>
                                            </td>
                                            <td class="py-3 px-6 text-center">
                                                <div class="flex items-center">
                                                    <span v-if="!!row.end_date">{{ moment(row.start_date).format("MMM YYYY") }} to {{ moment(row.end_date).format("MMM YYYY") }}</span>
                                                    <span v-else>{{ moment(row.start_date).format("MMM YYYY") }} to Present</span>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </MDBAccordionItem>

                                <MDBAccordionItem headerTitle="Education" collapseId="education">
                                    <table class="w-full table-auto">
                                        <thead>
                                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                            <th class="py-3 px-6 text-left">School</th>
                                            <th class="py-3 px-6 text-left">Degree / Field</th>
                                            <th class="py-3 px-6 text-left">Duration</th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-gray-600 text-sm font-light">
                                        <tr class="border-b border-gray-200 hover:bg-gray-100" v-if="!!applicant.educations && !applicant.educations.length">
                                            <td class="py-3 px-6 text-left whitespace-nowrap">No records found.</td>
                                        </tr>
                                        <tr class="border-b border-gray-200 hover:bg-gray-100" v-for="row in applicant.educations">
                                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <span class="font-medium">{{ row.school }}</span>
                                                </div>
                                            </td>
                                            <td class="py-3 px-6 text-left">
                                                <div class="flex items-center">
                                                    <span>{{ row.degree }} {{ row.field }}</span>
                                                </div>
                                            </td>
                                            <td class="py-3 px-6 text-center">
                                                <div class="flex items-center">
                                                    <span v-if="!!row.end_date">{{ moment(row.start_date).format("MMM YYYY") }} to {{ moment(row.end_date).format("MMM YYYY") }}</span>
                                                    <span v-else>{{ moment(row.start_date).format("MMM YYYY") }} to -</span>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </MDBAccordionItem>

                                <MDBAccordionItem headerTitle="Technical Skill" collapseId="technical-skill">
                                    <table class="w-full table-auto">
                                        <thead>
                                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                            <th class="py-3 px-6 text-left">Skill</th>
                                            <th class="py-3 px-6 text-left">Proficiency</th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-gray-600 text-sm font-light">
                                        <tr class="border-b border-gray-200 hover:bg-gray-100" v-if="!!applicant.technicalSkills && !applicant.technicalSkills.length">
                                            <td class="py-3 px-6 text-left whitespace-nowrap">No records found.</td>
                                        </tr>
                                        <tr class="border-b border-gray-200 hover:bg-gray-100" v-for="row in applicant.technicalSkills">
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
                                        </tr>
                                        </tbody>
                                    </table>
                                </MDBAccordionItem>

                                <MDBAccordionItem headerTitle="Soft Skill" collapseId="soft-skill">
                                    <table class="w-full table-auto">
                                        <thead>
                                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                            <th class="py-3 px-6 text-left">Skill</th>
                                            <th class="py-3 px-6 text-left">Proficiency</th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-gray-600 text-sm font-light">
                                        <tr class="border-b border-gray-200 hover:bg-gray-100" v-if="!!applicant.softSkills && !applicant.softSkills.length">
                                            <td class="py-3 px-6 text-left whitespace-nowrap">No records found.</td>
                                        </tr>
                                        <tr class="border-b border-gray-200 hover:bg-gray-100" v-for="row in applicant.softSkills">
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
                                        </tr>
                                        </tbody>
                                    </table>
                                </MDBAccordionItem>

                                <MDBAccordionItem headerTitle="Language" collapseId="language">
                                    <table class="w-full table-auto">
                                        <thead>
                                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                            <th class="py-3 px-6 text-left">Language</th>
                                            <th class="py-3 px-6 text-left">Speaking Proficiency</th>
                                            <th class="py-3 px-6 text-left">Writing Proficiency</th>
                                            <th class="py-3 px-6 text-left">Reading Proficiency</th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-gray-600 text-sm font-light">
                                        <tr class="border-b border-gray-200 hover:bg-gray-100" v-if="!!applicant.languages && !applicant.languages.length">
                                            <td class="py-3 px-6 text-left whitespace-nowrap">No records found.</td>
                                        </tr>
                                        <tr class="border-b border-gray-200 hover:bg-gray-100" v-for="row in applicant.languages">
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
                                        </tr>
                                        </tbody>
                                    </table>
                                </MDBAccordionItem>

                            </MDBAccordion>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                    <jet-secondary-button @click="cancel">
                        Cancel
                    </jet-secondary-button>
                    <jet-button v-if="gigAd.close_date == null && gigApp.status === 'Submitted'"
                                class="ml-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="reject">
                        Reject
                    </jet-button>
                    <jet-button v-if="gigAd.close_date == null && gigApp.status === 'Submitted'"
                                class="ml-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="shortlist">
                        Shortlist
                    </jet-button>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent, ref } from 'vue'
    import { Link } from '@inertiajs/inertia-vue3'
    import AppLayout from '@/Layouts/AppLayout'
    import JetButton from '@/Jetstream/Button'
    import JetLabel from '@/Jetstream/Label.vue'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import { MDBAccordion, MDBAccordionItem } from "mdb-vue-ui-kit"
    import moment from 'moment'
    import ToastMessage from "../../../mixins/toast-message"

    export default defineComponent({
        mixins: [ ToastMessage ],

        components: {
            AppLayout,
            Link,
            JetButton,
            JetLabel,
            JetSecondaryButton,
            MDBAccordion,
            MDBAccordionItem,
        },

        props: [
            'gigAd',
            'gigApp',
            'applicant'
        ],

        data() {
            return {
                moment: moment,

                form: this.$inertia.form({
                    id: this.gigAd.id,
                    gig_app_id: this.gigApp.id,
                    user_id: this.applicant.id,
                })
            }
        },

        setup(){
            const activeItem = ref('profile-about');
            return {
                activeItem
            }
        },

        methods: {
            cancel() {
                this.form.get(route('gigHost.gigApp.list'));
            },

            reject() {
                this.form.post(route('gigHost.gigApplicant.reject'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.showSuccessMessage('Rejected')
                    }
                });
            },

            shortlist() {
                this.form.post(route('gigHost.gigApplicant.shortlist'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.showSuccessMessage('Shortlisted')
                    }
                });
            }
        }
    })
</script>
