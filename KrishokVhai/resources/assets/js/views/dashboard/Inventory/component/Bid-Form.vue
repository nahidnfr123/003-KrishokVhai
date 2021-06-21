<template>
    <div class="col-12">
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="form-group">
                    <label for="can_bid">Enable bid ?</label>
                    <div class="form-control">
                        <div class="custom-control custom-switch form-check form-switch">
                            <input type="checkbox" class="form-check-input" id="can_bid" v-model="productData.can_bid">
                            <label class="form-check-label ml-2" for="can_bid" v-if="productData.can_bid">Enabled</label>
                            <label class="form-check-label ml-2" for="can_bid" v-else>Disabled</label>
                        </div>
                    </div>
                    <div v-if="errors.can_bid && Array.isArray(errors.can_bid) ? errors.can_bid[0] : errors.can_bid">
                        <p class="text-danger mt-1">{{ errors.can_bid && Array.isArray(errors.can_bid) ? errors.can_bid[0] : errors.can_bid }}</p>
                    </div>
                </div>
            </div>

            <template v-if="productData.can_bid">
                <div class="col-12 col-lg-6">
                    <div class="form-group">
                        <label for="minimum_bid_amount">Bid amount: (*)</label>
                        <input type="number" id="minimum_bid_amount" class="form-control" v-model="productData.minimum_bid_amount">
                        <div v-if="errors.minimum_bid_amount && Array.isArray(errors.minimum_bid_amount) ? errors.minimum_bid_amount[0] : errors.minimum_bid_amount">
                            <p class="text-danger mt-1">{{ errors.minimum_bid_amount && Array.isArray(errors.minimum_bid_amount) ? errors.minimum_bid_amount[0] : errors.minimum_bid_amount }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="form-group">
                        <label for="start_date">Start date: (*)</label>
                        <input type="date" id="start_date" class="form-control" v-model="productData.start_date" min="">
                        <div v-if="errors.start_date && Array.isArray(errors.start_date) ? errors.start_date[0] : errors.start_date">
                            <p class="text-danger mt-1">{{ errors.start_date && Array.isArray(errors.start_date) ? errors.start_date[0] : errors.start_date }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="form-group">
                        <label for="end_date">End date: (*)</label>
                        <input type="date" id="end_date" class="form-control" v-model="productData.end_date" min="">
                        <div v-if="errors.end_date && Array.isArray(errors.end_date) ? errors.end_date[0] : errors.end_date">
                            <p class="text-danger mt-1">{{ errors.end_date && Array.isArray(errors.end_date) ? errors.end_date[0] : errors.end_date }}</p>
                        </div>
                    </div>
                </div>

            </template>
        </div>
    </div>
</template>

<script>
export default {
    name: "Bid-Form",
    props: {
        errors: {
            type: [Object, Array],
        },
        productData: {
            type: [Object, Array],
        }
    }
}
</script>

<style scoped>

</style>
