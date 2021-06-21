<template>
    <div>
        <label v-if="label" :for="id" :class="label_class ? label_class : default_label_style">{{ label }}</label>
        <textarea v-if="type === 'textarea'" cols="10" rows="4"
                  :id="id"
                  :placeholder="placeholder"
                  :value="value"
                  :name="name"
                  :class="[Replace_Input_Class ? Replace_Input_Class : 'form-control', Add_Input_Class, error ? 'border-red-500 border border-opacity-100' : '',
                      disabled ? 'bg-gray-400 dark:bg-gray-700 hover:bg-gray-300 hover:dark:bg-gray-800 cursor-not-allowed' : '']"
                  @input="updateValue($event.target.value)"
                  ref="input"
                  :disabled="disabled"
        >
        </textarea>

        <input v-else
               :type="type"
               :id="id"
               :placeholder="placeholder"
               :value="value"
               :name="name"
               :pattern="pattern"
               :minlength="minlength"
               :maxlength="maxlength"
               :class="[Replace_Input_Class ? Replace_Input_Class : 'form-control', Add_Input_Class, error ? 'border-red-500 border border-opacity-100' : '',
                  disabled ? 'bg-gray-400 dark:bg-gray-700 hover:bg-gray-300 hover:dark:bg-gray-800 cursor-not-allowed' : '']"
               @input="updateValue($event.target.value)"
               ref="input"
               :disabled="disabled"
               :hidden="hidden"
        >

        <p class="text-danger mt-1" v-if="!!error && displayErrorMsg == 'true'">{{ error }}</p>
    </div>
</template>

<!-- Text Input includes text, email, password, textarea, date, number, tel, etc... -->
<script>
import {default_label_style, default_text_input_style} from '../config';

export default {
    name: "NFR_VueForm_TextInput",
    //props: ['Replace_Input_Class', 'type', 'label', 'id', 'error', 'placeholder', 'value', 'validation', 'name', 'display_label'],
    props: {
        type: {
            type: [String, Number],
            required: true,
            /*validator(value) {
                return ['text', 'email', 'password', 'date'].includes(value);
            },*/
        },
        disabled:{
            type: Boolean,
            default: false
        },
        hidden:{
            type: Boolean,
            default: false
        },
        value: {
            type: [String, Number],
            required: true
        },
        error: {
            type: [String, Array, Object]
        },
        displayErrorMsg: {
            type: String,
            default: "true",
        },
        id: String,
        name: String,
        minlength: String,
        maxlength: String,
        pattern: String,
        label: String,
        placeholder: {
            type: String,
            default: "Text Input",
        },
        validation: {
            type: [Array, Object],
            default: () => []
        },

        Replace_Input_Class: String, // Replace Existing design ...
        Add_Input_Class: String, // Add more design ...
        label_class: String, // Use Custom class list ...
    },
    data() {
        return {
            default_label_style: default_label_style,
            default_input_style: default_text_input_style,
        }
    },
    methods: {
        focus() {
            this.$refs.input.focus()
        },
        updateValue(value) {
            this.$emit('input', value.trim());
        },
    },
    computed: {},
    mounted() {

    }
}
</script>
