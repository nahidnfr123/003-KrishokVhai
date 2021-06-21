<template>
    <button :type="type"
            :class="[Replace_Input_Class ? Replace_Input_Class : 'btn btn-primary text-white', Add_Input_Class,
            disabled || processing ? 'cursor-not-allowed' : '']"
            @click.stop.prevent="btnClicked()"
            :disabled="disabled || processing">

        <span v-if="processing" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        <slot></slot>

    </button>
</template>

<script>
import {default_button_style} from "../config";

export default {
    props: {
        type: {
            type: String,
            default: 'submit',
        },
        disabled: {
            type: Boolean,
            default: false
        },
        processing: {
            type: Boolean,
            default: false
        },
        Replace_Input_Class: String, // Replace Existing design ...
        Add_Input_Class: String, // Add more design ...
    },
    data() {
        return {
            default_button_styles: default_button_style,
        }
    },
    methods: {
        btnClicked() {
            this.$emit('button_clicked');
        }
    }
}
</script>
