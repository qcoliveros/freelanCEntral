<template>
    <app-layout title="Gigs">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Find Gig
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6">
                <div class="px-4 py-5 sm:p-6 bg-white shadow sm:rounded-lg">
                    Find me.
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import JetIcon from '@/Jetstream/Icon'

    export default defineComponent({
        components: {
            AppLayout,
            JetIcon,
        },

        props: [ 'gigAppList' ],

        data() {
            return {
                form: this.$inertia.form({
                    search: null,
                })
            }
        },
    })
</script>
