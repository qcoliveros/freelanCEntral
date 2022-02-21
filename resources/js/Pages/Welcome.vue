<template>
    <Head title="Welcome" />

    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
        <div v-if="canLogin" class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            <Link v-if="$page.props.user" :href="route('dashboard')" class="text-sm text-gray-700 underline">
                Dashboard
            </Link>

            <template v-else>
                <Link :href="route('login')" class="text-sm text-gray-700 underline">
                    Log in
                </Link>

                <Link v-if="canRegister" :href="route('register')" class="ml-4 text-sm text-gray-700 underline">
                    Register
                </Link>
            </template>
        </div>

        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                     viewBox="0 0 392.566 392.566" style="enable-background:new 0 0 392.566 392.566;" xml:space="preserve" width="64px" height="64px">
                    <path style="fill:#56ACE0;" d="M311.857,285.43h-73.374c-17.39,29.737-31.547,51.523-33.099,53.915
                        c-4.331,6.659-13.964,6.659-18.295,0c-1.552-2.392-15.709-24.178-33.099-53.915H80.681l-50.618,85.333h332.412L311.857,285.43z"/>
                    <path style="fill:#FFFFFF;" d="M102.855,115.216c2.78,49.907,79.968,176.485,93.414,197.948
                        c32.582-52.17,93.414-157.543,93.414-197.947c0-51.523-41.891-93.414-93.414-93.414S100.01,63.758,102.855,115.216z"/>
                    <path style="fill:#FFC10D;" d="M196.269,43.588c-39.499,0-71.628,32.129-71.628,71.628c0,10.667,6.788,30.319,17.648,54.368h60.38
                        c6.206,0,11.313,5.042,11.313,11.313c0,6.206-5.042,11.313-11.313,11.313h-49.713c2.651,5.301,5.43,10.796,8.275,16.291h21.204
                        c6.271,0,11.313,5.042,11.313,11.313c0,6.271-5.042,11.313-11.313,11.313h-9.18c7.37,13.382,15.063,26.958,23.014,40.339
                        c38.012-64.065,71.628-132.267,71.628-156.186C267.897,75.717,235.768,43.588,196.269,43.588z"/>
                    <g>
                        <path style="fill:#194F82;" d="M391.049,376.065l-63.612-107.119c-1.939-3.297-5.56-5.301-9.374-5.301h-66.974
                            c28.768-51.006,60.444-114.877,60.444-148.428c0-63.547-51.717-115.2-115.2-115.2s-115.2,51.717-115.2,115.2
                            c0,33.552,31.677,97.422,60.444,148.428H74.54c-3.879,0-7.434,2.004-9.374,5.301L1.554,376.065
                            c-4.331,7.24,0.905,16.485,9.374,16.485H381.61C390.079,392.55,395.315,383.37,391.049,376.065z M102.855,115.216
                            c-2.844-51.459,41.891-93.414,93.414-93.414s93.414,41.891,93.414,93.414c0,40.404-60.768,145.842-93.414,197.948
                            C182.823,291.766,105.635,165.123,102.855,115.216z M30.063,370.764L30.063,370.764l50.618-85.333h73.309
                            c17.39,29.737,31.547,51.523,33.099,53.915c4.331,6.659,13.964,6.659,18.295,0c1.552-2.392,15.709-24.178,33.099-53.915h73.309
                            l50.618,85.333H30.063z"/>
                        <path style="fill:#194F82;" d="M140.544,102.416h12.671v20.04c0,5.56-3.556,6.206-4.848,6.206c-2.78,0-5.495-1.422-8.016-4.202
                            l-4.978,6.788c3.814,3.879,8.275,5.883,13.382,5.883c4.073,0,13.964-1.487,13.964-15.127V94.271h-22.174
                            C140.544,94.271,140.544,102.416,140.544,102.416z"/>
                        <path style="fill:#194F82;" d="M257.231,124.978c0.323-7.37-6.012-9.762-8.663-10.279c0.711-0.323,6.271-2.069,6.271-9.18
                            c0-11.313-12.218-11.313-15.063-11.313h-16.549v42.602h18.618C247.663,136.808,256.778,135.321,257.231,124.978z M232.665,102.158
                            h4.59c2.78,0,4.784,0.323,5.947,0.905c1.164,0.582,1.745,1.939,1.745,3.814c0,1.939-0.646,3.168-1.939,3.685
                            c-1.228,0.517-3.232,0.84-5.883,0.84h-4.461L232.665,102.158L232.665,102.158z M232.665,128.727H232.6v-9.762h5.624
                            c3.103,0,5.43,0.323,6.853,0.905c1.487,0.646,2.133,1.875,2.133,3.879c0,1.939-0.646,3.232-2.004,3.943
                            c-1.293,0.711-3.426,1.034-6.077,1.034H232.665z"/>
                        <path style="fill:#194F82;" d="M215.081,115.216c0-8.339-5.883-22.044-22.303-22.044c-14.869,0-22.303,11.83-22.303,22.044
                            c0,8.339,5.947,22.044,22.303,22.044C207.582,137.261,215.081,125.43,215.081,115.216z M192.713,128.921
                            c-6.465,0-12.606-5.689-12.671-13.705h0.065c0-6.594,4.848-13.705,12.671-13.705c6.594,0,12.671,5.689,12.606,13.705
                            C205.384,121.81,200.471,128.921,192.713,128.921z"/>
                    </g>
                </svg>
                <div class="ml-4 text-2xl leading-7 font-semibold text-gray-900 dark:text-white">freelanCEntral</div>
            </div>

            <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <div class="p-6">
                        <div class="flex items-center">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-500"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            <div class="ml-4 text-lg leading-7 font-semibold"><a href="/" class="underline text-gray-900 dark:text-white">Lorem Ipsum 1</a></div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
                                dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                            </div>
                        </div>
                    </div>

                    <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l">
                        <div class="flex items-center">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-500"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <div class="ml-4 text-lg leading-7 font-semibold"><a href="/" class="underline text-gray-900 dark:text-white">Lorem Ipsum 2</a></div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
                                dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                            </div>
                        </div>
                    </div>

                    <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-500"><path d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                            <div class="ml-4 text-lg leading-7 font-semibold"><a href="/" class="underline text-gray-900 dark:text-white">Lorem Ipsum 3</a></div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
                                dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                            </div>
                        </div>
                    </div>

                    <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-l">
                        <div class="flex items-center">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-500"><path d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <div class="ml-4 text-lg leading-7 font-semibold text-gray-900 dark:text-white">Lorem Ipsum 4</div>
                        </div>

                        <div class="ml-12">
                            <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
                                dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-center mt-4 sm:items-center sm:justify-between">
                <div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
                    Copyright 2022
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
    .bg-gray-100 {
        background-color: #f7fafc;
        background-color: rgba(247, 250, 252, var(--tw-bg-opacity));
    }

    .border-gray-200 {
        border-color: #edf2f7;
        border-color: rgba(237, 242, 247, var(--tw-border-opacity));
    }

    .text-gray-400 {
        color: #cbd5e0;
        color: rgba(203, 213, 224, var(--tw-text-opacity));
    }

    .text-gray-500 {
        color: #a0aec0;
        color: rgba(160, 174, 192, var(--tw-text-opacity));
    }

    .text-gray-600 {
        color: #718096;
        color: rgba(113, 128, 150, var(--tw-text-opacity));
    }

    .text-gray-700 {
        color: #4a5568;
        color: rgba(74, 85, 104, var(--tw-text-opacity));
    }

    .text-gray-900 {
        color: #1a202c;
        color: rgba(26, 32, 44, var(--tw-text-opacity));
    }

    @media (prefers-color-scheme: dark) {
        .dark\:bg-gray-800 {
            background-color: #2d3748;
            background-color: rgba(45, 55, 72, var(--tw-bg-opacity));
        }

        .dark\:bg-gray-900 {
            background-color: #1a202c;
            background-color: rgba(26, 32, 44, var(--tw-bg-opacity));
        }

        .dark\:border-gray-700 {
            border-color: #4a5568;
            border-color: rgba(74, 85, 104, var(--tw-border-opacity));
        }

        .dark\:text-white {
            color: #fff;
            color: rgba(255, 255, 255, var(--tw-text-opacity));
        }

        .dark\:text-gray-400 {
            color: #cbd5e0;
            color: rgba(203, 213, 224, var(--tw-text-opacity));
        }
    }
</style>

<script>
    import { defineComponent } from 'vue'
    import { Head, Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
        components: {
            Head,
            Link,
        },

        props: {
            canLogin: Boolean,
            canRegister: Boolean,
            laravelVersion: String,
            phpVersion: String,
        }
    })
</script>
