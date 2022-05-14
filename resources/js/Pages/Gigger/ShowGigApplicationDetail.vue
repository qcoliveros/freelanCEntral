<template>
    <app-layout title="Gig Applications">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gig Application for {{ gigAd.job_title }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6">
                <div class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                    <view-gig-ad-detail :gigAd="gigAd" />

                    <view-gig-host :gigHost="gigHost" />
                </div>

                <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                    <jet-secondary-button @click="cancel">
                        Cancel
                    </jet-secondary-button>
                    <jet-button class="ml-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                                @click="withdrawGigApp" v-if="!['Withdrawn', 'Rejected', 'Accepted'].includes(gigApp.status)">
                        Withdraw
                    </jet-button>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout'
    import JetButton from '@/Jetstream/Button'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import ToastMessage from '../../../mixins/toast-message'
    import ViewGigAdDetail from '@/Pages/Gigger/Partials/ViewGigAdDetail'
    import ViewGigHost from '@/Pages/Shared/ViewGigHost'

    export default defineComponent({
        mixins: [
            ToastMessage,
        ],

        components: {
            AppLayout,
            JetSecondaryButton,
            JetButton,
            ViewGigAdDetail,
            ViewGigHost,
        },

        props: [
            'gigApp',
            'gigAd',
            'gigHost',
        ],

        data() {
            return {
                form: this.$inertia.form({
                    id: this.gigApp.id,
                    gig_ad_id: this.gigAd.id,
                })
            }
        },

        methods: {
            cancel() {
                this.form.get(route('gigger.gigApp.list'))
            },

            withdrawGigApp() {
                this.form.post(route('gigger.gigApp.withdraw'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.showSuccessMessage('Application withdrawn')
                    },
                    onError: (errors) => {
                        this.showErrorMessage(errors.withdrawApplicationError)
                    }
                })
            }
        }
    })
</script>
