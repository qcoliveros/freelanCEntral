<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div>
                        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                            <div class="mt-2 text-2xl flex">
                                <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 mr-3" >
                                    <img class="h-10 w-10 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />
                                </div>
                                <jet-secondary-button @click="openDetailModal" class="items-end">
                                    Start a post
                                </jet-secondary-button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-4" v-for="post in postList.data">
                    <div>
                        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                            <div class="mt-2 flex flex-row">
                                <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 mr-3" >
                                    <img class="h-15 w-15 rounded-full object-cover" :src="post.user.profile_photo_url" :alt="post.user.name" />
                                </div>
                                <div>
                                    <div class="font-bold">{{ post.user.name }}</div>
                                    <div class="text-sm">{{ moment(post.publish_date).format("DD MMM YYYY") }}</div>
                                </div>
                            </div>
                            <div class="mt-4" v-html="modifyEmbeddedVideo(post.message)" />

                            <jet-section-border />

                            <div class="flex flex-row">
                                <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 mr-3 flex-none">
                                    <img class="h-10 w-10 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />
                                </div>
                                <div class="flex-1">
                                    <jet-rich-text-editor class="mt-1 block w-full" v-model="form.comment" />
                                    <jet-input-error :message="form.errors.comment" class="mt-2" />
                                </div>
                                <div class="flex-none">
                                    <jet-button class="ml-2" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="publishComment(post.id)">
                                        Post
                                    </jet-button>
                                </div>
                            </div>

                            <div class="mt-4 flex flex-row" v-for="comment in post.comments">
                                <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 mr-3">
                                    <img class="h-10 w-10 rounded-full object-cover" :src="comment.user.profile_photo_url" :alt="comment.user.name" />
                                </div>
                                <div class="flex flex-col bg-gray-100 sm:rounded-lg p-2 w-full">
                                    <div class="font-bold">{{ comment.user.name }}</div>
                                    <div class="text-sm">{{ moment(comment.publish_date).format("DD MMM YYYY") }}</div>
                                    <div class="mt-4" v-html="modifyEmbeddedVideo(comment.comment)" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <jet-pagination :links="postList.links" />

                <jet-dialog-modal :show="isOpenDetailModal" @close="closeDetailModal">
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
                        <jet-secondary-button @click="closeDetailModal">
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
    import JetButton from "@/Jetstream/Button"
    import JetDialogModal from '@/Jetstream/DialogModal'
    import JetInput from "@/Jetstream/Input"
    import JetInputError from "@/Jetstream/InputError"
    import JetLabel from "@/Jetstream/Label"
    import JetRichTextEditor from "@/Jetstream/RichTextEditor"
    import JetPagination from '@/Jetstream/Pagination'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
    import JetSectionBorder from "@/Jetstream/SectionBorder"
    import EmbeddedMedia from "../../mixins/embedded-media"
    import moment from "moment"
    import ToastMessage from "../../mixins/toast-message"

    export default defineComponent({
        mixins: [
            EmbeddedMedia,
            ToastMessage
        ],

        components: {
            AppLayout,
            JetButton,
            JetDialogModal,
            JetInput,
            JetInputError,
            JetLabel,
            JetPagination,
            JetRichTextEditor,
            JetSecondaryButton,
            JetSectionBorder,
        },

        props: [
            'postList',
        ],

        data() {
            return {
                moment: moment,

                isOpenDetailModal: false,

                form: this.$inertia.form({
                    id: null,
                    message: null,
                    comment: null,
                    publish_date: null,
                })
            }
        },

        methods: {
            openDetailModal() {
                this.isOpenDetailModal = true
            },

            closeDetailModal() {
                this.isOpenDetailModal = false
                this.form.reset()
                this.form.clearErrors()
            },

            publishPost() {
                this.form.post(route('post.publish'), {
                    errorBag: 'postError',
                    preserveScroll: true,
                    onSuccess: () => {
                        this.closeDetailModal()
                        this.showSuccessMessage('Published')
                    }
                });
            },

            publishComment(postId) {
                this.form.id = postId
                this.form.post(route('post-comment.publish'), {
                    errorBag: 'postCommentError',
                    preserveScroll: true,
                    onSuccess: () => {
                        this.form.reset()
                        this.showSuccessMessage('Published')
                    }
                });
            }
        }
    })
</script>
