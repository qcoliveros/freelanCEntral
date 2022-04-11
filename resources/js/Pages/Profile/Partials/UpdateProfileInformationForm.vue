<template xmlns="http://www.w3.org/1999/html">
    <jet-form-section @submitted="updateProfileInformation">
        <template #title>
            Profile Information
        </template>

        <template #description>
            Update your account's profile information.
        </template>

        <template #form>
            <!-- Profile Photo -->
            <div class="col-span-6 sm:col-span-5" v-if="$page.props.jetstream.managesProfilePhotos">
                <!-- Profile Photo File Input -->
                <input type="file" class="hidden" ref="photo"
                       @change="updatePhotoPreview">

                <!-- Current Profile Photo -->
                <div class="mt-2" v-show="! photoPreview">
                    <img :src="user.profile_photo_url" :alt="user.name" class="rounded-full h-30 w-30 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" v-show="photoPreview">
                    <span class="block rounded-full w-30 h-30 bg-cover bg-no-repeat bg-center"
                          :style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <div class="flex flex-row">
                    <jet-icon name="add-icon" tooltip="Add Photo" @click.prevent="selectNewPhoto" />
                    <jet-icon name="delete-icon" tooltip="Remove Photo" @click.prevent="deletePhoto" />
                </div>

                <jet-input-error :message="form.errors.photo" class="mt-2" />
            </div>

            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="name" value="Name" />
                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autocomplete="name" />
                <jet-input-error :message="form.errors.name" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="email" value="Email" />
                <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" />
                <jet-input-error :message="form.errors.email" class="mt-2" />
            </div>

            <!-- Phone -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="phone" value="Phone" />
                <div class="flex flex-row gap-2">
                    <jet-input id="phone" type="text" class="mt-1 block w-full" v-model="form.phone" />
                    <multiselect id="phone_type" v-model="form.phone_type" :options="$page.props.parameter.phoneTypes" :searchable="true" />
                </div>
                <jet-input-error :message="form.errors.phone" class="mt-2" />
                <jet-input-error :message="form.errors.phone_type" class="mt-2" />
            </div>

            <!-- Messenger -->
            <div v-if="roles.includes('Gigger')" class="col-span-6 sm:col-span-4">
                <jet-label for="messenger" value="Messenger" />
                <div class="flex flex-row gap-2">
                    <jet-input id="messenger" type="text" class="mt-1 block w-full" v-model="form.messenger" />
                    <multiselect id="messenger_type" v-model="form.messenger_type" :options="$page.props.parameter.messengerTypes" :searchable="true" />
                </div>
                <jet-input-error :message="form.errors.messenger" class="mt-2" />
                <jet-input-error :message="form.errors.messenger_type" class="mt-2" />
            </div>

            <!-- LinkedIn URL -->
            <div v-if="!roles.includes('Administrator')" class="col-span-6 sm:col-span-4">
                <jet-label v-if="roles.includes('Gigger')" for="website_url" value="LinkedIn URL" />
                <jet-label v-else for="website_url" value="Website" />
                <jet-input id="website_url" type="text" class="mt-1 block w-full" v-model="form.website_url" autocomplete="website_url" />
                <jet-input-error :message="form.errors.website_url" class="mt-2" />
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
import JetInput from '@/Jetstream/Input.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetLabel from '@/Jetstream/Label.vue'
import JetActionMessage from '@/Jetstream/ActionMessage.vue'
import JetIcon from '@/Jetstream/Icon.vue'
import Multiselect from "@vueform/multiselect"

export default defineComponent({
    components: {
        JetActionMessage,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
        JetIcon,
        Multiselect,
    },

    props: [
        'user',
        'roles'
    ],

    data() {
        return {
            form: this.$inertia.form({
                _method: 'PUT',
                photo: null,
                name: this.user.name,
                email: this.user.email,
                phone: this.user.phone,
                phone_type: this.user.phone_type,
                messenger: this.user.messenger,
                messenger_type: this.user.messenger_type,
                website_url: this.user.website_url,
            }),

            photoPreview: null,
        }
    },

    methods: {
        updateProfileInformation() {
            if (this.$refs.photo) {
                this.form.photo = this.$refs.photo.files[0]
            }

            this.form.post(route('user-profile-information.update'), {
                errorBag: 'updateProfileInformation',
                preserveScroll: true,
                onSuccess: () => (this.clearPhotoFileInput()),
            });
        },

        selectNewPhoto() {
            this.$refs.photo.click();
        },

        updatePhotoPreview() {
            const photo = this.$refs.photo.files[0];

            if (! photo) return;

            const reader = new FileReader();

            reader.onload = (e) => {
                this.photoPreview = e.target.result;
            };

            reader.readAsDataURL(photo);
        },

        deletePhoto() {
            this.$inertia.delete(route('current-user-photo.destroy'), {
                preserveScroll: true,
                onSuccess: () => {
                    this.photoPreview = null;
                    this.clearPhotoFileInput();
                },
            });
        },

        clearPhotoFileInput() {
            if (this.$refs.photo?.value) {
                this.$refs.photo.value = null;
            }
        },
    },
})
</script>
