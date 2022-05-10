<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ gigHost.name }} Page
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow sm:rounded-tl-md sm:rounded-tr-md">
                    <div>
                        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                            <view-gig-host :show-label="false" :gigHost="gigHost" />
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md">
                    <jet-secondary-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                                          @click="unfollow" v-if="isFollowing">
                        Unfollow
                    </jet-secondary-button>
                    <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                                @click="follow" v-else>
                        Follow
                    </jet-button>
                </div>

                <manage-user-post :post-list="postList" />
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import JetButton from '@/Jetstream/Button'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import ManageUserPost from '@/Pages/Shared/ManageUserPost'
    import ViewGigHost from '@/Pages/Shared/ViewGigHost'
    import ToastMessage from '../../../mixins/toast-message'

    export default defineComponent({
        mixins: [
            ToastMessage
        ],

        components: {
            AppLayout,
            JetButton,
            JetSecondaryButton,
            ManageUserPost,
            ViewGigHost,
        },

        props: [
            'isFollowing',
            'gigHost',
            'postList',
        ],

        data() {
            return {
                form: this.$inertia.form({
                    user_id: this.gigHost.id,
                })
            }
        },

        methods: {
            follow() {
                this.form.post(route('user-page.follow'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.showSuccessMessage('You are now following the user.')
                    },
                    onError: (errors) => {
                        this.showErrorMessage(errors.followUserError)
                    }
                })
            },

            unfollow() {
                this.form.post(route('user-page.unfollow'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.showSuccessMessage('You are not following the user anymore.')
                    },
                    onError: (errors) => {
                        this.showErrorMessage(errors.unfollowUserError)
                    }
                })
            }
        }
    })
</script>
