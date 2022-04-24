<template xmlns="http://www.w3.org/1999/html">
    <jet-form-section @submitted="updateAboutInformation">
        <template #title>
            About
        </template>

        <template #description>
            Update your account's summary information.
        </template>

        <template #form>
            <!-- About -->
            <div class="col-span-6 sm:col-span-4">
                <jet-rich-text-editor class="mt-1 block w-full" v-model="form.about" />
                <jet-input-error :message="form.errors.about" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </jet-action-message>

            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
    import { defineComponent } from 'vue'
    import JetActionMessage from '@/Jetstream/ActionMessage'
    import JetButton from '@/Jetstream/Button'
    import JetFormSection from '@/Jetstream/FormSection'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'
    import JetRichTextEditor from '@/Jetstream/RichTextEditor'

    export default defineComponent({
        components: {
            JetActionMessage,
            JetButton,
            JetFormSection,
            JetRichTextEditor,
            JetInputError,
            JetLabel,
        },

        props: ['user'],

        data() {
            return {
                form: this.$inertia.form({
                    about: this.user.about,
                }),
            }
        },

        methods: {
            updateAboutInformation() {
                this.form.post(route('user-about-information.update'), {
                    errorBag: 'updateAboutInformation',
                    preserveScroll: true,
                });
            },
        },
    })
</script>
