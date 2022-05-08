<template>
    <div class="md:grid md:grid-cols-4 md:gap-2">
        <div class="md:mt-0 md:col-span-3">
            <div>
                <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 mr-3">
                    <img class="h-14 w-14 rounded-full object-cover" :src="gigHost.profile_photo_url" :alt="gigHost.name" />
                </div>
                {{ gigHost.name }}
            </div>
            <div class="mt-4">
                <div v-html="modifyEmbeddedVideo(gigHost.about)" />
            </div>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from 'vue'
    import EmbeddedMedia from '../../../../mixins/embedded-media'
    import JetLabel from '@/Jetstream/Label.vue'

    export default defineComponent({
        mixins: [
            EmbeddedMedia,
        ],

        components: {
            JetLabel,
        },

        props: [ 'gigHost' ]
    })
</script>
