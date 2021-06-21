<template>
    <div>
        <label v-if="label" :class="label_class ? label_class : default_label_style">
            {{ label }}
        </label>
        <div class="rounded-lg py-1.5" :class="{'pl-2 border-red-500 border border-opacity-80':!!error}">
            <div class="relative inline-block w-12 align-middle select-none transition duration-500 ease-in">
                <input :type="type" :name="name" :id="id"
                       class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 dark:border-gray-800 appearance-none cursor-pointer"
                       :class="{'right-0 border-purple-600 dark:border-purple-600':!!checked}"
                       @click="handleChange($event.target.value)"
                />
                <label :for="id" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-200 dark:bg-gray-800 cursor-pointer shadow-inner"
                       :class="{'bg-purple-500 dark:bg-purple-500': !! checked}"></label>
            </div>
            <label :for="id" :class="input_with_label_style" v-if="switchLabel">{{ switchLabel }}</label>
        </div>

        <p class="text-red-500 text-xs italic mt-2" v-if="!!error">{{ error }}</p>
    </div>
</template>


<script>
import {default_label_style, default_text_input_style, input_with_label_style} from "../config";

export default {
    name: 'NFR_VueForm_Switch',
    props: {
        type: {
            String,
            default: "checkbox"
            /*validator(value) {
                return ['text', 'email', 'password', 'date'].includes(value);
            },*/
        },
        value: {
            String,
            required: true,
            default: ""
        },
        switchLabel: {
            type: String,
            required: true,
            default: "Toggle"
        },
        error: {
            type: String
        },
        id: String,
        name: String,
        label: String,
        placeholder: {
            type: String,
            default: "Select"
        },
        displayProperty: {
            type: String,
            default: "name",
        },
        valueProperty: {
            type: String,
            default: "id",
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
            default_input_style: default_text_input_style + ' outline-none appearance-none',
            input_with_label_style: input_with_label_style,
            checked: false,
            /*validated: false,*/
        }
    },
    methods: {
        handleChange(value) {
            this.checked = !this.checked;
            this.$emit('input', this.checked);
        },
    }
}
</script>
