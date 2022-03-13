<template>
    <Link :href="'/'">
        <div class="flex items-center justify-center mt-8">
            <jet-application-logo class="block h-16 w-auto" />
            <div class="flex flex-col items-center">
                <div class="ml-4 text-3xl leading-7 font-semibold">freelanCEntral</div>
                <div class="ml-4 text-base leading-7">find your next Gig* here!</div>
            </div>
        </div>
    </Link>
</template>

<script>
import { defineComponent } from 'vue'
import { Link } from '@inertiajs/inertia-vue3';
import JetApplicationLogo from "@/Jetstream/ApplicationLogo";

export default defineComponent({
    components: {
        JetApplicationLogo,
        Link,
    },
})
</script>
