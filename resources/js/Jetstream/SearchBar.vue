<template>
    <div class="flex items-center justify-left">
        <div class="flex border-2 rounded">
            <input type="text" name="search" autocomplete="off" placeholder="Search"
                   :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" ref="search"
                   @keyup.enter="onClickSearch"
                   class="px-4 py-2 border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 shadow-sm" />

            <button v-if="!searched" class="flex items-center justify-center px-4 border-l" @click="onClickSearch">
                <jet-icon name="search-icon" />
            </button>

            <button v-else class="flex items-center justify-center px-4 border-l" @click="onClickClearSearch">
                <jet-icon name="clear-icon" />
            </button>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from 'vue'
    import JetIcon from '@/Jetstream/Icon'
    import JetInput from '@/Jetstream/Input'

    export default defineComponent({
        components: {
            JetIcon,
            JetInput,
        },

        props: [ 'modelValue' ],

        emits: [
            'update:modelValue',
            'clickSearch',
            'clickClearSearch'
        ],

        data() {
            return {
                searched: false,
            }
        },

        mounted() {
            if (this.modelValue !== null) {
                this.searched = true
            }
        },

        methods: {
            onClickSearch () {
                this.$emit('clickSearch')
            },

            onClickClearSearch() {
                this.$emit('clickClearSearch')
            }
        }
    })
</script>
