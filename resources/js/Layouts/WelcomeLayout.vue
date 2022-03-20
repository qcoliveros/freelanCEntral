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
                                <Link v-if="$page.props.user" :href="route('dashboard')" class="text-sm">Dashboard</Link>

                                <template v-else>
                                    <Link :href="route('login')" class="text-sm font-bold">Login</Link>
                                    <Link v-if="canRegister" :href="route('register')"
                                          class="ml-4 px-3 py-2 mr-2 rounded text-white text-sm font-semibold whitespace-no-wrap bg-green-800 hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring focus:ring-green-300 disabled:opacity-25 transition"
                                        >Register</Link>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <main>
                <slot></slot>
            </main>

            <footer class="bg-black border-t border-gray-100">
                <div class="max-w-7xl mx-auto lg:px-8">
                    <div class="flex justify-between h-12">
                        <div class="mt-4 text-xs sm:ml-0 text-white">© 2022 freelanCEntral Inc.</div>
                        <div class="mt-4 text-xs sm:ml-0 text-white">
                            Terms of Service &nbsp;|&nbsp;&nbsp;Privacy Policy
                        </div>
                    </div>
                </div>
            </footer>
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
