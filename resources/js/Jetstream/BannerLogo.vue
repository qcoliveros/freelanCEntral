<template>
    <div class="flex items-center justify-center">
        <jet-application-logo class="block h-10 w-auto" />
        <div class="flex flex-col items-center">
            <div class="ml-2 text-xl font-semibold">freelanCEntral</div>
            <div class="ml-2 text-xs">find your next Gig* here!</div>
        </div>
    </div>
</template>

<script>
import { defineComponent } from 'vue'
import JetApplicationLogo from "@/Jetstream/ApplicationLogo";

export default defineComponent({
    components: {
        JetApplicationLogo,
    },
})
</script>
