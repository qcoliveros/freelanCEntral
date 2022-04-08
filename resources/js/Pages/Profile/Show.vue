<template>
    <app-layout title="Profile">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Profile
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div v-if="$page.props.jetstream.canUpdateProfileInformation">
                    <update-profile-information-form :user="$page.props.user" />

                    <jet-section-border />

                    <update-about-form :user="$page.props.user" />
                </div>

                <div v-if="!$page.props.user.roles.includes('Administrator')">
                    <jet-section-border />

                    <manage-work-experience-form class="mt-10 sm:mt-0" :workExperiences="$page.props.user.workExperiences" />

                    <jet-section-border />

                    <manage-education-form class="mt-10 sm:mt-0" :educations="$page.props.user.educations" />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import JetSectionBorder from '@/Jetstream/SectionBorder.vue'
    import UpdateProfileInformationForm from '@/Pages/Profile/Partials/UpdateProfileInformationForm.vue'
    import UpdateAboutForm from '@/Pages/Profile/Partials/UpdateAboutForm.vue'
    import ManageWorkExperienceForm from "@/Pages/Profile/Partials/ManageWorkExperienceForm"
    import ManageEducationForm from "@/Pages/Profile/Partials/ManageEducationForm"

    export default defineComponent({
        props: ['sessions'],

        components: {
            AppLayout,
            JetSectionBorder,
            UpdateProfileInformationForm,
            UpdateAboutForm,
            ManageWorkExperienceForm,
            ManageEducationForm,
        },
    })
</script>
