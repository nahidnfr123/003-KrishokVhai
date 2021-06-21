<template>
    <!-- BEGIN: Content-->
    <div>
        <div class="content-wrapper-before"></div>
        <div class="content-header row"></div>
        <div class="content-body">
            <div id="user-profile">
                <div class="row">
                    <div class="col-sm-12 col-xl-8 ">
                        <div class="media d-flex m-1 ">
                            <div class="align-left p-1 position-relative">
                                <a class="profile-image">
                                    <img :src="user.avatar? user.avatar :'/storage/images/users/default.jpg'" class="rounded-circle img-border height-100" alt="Card image"
                                         style="height: 100px; width: 100px; border-radius: 50%; object-fit: cover; object-position: center center">
                                </a>
                                <div class="position-absolute" style="right: 10px; bottom: 20px;">
                                    <form method="post" encType="multipart/form-data">
                                        <input type="file" ref="chooseProfileImage" name="avatar" style="display: none; opacity: 0; visibility: hidden;"
                                               @change="onImageChange">
                                        <button class="btn btn-sm btn-info btn-glow d-flex justify-content-center align-items-center"
                                                style="border-radius: 50%; height: 40px; width: 40px; font-size: 20px"
                                                @click.stop.prevent="$refs.chooseProfileImage.click()">
                                            <i class="fas fa-camera"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="media-body text-left  mt-1">
                                <h3 class="font-large-1 black">{{ user.first_name + ' ' + user.last_name }}</h3>
                                <div class="d-flex">
                                    <p class="font-medium-1 black">
                                        ( <span v-for="(role, i) in $store.state.auth.userRoles" :key=i>{{ role + ', ' }} </span> )
                                    </p>
                                    <p class="ml-2 black" v-if="userAddress && Object.keys(userAddress).length">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span v-if="userAddress[0].address">{{ userAddress[0].address }} </span>
                                        <span v-if="userAddress[0].city">, {{ userAddress[0].city.name }}</span>
                                        <span v-if="userAddress[0].state">, {{ userAddress[0].state.name }}</span>
                                        <span v-if="userAddress[0].country">, {{ userAddress[0].country.name }} </span>
                                    </p>
                                </div>
                                <div>
                                    <button class="btn btn-bg-gradient-x-blue-green btn-glow white" style="margin-left: 10px;"
                                            @click="displayUpdateProfileModal = true">
                                        Edit Profile
                                    </button>
                                    <button class="btn btn-bg-gradient-x-purple-red btn-glow white" @click="changePasswordForm()">
                                        Change Password
                                    </button>
                                    <button class="btn btn-danger btn-glow white" @click.stop.prevent="deleteAccount()">
                                        Delete Account
                                    </button>
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
                                                                            <li>
                                                                                <strong>99%</strong>
                                                                                Job Success
                                                                            </li>
                                                                            <li>
                                                                                <strong>4.9 stars </strong>
                                                                                <i class="la la-star yellow darken-2"></i>
                                                                                <i class="la la-star yellow darken-2"></i>
                                                                                <i class="la la-star yellow darken-2"></i>
                                                                                <i class="la la-star yellow darken-2"></i>
                                                                                <i class="la la-star yellow darken-2"></i>
                                                                            <li>
                                                                                <strong>1022</strong> Hours Worked
                                                                            </li>
                                                                            <li>
                                                                                <strong>26</strong> Jobs
                                                                            </li>
                                                                        </ul>-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-9 col-lg-7 col-md-12" v-if="userDetails && Object.keys(userDetails).length">
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
                                            <div class="mb-1"><strong>Email: </strong>{{ userDetails.email }}</div>
                                            <div class="mb-1" v-if="userDetails.postal_code"><strong>Postal code: </strong>{{ userDetails.postal_code }}</div>
                                            <div class="mb-1" v-if="userDetails.gender"><strong>Gender: </strong>{{ userDetails.gender }}</div>
                                            <div class="mb-1" v-if="userDetails.dob"><strong>Dob: </strong>{{ userDetails.dob | dateFormatMDY() }}</div>
                                            <div class="mb-1" v-if="userDetails.mobile_number"><strong>Mobile: </strong>{{ userDetails.mobile_number }}</div>
                                            <div class="mb-1" v-if="userDetails.farmer">
                                                <div class="mb-1" v-if="userDetails.farmer.farmer_type">
                                                    <strong>Farmer type: </strong> {{ userDetails.farmer.farmer_type }}
                                                </div>
                                                <div class="mb-1" v-if="userDetails.farmer.acres">
                                                    <strong>Field area: </strong> {{ userDetails.farmer.acres }}, acres
                                                </div>
                                                <div class="mb-1" v-if="userDetails.about">
                                                    <strong>About: </strong>
                                                    <div>
                                                        {{ userDetails.about }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-1" v-if="userDetails.officer">
                                                <div class="mb-1"><strong>Office name: </strong>{{ userDetails.officer.office_name }}</div>
                                                <div class="mb-1"><strong>Job title: </strong>{{ userDetails.officer.job_title }}</div>
                                                <div class="mb-1" v-if="userDetails.about">
                                                    <strong>About: </strong>
                                                    <div>
                                                        {{ userDetails.about }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-1" v-if="userDetails.retailer">
                                                <div class="mb-1"><strong>Retailer interest: </strong>{{ userDetails.retailer.retailer_interest }}</div>
                                                <div class="mb-1" v-if="userDetails.about">
                                                    <strong>About: </strong>
                                                    <div v-html=userDetails.about></div>
                                                </div>
                                            </div>
                                        </div>


                                        <div v-if="products && Object.keys(products).length" class="mt-2">
                                            <hr>
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
                                </div>
                            </div>
                        </div>
                        <!--Project Timeline div ends-->
                    </div>
                </div>
            </div>

        </div>

        <update-password v-if="showUpdatePasswordModal" @closeUpdatePasswordModal="showUpdatePasswordModal=false"/>


        <update-profile-modal
            :displayModal="displayUpdateProfileModal"
            @displayModalClose="displayUpdateProfileModal = false"
            @updated="getUserWithAddress()"/>

    </div>
    <!-- END: Content-->
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import UpdatePassword from "../../../components/modals/updatePasswordModal";
import Pagination from "../../../components/pagination";
import UpdateProfileModal from "./UpdateProfileModal";
import axios from "axios";

export default {
    name: "Profile",
    components: {
        //UpdateProfileModal: () => import(/*webpackChunkName: "UpdateProfileModal"*/'./UpdateProfileModal'),
        //UpdatePassword: () => import(/*webpackChunkName: "UpdatePassword"*/'../../../components/modals/updatePasswordModal'),

        UpdateProfileModal,
        UpdatePassword,
        Pagination
    },
    data() {
        return {
            displayUpdateProfileModal: false,
            products: {},
            showUpdatePasswordModal: false,
            avatar: '',
            errors: [],
            loading: false,
            pagination: {
                current_page: 1
            },
            userDetails: {},
            userAddress: {},
        }
    },
    activated() {
        this.getProducts();
        this.getUserWithAddress();
    },
    computed: {
        ...mapGetters({
            user: 'auth/user',
            getErrors: 'auth/error'
        }),
    },
    methods: {
        ...mapActions({
            deleteME: 'user_state/deleteME',
            uploadProfileImage: 'user_state/uploadProfileImage',
        }),
        changePasswordForm() {
            this.showUpdatePasswordModal = true;
        },
        async getUserWithAddress() {
            this.userDetails = '';
            await axios.get(`api/user/address`).then((res) => {
                if (res.data && res.data.data) {
                    this.displayUpdateProfileModal = false;
                    this.userDetails = res.data.data;
                    this.userAddress = res.data.data.address;
                }
            })
        },
        deleteAccount() {
            this.$swal.fire({
                title: 'Are you sure you want to delete your account?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    let timerInterval
                    this.$swal.fire({
                        title: 'Deletion process has started!',
                        //html: 'I will close in <b></b> milliseconds.',
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: () => {
                            this.$swal.showLoading()
                            timerInterval = setInterval(() => {
                                const content = this.$swal.getContent()
                                if (content) {
                                    const b = content.querySelector('b')
                                    if (b) {
                                        b.textContent = this.$swal.getTimerLeft()
                                    }
                                }
                            }, 100)
                        },
                        willClose: () => {
                            clearInterval(timerInterval)
                        }
                    }).then((result) => {
                        /* Read more about handling dismissals below */
                        if (result.dismiss === this.$swal.DismissReason.timer) {
                            this.deleteME(this.user.id).then(() => {
                                //if (this.user == null) window.location.href = `/`;
                                window.location.href = `/`;
                            });
                        }
                    });
                }
            });
        },
        async onImageChange(e) {
            let file = this.$refs.chooseProfileImage.files[0];
            if (this.$refs.chooseProfileImage.files.length > 0) {
                if (/\.(jpe?g|png|gif)$/i.test(file.name)) {
                    if (file['size'] < 2111775) {
                        let reader = new FileReader();
                        this.avatar = file;
                        /*reader.addEventListener('load', function () {
                            this.$refs.chooseProfileImage.src = reader.result;
                        }.bind(this), false);*/
                        reader.readAsDataURL(file);
                        await this.uploadProfileImage(this.avatar);
                    } else {
                        alert('File size can not be bigger than 2 MB')
                    }
                } else {
                    alert('File must be jpeg, jpg or png.')
                }
            }
        },
        handleChange(page) {
            this.pagination.current_page = page; /// error occurs for this code ...
            this.getProducts();
        },
        async getProducts(page = this.pagination.current_page) {
            await axios.get(`/api/user/show/${this.user.id}/products?page=${page}`)
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
