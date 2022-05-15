<template>
    <div class="md:grid md:grid-cols-4 md:gap-2">
        <div class="md:mt-0 md:col-span-3">
            <div>
                <jet-label value="Task Title" />
                <div class="font-medium">{{ gigTask.title }}</div>
            </div>
            <div class="mt-4">
                <jet-label value="Task Description" />
                <div class="font-medium" v-html="modifyEmbeddedVideo(gigTask.description)" />
            </div>
            <div class="mt-4">
                <jet-label value="Task Duration" />
                <span class="font-medium">{{ moment(gigTask.start_date).format("DD MMM YYYY") }} to {{ moment(gigTask.end_date).format("DD MMM YYYY") }}</span>
            </div>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from 'vue'
    import EmbeddedMedia from '../../../mixins/embedded-media'
    import JetLabel from '@/Jetstream/Label'
    import moment from 'moment'

    export default defineComponent({
        mixins: [
            EmbeddedMedia,
        ],

        components: {
            JetLabel,
        },

        props: [
            'gigTask'
        ],

        data() {
            return {
                moment: moment,
            }
        },
    })
</script>
