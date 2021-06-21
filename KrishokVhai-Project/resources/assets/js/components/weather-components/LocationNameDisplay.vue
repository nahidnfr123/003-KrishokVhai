<template>
    <div v-if="Object.keys(dataToDisplay).length">
        <h4>
            <span v-if="dataToDisplay.address.road">{{ dataToDisplay.address.road }},</span>
            <span v-if="dataToDisplay.address.village">{{ dataToDisplay.address.village }},</span>
            <span v-if="dataToDisplay.address.town">{{ dataToDisplay.address.town }},</span>
            <span v-else-if="dataToDisplay.address.neighbourhood">{{ dataToDisplay.address.neighbourhood }},</span>
            <span v-else-if="dataToDisplay.address.city">{{ dataToDisplay.address.city }},</span>
            <span v-else-if="dataToDisplay.address.state">{{ dataToDisplay.address.state }},</span>
            <span> {{ dataToDisplay.address.country_code.toUpperCase() }}</span>
        </h4>

        <div class="text-muted text-sm" v-if="dataToDisplay.display_name"><strong>Location details:</strong> {{ dataToDisplay.display_name }}</div>
        <hr>
    </div>
</template>

<script>
export default {
    name:'LocationNameDisplay',
    props:{
        dataToDisplay: Object,
    }
}
</script>

<style scoped lang="css">
.text-sm{
    font-size: 12px;
}
</style>
