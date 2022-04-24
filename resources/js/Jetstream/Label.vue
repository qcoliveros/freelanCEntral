<template>
    <label class="font-medium text-sm text-gray-700" :class="isInline ? '' : 'block'">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot></slot></span>
    </label>
</template>

<script>
    import { defineComponent } from 'vue'

    export default defineComponent({
        props: [
            'value',
            'isInline'
        ]
    })
</script>
