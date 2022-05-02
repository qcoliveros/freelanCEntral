<template>
    <button :type="type" class="items-center align-middle rounded-md outline-none mr-1 mb-1 px-6 py-2 bg-transprent text-sm font-bold text-gray-700 uppercase focus:outline-none hover:bg-gray-100 p-2">
        <slot></slot>
    </button>
</template>

<script>
import { defineComponent } from 'vue'

export default defineComponent({
    props: {
        type: {
            type: String,
            default: 'button',
        },
    }
})
</script>
