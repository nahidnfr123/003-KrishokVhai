<template>
    <div>
        <label :for="label" class="block font-semibold text-sm mb-2 text-gray-800 dark:text-gray-300">{{ label }}:</label>
        <input class="rounded-lg w-full h-10 py-4 px-4 text-sm text-gray-800 bg-white placeholder-gray-500 placeholder-opacity-60 shadow dark:bg-gray-900 dark:text-gray-100 focus:outline-none"
               :id="label"
               :class="{ 'border-red-500 border border-opacity-100':!!error }"
               :type="type"
               :placeholder="placeholder"
               :value="value"
               @input="updateValue($event.target.value)">
        <p class="text-red-500 text-xs italic mt-2" v-if="!!error">{{ error }}</p>
    </div>
</template>

<script>
export default {
    name: "TextInput",
    props: ['error', 'label', 'type', 'placeholder', 'value'],
    methods: {
        updateValue(value) {
            this.$emit('input', value)
        }
    },
}
</script>
