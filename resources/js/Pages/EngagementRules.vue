<template>
    <welcome-layout title="Welcome" canLogin="canLogin" canRegister="canRegister">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-1">
                        <div class="mt-4 text-xl leading-7 font-semibold text-center">Rules of Engagement</div>
                        <div class="p-6">
                            <div class="flex items-center">
                                <jet-checkbox-icon class="block h-8 w-auto" />
                                <div class="ml-4 text-lg leading-7 font-semibold">
                                    <strong>No to Money and formal Contracts</strong> – do not ask for or give any monetary or non-monetary gift to the Gig Host
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center">
                                <jet-checkbox-icon class="block h-8 w-auto" />
                                <div class="ml-4 text-lg leading-7 font-semibold">
                                    Be <strong>Generous</strong> with your <strong>Time</strong> and <strong>Skills</strong> – make the experience extra meaningful by allocating precious time and learning the skills
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center">
                                <jet-checkbox-icon class="block h-8 w-auto" />
                                <div class="ml-4 text-lg leading-7 font-semibold">
                                    Write a helpful Gig Host review– thank your Gig Host and explain the valuable skills you’ve gained during the Gig
                                </div>
                            </div>
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
import JetCheckboxIcon from "@/Jetstream/CheckboxIcon"

export default defineComponent({
    props: {
        canLogin: Boolean,
        canRegister: Boolean,
    },

    components: {
        Head,
        Link,
        WelcomeLayout,
        JetCheckboxIcon,
    }
})
</script>
