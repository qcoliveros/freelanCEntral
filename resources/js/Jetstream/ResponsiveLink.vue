<template>
    <div>
        <button class="w-full text-left block rounded-md focus:outline-none focus:text-green-800 transition hover:scale-110 hover:text-gray-500" v-if="as == 'button'">
            <slot></slot>
        </button>

        <Link :href="href" :class="classes" v-else>
            <slot />
        </Link>
    </div>
</template>

<script>
    import { defineComponent } from 'vue'
    import { Link } from '@inertiajs/inertia-vue3'

    export default defineComponent({
        components: {
            Link,
        },
        props: ['href', 'as']
    })
</script>
