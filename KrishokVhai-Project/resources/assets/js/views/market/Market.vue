<template>
    <div>

        <!-- ##### Breadcrumb Area Start ##### -->
        <div class="breadcrumb-area bg-img bg-overlay jarallax" style="background-image: url('/frontend-assets/img/bg-img/18.jpg');">
            <div class="container h-100">
                <div class="row h-100 align-items-center">
                    <div class="col-12">
                        <div class="breadcrumb-text">
                            <h2>Market</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="famie-breadcrumb">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <router-link to="/"><i class="fa fa-home"></i> Home</router-link>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Market</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- ##### Breadcrumb Area End ##### -->

        <div v-if="!canAddToCart" class="container">
            <div class="col-12">
                <div class="alert alert-danger text-center">
                    You cannot order products. As your account type is not a Customer or Retailer account.
                </div>
            </div>
        </div>

        <!-- ##### Shop Area Start ##### -->
        <section class="shop-area section-padding-0-100" ref="ScrollPoint">
            <div class="container">

                <div class="row">
                    <!-- Shop Filters -->
                    <div class="col-12">
                        <div class="shop-filters mb-30 d-flex align-items-center justify-content-between">
                            <!-- Product Show -->
                            <div class="product-show">
                                <h6>Showing {{ pagination.from }}–{{ pagination.to }} of {{ pagination.total }} results</h6>
                            </div>

                            <!-- Product View Mode -->
                            <div class="produtc-view-mode">
                                <a href="#"><i class="fa fa-th"></i></a>
                                <a href="#"><i class="fa fa-list-ul"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Shop Sidebar Area -->
                    <div class="col-12 col-md-4 col-lg-3">

                        <!-- Shopping Cart -->
                        <!--                        <div class="shopping-cart mb-50">
                                                    <h5 class="mb-30">Shopping Cart</h5>
                                                    &lt;!&ndash; Cart Table &ndash;&gt;
                                                    <div class="cart-table clearfix">
                                                        <table class="table table-responsive">
                                                            &lt;!&ndash; tbody &ndash;&gt;
                                                            <tbody>
                                                            &lt;!&ndash; Single Table Row &ndash;&gt;
                                                            <tr>
                                                                <td class="cart_product_img">
                                                                    <a href="#"><img src="img/bg-img/34.jpg" alt="Product"></a>
                                                                </td>
                                                                <td class="cart_product_desc">
                                                                    <p>Bayonne Ham</p>
                                                                    <h6>1 x $39.99</h6>
                                                                </td>
                                                                <td class="pro-close">
                                                                    <a href="#"><i class="icon_close"></i></a>
                                                                </td>
                                                            </tr>
                                                            &lt;!&ndash; Single Table Row &ndash;&gt;
                                                            <tr>
                                                                <td class="cart_product_img">
                                                                    <a href="#"><img src="img/bg-img/35.jpg" alt="Product"></a>
                                                                </td>
                                                                <td class="cart_product_desc">
                                                                    <p>Bayonne Ham</p>
                                                                    <h6>1 x $39.99</h6>
                                                                </td>
                                                                <td class="pro-close">
                                                                    <a href="#"><i class="icon_close"></i></a>
                                                                </td>
                                                            </tr>
                                                            &lt;!&ndash; Single Table Row &ndash;&gt;
                                                            <tr>
                                                                <td class="cart_product_img">
                                                                    <a href="#"><img src="img/bg-img/36.jpg" alt="Product"></a>
                                                                </td>
                                                                <td class="cart_product_desc">
                                                                    <p>Bayonne Ham</p>
                                                                    <h6>1 x $39.99</h6>
                                                                </td>
                                                                <td class="pro-close">
                                                                    <a href="#"><i class="icon_close"></i></a>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    &lt;!&ndash; SubTotal &ndash;&gt;
                                                    <div class="cart-summary d-flex align-items-center justify-content-between">
                                                        <div class="sub-total">
                                                            <h6>SUBTOTAL</h6>
                                                        </div>
                                                        <div class="total-price">
                                                            <h6>$52.99</h6>
                                                        </div>
                                                    </div>
                                                    &lt;!&ndash; Checkout &ndash;&gt;
                                                    <a href="#" class="btn famie-btn checkout-btn mt-30 w-100">Checkout</a>
                                                </div>-->

                        <!-- Single Widget Area -->
                        <div class="single-widget-area" v-if="productCategory && productCategory.length">
                            <!-- Title -->
                            <h5 class="widget-title">Catagories</h5>
                            <!-- Cata List -->
                            <ul class="cata-list shop-page">
                                <li :class="[filters.category.length<=0?'active':'']">
                                    <a href="" @click.stop.prevent="filters.category=[]"><strong>All</strong></a>
                                </li>
                                <li v-for="category in productCategory" :class="[filters.category.includes(category.id)?'active':'']">
                                    <a href="" @click.stop.prevent="selectedCategories(category)">
                                        {{ category.title }} <span>({{ category.product_counter }})</span>
                                    </a>

                                    <ul class="cata-list shop-page" v-if="category.children">
                                        <li v-for="subcategory in category.children" :class="[filters.category.includes(subcategory.id)?'active':'']">
                                            <a href="" @click.stop.prevent="selectedCategories(subcategory)">
                                                {{ subcategory.title }} <span>({{ subcategory.product_counter }})</span>
                                            </a>
                                        </li>
                                    </ul>

                                </li>
                            </ul>
                        </div>

                        <!-- Single Widget Area -->
                        <div class="single-widget-area">
                            <!-- Title -->
                            <h5 class="widget-title">Price</h5>
                            <!-- Cata List -->
                            <ul class="cata-list shop-page">
                                <li><a href="#">Tk 0.00 - Tk 100.00</a></li>
                                <li><a href="#">Tk 100.00 - Tk 1000.00</a></li>
                                <li><a href="#">Tk 1000.00 - Tk 10000.00</a></li>
                                <li><a href="#">Tk 10000.00+</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Shop Products Area -->
                    <div class="col-12 col-md-8 col-lg-9">

                        <div class="mb-3">
                            <div class="d-flex">
                                <input type="text" v-model="filters.query"
                                       placeholder="Search: Product name, category, location" class="form-control">
                                <button class="btn bnt-sm btn-danger text-white"
                                        @click.stop.prevent="clearSearch()">
                                    Clear
                                </button>
                            </div>

                            <div class="mt-1">
                                <span v-if="filters.query"><strong>Query: </strong>{{ filters.query }}</span>
                                <span v-if="filters.category_name">, <strong>Category: </strong>{{ filters.category_name }}</span>
                                <span v-if="filters.price.length">, <strong>Price: </strong>{{ filters.price }}</span>
                            </div>
                        </div>

                        <div class="col-12" v-if="searching">
                            <div class="d-flex justify-content-center align-items-center bg-dark py-2 rounded text-white my-2">
                                <div class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="margin-top: 1px;"/>
                                <div style="margin-left: 10px;">Searching ...</div>
                            </div>
                        </div>

                        <div class="col-12" v-if="loading">
                            <loading v-if="loading" msg="Loading products ..."/>
                        </div>
                        <div class="row" v-if="!loading && products && Object.keys(products).length">
                            <!-- Single Product Area -->
                            <div class="col-12 col-sm-6 col-lg-4" v-for="product in products" :key="product.id">
                                <div class="single-product-area mb-50">
                                    <!-- Product Thumbnail -->
                                    <div class="product-thumbnail">
                                        <img :src="product.first_image" alt="" style="height: 180px !important; object-fit: cover; object-position: center;">
                                        <!-- Product Tags -->
                                        <span class="product-tags bg-danger"
                                              v-if="product.total_stock == '0' || product.total_stock == 0 || !product.total_stock">
                                            Out of stock
                                        </span>
                                        <!-- Product Meta Data -->
                                        <div class="product-meta-data" style="opacity: 1; visibility: visible;">
                                            <a href="#" title="View Details"
                                               @click.stop.prevent="viewProduct(product)">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <template v-if="!roles || !roles.includes('farmer')">
                                                <a href="#" title="Add To Cart"
                                                   v-if="product.total_stock && canAddToCart && (product.total_stock != '0' || product.total_stock != 0)"
                                                   @click.stop.prevent="addToCart(product)">
                                                    <i class="icon_cart_alt"></i>
                                                </a>
                                            </template>
                                            <!--<a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><i class="arrow_left-right_alt"></i></a>-->
                                        </div>
                                    </div>
                                    <!-- Product Description -->
                                    <div class="product-desc text-center pt-4">
                                        <a href="#" class="product-title">{{ product.product_name }}</a>
                                        <div v-if="roles && roles.length && roles.includes('retailer')">
                                            <div class="price">{{ product.retail_price }} {{ product.currency }}
                                                <template v-if="product.stock_type"> / {{ product.stock_type }}</template>
                                            </div>
                                        </div>
                                        <div v-else>
                                            <div class="price">{{ product.regular_price }} {{ product.currency }}
                                                <template v-if="product.stock_type"> / {{ product.stock_type }}</template>
                                            </div>
                                        </div>
                                        <div>Stock: {{ product.total_stock }}
                                            <template v-if="product.stock_type"> {{ product.stock_type }}</template>
                                        </div>
                                        <!--                                        <h6 class="price">{{ product.regular_price }}</h6>-->
                                    </div>
                                </div>
                            </div>

                            <!-- Pagination -->
                            <pagination
                                v-if="pagination.last_page > 1"
                                :pagination="pagination"
                                :offset="5"
                                @paginate="handleChange($event)"
                                class="">
                            </pagination>
                        </div>
                        <div v-else>
                            <div class="alert alert-info text-center" v-if="!loading">
                                No products available!
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </section>
        <!-- ##### Shop Area End ##### -->


        <ViewProducts
            :showProductModal="showProductModal"
            :canAddToCart="canAddToCart"
            :user="user"
            :roles="roles"
            :product="product"
            @closeViewProductModal="closeViewProductModal"
            @addToCart="addToCart($event)"/>

    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import Pagination from "../../components/pagination";
