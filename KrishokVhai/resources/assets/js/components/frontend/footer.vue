<template>
    <footer class="footer-area">
        <!-- Main Footer Area -->
        <div class="main-footer bg-img bg-overlay section-padding-80-0" :style="'background-image: url('+BaseUrl+'frontend-assets/img/bg-img/3.jpg);'">
            <div class="container">
                <div class="row">

                    <!-- Single Footer Widget Area -->
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="footer-widget mb-80">
                            <!--                            <a href="#" class="foo-logo d-block mb-30"><img :src="BaseUrl+'frontend-assets/img/core-img/logo2.png'" alt=""></a>-->
                            <p class="text-justify">Krishok Vhai is an e-commerce and knowledge platform dedicated to the farmers.
                                To help rural farmers sell their products and gain agricultural knowledge.</p>
                            <div class="contact-info">
                                <p><i class="fa fa-map-pin" aria-hidden="true"></i><span> Dinajpur, Bangladesh</span></p>
                                <p><i class="fa fa-envelope" aria-hidden="true"></i><span>info.deercreative@gmail.com</span></p>
                                <!--                                <p><i class="fa fa-phone" aria-hidden="true"></i><span>+84 223 9000</span></p>-->
                            </div>
                        </div>
                    </div>

                    <!-- Single Footer Widget Area -->
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="footer-widget mb-80">
                            <h5 class="widget-title">QUICK LINK</h5>
                            <!-- Footer Widget Nav -->
                            <nav class="footer-widget-nav">
                                <ul>
                                    <li>
                                        <router-link to="/">Home</router-link>
                                    </li>
                                    <li>
                                        <router-link to="/market">Shop</router-link>
                                    </li>
                                    <li>
                                        <router-link to="/weather">Weather</router-link>
                                    </li>
                                    <li><a href="#">FAQs</a></li>
                                    <li><a href="#">Payments</a></li>
                                    <li>
                                        <router-link to="/news">News</router-link>
                                    </li>
                                    <li>
                                        <router-link to="/articles/farming-practice">Farming practice</router-link>
                                    </li>
                                    <li>
                                        <router-link to="/blogs">Blogs</router-link>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>

                    <!-- Single Footer Widget Area -->
                    <div class="col-12 col-sm-6 col-lg-3" v-if="posts && Object.keys(posts).length">
                        <div class="footer-widget mb-80">
                            <h5 class="widget-title">RECENT NEWS</h5>

                            <!-- Single Recent News Start -->
                            <div class="single-recent-blog d-flex align-items-center" v-for="(post, index) in posts">
                                <div class="post-thumbnail">
                                    <img :src="post.first_image" alt="">
                                </div>
                                <div class="post-content">
                                    <router-link :to="{name:'Read Article', params:{articles_type: filters.articles_type, post_slug:post.slug}}" class="post-title">
                                        {{ post.title }}
                                    </router-link>
                                    <div class="post-date">{{ post.created_at | dateFormatAgo }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Single Footer Widget Area -->
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="footer-widget mb-80">
                            <h5 class="widget-title">STAY CONNECTED</h5>
                            <!-- Footer Social Info -->
                            <div class="footer-social-info">
                                <a href="#">
                                    <i class="fa fa-facebook" aria-hidden="true"></i>
                                    <span>Facebook</span>
                                </a>
                                <a href="#">
                                    <i class="fa fa-twitter" aria-hidden="true"></i>
                                    <span>Twitter</span>
                                </a>
                                <a href="#">
                                    <i class="fa fa-pinterest" aria-hidden="true"></i>
                                    <span>Pinterest</span>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Copywrite Area  -->
        <div class="copywrite-area">
            <div class="container">
                <div class="copywrite-text">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                                Copyright &copy;{{ year }} All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</template>

<script>

export default {
    name: 'FooterBar',
    data() {
        return {
            year: '2021',
            posts: {},
            filters: {
                articles_type: 'news',
                query: "",
                category_name: '',
                categories: [],
                limit: '2',
            }
        }
    },
    props: {
        BaseUrl: String,
    },
    mounted() {
        this.year = new Date().getFullYear();
        this.getPosts();
    },
    methods: {
        async getPosts(page = 1) {
            this.filters.articles_type = 'news';

            await axios.get(`api/post/frontend?page=${page}`, {
                params: this.filters,
            }).then((response) => {
                this.posts = response.data.data;
            }).catch((error) => {
                alert("There wa a problem fetching data from database.");
            });
        },
    }
}
</script>

