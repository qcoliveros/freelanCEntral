<template>
    <welcome-layout title="Welcome" canLogin="canLogin" canRegister="canRegister">
        <div class="py-12">
            <div class="full-h-screen max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-1">
                        <div class="mt-4 text-xl leading-7 font-semibold text-center">Tips from the GigMaster</div>
                        <div class="p-6">
                            <div class="flex items-center">
                                <jet-checkbox-icon class="block h-8 w-auto" />
                                <div class="ml-4 text-lg leading-7 font-semibold">Articles on work, skills development, coaching</div>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center">
                                <jet-checkbox-icon class="block h-8 w-auto" />
                                <div class="ml-4 text-lg leading-7 font-semibold">Blogs</div>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center">
                                <jet-checkbox-icon class="block h-8 w-auto" />
                                <div class="ml-4 text-lg leading-7 font-semibold">Gig success stories</div>
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
