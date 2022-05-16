<template>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-4" v-if="!['Draft','Closed'].includes(gigTask.status)">
        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
            <div class="mt-2 text-2xl flex">
                <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 mr-3">
                    <img class="h-10 w-10 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />
                </div>
                <jet-secondary-button @click="openCommentModal(null)" class="items-end">
                    Add Comment
                </jet-secondary-button>
            </div>
        </div>
    </div>
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mt-4" v-for="taskComment in gigTaskComments">
        <div>
            <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                <div class="mt-2 flex flex-row">
                    <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 mr-3">
                        <img class="h-10 w-10 rounded-full object-cover" :src="taskComment.user.profile_photo_url" :alt="taskComment.user.name" />
                    </div>
                    <div>
                        <div class="font-bold">{{ taskComment.user.name }}</div>
                        <div class="text-xs inline-flex align-top">
                            {{ moment(taskComment.publish_date).format("DD MMM YYYY") }}
                        </div>
                    </div>
                </div>
                <div class="mt-4" v-html="modifyEmbeddedVideo(taskComment.message)" />

                <jet-section-border />

                <div class="flex" v-if="!['Draft','Closed'].includes(gigTask.status)">
                    <jet-responsive-nav-link as="button" @click="openCommentModal(taskComment.id)">
                        <span class="inline-flex align-middle"><jet-icon name="chat-icon" />&nbsp;Comment</span>
                    </jet-responsive-nav-link>
                </div>

                <div class="mt-4 flex flex-row" v-for="comment in taskComment.comments">
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
            JetResponsiveNavLink,
            JetRichTextEditor,
            JetSecondaryButton,
            JetSectionBorder,
        },

        props: [
            'gigPlaybook',
            'gigTask',
            'gigTaskComments'
        ],

        data() {
            return {
                moment: moment,

                isOpenCommentModal: false,

                form: this.$inertia.form({
                    id: this.gigPlaybook.id,
                    task_id: this.gigTask.id,
                    comment_id: null,
                    message: null,
                })
            }
        },

        methods: {
            openCommentModal(commentId) {
                this.isOpenCommentModal = true
                this.form.comment_id = commentId
            },

            closeCommentModal() {
                this.isOpenCommentModal = false
                this.form.comment_id = null
                this.form.message = null
                this.form.clearErrors()
            },

            publishComment() {
                console.log('id ' + this.form.comment_id)
                this.form.post(route('gig-task-comment.publish'), {
                    errorBag: 'gigPlaybookTaskCommentError',
                    preserveScroll: true,
                    onSuccess: () => {
                        this.closeCommentModal()
                        this.showSuccessMessage('Published')
                    }
                });
            }
        }
    })
</script>
