<template>
    <div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"
         :class="displayModal?'show':''"
         style="display: block; padding-right: 5px; z-index: 2000000 !important; overflow-y: auto;" v-if="displayModal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            @click.stop.prevent="closeModal"></button>
                </div>
                <div class="modal-body">


                    <!-- General form -->
                    <section class="">
                        <form @submit.stop.prevent="register" method="post" autofocus="autofocus" autocomplete="off">
                            <div class="row">
                                <!--                                <div class="col-12 col-md-6 col-lg-4">
                                                                    <Custom_Text_Input
                                                                        class="mb-3"
                                                                        type="text"
                                                                        label="First Name (*)"
                                                                        name="first_name"
                                                                        placeholder="John"
                                                                        v-model="dataToUpdate.first_name"
                                                                        :error="errors.first_name && Array.isArray(errors.first_name) ? errors.first_name[0] : errors.first_name"
                                                                        id="first_name"/>
                                                                </div>
                                                                <div class="col-12 col-md-6 col-lg-4">
                                                                    <Custom_Text_Input
                                                                        class="mb-3"
                                                                        type="text"
                                                                        label="Last Name (*)"
                                                                        name="last_name"
                                                                        placeholder="Doe"
                                                                        v-model="dataToUpdate.last_name"
                                                                        :error="errors.last_name && Array.isArray(errors.last_name) ? errors.last_name[0] : errors.last_name"
                                                                        id="last_name"/>
                                                                </div>-->


                                <div class="col-12 col-md-6 col-lg-4">
                                    <Custom_Text_Input
                                        class="mb-3"
                                        Add_Input_Class="no-arrow"
                                        v-model="dataToUpdate.mobile_number"
                                        label="Mobile Number (*)"
                                        type="tel"
                                        name="phone"
                                        pattern="[01][0-9]{9}"
                                        minlength="11"
                                        maxlength="11"
                                        :error="errors.mobile_number && Array.isArray(errors.mobile_number) ? errors.mobile_number[0] : errors.mobile_number"
                                        placeholder="01*********"
                                        id="mobile_number"/>
                                    <!--pattern="[+]{01}[0-9]{11,14}"-->
                                </div>

                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="dob">Date of birth:
                                            <span class="ml-1" v-if="dataToUpdate.dob">{{ dataToUpdate.dob | dateFormatMDY() }}</span>
                                        </label>
                                        <input type="date" id="dob" class="form-control" v-model="dataToUpdate.dob" ref="datePicker">
                                        <div v-if="errors.dob && Array.isArray(errors.dob) ? errors.dob[0] : errors.dob">
                                            <p class="text-danger mt-1">
                                                {{ errors.dob && Array.isArray(errors.dob) ? errors.dob[0] : errors.dob }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="dob">Postal Code</label>
                                        <input type="text" id="postal_code" class="form-control" placeholder="1205"
                                               minlength="4"
                                               maxlength="6"
                                               v-model="dataToUpdate.postal_code">
                                        <div v-if="errors.postal_code && Array.isArray(errors.postal_code) ? errors.postal_code[0] : errors.postal_code">
                                            <p class="text-danger mt-1">{{ errors.postal_code && Array.isArray(errors.postal_code) ? errors.postal_code[0] : errors.postal_code }}</p>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label for="about">About</label>
                                        <textarea name="about" id="about" v-model="dataToUpdate.about" class="form-control"></textarea>
                                        <div v-if="errors.about && Array.isArray(errors.about) ? errors.about[0] : errors.about">
                                            <p class="text-danger mt-1">{{ errors.about && Array.isArray(errors.about) ? errors.about[0] : errors.about }}</p>
                                        </div>
                                    </div>

                                </div>
                                <!--                                <div class="col-12 col-md-6 col-lg-4">
                                                                    <h5>Address:</h5>
                                                                    <address-select-component
                                                                        :address="userAddressForm.address"
                                                                        :errors="this.errors"
                                                                        @updateAddressValues="updateAddressData($event)"
                                                                    />
                                                                </div>-->


                                <div class="col-12 col-md-6 col-lg-4">
                                </div>
                                <div class="col-12 col-md-6 col-lg-4"
                                     v-if="['farmer', 'retailer', 'agricultural-officer'].includes(dataToUpdate.user_type)">
                                </div>
                            </div>

                            <Custom_Loading_Button
                                class="mb-2"
                                Add_Input_Class="col-12"
                                @button_clicked="updateProcessing"
                                :processing="processing">
                                <span>Update</span>
                            </Custom_Loading_Button>
                        </form>
                    </section>


                    <!-- Conditional Form -->
                    <section>

                    </section>


                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
// import AddressSelectComponent from "../../../components/AddressSelectComponent";

export default {
    name: "UpdateProfileModal",
    components: {
        // AddressSelectComponent
    },
    props: {
        displayModal: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
            processing: false,
            errors: {},
            user_details: {},
            dataToUpdate: {
                mobile_number: "",
            },
            userAddressForm: {
                address: '',
                country_id: '',
                state_id: '',
                city_id: '',
            },
        }
    },
    computed: {
        ...mapGetters({
            user: 'auth/user',
            roles: 'auth/roles',
        }),
    },
    mounted() {
        this.getUserDetails();
    },
    activated() {
        this.getUserDetails();
    },
    methods: {
        async getUserDetails() {
            this.loading = true;
            await axios.get(`/api/user/details`)
                .then((response) => {
                    this.user_details = response.data.data;
                    this.dataToUpdate = this.user_details;
                }).catch((error) => {
                    this.errors = error;
                }).finally(() => this.loading = false);
        },
        closeModal() {
            this.$emit('displayModalClose', false)
        },
        updateAddressData(value) {
            this.showAddressForm = true;
            this.userAddressForm.address = value.address;
            this.userAddressForm.country_id = value.country_id;
            this.userAddressForm.state_id = value.state_id;
            this.userAddressForm.city_id = value.city_id;
        },
        async updateProcessing() {
            this.loading = true;
            this.errors = {};
            this.$Progress.start();

            if (Object.keys(this.errors).length) {
                this.$Progress.fail();
                this.loading = false;
                return
            }

            const formData = new FormData();

            formData.append('_method', 'PUT');
            formData.append('dob', this.dataToUpdate.dob);
            formData.append('about', this.dataToUpdate.about);
            formData.append('postal_code', this.dataToUpdate.postal_code);
            formData.append('mobile_number', this.dataToUpdate.mobile_number);

            await axios.post(`/api/user/${this.dataToUpdate.id}/update`, formData)
                .then((response) => {
                    this.$emit('updated', false)
                    this.$store.dispatch('snackbar/addSnack', {color: 'success', msg: 'User profile updated.', snakbarType: 'Success'}, {root: true});
                }).catch((error) => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                    this.$Progress.fail();
                }).finally(() => {
                    this.loading = false;
                    this.$Progress.finish();
                });
        },

        validateRequest() {
            if (!this.dataToUpdate.mobile_number.trim()) this.errors.mobile_number = 'Mobile number is required!';
        }
    }
}
</script>

<style scoped>

</style>
