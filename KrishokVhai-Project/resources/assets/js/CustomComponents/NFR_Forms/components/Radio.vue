<template>
    <div>
        <label v-if="label" :class="label_class ? label_class : default_label_style">{{ label }}</label>
        <div v-if="type === 'radio'" class="rounded-lg py-2" :class="[orientation, error ? 'pl-2 border-red-500 border border-opacity-80' : '']">
            <label v-if="options" v-for="option in options" class="flex">
                <span :class="[Replace_Input_Class ? Replace_Input_Class : default_radio_style, Add_Input_Class]">
                    <input
                        :type="type"
                        :id="id+'_'+option"
                        :placeholder="placeholder"
                        :value="option"
                        :name="name"
                        :class="{ 'border-red-500 border border-opacity-100':!!error }"
                        @change="updateTextValue($event.target.value)"
                    >
                </span>
                <span :class="input_with_label_style">{{ option }}</span>
            </label>
            <div v-if="!options" class="text-red-600">
                Radio button requires the 'option' parameter.
                <br>
                example: ':options="{male:'Male', female:'Female', others:'Others'}"'
            </div>
        </div>

        <div v-else class="text-red-600">
            Input type must be radio!
        </div>

        <p class="text-red-500 text-xs italic mt-2" v-if="!!error">{{ error }}</p>
    </div>
</template>


<style scoped>
.customRadioDesign {
    height: 23px;
    width: 23px;
    /* box-shadow: 0 2px 10px rgba(0, 0, 0, 1), inset 0 2px 6px rgba(0, 0, 0, 1);*/
}

.customRadioDesign input {
    /*display: none;*/
    transform: translate(25%, 8%);
    transform-origin: center center;
}
</style>


<!--
 Use the Replace_Input_Class : "default_input_style" .... to use the default design .... or you may use your own class to design the component...
 -->

<script>
import {default_label_style, default_radio_input_style, input_with_label_style} from "../config";

export default {
    name: "NFR_VueForm_Radio",
    //props: ['Replace_Input_Class', 'type', 'label', 'id', 'error', 'placeholder', 'value', 'validation', 'name', 'display_label'],
    props: {
        type: {
            String,
            required: true,
            /*validator(value) {
                return ['text', 'email', 'password', 'date'].includes(value);
            },*/
        },
        value: {
            String,
            Object,
            required: true
        },
        id: String,
        error: {
            type: [String, Array, Object]
        },
        validation: Object,
        name: String | Object,
        label: String,
        placeholder: String,
        options: {
            type: [String, Array, Object],
            required: true,
            default: () => {}
        },
        dayOptions: {
            type: [String, Array, Object],
            default: () => {}
        },
        orientation: String, // flex ..

        Replace_Input_Class: String, // Replace Existing design ...
        Add_Input_Class: String, // Add more design ...
        label_class: String, // Use Custom class list ...
    },
    data() {
        return {
            default_label_style: default_label_style,
            default_radio_style: default_radio_input_style,
            input_with_label_style: input_with_label_style,
        }
    },
    methods: {
        updateTextValue(value) {
            this.$emit('input', value)
        },
    },
    mounted() {

    }
}
</script>
