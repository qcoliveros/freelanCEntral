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
                <jet-textarea id="about" class="mt-1 block w-full" v-model="form.about" autocomplete="about" />
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
    import JetButton from '@/Jetstream/Button.vue'
    import JetFormSection from '@/Jetstream/FormSection.vue'
    import JetTextarea from '@/Jetstream/Textarea.vue'
    import JetInputError from '@/Jetstream/InputError.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import JetActionMessage from '@/Jetstream/ActionMessage.vue'

    export default defineComponent({
        components: {
            JetActionMessage,
            JetButton,
            JetFormSection,
            JetTextarea,
            JetInputError,
            JetLabel,
        },

        props: ['user'],

        data() {
            return {
                form: this.$inertia.form({
                    _method: 'POST',
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
