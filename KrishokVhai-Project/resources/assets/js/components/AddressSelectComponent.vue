<template>
    <div>
        <div class="form-group mb-3">
            <label for="Country">Country (*)</label>
            <select name="country" id="Country" class="form-control form-control-sm" v-model="userDetails.country_id" :disabled="!countries.length">
                <option value="" selected>---------</option>
                <option :value="country.id" v-for="(country, co) in countries" :key="co">{{ country.name }}</option>
            </select>
            <template v-if="errors.country_id && Array.isArray(errors.country_id) ? errors.country_id[0] : errors.country_id">
                <p class="text-danger mt-1">{{ errors.country_id && Array.isArray(errors.country_id) ? errors.country_id[0] : errors.country_id }}</p>
            </template>
        </div>
        <div class="form-group mb-3">
            <label for="State">State/Province (*)</label>
            <select name="state" id="State" class="form-control form-control-sm" v-model="userDetails.state_id" :disabled="!states.length">
                <option value="" selected>---------</option>
                <option :value="state.id" v-for="(state, co) in states" :key="co">{{ state.name }}</option>
            </select>
            <template v-if="errors.state_id && Array.isArray(errors.state_id) ? errors.state_id[0] : errors.state_id">
                <p class="text-danger mt-1">{{ errors.state_id && Array.isArray(errors.state_id) ? errors.state_id[0] : errors.state_id }}</p>
            </template>
        </div>
        <div class="form-group mb-3">
            <label for="City">City</label>
            <select name="city" id="City" class="form-control form-control-sm" v-model="userDetails.city_id" :disabled="!cities.length">
                <option value="" selected>---------</option>
                <option :value="city.id" v-for="(city, co) in cities" :key="co">{{ city.name }}</option>
            </select>
            <template v-if="errors.city_id && Array.isArray(errors.city_id) ? errors.city_id[0] : errors.city_id">
                <p class="text-danger mt-1">{{ errors.city_id && Array.isArray(errors.city_id) ? errors.city_id[0] : errors.city_id }}</p>
            </template>
        </div>
        <div class="form-group mb-3">
            <label for="address" v-if="this.$route.params.usertype == 'agricultural-officer'">Office Address (*)</label>
            <label for="address" v-else>Address (*)</label>
            <textarea cols="10" rows="3" class="form-control form-control-sm" id="address" name="address" v-model="userDetails.address"></textarea>
            <template v-if="errors.address && Array.isArray(errors.address) ? errors.address[0] : errors.address">
                <p class="text-danger mt-1">{{ errors.address && Array.isArray(errors.address) ? errors.address[0] : errors.address }}</p>
            </template>
        </div>
    </div>
</template>

<script>
export default {
    name: 'AddressSelectComponent',
    props: {
        address: String,
        errors: {
            type: Array | Object,
        },
    },
    data() {
        return {
            countries: {},
            states: {},
            cities: {},

            userDetails: {
                country_id: '',
                state_id: '',
                city_id: '',
                address: '',
            }
        }
    },
    watch: {
        'userDetails.country_id': function (newVal, oldVal) {
            if (newVal != oldVal) {
                this.getStates();
                this.$emit('updateAddressValues', this.userDetails);
            }
        },
        'userDetails.state_id': function (newVal, oldVal) {
            if (newVal != oldVal) {
                this.getCities();
                this.$emit('updateAddressValues', this.userDetails);
            }
        },
        'userDetails.city_id': function (newVal, oldVal) {
            if (newVal != oldVal) {
                this.$emit('updateAddressValues', this.userDetails);
            }
        },
        'userDetails.address': function (newVal, oldVal) {
            if (newVal != oldVal) {
                this.$emit('updateAddressValues', this.userDetails);
            }
        },
    },
    methods: {
        updateValue(value) {
            this.$emit('input', value.trim());
        },
        async getCountries() {
            await axios.get('/api/countries').then((response) => {
                this.countries = response.data;
            }).catch(error => {
                dispatch('snackbar/addSnack', {color: 'danger', msg: 'Error fetching countries.', snakbarType: 'Error'}, {root: true});
            });
        },
        async getStates() {
            await axios.get(`/api/states/${this.userDetails.country_id}`).then((response) => {
                this.states = response.data;
            }).catch(error => {
                dispatch('snackbar/addSnack', {color: 'danger', msg: 'Error fetching states.', snakbarType: 'Error'}, {root: true});
            });
        },
        async getCities() {
            await axios.get(`/api/cities/${this.userDetails.state_id}`).then((response) => {
                this.cities = response.data;
            }).catch(error => {
                dispatch('snackbar/addSnack', {color: 'danger', msg: 'Error fetching cities.', snakbarType: 'Error'}, {root: true});
            });
        }
    },
    computed: {},
    mounted() {
        this.getCountries();
    }
}
</script>


<style scoped lang="css">
textarea {
    resize: none;
}
</style>
