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
                                          @click="unfollow" v-if="!isOwn && isFollowing">
                        Unfollow
                    </jet-secondary-button>
                    <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                                @click="follow" v-else-if="!isOwn && !isFollowing">
                        Follow
                    </jet-button>
                    <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                                @click="openPostModal" v-else>
                        Post
                    </jet-button>
                </div>

                <manage-user-post :post-list="postList" />

                <jet-dialog-modal :show="isOpenPostModal" @close="closePostModal">
                    <template #title>
                        Create a post
                    </template>

                    <template #content>
                        <div class="mb-4">
                            <jet-label for="message" value="Message" />
                            <jet-rich-text-editor class="mt-1 block w-full" v-model="form.message" />
                            <jet-input-error :message="form.errors.message" class="mt-2" />
                        </div>
                    </template>

                    <template #footer>
                        <jet-secondary-button @click="closePostModal">
                            Cancel
                        </jet-secondary-button>

                        <jet-button class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="publishPost">
                            Post
                        </jet-button>
                    </template>
                </jet-dialog-modal>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import JetButton from '@/Jetstream/Button'
    import JetDialogModal from '@/Jetstream/DialogModal'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'
    import JetRichTextEditor from '@/Jetstream/RichTextEditor'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import ManageUserPost from '@/Pages/Shared/ManageUserPost'
    import ToastMessage from '../../../mixins/toast-message'
    import ViewGigHost from '@/Pages/Shared/ViewGigHost'

    export default defineComponent({
        mixins: [
            ToastMessage
        ],

        components: {
            AppLayout,
            JetButton,
            JetDialogModal,
            JetInputError,
            JetLabel,
            JetRichTextEditor,
            JetSecondaryButton,
            ManageUserPost,
            ViewGigHost,
        },

        props: [
            'isOwn',
            'isFollowing',
            'gigHost',
            'postList',
        ],

        data() {
            return {
                isOpenPostModal: false,

                form: this.$inertia.form({
                    id: null,
                    post_id: null,
                    message: null,
                    user_id: this.gigHost.id,
                })
            }
        },

        methods: {
            openPostModal() {
                this.isOpenPostModal = true
            },

            closePostModal() {
                this.isOpenPostModal = false
                this.form.reset()
                this.form.clearErrors()
            },

            publishPost() {
                this.form.post(route('post.publish'), {
                    errorBag: 'postError',
                    preserveScroll: true,
                    onSuccess: () => {
                        this.closePostModal()
                        this.showSuccessMessage('Published')
                    }
                });
            },

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
