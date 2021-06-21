<template>
    <!-- BEGIN: Content-->
    <div>
        <div class="content-wrapper-before"></div>
        <div class="content-header row"></div>
        <div class="content-body">
            <div id="user-profile" v-if="userProfile && Object.keys(userProfile).length">
                <div class="row">
                    <div class="col-sm-12 col-xl-8 ">
                        <div class="media d-flex m-1 ">
                            <div class="align-left p-1">
                                <a href="#" class="profile-image">
                                    <img :src="userProfile.avatar? userProfile.avatar :'/storage/images/users/default.jpg'" class="rounded-circle img-border height-100" alt="Card image"
                                         style="height: 100px; width: 100px; border-radius: 50%; object-fit: cover; object-position: center center">
                                </a>
                            </div>
                            <div class="media-body text-left  mt-1">
                                <h3 class="font-large-1 black">{{ userProfile.first_name + ' ' + userProfile.last_name }}</h3>
                                <div class="d-flex">
                                    <p class="font-medium-1 black">
                                        ( <span v-for="(role, r) in userProfile.roles" :key=r>{{ role + ', ' }} </span> )
                                    </p>
                                    <p class="ml-2 black" v-if="userProfile.address && userProfile.address.length">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span v-if="userProfile.address[0].country">{{ userProfile.address[0].country.name }} </span>
                                        <span v-if="userProfile.address[0].state">, {{ userProfile.address[0].state.name }}</span>
                                        <span v-if="userProfile.address[0].city">, {{ userProfile.address[0].city.name }}</span>
                                    </p>
                                </div>
                                <div>
                                    <!--<button class="btn btn-bg-gradient-x-purple-red btn-glow white" style="margin-left: 10px;"
                                            @click="sendFriendRequest(userProfile.id)">
                                        <i class="fas fa-plus"></i> Add friend
                                    </button>-->
                                    <router-link :to="{name: 'Chat-Conversation', params:{to_id:userProfile.id}}"
                                                 class="btn btn-bg-gradient-x-purple-red btn-glow white" style="margin-left: 10px;" title="Send message"
                                                 v-if="loggedInUser.status === 'active'">
                                        <i class="fas fa-comment"></i> Message
                                    </router-link>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-xl-3 col-lg-5 col-md-12">
                        <div class="card">
                            <div class="card-header pb-0">
                                <div class="card-title-wrap bar-primary">
                                    <!--                                    <div class="card-title">Work History</div>
                                                                        <hr>-->
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="card-body p-0 pt-0 pb-1">
                                    <!--                                    <ul>
                                                                            <li><strong>99%</strong>Job Success</li>
                                                                            <li>
                                                                                <strong>4.9 stars </strong>
                                                                                <i class="fas fa-star yellow darken-2"></i>
                                                                                <i class="fas fa-star yellow darken-2"></i>
                                                                                <i class="fas fa-star yellow darken-2"></i>
                                                                                <i class="fas fa-star yellow darken-2"></i>
                                                                                <i class="fas fa-star yellow darken-2"></i>
                                                                            </li>
                                                                            <li><strong>1022</strong> Hours Worked</li>
                                                                            <li><strong>26</strong> Jobs</li>
                                                                        </ul>-->
                                </div>
                            </div>
                        </div>

                        <!--                        <div class="card">
                                                    <div class="card-header">
                                                        <h4 class="card-title">Project X</h4>
                                                        <div class="heading-elements">
                                                            <ul class="list-inline d-block mb-0">
                                                                <li>
                                                                    <i class="ft-bar-chart font-large-1 danger"></i>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="card-content collapse show">
                                                        <div class="card-body pt-0 pb-1">
                                                            <h6 class="text-bold-600"> Task done:
                                                                <span>4/10</span>
                                                            </h6>
                                                            <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                                                <div class="progress-bar bg-gradient-x-danger" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0"
                                                                     aria-valuemax="100"></div>
                                                            </div>
                                                            <div class="media d-flex">
                                                                <div class="align-self-center">
                                                                    <h6 class="text-bold-600 mt-2"> Client:
                                                                        <span class="info">Xeon Inc.</span>
                                                                    </h6>
                                                                    <h6 class="text-bold-600 mt-1"> Deadline:
                                                                        <span class="blue-grey">June, 2018</span>
                                                                    </h6>
                                                                </div>
                                                                <div class="media-body text-right mt-2">
                                                                    <ul class="list-unstyled users-list">
                                                                        <li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="John Doe" class="avatar avatar-sm pull-up">
                                                                            <img class="media-object rounded-circle" src="/admin/app-assets/images/portrait/small/avatar-s-19.png" alt="Avatar">
                                                                        </li>
                                                                        <li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="Katherine Nichols" class="avatar avatar-sm pull-up">
                                                                            <img class="media-object rounded-circle" src="/admin/app-assets/images/portrait/small/avatar-s-18.png" alt="Avatar">
                                                                        </li>
                                                                        <li data-toggle="tooltip" data-popup="tooltip-custom" data-original-title="Joseph Weaver" class="avatar avatar-sm pull-up">
                                                                            <img class="media-object rounded-circle" src="/admin/app-assets/images/portrait/small/avatar-s-17.png" alt="Avatar">
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>-->
                    </div>


                    <div class="col-xl-9 col-lg-7 col-md-12" v-if="userProfile && Object.keys(userProfile).length">
                        <!--Project Timeline div starts-->
                        <div id="timeline">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title-wrap bar-primary">
                                        <div class="card-title">Profile Info</div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="card-block">
                                        <div>
                                            <div class="mb-1"><strong>Email: </strong>{{ userProfile.email }}</div>
                                            <div class="mb-1" v-if="userProfile.postal_code"><strong>Postal code: </strong>{{ userProfile.postal_code }}</div>
                                            <div class="mb-1" v-if="userProfile.gender"><strong>Gender: </strong>{{ userProfile.gender }}</div>
                                            <div class="mb-1" v-if="userProfile.dob"><strong>Dob: </strong>{{ userProfile.dob | dateFormatMDY() }}</div>
                                            <div class="mb-1" v-if="userProfile.farmer">
                                                <div class="mb-1" v-if="userProfile.farmer.farmer_type">
                                                    <strong>Farmer type: </strong> {{ userProfile.farmer.farmer_type }}
                                                </div>
                                                <div class="mb-1" v-if="userProfile.farmer.acres">
                                                    <strong>Field area: </strong> {{ userProfile.farmer.acres }}, acres
                                                </div>
                                                <div class="mb-1" v-if="userProfile.about">
                                                    <strong>About: </strong>
                                                    <div v-html=userProfile.about></div>
                                                </div>
                                                <hr>
                                                <div v-if="products && Object.keys(products).length" class="mt-2">
                                                    <h3>Product List:</h3>
                                                    <div class="col-md-12" v-for="product in products">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <div class="d-flex align-items-center">
                                                                        <img :src="product.first_image" alt=""
                                                                             style="height: 60px; width: 60px; border-radius: 50%;">
                                                                        <div class="pl-2">
                                                                            <div class="d-flex justify-content-start align-items-center">
                                                                                <h4>
                                                                                    <router-link :to="{name:'View Product',params:{product_slug:product.product_slug}}">
                                                                                        <strong>{{ product.product_name }}</strong>
                                                                                    </router-link>
                                                                                </h4>
                                                                                <div style="font-size: 12px!important; line-height: 10px;" class="ml-1">
                                                                                    ( <strong>Seller:</strong> {{ product.seller.first_name }} {{ product.seller.last_name }} )
                                                                                </div>
                                                                            </div>
                                                                            <div>
                                                                                <span>Regular price: <strong>{{ product.regular_price }} Tk</strong>,</span>
                                                                                <span>Retail price: <strong>{{ product.retail_price }} Tk</strong>,</span>
                                                                                <span>Stock: <strong>{{ product.total_stock }} {{ product.stock_type }}</strong></span>
                                                                            </div>
                                                                            <div>
                                                                                <span>Category: <strong v-for="category in product.categories">{{ category.title }}</strong></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div v-if="products.length > 0" class="paginationLink row">
                                                        <div class="col-12 col-md-6 my-2">
                                                            Showing (
                                                            <!--<span class="text-warning text-bold-600">{{ pagination.per_page * pagination.current_page }}</span>-->
                                                            <span class="text-warning text-bold-600">{{ pagination.from }} -  {{ pagination.to }}</span> ) from
                                                            <span class="text-warning text-bold-600">{{ pagination.total }}</span> products
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
                                            <div class="mb-1" v-if="userProfile.officer">
                                                <div class="mb-1"><strong>Office name: </strong>{{ userProfile.officer.office_name }}</div>
                                                <div class="mb-1"><strong>Job title: </strong>{{ userProfile.officer.job_title }}</div>
                                                <div class="mb-1">
                                                    <strong class="mb-1">Certificate: </strong>
                                                    <iframe
                                                        v-if="roles && (roles.includes('admin') || roles.includes('super admin') || roles.includes('developer') )"
                                                        :src="userProfile.officer.certificate" height="500" width="100%"></iframe>
                                                </div>
                                                <div class="mb-1" v-if="userProfile.about">
                                                    <strong>About: </strong>
                                                    <div>
                                                        {{ userProfile.about }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-1" v-if="userProfile.retailer">
                                                <div class="mb-1"><strong>Retailer interest: </strong>{{ userProfile.retailer.retailer_interest }}</div>
                                                <div class="mb-1" v-if="userProfile.about">
                                                    <strong>About: </strong>
                                                    <div>
                                                        {{ userProfile.about }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Project Timeline div ends-->
                    </div>
                </div>
            </div>

        </div>

    </div>
    <!-- END: Content-->
</template>

<script>
import {mapGetters} from "vuex";
import Pagination from "../../../components/pagination";

export default {
    name: "ViewProfile",
    components: {Pagination},
    data() {
        return {
            userProfile: {},
            products: {},
            loading: false,
            pagination: {
                current_page: 1
            },
        }
    },
    mounted() {
        //this.getUserData();
        this.getUserData(this.$route.params.id)
    },
    activated() {
        this.getUserData(this.$route.params.id)
    },
    computed: {
        ...mapGetters({
            loggedInUser: 'auth/user',
            roles: 'auth/roles'
        })
    },
    methods: {
        async getUserData(id = this.$route.params.id) {
            this.loading = true;
            await axios.get(`/api/user/show/${id}`).then((response) => {
                this.userProfile = response.data.data;
                this.getProducts();
            }).catch((error) => {
                this.errors = error;
            }).finally(() => this.loading = false);
        },
        handleChange(page) {
            this.pagination.current_page = page; /// error occurs for this code ...
            this.getProducts();
        },
        async getProducts(page = this.pagination.current_page) {
            await axios.get(`/api/user/show/${this.userProfile.id}/products?page=${page}`)
                .then((response) => {
                    this.products = response.data.data;
                    this.pagination = response.data.meta;
                }).catch((error) => {
                    this.errors = error;
                });
        },
    },
}
</script>

<style scoped>

</style>
