<template>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-4" v-for="post in postList.data">
        <div>
            <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                <div class="mt-2 flex flex-row">
                    <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 mr-3">
                        <img class="h-15 w-15 rounded-full object-cover" :src="post.user.profile_photo_url" :alt="post.user.name" />
                    </div>
                    <div>
                        <div class="font-bold">{{ post.user.name }}</div>
                        <div class="text-xs inline-flex align-top">
                            {{ moment(post.publish_date).format("DD MMM YYYY") }} | {{ post.likes_count }}&nbsp;<jet-icon name="like-icon-sm" />
                        </div>
                    </div>
                </div>
                <div class="mt-4" v-html="modifyEmbeddedVideo(post.message)" />

                <jet-section-border />

                <div class="flex" v-if="!$page.props.user.roles.includes('Administrator')">
                    <jet-responsive-nav-link as="button" @click="likePost(post)" v-if="!post.like_indicator">
                        <span class="inline-flex align-middle"><jet-icon name="like-icon" />&nbsp;Like</span>
                    </jet-responsive-nav-link>
                    <jet-responsive-nav-link as="button" @click="unlikePost(post)" v-else>
                        <span class="inline-flex align-middle"><jet-icon name="like-icon" />&nbsp;Unlike</span>
                    </jet-responsive-nav-link>
                    <jet-responsive-nav-link as="button" @click="openCommentModal(post)">
                        <span class="inline-flex align-middle"><jet-icon name="chat-icon" />&nbsp;Comment</span>
                    </jet-responsive-nav-link>
                </div>

                <div class="mt-4 flex flex-row" v-for="comment in post.comments">
                    <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 mr-3">
                        <img class="h-10 w-10 rounded-full object-cover" :src="comment.user.profile_photo_url" :alt="comment.user.name" />
                    </div>
                    <div class="flex flex-col bg-gray-100 sm:rounded-lg p-2 w-full">
                        <div class="font-bold">{{ comment.user.name }}</div>
                        <div class="text-xs">{{ moment(comment.publish_date).format("DD MMM YYYY") }}</div>
                        <div class="mt-4" v-html="modifyEmbeddedVideo(comment.message)" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <jet-pagination :links="postList.links" />

    <jet-dialog-modal :show="isOpenCommentModal" @close="closeCommentModal">
        <template #title>
            Add comment
        </template>

        <template #content>
            <div class="mb-4">
                <jet-label for="message" value="Message" />
                <jet-rich-text-editor class="mt-1 block w-full" v-model="form.message" />
                <jet-input-error :message="form.errors.message" class="mt-2" />
            </div>
        </template>

        <template #footer>
            <jet-secondary-button @click="closeCommentModal">
                Cancel
            </jet-secondary-button>

            <jet-button class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" @click="publishComment">
                Post
            </jet-button>
        </template>
    </jet-dialog-modal>
</template>

<script>
    import { defineComponent } from 'vue'
    import EmbeddedMedia from '../../../mixins/embedded-media'
    import JetButton from '@/Jetstream/Button'
    import JetDialogModal from '@/Jetstream/DialogModal'
    import JetIcon from '@/Jetstream/Icon'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'
    import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink'
    import JetRichTextEditor from '@/Jetstream/RichTextEditor'
    import JetPagination from '@/Jetstream/Pagination'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    import JetSectionBorder from '@/Jetstream/SectionBorder'
    import moment from 'moment'
    import ToastMessage from '../../../mixins/toast-message'

    export default defineComponent({
        mixins: [
            EmbeddedMedia,
            ToastMessage
        ],

        components: {
            JetButton,
            JetDialogModal,
            JetIcon,
            JetInputError,
            JetLabel,
            JetPagination,
            JetResponsiveNavLink,
            JetRichTextEditor,
            JetSecondaryButton,
            JetSectionBorder,
        },

        props: [ 'postList' ],

        data() {
            return {
                moment: moment,

                isOpenCommentModal: false,

                form: this.$inertia.form({
                    id: null,
                    post_id: null,
                    message: null,
                })
            }
        },

        methods: {
            openCommentModal(post) {
                this.isOpenCommentModal = true
                this.form.post_id = post.id
            },

            closeCommentModal() {
                this.isOpenCommentModal = false
                this.form.reset()
                this.form.clearErrors()
            },

            publishComment() {
                this.form.post(route('post-comment.publish'), {
                    errorBag: 'postCommentError',
                    preserveScroll: true,
                    onSuccess: () => {
                        this.closeCommentModal()
                        this.showSuccessMessage('Published')
                    }
                });
            },

            likePost(post) {
                this.form.post_id = post.id
                this.form.post(route('post.like'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.showSuccessMessage('Liked')
                    }
                });
            },

            unlikePost(post) {
                this.form.post_id = post.id
                this.form.post(route('post.unlike'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.showSuccessMessage('Unliked')
                    }
                });
            }
        }
    })
</script>
