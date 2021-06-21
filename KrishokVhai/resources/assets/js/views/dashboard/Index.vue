<template>
    <div class="content-body">
        <section class="row">
            <div class="col-sm-12">

                <!-- What is-->
                <div id="what-is" class="card">
                    <div class="card-header">
                        <h4 class="card-title">Dashboard</h4>
                        <!--<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
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


                                <div class="row mb-2">
                                    <div class="col-12 col-lg-8">
                                        <div class="mt-1 mb-1" v-if="(roles && roles.includes('farmer')) && (orders && Object.keys(orders).length)">
                                            <h4>New Orders</h4>


                                            <table class="table" style="width: 100% !important; font-size: 12px!important;"
                                                   v-if="orders.length && checkRoles()">
                                                <thead class="white" :class="search.removed?'bg-danger':'bg-info'">
                                                <tr>
                                                    <th style="max-width: 10px !important;">#</th>
                                                    <th>Product - seller</th>
                                                    <th>Total price</th>
                                                    <th>Status</th>
                                                    <th>Customer</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="(order, us) in orders" :key="order.id">
                                                    <th scope="row" style="width: 60px !important;">
                                                        <span v-if="productDetailsId == order.id"><i class="fas fa-angle-down"></i></span>
                                                        <span v-else><i class="fas fa-angle-up"></i></span>
                                                        <a href="" style="margin-left: 4px" @click.stop.prevent="showDetails(order.id)">{{ order.order_no }}</a>
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
                                                                        {{ product.individual_order_status }}
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
                                                        <div class="badge badge-light text-dark">{{ order.order_status }}</div>
                                                    </td>
                                                    <td>
                                                        <img :src="order.customer.avatar" alt="" class="rounded" style="width: 20px; height: 20px; border-radius: 100%; object-position: center center; object-fit: cover;">
                                                        <router-link :to="{name: 'View Profile', params:{id:order.customer.id}}" target="_blank"
                                                                     v-if="user && user.id != order.customer.id">{{ order.customer.username }}
                                                        </router-link>
                                                        <router-link :to="{name:'Profile'}" target="_blank" v-else>{{ order.customer.username }}</router-link>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <div v-else>
                                                <div class="alert alert-info text-center">
                                                    No recent orders found.
                                                </div>
                                            </div>


                                            <router-link class="btn btn-sm btn-warning"
                                                         :to="{name: 'Manage Order', params: {username: this.user.username}}">Show orders
                                            </router-link>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4" v-if="officers && Object.keys(officers).length">
                                        <div class="mt-1 mb-1">
                                            <h4>Agriculture Officers</h4>
                                            <div class="row">
                                                <!-- Display officers loop -->
                                                <div class="col-12 shadow mb-1 d-flex justify-content-start align-items-center pt-1 pb-1 rounded"
                                                     v-for="officer in officers">
                                                    <div class="avatar avatar-md">
                                                        <img class="media-object rounded-circle" :src="officer.avatar" alt=""
                                                             style="width: 40px; height: 40px; object-fit: cover; object-position: center center;">
                                                        <i class="online-status" v-if="checkOnlineUsers(officer.id)"></i>
                                                    </div>
                                                    <div>
                                                        <div class="ml-1"><strong>{{ officer.first_name }} {{ officer.last_name }}</strong></div>
                                                        <!--<div>{{ officer.email }}</div>-->
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <weather></weather>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
                <!--/ What is-->
            </div>
        </section>
    </div>
    <!-- END: Content-->

</template>
<script>
import {mapGetters} from "vuex";
import axios from "axios";
import Weather from "../Weather";

export default {
    name: 'Main_Dashboard',
    components: {
        Weather,
        //Weather: ()=> import(/*webpackChunkName: "Weather"*/'../Weather'),
    },
    data() {
        return {
            officers: {},
            orders: {},
            filters: {
                searchRole: "agricultural-officer",
            },
            productDetailsId: 0,
            search: {
                sellerId: "",
                seen: 0,
            },
        }
    },
    props: {
        getOnlineUsers: {
            type: [Object, Array],
        },
    },
    activated() {
        this.getOrders();
    },
    mounted() {
        this.getOfficers();
    },
    computed: {
        ...mapGetters({
            user: 'auth/user',
            roles: 'auth/roles',
            onlineUsers: 'user_state/onlineUsers'
        }),
    },
    methods: {
        checkRoles() {
            return !this.roles.includes('agricultural-officer');
        },
        checkOnlineUsers(userid) {
            return _.find(this.onlineUsers, {id: userid});
        },
        async getOrders() {
            this.search.sellerId = this.user.id;
            await axios.get('api/orders/show-new-orders', {
                params: this.search,
            }).then((res) => {
                this.orders = res.data.data;
            }).catch((err) => {
                console.log(err.response.data);
            });
        },
        showDetails(order_id) {
            if (this.productDetailsId == 0) {
                this.productDetailsId = order_id;
            } else if (this.productDetailsId != order_id) {
                this.productDetailsId = order_id;
            } else {
                this.productDetailsId = 0;
            }
        },
        async getOfficers() {
            await axios.get('api/search/people', {
                params: this.filters,
            }).then((res) => {
                this.officers = res.data.data;
            });
        }
    },

}
</script>


<style scoped lang="scss">
.avatar .online-status {
    position: absolute;
    bottom: -2px;
    right: -2px;
    height: 16px;
    width: 16px;
    background: #2ecc71;
    border-radius: 50%;
    border: 2px solid white;
}
</style>
