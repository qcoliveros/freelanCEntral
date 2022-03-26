<template>
    <welcome-layout title="Welcome" canLogin="canLogin" canRegister="canRegister">
        <div class="py-12">
            <div class="full-h-screen max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <div class="flex items-center justify-center mt-4">
                            <jet-icon name="gigger-icon" />
                        </div>
                        <div class="flex items-center justify-center mt-4">
                            <jet-icon name="gig-host-icon" />
                        </div>
                        <div class="text-xl leading-7 font-semibold text-center">Gigger</div>
                        <div class="text-xl leading-7 font-semibold text-center">Gig Host</div>
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="block h-8 w-auto"><jet-icon name="checkbox-icon" /></div>
                                <div class="ml-4 text-lg leading-7 font-semibold">fresh graduates interested in unpaid but enriching work experience</div>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="block h-8 w-auto"><jet-icon name="checkbox-icon" /></div>
                                <div class="ml-4 text-lg leading-7 font-semibold">graduate students who need help with projects/thesis</div>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="block h-8 w-auto"><jet-icon name="checkbox-icon" /></div>
                                <div class="ml-4 text-lg leading-7 font-semibold">mid-career professionals looking to gain experience for a career upgrade/switch</div>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="block h-8 w-auto"><jet-icon name="checkbox-icon" /></div>
                                <div class="ml-4 text-lg leading-7 font-semibold">managers who need support but don’t have budget to hire</div>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="block h-8 w-auto"><jet-icon name="checkbox-icon" /></div>
                                <div class="ml-4 text-lg leading-7 font-semibold">anyone with time to spare and keen to learn ‘on the job’ for free</div>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="block h-8 w-auto"><jet-icon name="checkbox-icon" /></div>
                                <div class="ml-4 text-lg leading-7 font-semibold">anyone with a personal project and keen to share relevant job skills for free</div>
                            </div>
                        </div>
                        <div class="p-6">
                            <Link :href="'/gigger/engagement-rules'">
                                <div class="mt-3 flex items-center text-sm font-semibold text-green-700">
                                    <div>Rules of Engagement</div>

                                    <div class="ml-1">
                                        <svg viewBox="0 0 20 20" fill="green" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                    </div>
                                </div>
                            </Link>
                        </div>
                        <div class="p-6">
                            <Link :href="'/gigHost/engagement-rules'">
                                <div class="mt-3 flex items-center text-sm font-semibold text-green-700">
                                    <div>Rules of Engagement</div>

                                    <div class="ml-1">
                                        <svg viewBox="0 0 20 20" fill="green" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                    </div>
                                </div>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </welcome-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import WelcomeLayout from "@/Layouts/WelcomeLayout"
    import JetIcon from '@/Jetstream/Icon'

    export default defineComponent({
        props: {
            canLogin: Boolean,
            canRegister: Boolean,
        },

        components: {
            Head,
            Link,
            WelcomeLayout,
            JetIcon,
        }
    })
</script>
