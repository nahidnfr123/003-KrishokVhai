<template>
    <div>
        <label v-if="label" :for="id" :class="label_class ? label_class : default_label_style">
            {{ label }}
        </label>
        <div class="relative">
            <select
                :type="type"
                :id="id"
                :placeholder="placeholder"
                :value="value"
                :name="name"
                :class="[Replace_Input_Class ? Replace_Input_Class : default_input_style, Add_Input_Class, error ? 'border-red-500 border border-opacity-100' : '']"
                @change="handleChange($event.target.value)"
                ref="childRef"
            >
                <option value="" class="py-2" selected disabled>{{ placeholder }}</option>

                <template v-if="optionsType === 'string'">
                    <option v-for="(option, index) in options" :key="index" :value="option" class="py-2">
                        {{ option }}
                    </option>
                </template>

                <template v-else>
                    <option v-for="(option, index) in options" :key="index" :value="option[valueProperty]" class="py-2">
                        {{ option[displayProperty] }}
                    </option>
                </template>
            </select>

            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 dark:text-gray-100">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                </svg>
            </div>
        </div>

        <p class="text-red-500 text-xs italic mt-2" v-if="!!error">{{ error }}</p>
    </div>

    <!--    class="h-10 leading-tight rounded-lg w-full py-2 px-2 text-sm text-gray-700 placeholder-gray-500 placeholder-opacity-60 shadow dark:text-gray-100 hover:shadow-md bg-white dark:bg-gray-800  focus:shadow-lg focus:outline-none focus:ring-1 focus:ring-blue-600 focus:border-transparent"-->
</template>

<!-- Text Input includes text, email, password, textarea, date, number, tel, etc... -->
<script>
import {default_label_style, default_text_input_style} from '../config';

export default {
    name: "NFR_VueForm_Select",
    //props: ['Replace_Input_Class', 'type', 'label', 'id', 'error', 'placeholder', 'value', 'validation', 'name', 'display_label'],
    props: {
        type: {
            String,
            default: "select"
            /*validator(value) {
                return ['text', 'email', 'password', 'date'].includes(value);
            },*/
        },
        value: {
            type: [String, Number],
            required: true,
            default: ""
        },
        options: {
            type: Array,
            required: true,
            default: () => []
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
            /*validated: false,*/
        }
    },
    methods: {
        handleChange(value) {
            this.$emit('input', value.trim());
            /*this.$emit('errorsEvent', null);
            if (value.trim() !== '') this.validated = true;*/
        },
        /*validateForm() {
            this.validated = true;
            if (this.errorMessage === '') {
                return true;
            }
            this.focus();
            this.$emit('errorsEvent', this.errorMessage);
            return false
        },
        focus() {
            this.$refs.childRef.focus();
        },*/
    },
    computed: {
        optionsType() {
            let ot = "string";
            if (this.options.length > 0 && typeof this.options[0] !== "string") {
                ot = "object";
            }
            return ot;
        },
        /*errorMessage() {
            if (!this.validated) {
                return '';
            }
            if (this.validation.length) {
                if (this.validation.includes('required')) {
                    return this.label + ' is required!';
                }
            }
            return '';
        }*/
    },
    mounted() {

    }
}
</script>
