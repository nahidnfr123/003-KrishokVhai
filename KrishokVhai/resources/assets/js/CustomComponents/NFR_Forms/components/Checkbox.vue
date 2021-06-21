<template>
    <div>
        <label v-if="label" :class="label_class ? label_class : default_label_style">{{ label }}</label>
        <div v-if="type === 'checkbox'" class="rounded-lg py-2" :class="[orientation, error ? 'pl-2 border-red-500 border border-opacity-80' : '']">
            <label class="flex" :class="orientation !== 'flex'?'mb-1':''">
                <span :class="[Replace_Input_Class ? Replace_Input_Class : 'form-control', Add_Input_Class]">
                    <input
                        :type="type"
                        :id="id"
                        :placeholder="placeholder"
                        :value="value"
                        :name="name"
                        :class="{ 'border-red-500 border border-opacity-100':!!error }"
                        @change="$emit('input', $event.target.checked)"
                    >
                </span>
                <span :class="input_with_label_style">{{ checkLabel }}</span>
            </label>
        </div>

        <div v-else class="text-red-600">
            Input type must be checkbox!
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
    name: "NFR_VueForm_CheckBox",
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
            type: [String, Boolean],
            required: true
        },
        id: String,
        error: {
            type: [String, Array, Object]
        },
        validation: Object,
        name: {
            type: [String, Object]
        },
        label: String,
        checkLabel: {
            type: [String],
            default: "Check box"
        },
        placeholder: String,
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
}
</script>
