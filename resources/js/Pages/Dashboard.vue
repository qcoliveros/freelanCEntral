<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow sm:rounded-lg">
                    <div>
                        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                            <div class="mt-2 text-2xl flex">
                                <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 mr-3">
                                    <img class="h-10 w-10 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />
                                </div>
                                <jet-secondary-button @click="openPostModal" class="items-end">
                                    Start a post
                                </jet-secondary-button>
                            </div>
                        </div>
                    </div>
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
    import ToastMessage from '../../mixins/toast-message'

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
        },

        props: [ 'postList' ],

        data() {
            return {
                isOpenPostModal: false,

                form: this.$inertia.form({
                    id: null,
                    post_id: null,
                    message: null,
                    publish_date: null,
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
            }
        }
    })
</script>
