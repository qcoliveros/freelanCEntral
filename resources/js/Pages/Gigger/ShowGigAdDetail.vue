<template>
    <app-layout title="Gig Ads">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gig Ad for {{ gigAd.job_title }}
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
                    <jet-button class="ml-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="applyGigAd">
                        Apply
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
            'search',
            'gigAd',
            'gigHost',
        ],

        data() {
            return {
                form: this.$inertia.form({
                    search: this.search,
                    gig_ad_id: this.gigAd.id,
                })
            }
        },

        methods: {
            cancel() {
                this.form.get(route('gigger.gigAd.find'))
            },

            applyGigAd() {
                this.form.post(route('gigger.gigAd.apply'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.closeGigAdModal()
                        this.showSuccessMessage('Application submitted')
                    },
                    onError: (errors) => {
                        this.showErrorMessage(errors.submitApplicationError)
                    }
                })
            }
        }
    })
</script>
