<template>
    <div>
        <CredentialsModal/>

        <!-- ##### Hero Area Start ##### -->
        <div class="hero-area">
            <div class="welcome-slides owl-carousel">
                <!-- Single Welcome Slides -->
                <div class="single-welcome-slides bg-img bg-overlay jarallax" :style="'background-image: url('+BaseUrl+'frontend-assets/img/bg-img/1.jpg);'">
                    <div class="container h-100">
                        <div class="row h-100 align-items-center">
                            <div class="col-12 col-lg-10">
                                <div class="welcome-content">
                                    <h2 data-animation="fadeInUp" data-delay="200ms">The hearth of the farm is the true center of our universe.</h2>
<!--                                    <p data-animation="fadeInUp" data-delay="400ms">
                                        Mauris vestibulum dolor nec lacinia facilisis. Fusce interdum sagittis volutpat. Praesent eget varius ligula, malesuada eleifend purus. Aenean euismod est at mauris mollis ultricies.
                                        Morbi arcu mi, dictum eu luala, dapibus
                                        interdum mollis.</p>-->
                                    <router-link to="/contact" exact class="btn famie-btn mt-4" data-animation="bounceInUp" data-delay="600ms">Contact Us</router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Single Welcome Slides -->
                <div class="single-welcome-slides bg-img bg-overlay jarallax" :style="'background-image: url('+BaseUrl+'frontend-assets/img/bg-img/7.jpg);'">
                    <div class="container h-100">
                        <div class="row h-100 align-items-center">
                            <div class="col-12 col-lg-10">
                                <div class="welcome-content">
                                    <h2 data-animation="fadeInDown" data-delay="200ms">The hearth of the farm is the true center of our universe.</h2>
                                    <p data-animation="fadeInDown" data-delay="400ms">Mauris vestibulum dolor nec lacinia facilisis. Fusce interdum sagittis volutpat. Praesent eget varius ligula, malesuada eleifend purus. Aenean euismod est at mauris mollis ultricies.
                                        Morbi arcu mi, dictum eu luala, dapibus
                                        interdum mollis.</p>
                                    <router-link to="/contact" exact class="btn famie-btn mt-4" data-animation="bounceInUp" data-delay="600ms">Contact Us</router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ##### Hero Area End ##### -->


        <!-- ##### Famie Benefits Area Start ##### -->
        <section class="famie-benefits-area section-padding-100-0 pb-5">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="benefits-thumbnail mb-50">
                            <img :src="BaseUrl+'frontend-assets/img/bg-img/2.jpg'" alt="">
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <!-- Single Benefits Area -->
                    <div class="col-12 col-sm-4 col-lg">
                        <div class="single-benefits-area wow fadeInUp mb-50" data-wow-delay="100ms">
                            <img :src="BaseUrl+'frontend-assets/img/core-img/digger.png'" alt="">
                            <h5>Best Services</h5>
                        </div>
                    </div>

                    <!-- Single Benefits Area -->
                    <div class="col-12 col-sm-4 col-lg">
                        <div class="single-benefits-area wow fadeInUp mb-50" data-wow-delay="300ms">
                            <img :src="BaseUrl+'frontend-assets/img/core-img/windmill.png'" alt="">
                            <h5>Farm Experiences</h5>
                        </div>
                    </div>

                    <!-- Single Benefits Area -->
                    <div class="col-12 col-sm-4 col-lg">
                        <div class="single-benefits-area wow fadeInUp mb-50" data-wow-delay="500ms">
                            <img :src="BaseUrl+'frontend-assets/img/core-img/cereals.png'" alt="">
                            <h5>100% Natural</h5>
                        </div>
                    </div>

                    <!-- Single Benefits Area -->
                    <div class="col-12 col-sm-4 col-lg">
                        <div class="single-benefits-area wow fadeInUp mb-50" data-wow-delay="700ms">
                            <img :src="BaseUrl+'frontend-assets/img/core-img/tractor.png'" alt="">
                            <h5>Farm Equipment</h5>
                        </div>
                    </div>

                    <!-- Single Benefits Area -->
                    <div class="col-12 col-sm-4 col-lg">
                        <div class="single-benefits-area wow fadeInUp mb-50" data-wow-delay="900ms">
                            <img :src="BaseUrl+'frontend-assets/img/core-img/sunrise.png'" alt="">
                            <h5>Organic food</h5>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ##### Famie Benefits Area End ##### -->

        <!-- ##### About Us Area Start ##### -->
        <section class="about-us-area">
            <div class="container">
                <div class="row align-items-center">

                    <!-- About Us Content -->
                    <div class="col-12 col-md-8">
                        <div class="about-us-content mb-100">
                            <!-- Section Heading -->
                            <div class="section-heading">
                                <p>About us</p>
                                <h2><span>Let Us</span> Tell You Our Story</h2>
                                <img :src="BaseUrl+'frontend-assets/img/core-img/decor.png'" alt="">
                            </div>
                            <p>The story of Smart agro begins in 2020, when Nahid Ferdous (our CEO and Co-founder) saw technology making things easier for the world, but not back home on the farm.
                            </p>
                            <p>
                                The software tools available to farmers at the time were clumsy, difficult to use, and expensive. So over the next few years, the FarmLogs team started building simple software that would help farmers run more efficient operations.</p>
                            <!--                            <a href="#" class="btn famie-btn mt-30">Read More</a>-->
                        </div>
                    </div>

                    <!-- Famie Video Play -->
                    <div class="col-12 col-md-4">
                        <div class="famie-video-play mb-100">
                            <img :src="BaseUrl+'frontend-assets/img/bg-img/6.jpg'" alt="">
                            <!-- Play Icon -->
                            <a href="http://www.youtube.com/watch?v=7HKoqNJtMTQ" class="play-icon"><i
                                class="fa fa-play"></i></a>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!-- ##### About Us Area End ##### -->

        <!-- ##### Services Area Start ##### -->
        <section class="services-area d-flex flex-wrap">
            <!-- Service Thumbnail -->
            <div class="services-thumbnail bg-img jarallax"
                 :style="'background-image:url('+ BaseUrl+'frontend-assets/img/bg-img/7.jpg)'"></div>

            <!-- Service Content -->
            <div class="services-content section-padding-100-50 px-5">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <!-- Section Heading -->
                            <div class="section-heading">
                                <p>What we do</p>
                                <h2><span>Our Produce</span> Is Mainstay For Us</h2>
                                <img :src="BaseUrl+'frontend-assets/img/core-img/decor.png'" alt="">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 mb-50">
                            <p>Mauris fermentum nunc quis massa lacinia consequat. Suspendisse orci magna, pharetra sedonia
                                risus ut,
                                elementum mollis nisin. Nunc in sapien turpis. Donec egeto david orci pulvinar ultrices
                                necto drax turpis.
                                Pellentesque justo metus, semper nec ullamcorper id, gravida ultricies arcu.</p>
                        </div>

                        <!-- Single Service Area -->
                        <div class="col-12 col-lg-6">
                            <div class="single-service-area mb-50 wow fadeInUp" data-wow-delay="100ms">
                                <!-- Service Title -->
                                <div class="service-title mb-3 d-flex align-items-center">
                                    <img :src="BaseUrl+'frontend-assets/img/core-img/s1.png'" alt="">
                                    <h5>Fruit &amp; Vegetable</h5>
                                </div>
                                <p>Intiam eu sagittis est, aster cosmo lacini libero. Praesent dignissim sed odio velo
                                    aliquam manta legolas. </p>
                            </div>
                        </div>

                        <!-- Single Service Area -->
                        <div class="col-12 col-lg-6">
                            <div class="single-service-area mb-50 wow fadeInUp" data-wow-delay="300ms">
                                <!-- Service Title -->
                                <div class="service-title mb-3 d-flex align-items-center">
                                    <img :src="BaseUrl+'frontend-assets/img/core-img/s2.png'" alt="">
                                    <h5>Meat &amp; Eggs</h5>
                                </div>
                                <p>Intiam eu sagittis est, aster cosmo lacini libero. Praesent dignissim sed odio velo
                                    aliquam manta legolas. </p>
                            </div>
                        </div>

                        <!-- Single Service Area -->
                        <div class="col-12 col-lg-6">
                            <div class="single-service-area mb-50 wow fadeInUp" data-wow-delay="500ms">
                                <!-- Service Title -->
                                <div class="service-title mb-3 d-flex align-items-center">
                                    <img :src="BaseUrl+'frontend-assets/img/core-img/s3.png'" alt="">
                                    <h5>Milk &amp; Cheese</h5>
                                </div>
                                <p>Intiam eu sagittis est, aster cosmo lacini libero. Praesent dignissim sed odio velo
                                    aliquam manta legolas. </p>
                            </div>
                        </div>

                        <!-- Single Service Area -->
                        <div class="col-12 col-lg-6">
                            <div class="single-service-area mb-50 wow fadeInUp" data-wow-delay="700ms">
                                <!-- Service Title -->
                                <div class="service-title mb-3 d-flex align-items-center">
                                    <img :src="BaseUrl+'frontend-assets/img/core-img/s4.png'" alt="">
                                    <h5>Rice &amp; Corn</h5>
                                </div>
                                <p>Intiam eu sagittis est, aster cosmo lacini libero. Praesent dignissim sed odio velo
                                    aliquam manta legolas. </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <!-- ##### Services Area End ##### -->

        <!-- ##### Our Products Area Start ##### -->
        <section class="our-products-area section-padding-100">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <!-- Section Heading -->
                        <div class="section-heading text-center">
                            <p>Featured Products</p>
                            <h2><span>Our Product</span> Are Highest Quality</h2>
                            <img :src="BaseUrl+'frontend-assets/img/core-img/decor2.png'" alt="">
                        </div>
                    </div>
                </div>

                <div class="row" v-if="!loading && products && Object.keys(products).length">
                    <!-- Single Product Area -->
                    <div class="col-12 col-sm-6 col-lg-4" v-for="product in products" :key="product.id">
                        <div class="single-product-area mb-50">
                            <!-- Product Thumbnail -->
                            <div class="product-thumbnail">
                                <img :src="product.first_image" alt="" style="height: 180px !important; object-fit: cover; object-position: center;">
                                <!-- Product Tags -->
                                <span class="product-tags bg-danger" v-if="!product.total_stock">Out of stock</span>
                                <!-- Product Meta Data -->
                                <div class="product-meta-data" style="opacity: 1; visibility: visible;">
                                    <a href="#" title="View Details"
                                       @click.stop.prevent="viewProduct(product)">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <template v-if="!roles || !roles.includes('farmer')">
                                        <a href="#" title="Add To Cart"
                                           v-if="product.total_stock && canAddToCart"
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
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="gotoshop-btn text-center wow fadeInUp" data-wow-delay="900ms">
                            <router-link :to="{name:'Market'}" class="btn famie-btn">Go to Store</router-link>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ##### Our Products Area End ##### -->

        <!-- ##### Newsletter Area Start ##### -->
        <!--        <section class="newsletter-area section-padding-100 bg-img bg-overlay jarallax"
                         :style="'background-image:url(' +BaseUrl+'frontend-assets/img/bg-img/8.jpg)'">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-12 col-lg-10">
                                <div class="newsletter-content">
                                    &lt;!&ndash; Section Heading &ndash;&gt;
                                    <div class="section-heading white text-center">
                                        <p>What we do</p>
                                        <h2><span>Our Produce</span> Is Mainstay For Us</h2>
                                        <img :src="BaseUrl+'frontend-assets/img/core-img/decor2.png'" alt="">
                                    </div>
                                    <p class="text-white mb-50 text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                        Nullam at diam convallis ligula cursus bibendum sed at enim. Class aptent taciti sociosqu ad
                                        litora torquent conubia nostra, per inceptos
                                        himenaeos.</p>
                                </div>
                            </div>
                        </div>
                        &lt;!&ndash; Newsletter Form &ndash;&gt;
                        <div class="row justify-content-center">
                            <div class="col-12 col-lg-6">
                                <form action="#" method="post">
                                    <input type="text" class="form-control" placeholder="Enter your email">
                                    <button type="submit" class="btn famie-btn">Subscribe</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>-->
        <!-- ##### Newsletter Area End ##### -->

        <!-- ##### Farming Practice Area Start ##### -->
        <section class="farming-practice-area section-padding-100-50">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <!-- Section Heading -->
                        <div class="section-heading text-center">
                            <p>Make the green world</p>
                            <h2><span>Farming Practices</span> To Preserve Land & Water</h2>
                            <img :src="BaseUrl+'frontend-assets/img/core-img/decor2.png'" alt="">
                        </div>
                    </div>
                </div>

                <div class="row" v-if="farmingPracticePosts && Object.keys(farmingPracticePosts).length">
                    <div class="col-12 col-sm-6 col-lg-4" v-for="post in farmingPracticePosts">
                        <div class="single-farming-practice-area mb-50 wow fadeInUp" data-wow-delay="100ms">
                            <!-- Thumbnail -->
                            <div class="farming-practice-thumbnail">
                                <img :src="post.first_image?post.first_image:'/frontend-assets/placeholder.gif'" alt=""
                                     style="width:100%; height: 200px!important; object-fit: cover; object-position: center center; background: #6c757d;" class="rounded">
                            </div>
                            <!-- Content -->
                            <div class="farming-practice-content text-center">
                                <!-- Icon -->
                                <!--                                <div class="farming-icon">
                                                                    <img src="/frontend-assets/img/core-img/chicken.png" alt="">
                                                                </div>-->
                                <span>Farming practice for</span>
                                <router-link :to="{name:'Read Article', params:{articles_type: postFilters.articles_type, post_slug:post.slug}}">
                                    <h4 style="cursor:pointer;">{{ post.title | truncate(60) }}</h4>
                                </router-link>
                                <div>{{ post.description | truncate(160) }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="gotoshop-btn text-center wow fadeInUp" data-wow-delay="900ms">
                                <router-link :to="{name:'Articles', params: {'articles_type':'farming-practice'}}" class="btn famie-btn">Go TO Post</router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ##### Farming Practice Area End ##### -->


        <!-- ##### News Area Start ##### -->
        <section class="news-area bg-gray section-padding-100-0 mb-4">
            <div class="container">
                <div class="row" v-if="blogPosts && Object.keys(blogPosts).length">

                    <template v-for="(post, index) in blogPosts">

                        <!-- Featured Post Area -->
                        <div class="col-12 col-lg-6" v-if="index == 0">
                            <div class="featured-post-area mb-100 wow fadeInUp" data-wow-delay="100ms">
                                <img :src="post.first_image?post.first_image:'/frontend-assets/placeholder.gif'" alt="">
                                <!-- Post Content -->
                                <div class="post-content">
                                    <h6>Post on <a class="post-date">{{ post.created_at | dateFormatMDY }}</a>
                                        /
                                        <router-link to="/login" v-if="!user">{{ post.author }}</router-link>

                                        <a :href="`dashboard/@${user.username}/profile`" v-if="user && user.id == post.user_id"
                                           target="_blank">{{ post.author }}</a>

                                        <a :href="`/dashboard/@${user.username}/users/view-profile/${post.user_id}`" v-else-if="user"
                                           target="_blank" class="post-author">{{ post.author }}</a>
                                    </h6>
                                    <router-link :to="{name:'Read Article', params:{articles_type: postFilters.articles_type, post_slug:post.slug}}" class="post-title">
                                        {{ post.title | truncate(60) }}
                                    </router-link>

                                </div>
                            </div>
                        </div>

                        <!-- Single Blog Area -->
                        <div class="col-12 col-lg-6 mb-100" v-else>
                            <!-- Single Blog Area -->
                            <div class="single-blog-area style-2 wow fadeInUp" data-wow-delay="300ms">
                                <!-- Post Content -->
                                <div class="post-content">
                                    <h6>Post on <a class="post-date">{{ post.created_at | dateFormatMDY }}</a>
                                        /
                                        <router-link to="/login" v-if="!user">{{ post.author }}</router-link>

                                        <a :href="`dashboard/@${user.username}/profile`" v-if="user && user.id == post.user_id"
                                           target="_blank">{{ post.author }}</a>

                                        <a :href="`/dashboard/@${user.username}/users/view-profile/${post.user_id}`" v-else-if="user"
                                           target="_blank" class="post-author">{{ post.author }}</a>
                                    </h6>
                                    <router-link :to="{name:'Read Article', params:{articles_type: postFilters.articles_type, post_slug:post.slug}}" class="post-title">
                                        {{ post.title | truncate(60) }}
                                    </router-link>
                                    <div>{{ post.description | truncate(160) }}</div>
                                </div>
                            </div>
                        </div>
                    </template>

                    <div class="row">
                        <div class="col-12">
                            <div class="gotoshop-btn text-center wow fadeInUp" data-wow-delay="900ms">
                                <router-link :to="{name:'Articles', params: {'articles_type':'blog'}}" class="btn famie-btn">Go TO Blog</router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ##### News Area End ##### -->

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
import ViewProducts from "./market/ViewProducts";
import Pagination from "../components/pagination";
import CredentialsModal from "./CredentialsModal";

export default {
    name: "Home",
    components: {
        CredentialsModal,
        ViewProducts,
        Pagination,
        //CredentialsModal: ()=> import(/*webpackChunkName: "CredentialsModal"*/'./CredentialsModal.vue'),
        //ViewProducts: ()=> import(/*webpackChunkName: "ViewProducts"*/'./market/ViewProducts.vue'),
    },
    data() {
        return {
            canAddToCart: false,
            BaseUrl: process.env.MIX_BASE_URL,
            products: {},
            product: {},
            farmingPracticePosts: {},
            blogPosts: {},
            loading: false,
            pagination: {
                current_page: 1
            },
            productFilters: {
                query: '',
                category: [],
                category_name: '',
                price: [],
                location: [],
                limit: 6,
            },
            postFilters: {
                articles_type: 'farming-practice',
                query: "",
                category_name: '',
                categories: [],
                limit: '6',
            },
            blogPostFilters: {
                articles_type: 'blog',
                query: "",
                category_name: '',
                categories: [],
                limit: '4',
            },
            showProductModal: false,
        }
    },
    computed: {
        ...mapGetters({
            user: 'auth/user',
            roles: 'auth/roles',
            cart: 'cart/cart',
        }),
    },
    mounted() {
        this.canAddToCart = true;
        this.checkCanAddToCart();
        this.getProducts(false);
        this.getFarmingPracticePosts();
        this.getBlogPosts();


        const plugin = document.createElement("script");
        plugin.setAttribute(
            "src", this.BaseUrl + "frontend-assets/js/carousel.js"
        );
        plugin.async = true;
        document.body.appendChild(plugin);
    },
    deactivated() {
        this.canAddToCart = true;
    },
    methods: {
        ...mapActions({
            getCart: 'cart/getCart',
        }),
        async getProducts(load = true) {
            this.loading = load;
            await axios.get(`api/products/all?page=${this.pagination.current_page}`, {
                params: _.omit(this.productFilters, 'category_name')
            }).then((response) => {
                this.products = response.data.data;
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
        async getFarmingPracticePosts(page = this.pagination.current_page) {
            await axios.get(`api/post/frontend?page=${page}`, {
                params: _.omit(this.postFilters, 'category_name')
            }).then((response) => {
                this.farmingPracticePosts = response.data.data;
            }).catch((error) => {

            });
        },
        async getBlogPosts(page = this.pagination.current_page) {
            await axios.get(`api/post/frontend?page=${page}`, {
                params: _.omit(this.blogPostFilters, 'category_name')
            }).then((response) => {
                this.blogPosts = response.data.data;
            }).catch((error) => {

            });
        },
        viewProduct(product) {
            this.showProductModal = true;
            this.product = product;
        },
        closeViewProductModal() {
            this.showProductModal = false;
            this.product = {};
        },
    },
};

</script>
