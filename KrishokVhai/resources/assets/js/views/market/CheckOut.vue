<template>
    <div class="container">
        <div class="fullPageLoader" v-if="onlinePaymentSubmit">
            <div class="d-flex justify-content-center align-items-center align-content-center text-white" style="height: 100%; width: 100%;">
                <div class="text-center">
                    <div class="spinner-border spinner-border-sm" role="status" aria-hidden="true"/>
                    <div>Initiating online payment process...</div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-12 m-auto mb-4">
            <h3 class="text-center mt-4 text-muted">Checkout</h3>
            <hr>
            <div class="row" v-if="cart.length">
                <div class="col-12 col-lg-12 col-xl-7">
                    <table class="table" style="min-width: 100%;">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col" style="max-width: 60px !important;">Image</th>
                            <th scope="col">Item</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Price</th>
                            <!--                        <th scope="col">Action</th>-->
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(product, index) in cart" :key="product.id">
                            <th scope="row">{{ index }}</th>
                            <td>
                                <img :src="product.first_image" alt="" class="img-fluid rounded" style="height: 40px!important; margin-right: 10px !important;">
                            </td>
                            <td>{{ product.product_name }}</td>
                            <td>
                                {{ product.quantity }} {{ product.stock_type }}
                            </td>
                            <td>{{ itemTotal(product) }}</td>
                            <td>
                                <!--<button class="btn btn-sm btn-danger" @click="$store.commit('cart/removeFromCart',index)"><i class="fas fa-times"></i></button>-->
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="font-bold">Total Amount</td>
                            <td></td>
                            <td></td>
                            <td class="font-bold">{{ cartTotal }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-12 col-lg-12 col-xl-5 mt-4" v-if="!loading">
                    <h6>Payment method:</h6>
                    <div class="form-group">
                        <input type="radio" id="cashOnDelivery" name="paymentOptions" value="cashOnDelivery" v-model="paymentMethod"
                               class="form-group">
                        <label for="cashOnDelivery">Cash on delivery</label>
                        <br>
                        <input type="radio" id="onlinePayment" name="paymentOptions" value="onlinePayment" v-model="paymentMethod"
                               class="form-group">
                        <label for="onlinePayment">Online payment</label>

                        <!--                        <input type="checkbox" checked id="paymentMethod" readonly="readonly" disabled>
                                                <label for="paymentMethod">Cash on delivery</label>-->
                    </div>
                    <hr>
                    <h6>Address</h6>
                    <div class="mb-2">
                        <template v-if="userDetails && Object.keys(userDetails).length && userDetails.address">
                            <div v-for="(address, key) in userDetails.address" class="d-flex align-items-center justify-content-between p-2 rounded" :class="[addressId==address.id?'bg-gray':'']">
                                <div>
                                    <input type="radio" name="addressCheck" :id="'addressCheck'+address.id"
                                           style="margin-right: 10px;" :value="address.id" v-model="addressId">
                                    <label class="font-bold" :for="'addressCheck'+address.id">
                                        <span>{{ address.address }}</span>
                                        <span v-if="address.city">, {{ address.city['name'] | capitalize }}</span>
                                        <span v-if="address.state">, {{ address.state['name'] | capitalize }}</span>
                                        <span v-if="address.country">, {{ address.country['name'] | capitalize }}</span>
                                    </label>
                                </div>
                                <button class="btn btn-sm btn-danger" v-if="key != 0"
                                        @click.stop.prevent="removeAddress(address.id)"><i class="fas fa-times"></i></button>
                            </div>
                        </template>
                        <div v-else>
                            <div class="alert-danger alert" v-if="!loading">
                                No address found.
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div>
                        <button class="btn btn-success btn-sm"
                                @click="showAddressForm=true" v-if="!showAddressForm && (userDetails.address && Object.keys(userDetails.address).length < 3)">
                            Add new address
                        </button>
                        <template v-if="userDetails.address && Object.keys(userDetails.address).length < 3">
                            <form action="" v-if="showAddressForm">
                                <h4>Add new address</h4>
                                <address-select-component
                                    :address="userAddressForm.address"
                                    :errors="this.errors"
                                    @updateAddressValues="updateAddressData($event)"
                                />
                                <div class="d-flex justify-content-between align-items-center">
                                    <button class="btn btn-sm btn-danger text-white rounded" @click="closeForm()">Close</button>
                                    <button class="btn btn-sm btn-primary text-white rounded" @click.stop.prevent="addNewAddress()">Save</button>
                                </div>
                            </form>
                        </template>
                        <div v-else>
                            <div class="alert-danger alert" v-if="!loading">
                                Already 3 address is added can't add more.
                            </div>
                        </div>
                    </div>
                    <br>
                    <button class="btn btn-warning pull-right mb-2" @click.stop.prevent="confirmOrder()">Confirm Order</button>
                </div>
            </div>
            <div v-else>
                <div class="alert alert-danger text-center">Cart is empty!</div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import AddressSelectComponent from "../../components/AddressSelectComponent";

export default {
    name: "CheckOut",
    components: {AddressSelectComponent},
    data() {
        return {
            onlinePaymentSubmit: false,
            paymentMethod: 'cashOnDelivery', // 'cashOnDelivery',
            loading: false,
            showAddressForm: '',
            userAddressForm: {
                address: '',
                country_id: '',
                state_id: '',
                city_id: '',
            },
            userDetails: {},
            addressId: 0,
            errors: '',
            cartDataOrder: {},
            total_price: 0,
        }
    },
    computed: {
        ...mapGetters({
            user: 'auth/user',
        }),
        cart() {
            return this.$store.state.cart.cart;
        },
        cartTotal() {
            let price = this.cart.reduce((acc, item) => acc + (item.regular_price * item.quantity), 0);
            //price = (price / 100);
            this.total_price = price;
            return price.toLocaleString('en-BN', {style: 'currency', currency: 'BDT'});
            //return 'Tk ' + price;
        },
    },
    mounted() {
        this.getCart();
        this.getUserAddress();
    },
    methods: {
        ...mapActions({
            getCart: 'cart/getCart',
        }),
        itemTotal(item) {
            let price = (item.regular_price * item.quantity);
            //price = (price / 100);
            return price.toLocaleString('en-BN', {style: 'currency', currency: 'BDT'});
            //return 'Tk ' + price;
        },
        async getUserAddress() {
            this.loading = true;
            await axios.get('api/user/address').then((response) => {
                this.userDetails = response.data.data;
            }).catch((error) => {
                console.log(error);
            }).finally(() => this.loading = false);
        },
        closeForm() {
            this.showAddressForm = false;
            this.clearForm();
        },
        clearForm() {
            this.userAddressForm = {
                address: '',
                country_id: '',
                state_id: '',
                city_id: '',
            };
        },
        updateAddressData(value) {
            this.showAddressForm = true;
            this.userAddressForm.address = value.address;
            this.userAddressForm.country_id = value.country_id;
            this.userAddressForm.state_id = value.state_id;
            this.userAddressForm.city_id = value.city_id;
        },
        async addNewAddress() {
            let __this = this;
            __this.$Progress.start();
            __this.errors = [];

            if (!__this.userAddressForm.address.trim()) __this.errors.address = 'Address is required.';
            if (!__this.userAddressForm.country_id.toString().trim()) __this.errors.country_id = 'Country is required.';
            if (!__this.userAddressForm.state_id.toString().trim()) __this.errors.state_id = 'State/province  is required.';

            if (Object.keys(__this.errors).length) {
                __this.$Progress.fail();
                return;
            }

            await axios.post('api/user/add-address', this.userAddressForm).then((response) => {
                this.userDetails = response.data.data;
                this.closeForm();
            }).catch((error) => {
                console.log(error);
            }).finally(() => {
                __this.$Progress.finish();
            });
        },
        async removeAddress(id) {
            this.$Progress.start();
            await axios.delete('api/user/address/remove/' + id).then((response) => {
                this.userDetails = response.data.data;
                //this.clearForm();
            }).catch((error) => {
                console.log(error);
            }).finally(() => {
                this.$Progress.finish();
            });
        },
        async confirmOrder() {
            this.$Progress.start();
            if (this.$store.state.cart.cart && !Object.keys(this.$store.state.cart.cart).length) {
                await this.$store.dispatch('snackbar/addSnack', {color: 'danger', msg: 'Cart is empty.', snakbarType: 'Error'}, {root: true});
                this.$Progress.fail();
                return;
            }
            if (!this.addressId) {
                await this.$store.dispatch('snackbar/addSnack', {color: 'danger', msg: 'Please select address.', snakbarType: 'Error'}, {root: true});
                this.$Progress.fail();
                return;
            }
            if (this.paymentMethod === 'onlinePayment') {
                this.onlinePaymentSubmit = true;
                await this.proceedToPayment();
            } else {
                await this.placeOrder();
            }
        },
        async placeOrder() {
            await axios.post('api/product/order', {
                address_id: this.addressId,
                total_price: this.total_price,
                payment_method: this.paymentMethod,
                cartData: this.$store.state.cart.cart,
            }).then((response) => {
                this.$store.dispatch('cart/clearCart');
                this.clearForm();
                window.location.href = `dashboard/@${this.user.username}/products/orders`;
            }).catch((error) => {
                console.log(error);
            }).finally(() => {
                this.$Progress.finish();
            });
        },
        async proceedToPayment() {
            return false;
        }
    }
}
</script>

<style scoped>
.fullPageLoader {
    position: absolute;
    top: 0;
    left: 0;
    height: 100vh;
    width: 100vw;
    z-index: 1000;
    background-color: rgba(20, 20, 20, .5);
    overflow: hidden !important;
}
</style>
