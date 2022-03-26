<template>
    <welcome-layout title="Welcome" canLogin="canLogin" canRegister="canRegister">
        <div class="py-12">
            <div class="full-h-screen max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-1">
                        <div class="mt-4 text-xl leading-7 font-semibold text-center">Rules of Engagement (Gig Host)</div>
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="block h-8 w-auto"><jet-icon name="checkbox-icon" /></div>
                                <div class="ml-4 text-lg leading-7 font-semibold">
                                    <strong>No to Money and formal Contracts</strong> – do not ask for or give any monetary or non-monetary compensation to the Gigger
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="block h-8 w-auto"><jet-icon name="checkbox-icon" /></div>
                                <div class="ml-4 text-lg leading-7 font-semibold">
                                    Be <strong>Generous</strong> with your <strong>Time</strong> and <strong>Skills</strong> – make the experience extra meaningful by guiding and coaching your Gigger to learn valuable skills
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="block h-8 w-auto"><jet-icon name="checkbox-icon" /></div>
                                <div class="ml-4 text-lg leading-7 font-semibold">
                                    Write an excellent Gig certification and Gigger review – to help your Gigger use the experience to find a relevant job
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <Link :href="'/../gig-master-tips'">
                                <div class="mt-3 flex items-center text-sm font-semibold text-green-700">
                                    <div>Tips</div>

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
import { Head, Link } from '@inertiajs/inertia-vue3';
import WelcomeLayout from "@/Layouts/WelcomeLayout";
import JetIcon from "@/Jetstream/Icon"

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
