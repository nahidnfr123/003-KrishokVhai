<template>
    <div class="content-body position-relative" v-if="user.status === 'active'">

        <div class="position-absolute overflow-loader d-flex justify-content-center" v-if="processing">
            <div class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="margin-top: 100px;"/>
        </div>

        <section class="row">
            <div class="col-sm-12">

                <div id="what-is" class="card">
                    <div class="card-header">
                        <h4 class="card-title">Manage Orders</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <!--<div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                                </ul>
                            </div>-->
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            <div class="card-text">

                                <div class="users-list-filter px-1">
                                    <form v-on:submit.prevent="getOrders()">
                                        <div class="row border rounded py-2 mb-2 bt-2">
                                            <h5 class="col-12">Search Options</h5>
                                            <div class="col-12 col-sm-6 col-lg-8">
                                                <label for="nameField">Product name, category name, seller name, customer name, order id</label>
                                                <fieldset class="form-group">
                                                    <input type="text" v-model="search.query"
                                                           name="search" id="nameField" class="form-control" placeholder="name, email or mobile number ..." maxlength="120">
                                                </fieldset>
                                            </div>
                                            <div class="col-12 col-sm-6 col-lg-2">
                                                <label for="userStatus">Status</label>
                                                <fieldset class="form-group">
                                                    <select v-model="search.status" name="userStatus" id="userStatus" class="form-control">
                                                        <option value="" selected>All</option>
                                                        <option value="confirmed">Confirmed</option>
                                                        <option value="pending">Pending</option>
                                                        <option value="cancel">Canceled</option>
                                                    </select>
                                                </fieldset>
                                            </div>
                                            <div class="col-12 col-sm-6 col-lg-2 d-flex align-items-center">
                                                <button type="reset" class="btn btn-primary btn-block glow mb-0" @click.stop.prevent="clearForm()">Clear</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>


                                <div class="text-center alert alert-warning" v-if="search.removed && allOrders.length">
                                    Showing removed orders.
                                </div>
                                <div class="text-center alert alert-danger" v-if="errors.lenght">
                                    {{ errors }}
                                </div>

                                <div class="table-responsive" style="max-width: 100% !important; width: 100% !important;">

                                    <button class="btn btn-danger btn-sm btn-glow mb-2"
                                            @click.stop.prevent="search.removed = true"
                                            v-if="!search.removed">
                                        <i class="fas fa-trash"></i>
                                        Show removed orders
                                    </button>
                                    <button class="btn btn-success btn-sm btn-glow mb-2"
                                            @click.stop.prevent="search.removed = false"
                                            v-else>
                                        <i class="fas fa-arrow-left"></i>
                                        Show all orders
                                    </button>

                                    <!--                                    <loading v-if="loading" msg="Loading orders ..."/>-->

                                    <table class="table" style="width: 100% !important; font-size: 12px!important;"
                                           v-if="allOrders.length && checkRoles()">
                                        <thead class="white" :class="search.removed?'bg-danger':'bg-info'">
                                        <tr>
                                            <th style="max-width: 10px !important;">#</th>
                                            <th>Product - seller</th>
                                            <th>Total price</th>
                                            <th>Status</th>
                                            <th>Customer</th>
                                            <th>Address</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(order, us) in allOrders" :key="order.id" :class="[!isProductSeen(order)?'text-primary font-weight-bold':'']">
                                            <th scope="row" style="width: 60px !important;">
                                                <span v-if="productDetailsId == order.id"><i class="fas fa-angle-down"></i></span>
                                                <span v-else><i class="fas fa-angle-up"></i></span>
                                                <a href="" style="margin-left: 4px" @click.stop.prevent="showDetails(order)">{{ order.order_no }}</a>
                                            </th>
                                            <td>
                                                <template v-if="productDetailsId == order.id">
                                                    <div v-if="order.products && order.products.length" v-for="product in order.products" class="rounded mb-1"
                                                         :class="[product.individual_order_status == 'canceled'?'bg-danger text-white':'']">
                                                        <template v-if="!search.sellerId || (search.sellerId && search.sellerId == product.seller.id)">
                                                            <img :src="product.first_image" alt="" style="height: 50px !important;" class="rounded">
                                                            <div>
                                                                <router-link :to="{name:'View Product',params:{product_slug:product.product_slug}}" target="_blank">
                                                                    <strong>{{ product.product_name }} ({{ product.quantity }})</strong>
                                                                </router-link>
                                                            </div>
                                                            <div>
                                                                <strong>Status: </strong>
                                                                <template v-if="search.sellerId && search.sellerId == product.seller.id && product.individual_order_status !== 'confirmed'">
                                                                    <select name="status" id="status" @change.stop.prevent="updateStatus($event, order.id,  product.id)">
                                                                        <option value="" disabled></option>
                                                                        <option value="confirmed" :selected="product.individual_order_status == 'confirmed'?'selected':''">confirm</option>
                                                                        <option value="pending" :selected="product.individual_order_status == 'pending'?'selected':''">pending</option>
                                                                        <option value="canceled" :selected="product.individual_order_status == 'canceled'?'selected':''">cancel</option>
                                                                    </select>
                                                                </template>
                                                                <template v-else>
                                                                    {{ product.individual_order_status }}
                                                                </template>
                                                            </div>
                                                            <div>
                                                                <span><strong>Seller: </strong></span>
                                                                <span>
                                                                <router-link :to="{name: 'View Profile', params:{id:product.seller.id}}" target="_blank"
                                                                             v-if="user && user.id != product.seller.id">{{ product.seller.username }}</router-link>
                                                                <router-link :to="{name:'Profile'}" target="_blank" v-else>{{ product.seller.username }}</router-link>
                                                            </span>
                                                            </div>
                                                            <hr>
                                                        </template>
                                                    </div>
                                                </template>
                                                <div v-else>{{ order.products.length }} - Products</div>
                                            </td>
                                            <td>Tk {{ order.total_price }}</td>
                                            <td>
                                                <div class="form-group d-flex justify-content-start align-items-center" v-if="!search.removed">
                                                    <div class="mr-1">
                                                        <confirmed-icon v-if="order.order_status == 'confirmed'"/>
                                                        <pending-icon v-if="order.order_status == 'pending'"/>
                                                        <cancel-icon v-if="order.order_status == 'cancel'"/>
                                                    </div>
                                                    <div>
                                                        {{ order.order_status }}
                                                    </div>
                                                    <!--<select name="status" id="status" @change.stop.prevent="updateStatus($event, order.id)" v-if="user.id == 1">
                                                        <option value=""></option>
                                                        <option value="confirmed" :selected="order.order_status == 'confirmed'?'selected':''">confirm</option>
                                                        <option value="pending" :selected="order.order_status == 'pending'?'selected':''">pending</option>
                                                        <option value="cancel" :selected="order.order_status == 'cancel'?'selected':''">cancel</option>
                                                    </select>-->
                                                </div>
                                                <div v-else class="badge badge-light text-dark">{{ order.order_status }}</div>
                                            </td>
                                            <td>
                                                <img :src="order.customer.avatar" alt="" class="rounded" style="width: 20px; height: 20px; border-radius: 100%; object-position: center center; object-fit: cover;">
                                                <router-link :to="{name: 'View Profile', params:{id:order.customer.id}}" target="_blank"
                                                             v-if="user && user.id != order.customer.id">{{ order.customer.username }}
                                                </router-link>
                                                <router-link :to="{name:'Profile'}" target="_blank" v-else>{{ order.customer.username }}</router-link>
                                            </td>
                                            <td>{{ order.address.address }}</td>
                                            <td>
                                                <div class="dropdown text-dark">
                                                    <button class="btn btn-sm btn-glow btn-bg-gradient-x-orange-yellow col-12 col-md-5 mr-1 mb-1 dropdown-toggle"
                                                            type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a href="#" class="dropdown-item" @click.stop.prevent="viewOrder = order">
                                                            <i class="fas fa-eye"></i> View details
                                                        </a>
                                                        <a class="dropdown-item" href="#" @click.stop.prevent="restoreOrder(order.id)" v-if="order.deleted_at">
                                                            <i class="fas fa-trash-restore"></i> Restore
                                                        </a>
                                                        <a class="dropdown-item" href="#" @click.stop.prevent="removeOrder(order.id)" v-if="!order.deleted_at">
                                                            <i class="fas fa-trash"></i> Remove
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div v-else>
                                        <div v-if="!processing && !loading" class="alert alert-info text-center">
                                            No orders found.
                                        </div>
                                    </div>


                                    <div v-if="allOrders.length > 0" class="paginationLink row">
                                        <div class="col-12 col-md-6 my-2">
                                            Showing (
                                            <!--<span class="text-warning text-bold-600">{{ pagination.per_page * pagination.current_page }}</span>-->
                                            <span class="text-warning text-bold-600">{{ pagination.from }} -  {{ pagination.to }}</span> ) from
                                            <span class="text-warning text-bold-600">{{ pagination.total }}</span> orders
                                        </div>

                                        <div class="col-12 col-md-6" style="margin-top: 10px;">
                                            <pagination
                                                v-if="pagination.last_page > 1"
                                                :pagination="pagination"
                                                :offset="5"
                                                @paginate="handleChange($event)"
                                                class="">
                                            </pagination>

                                            <div class="text-right">
                                                Current <span class="text-warning">page: {{ pagination.current_page }}</span>,
                                                Total <span class="text-warning">page: {{ pagination.last_page }}</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ What is-->

            </div>
        </section>


        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"
             :class="Object.keys(viewOrder).length?'show':''"
             style="display: block; padding-right: 5px; z-index: 2000000 !important; overflow-y: auto;" v-if="Object.keys(viewOrder).length">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Order no. {{ viewOrder.order_no }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                @click.stop.prevent="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <h5>Ordered products</h5>
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between flex-wrap align-items-center">
                                        <div v-if="viewOrder.products && viewOrder.products.length" v-for="product in viewOrder.products" class="mb-1">
                                            <img :src="product.first_image" alt="" style="height: 100px !important;" class="rounded">
                                            <div>
                                                <div>
                                                    <router-link :to="{name:'View Product',params:{product_slug:product.product_slug}}" target="_blank">
                                                        <strong>{{ product.product_name }} ({{ product.quantity }})</strong>
                                                    </router-link>
                                                    <strong>, {{ product.quantity }} x Tk. {{ product.regular_price }} = {{ product.quantity * product.regular_price }}</strong>
                                                </div>
                                                <span><strong>Seller: </strong></span>
                                                <router-link :to="{name: 'View Profile', params:{id:product.seller.id}}" target="_blank"
                                                             v-if="user && user.id != product.seller.id">
                                                    {{ product.seller.first_name }} {{ product.seller.last_name }}
                                                </router-link>
                                                <router-link :to="{name:'Profile'}" target="_blank" v-else>
                                                    {{ product.seller.first_name }} {{ product.seller.last_name }}
                                                </router-link>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div>
                                        <h5>Total price: <strong>Tk. {{ viewOrder.total_price }}</strong></h5>
                                        <div class="badge badge-warning text-dark">Order status: <strong>{{ viewOrder.order_status }}</strong></div>
                                    </div>
                                    <hr>
                                </div>
                                <div class="col-12">
                                    <div>
                                        Delivery address:
                                        <strong>
                                            <span>{{ viewOrder.address.address }}</span>
                                            <span v-if="viewOrder.address.city">, {{ viewOrder.address.city['name'] | capitalize }}</span>
                                            <span v-if="viewOrder.address.state">, {{ viewOrder.address.state['name'] | capitalize }}</span>
                                            <span v-if="viewOrder.address.country">, {{ viewOrder.address.country['name'] | capitalize }}</span>
                                        </strong>
                                    </div>
                                    <hr>
                                    <div>Ordered By:</div>
                                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                                        <div class="d-flex flex-wrap">
                                            <img :src="viewOrder.customer.avatar" alt="" class="rounded" style="width: 50px; height: 50px; border-radius: 100%; object-position: center center; object-fit: cover;">
                                            <div class="ml-2">
                                                <router-link :to="{name: 'View Profile', params:{id:viewOrder.customer.id}}" target="_blank"
                                                             v-if="user && user.id != viewOrder.customer.id">
                                                    {{ viewOrder.customer.first_name }} {{ viewOrder.customer.last_name }}
                                                </router-link>
                                                <router-link :to="{name:'Profile'}" target="_blank" v-else>
                                                    {{ viewOrder.customer.first_name }} {{ viewOrder.customer.last_name }}
                                                </router-link>
                                                <div>{{ viewOrder.customer.email }}, {{ viewOrder.customer.mobile_number }}</div>
                                            </div>
                                        </div>
                                        <div>
                                            <router-link class="btn btn-success" :to="{name: 'Chat-Conversation', params:{to_id:viewOrder.customer.id}}"
                                                         v-if="user.id !== viewOrder.customer.id">
                                                <i class="fas fa-comment" @click.stop.prevent="alert('feature under development.')"></i>
                                                Chat
                                            </router-link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</template>


<script>
import {mapGetters} from "vuex";
import Pagination from "../../../components/pagination";
import CancelIcon from "../../../components/icon/cancel-icon";
import ConfirmedIcon from "../../../components/icon/confirmed-icon";
import PendingIcon from "../../../components/icon/pending-icon";
import axios from "axios";

export default {
    name: "ManageOrders",
    components: {PendingIcon, ConfirmedIcon, CancelIcon, Pagination},
    data() {
        return {
            allOrders: [],
            viewOrder: {},
            productDetailsId: 0,
            //showingRemovedOrders: false,
            processing: false,
            loading: false,
            errors: [],
            pagination: {
                current_page: 1
            },
            search: {
                query: "", // Search query from text box
                sellerId: "",
                customerId: "",
                status: "",
                pinned: "",
                removed: false,
            },
        }
    },
    activated() {
        //this.checkUserRole();
        //this.checkSellerHasOrders();
    },
    mounted() {
        this.getOrders();
        this.checkUserRole();
    },
    watch: {
        search: {
            handler: _.debounce(function () {
                this.pagination.current_page = 1;
                this.getOrders(this.pagination.current_page, false);
            }, 500), deep: true
        },
    },
    computed: {
        ...mapGetters({
            user: 'auth/user',
            roles: 'auth/roles',
        }),
    },
    methods: {
        checkRoles() {
            let roles = this.roles;
            return !roles.includes('agricultural-officer');
        },
        checkSellerHasOrders() {
            if (this.roles.includes('farmer')) {
                return true;
            }
            return false;
        },
        clearForm() {
            this.errors = '';
            this.search = {
                query: "",
                status: "",
                removed: false,
                pinned: "",
            };
        },
        checkUserRole() {
            const roles = this.roles;
            if (roles && roles.length) {
                if (roles.includes('farmer')) {
                    this.search.sellerId = this.user.id;
                } else {
                    this.search.sellerId = '';
                }
                if (roles.includes('retailer') || roles.includes('customer')) {
                    this.search.customerId = this.user.id;
                } else {
                    this.search.customerId = '';
                }
            }
        },
        handleChange(page) {
            const S = this.search;
            this.getOrders(page, false)
        },
        async getOrders(page, processing = true) {
            this.processing = processing;
            !processing ? this.loading = true : '';
            await axios.get(`api/product/order?query=${this.search.query}` +
                `&status=${this.search.status}` +
                `&removedOrders=${this.search.removed}` +
                `&customerId=${this.search.customerId}` +
                `&sellerId=${this.search.sellerId}` +
                `&pinned=${this.search.pinned}` +
                `&page=${page || this.pagination.current_page}`)
                .then(response => {
                    this.allOrders = response.data.data;
                    this.pagination = response.data.meta;
                    this.errors = [];
                })
                .catch((errors) => {
                    this.errors = errors.response.data.message
                })
                .finally(() => {
                    this.processing = false;
                    this.loading = false;
                });
        },
        isProductSeen(order) {
            let counter = 0;
            if (order.products) {
                for (let x = 0; x < order.products.length; x++) {
                    if (order.products[x].seen == 1 && order.products[x].seller_id == this.user.id) {
                        counter++;
                    }
                }
            }
            return counter; /// if false ... text bold ....
        },
        showDetails(order) {
            let order_id = order.id;
            if (this.productDetailsId == 0) {
                this.productDetailsId = order_id;
            } else if (this.productDetailsId != order_id) {
                this.productDetailsId = order_id;
            } else {
                this.productDetailsId = 0;
            }
            if (!this.isProductSeen(order)) {
                this.updateOrderSeen(order);
            }
        },
        async updateOrderSeen(order) {
            let order_id = order.id;
            let formData = new FormData();
            formData.append('_method', 'PUT');
            axios.post(`api/product/order/update/seen/${order_id}`, formData)
                .then((res) => {
                    let order = res.data.data;
                    this.allOrders.map(ord => {
                        if (ord.id === order.id) {
                            for (let key in order) {
                                ord[key] = order[key];
                            }
                        }
                    });
                });
        },
        async removeOrder(order_id) {
            this.$swal.fire({
                title: 'Are you sure you want to remove this order?',
                text: 'You can view removed orders in trash.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, remove it!'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    this.$Progress.start();
                    await axios.delete(`api/product/order/remove/${order_id}`).then(() => {
                        this.getOrders(this.pagination.current_page, false);
                        this.$swal.fire(
                            'Removed!',
                            'Order has been removed.',
                            'success'
                        )
                    }).catch(() => {
                        this.$store.dispatch('snackbar/addSnack', {color: 'danger', msg: 'Failed to remove order!', snakbarType: 'Error'}, {root: true});
                    }).finally(() => this.$Progress.finish());
                }
            });
        },
        async restoreOrder(order_id) {
            this.$Progress.start();
            this.loading = true;
            await axios.get(`api/product/order/restore/${order_id}`).then(() => {
                this.getOrders(this.pagination.current_page, false);
                this.$swal.fire(
                    'Restored!',
                    'Order has been restored.',
                    'success'
                )
            }).catch(() => {
                this.$store.dispatch('snackbar/addSnack', {color: 'danger', msg: 'Failed to restore order.', snakbarType: 'Error'}, {root: true});
            }).finally(() => {
                this.$Progress.finish();
                this.loading = false;
            });
        },
        async updateStatus(event, order_id, product_id) {
            this.$Progress.start();
            let formData = new FormData();
            formData.append("_method", "put");
            formData.append('status', event.target.value);
            await axios.post(`api/product/order/${order_id}/${product_id}`, formData).then(() => {
                this.getOrders(this.pagination.current_page, false);
                this.$store.dispatch('snackbar/addSnack', {color: 'success', msg: 'Order status updated.', snakbarType: 'Success'}, {root: true});
            }).catch(() => {
                this.$store.dispatch('snackbar/addSnack', {color: 'danger', msg: 'Failed to update status.', snakbarType: 'Error'}, {root: true});
            }).finally(() => {
                this.$Progress.finish();
            });
        },
        closeModal() {
            this.viewOrder = {};
        },
    }
}
</script>

<style scoped lang="css">
.overflow-loader {
    position: absolute !important;
    top: 0;
    left: 0;
    padding: 0;
    bottom: 0;
    z-index: 100000;
    background: rgba(20, 20, 20, .4);
    height: 100%;
    width: 100%;
    text-align: center;
    color: white;
}
</style>