// import store from "../../store";
import ViewProducts from "./ViewProducts";

export default {
    name: "Market",
    components: {
        ViewProducts,
        //ViewProducts: () => import(/*webpackChunkName: "ViewProducts"*/'./ViewProducts'),
        Pagination,
    },
    data() {
        return {
            canAddToCart: true,
            loading: false,
            searching: false,
            products: {},
            pagination: {
                current_page: 1
            },
            product: {},
            showProductModal: false,
            filters: {
                query: '',
                category: [],
                category_name: '',
                price: [],
                location: [],
            },
        }
    },
    watch: {
        filters: {
            handler: _.debounce(function () {
                this.searching = true;
                this.getProducts(false);
            }, 500), deep: true
        }
    },
    computed: {
        ...mapGetters({
            productCategory: 'productCategory/productCategories',
            user: 'auth/user',
            roles: 'auth/roles',
            cart: 'cart/cart',
        }),
    },
    activated() {
        this.canAddToCart = true;
        this.checkCanAddToCart();
    },
    deactivated() {
        this.canAddToCart = true;
    },
    mounted() {
        this.getProdCat();
        this.checkCanAddToCart();
        this.getProducts();
    },
    methods: {
        ...mapActions({
            fetchProductCategories: 'productCategory/fetchProductCategory',
            getCart: 'cart/getCart',
        }),
        checkCanAddToCart() {
            const roles = this.roles;
            if (roles && roles.length) {
                for (let key in roles) {
                    if (!['customer', 'retailer'].includes(roles[key])) {
                        localStorage.removeItem("cart");
                        this.canAddToCart = false;
                        return;
                    }
                }
            }
        },
        handleChange(page) {
            this.pagination.current_page = page;
            this.getProducts(false);
        },
        async getProdCat() {
            await this.fetchProductCategories();
        },
        selectedCategories(category) {
            this.filters.category = [];
            this.filters.category_name = category.title;
            this.filters.category.push(category.id);
            if (category.children) {
                for (let x = 0; x < category.children.length; x++) {
                    this.filters.category.push(category.children[x].id);
                }
            }
        },
        async getProducts(load = true) {
            this.loading = load;
            await axios.get(`api/products/all?page=${this.pagination.current_page}`, {
                params: _.omit(this.filters, 'category_name')
            }).then((response) => {
                this.products = response.data.data;
                this.pagination = response.data.meta;
                if (this.searching) {
                    const el = this.$refs.ScrollPoint;
                    if (el) el.scrollIntoView({behavior: 'smooth'});
                }
            }).catch(error => {
                let err = error.response.data.errors;
                this.$store.dispatch('snackbar/addSnack', {color: 'danger', msg: 'Server error', snakbarType: 'Error'}, {root: true});
            }).finally(() => {
                this.loading = false;
                this.searching = false;
            });
        },
        clearSearch() {
            this.filters = {
                query: '',
                category: [],
                category_name: '',
                price: [],
                location: [],
            };
        },
        addToCart(product) {
            let stock = product.total_stock;
            let cartQuantity = 0;
            let cartItems = this.cart;
            let productInTheCart = cartItems.findIndex(item => item.product_slug === product.product_slug);
            if (productInTheCart !== -1) {
                cartQuantity = cartItems[productInTheCart].quantity;
            }
            if (stock <= cartQuantity) {
                this.$store.dispatch('snackbar/addSnack', {color: 'danger', msg: 'No more products in stock.', snakbarType: 'Warning'}, {root: true});
                return;
            }

            // Add to cart ...
            this.$store.commit('cart/addToCart', product);
            this.$store.dispatch('snackbar/addSnack', {color: 'success', msg: `Success.`, snakbarType: 'Success'}, {root: true});
            this.getCart();
        },
        viewProduct(product) {
            this.showProductModal = true;
            this.product = product;
        },
        closeViewProductModal() {
            this.showProductModal = false;
            this.product = {};
        },
    }
}
</script>

<style scoped lang="scss">
.cata-list li.active a {
    color: dodgerblue !important;
    font-size: 16px;
}

.price {
    font-size: 18px !important;
}

.modal {
    position: fixed;
    overflow-y: scroll;

    &::before {
        height: 100vh;
        width: 100vw;
        content: '';
        background: rgba(40, 40, 40, .6);
        position: fixed;
    }
}

.displayImageContainer {
    transition: all 200ms ease-in-out;
    cursor: pointer;

    &.active {
        opacity: 0.6;
        filter: grayscale(1);
    }

    &:hover {
        opacity: 0.7;
    }
}
</style>
