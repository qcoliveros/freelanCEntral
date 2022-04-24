<template>
    <ckeditor :editor="editor" v-model="editorData" :config="editorConfig" />
</template>

<script>
    import { defineComponent } from 'vue'
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic'

    export default defineComponent({
        props: ['modelValue'],

        emits: ['update:modelValue'],

        data() {
            return {
                editor: ClassicEditor,
                editorData: this.modelValue,
                editorConfig: {
                    removePlugins: [
                        'MediaEmbed',
                        'Table', 'TableToolbar',
                    ],
                }
            };
        },

        watch: {
            editorData(value) {
                const isSame = this.modelValue === value
                if (isSame) {
                    return
                }

                this.$emit('update:modelValue', value)
            },
        },

        methods: {
            focus() {
                this.$refs.input.focus()
            }
        }
    })
</script>
