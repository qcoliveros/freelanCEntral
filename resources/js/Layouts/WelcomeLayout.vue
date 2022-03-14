<template>
    <div>
        <Head :title="title" />

        <jet-banner />

        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="'/'">
                                    <jet-banner-logo />
                                </Link>
                            </div>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <div v-if="canLogin" class="hidden px-6 py-4 sm:block grid-cols-1">
                                <Link v-if="$page.props.user" :href="route('dashboard')" class="text-sm underline">Dashboard</Link>

                                <template v-else>
                                    <Link :href="route('login')" class="text-sm underline" as="button">Login</Link>
                                    <Link v-if="canRegister" :href="route('register')" class="ml-4 text-sm underline">Register</Link>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main>
                <slot></slot>
            </main>
        </div>
    </div>
</template>

<script>
import { defineComponent } from 'vue'
import { Head, Link } from '@inertiajs/inertia-vue3';
import JetBannerLogo from '@/Jetstream/BannerLogo.vue'
import JetBanner from '@/Jetstream/Banner.vue'
import JetNavLink from '@/Jetstream/NavLink.vue'

export default defineComponent({
    props: {
        title: String,
        canLogin: Boolean,
        canRegister: Boolean,
    },

    components: {
        Head,
        Link,
        JetBannerLogo,
        JetBanner,
        JetNavLink,
    }
})
</script>
