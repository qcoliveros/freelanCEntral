<template>
    <textarea class="border-gray-300 focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50 rounded-md shadow-sm"
           :value="modelValue"
           @input="$emit('update:modelValue', $event.target.value)"
           ref="input"
           rows="5">
    </textarea>
</template>

<script>
    import { defineComponent } from 'vue'
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic'

    export default defineComponent({
        props: ['modelValue'],

        emits: ['update:modelValue'],

        mounted() {
            ClassicEditor
                .create(this.$el, {
                    removePlugins: [
                        'MediaEmbed',
                        'Table', 'TableToolbar',
                    ],
                })
                .then(editor => {
                    this.instance = editor;
                })
                .catch(error => {
                    console.error( error );
                });
        },

        methods: {
            focus() {
                this.$refs.input.focus()
            }
        }
    })
</script>
