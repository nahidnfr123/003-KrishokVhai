<template>
    <div>
        <label v-if="label" :for="id" :class="label_class ? label_class : default_label_style">{{ label }}</label>
        <textarea v-if="type === 'textarea'" cols="10" rows="4"
                  :id="id"
                  :placeholder="placeholder"
                  :value="value"
                  :name="name"
                  :class="{ 'border-red-500 border border-opacity-100':!!error} + ' ' + (Replace_Input_Class ? Replace_Input_Class : default_input_style) + ' ' + Add_Input_Class"
                  @input="updateTextValue($event.target.value)"
        >
        </textarea>

        <div v-if="type === 'radio'">
            <label v-if="options" v-for="option in options">
                <input
                    :type="type"
                    :id="id+'_'+option"
                    :placeholder="placeholder"
                    :value="option"
                    :name="name"
                    :class="{ 'border-red-500 border border-opacity-100':!!error } + ' ' + (Replace_Input_Class ? Replace_Input_Class : default_input_style) + ' ' + Add_Input_Class"
                    @change="updateTextValue($event.target.value)"
                >
                <span class="mr-4 text-gray-800 dark:text-gray-300">{{ option }}</span>
            </label>
            <div v-if="!options" class="text-red-600">
                Radio button requires the 'option' parameter.
                <br>
                example: ':options="{male:'Male', female:'Female', others:'Others'}"'
            </div>
        </div>

        <div v-if="type === 'checkbox'">
            <label v-if="options" v-for="option in options">
                <input
                    :type="type"
                    :id="id+'_'+option"
                    :placeholder="placeholder"
                    :value="option"
                    :name="name"
                    :class="{ 'border-red-500 border border-opacity-100':!!error } + ' ' + (Replace_Input_Class ? Replace_Input_Class : default_input_style) + ' ' + Add_Input_Class"
                    @change="updateCheckboxValue($event.target.value)"
                >
                <span class="mr-4 text-gray-800 dark:text-gray-300">{{ option }}</span>
            </label>
        </div>

        <input v-else
               :type="type"
               :id="id"
               :placeholder="placeholder"
               :value="value"
               :name="name"
               :class="{ 'border-red-500 border border-opacity-100':!!error } + ' ' + (Replace_Input_Class ? Replace_Input_Class : default_input_style) + ' ' + Add_Input_Class"
               @input="updateTextValue($event.target.value)"
        >

        <p class="text-red-500 text-xs italic mt-2" v-if="!!error">{{ error }}</p>
    </div>
</template>

<!--
 Use the Replace_Input_Class : "default_input_style" .... to use the default design .... or you may use your own class to design the component...
 -->

<script>
export default {
    name: "NFR_VueForm",
    //props: ['Replace_Input_Class', 'type', 'label', 'id', 'error', 'placeholder', 'value', 'validation', 'name', 'display_label'],
    props: {
        type: String,
        value: String | Object,
        Replace_Input_Class: String, // Replace Existing design ...
        Add_Input_Class: String, // Add more design ...
        label_class: String, // Use Custom class list ...
        id: String,
        error: String | Object,
        validation: Object,
        name: String | Object,
        label: String,
        placeholder: String,
        options: Object,
    },
    data() {
        return {
            default_label_style: 'block font-medium text-sm mb-2 text-gray-800 dark:text-gray-300',
            default_input_style: 'rounded-lg w-full py-4 px-4 text-sm text-gray-700 bg-white placeholder-gray-500 placeholder-opacity-60 shadow dark:bg-gray-800 dark:text-gray-100 hover:shadow-md focus:shadow-lg focus:outline-none',
        }
    },
    methods: {
        updateTextValue(value) {
            this.$emit('input', value)
        },
        updateCheckboxValue(value) {
            this.$emit('input', {
                value
            })
        }
    },
    mounted() {

    }
}
</script>
