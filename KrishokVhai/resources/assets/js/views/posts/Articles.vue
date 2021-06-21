<template>
    <div>
        <!-- ##### Breadcrumb Area Start ##### -->
        <div class="breadcrumb-area bg-img bg-overlay jarallax" style="background-image: url('/frontend-assets/img/bg-img/18.jpg');">
            <div class="container h-100">
                <div class="row h-100 align-items-center">
                    <div class="col-12">
                        <div class="breadcrumb-text">
                            <h2>{{ filters.articles_type }}</h2>
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
                        <li class="breadcrumb-item active" aria-current="page">{{ filters.articles_type }}</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- ##### Breadcrumb Area End ##### -->

        <!-- ##### About Us Area Start ##### -->
        <!--        <section class="about-us-area">
                    <div class="container">
                        <div class="row align-items-center">

                            &lt;!&ndash; About Us Thumbnail &ndash;&gt;
                            <div class="col-12 col-lg-6">
                                <div class="about-us-thumbnail mb-100">
                                    <img src="/frontend-assets/img/bg-img/24.jpg" alt="">
                                </div>
                            </div>

                            &lt;!&ndash; About Us Content &ndash;&gt;
                            <div class="col-12 col-lg-6">
                                <div class="about-us-content mb-100">
                                    &lt;!&ndash; Section Heading &ndash;&gt;
                                    <div class="section-heading">
                                        <p>FARMING PROCESS</p>
                                        <h2><span>Farming Practices</span> &amp; Methods</h2>
                                        <img src="/frontend-assets/img/core-img/decor.png" alt="">
                                    </div>
                                    <p>Lorem ipsum dolor sit amet, consectetu adipiscing elit. Etiam nunc elit, pretium atlanta urna veloci, fermentum malesuda mina. Donec auctor nislec neque sagittis, sit amet dapibus pellentesque donal feugiat. Nulla mollis magna non
                                        sanaliquet, volutpat do zutum, ultrices consectetur, ultrices at purus.</p>
                                    <a href="#" class="btn famie-btn mt-30">Read More</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </section>-->
        <!-- ##### About Us Area End ##### -->

        <!-- ##### Farming Practice Area Start ##### -->
        <section class="farming-practice-area bg-gray section-padding-100-50">
            <div class="container">
                <div class="row" ref="ScrollPoint">
                    <div class="col-12">
                        <!-- Section Heading -->
                        <div class="section-heading text-center">
                            <p>Make the green world</p>
                            <h2><span>Farming Practices</span> To Preserve Land & Water</h2>
                            <img src="/frontend-assets/img/core-img/decor2.png" alt="">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-4 col-lg-4">
                        <div>
                            <label for="_search_">Search</label>
                            <input type="text" class="form-control" v-model="filters.query" id="_search_">
                        </div>

                        <div class="single-widget-area mt-2">
                            <!-- Title -->
                            <h5 class="widget-title">Categories</h5>
                            <!-- Cata List -->
                            <div v-if="postCategories && Object.keys(postCategories).length"
                                 style="border-radius: 4px;">
                                <h6 class="cursor-pointer hoverActive" :class="[postCategoryId==0?'bg-primary text-white':'']"
                                    @click.stop.prevent="showAllCategory">All</h6>
                                <category-list-frontend
                                    categoryProductCountFilter="farming-practice"
                                    :data="postCategories" id="searchCategory"
                                    @nodeClicked="selectedCategories($event)"
                                    :selectedCategory="postCategoryId"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-8 col-lg-8">

                        <div class="col-12" v-if="loading">
                            <loading v-if="loading" msg="Loading posts ..."/>
                        </div>

                        <div class="row" v-if="posts && Object.keys(posts).length">
                            <div class="col-12 col-sm-6 col-lg-6" v-for="post in posts">
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
                                        <router-link :to="{name:'Read Article', params:{articles_type: filters.articles_type, post_slug:post.slug}}">
                                            <h4 style="cursor:pointer;">{{ post.title | truncate(60) }}</h4>
                                        </router-link>
                                        <div>{{ post.description | truncate(160) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-else role="alert">
                            <div class="alert alert-danger text-center" v-if="!loading">
                                No articles found ...
                            </div>
                        </div>
                    </div>
                </div>

                <div v-if="posts && Object.keys(posts).length" class="paginationLink">
                    <div class="col-12 m-auto" style="margin-top: 10px;">
                        <pagination
                            v-if="pagination.last_page > 1"
                            :pagination="pagination"
                            :offset="5"
                            @paginate="handleChange($event)"
                            class="">
                        </pagination>
                    </div>
                </div>

            </div>
        </section>
        <!-- ##### Farming Practice Area End ##### -->


        <!-- ##### FAQ Area Start ##### -->
        <!--        <section class="famie-faq-area section-padding-100">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                &lt;!&ndash; Section Heading &ndash;&gt;
                                <div class="section-heading text-center">
                                    <p>HAVE A QUESTION?</p>
                                    <h2><span>Get answers</span> to FAQs about the service</h2>
                                    <img src="/frontend-assets/img/core-img/decor2.png" alt="">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="accordions" id="accordion" role="tablist" aria-multiselectable="true">

                                    &lt;!&ndash; Single Accordian Area &ndash;&gt;
                                    <div class="panel single-accordion">
                                        <h6><a role="button" class="" aria-expanded="true" aria-controls="collapseOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Are organic products of the same quality as other food and drink ?
                                            <span class="accor-open"><i class="arrow_carrot-up" aria-hidden="true"></i></span>
                                            <span class="accor-close"><i class="arrow_carrot-down" aria-hidden="true"></i></span>
                                        </a></h6>
                                        <div id="collapseOne" class="accordion-content collapse show">
                                            <p>Organic production methods differ from conventional ones – but the aim is nonetheless to produce top-quality food and drink. Organic produce has to meet the same safety standards as other foods and complies with EU General Food
                                                law. The difference is that instead of using chemical compounds to combat pests or weeds, organic farmers use multi-annual crop rotations and resistant varieties to prevent such problems from occurring in the first place.</p>
                                        </div>
                                    </div>

                                    &lt;!&ndash; Single Accordian Area &ndash;&gt;
                                    <div class="panel single-accordion">
                                        <h6>
                                            <a role="button" class="collapsed" aria-expanded="true" aria-controls="collapseTwo" data-parent="#accordion" data-toggle="collapse" href="#collapseTwo">Do organic products taste different from other food and drink ?
                                                <span class="accor-open"><i class="arrow_carrot-up" aria-hidden="true"></i></span>
                                                <span class="accor-close"><i class="arrow_carrot-down" aria-hidden="true"></i></span>
                                            </a>
                                        </h6>
                                        <div id="collapseTwo" class="accordion-content collapse">
                                            <p>Organic production methods differ from conventional ones – but the aim is nonetheless to produce top-quality food and drink. Organic produce has to meet the same safety standards as other foods and complies with EU General Food
                                                law. The difference is that instead of using chemical compounds to combat pests or weeds, organic farmers use multi-annual crop rotations and resistant varieties to prevent such problems from occurring in the first place.</p>
                                        </div>
                                    </div>

                                    &lt;!&ndash; Single Accordian Area &ndash;&gt;
                                    <div class="panel single-accordion">
                                        <h6>
                                            <a role="button" aria-expanded="true" aria-controls="collapseThree" class="collapsed" data-parent="#accordion" data-toggle="collapse" href="#collapseThree">Are all of your poultry, meat and fish products raised humanely ?
                                                <span class="accor-open"><i class="arrow_carrot-up" aria-hidden="true"></i></span>
                                                <span class="accor-close"><i class="arrow_carrot-down" aria-hidden="true"></i></span>
                                            </a>
                                        </h6>
                                        <div id="collapseThree" class="accordion-content collapse">
                                            <p>Organic production methods differ from conventional ones – but the aim is nonetheless to produce top-quality food and drink. Organic produce has to meet the same safety standards as other foods and complies with EU General Food
                                                law. The difference is that instead of using chemical compounds to combat pests or weeds, organic farmers use multi-annual crop rotations and resistant varieties to prevent such problems from occurring in the first place.</p>
                                        </div>
                                    </div>

                                    &lt;!&ndash; Single Accordian Area &ndash;&gt;
                                    <div class="panel single-accordion">
                                        <h6>
                                            <a role="button" aria-expanded="true" aria-controls="collapseFour" class="collapsed" data-parent="#accordion" data-toggle="collapse" href="#collapseFour">Does FAMIE contain any ingredients from China or outside of North America ?
                                                <span class="accor-open"><i class="arrow_carrot-up" aria-hidden="true"></i></span>
                                                <span class="accor-close"><i class="arrow_carrot-down" aria-hidden="true"></i></span>
                                            </a>
                                        </h6>
                                        <div id="collapseFour" class="accordion-content collapse">
                                            <p>Organic production methods differ from conventional ones – but the aim is nonetheless to produce top-quality food and drink. Organic produce has to meet the same safety standards as other foods and complies with EU General Food
                                                law. The difference is that instead of using chemical compounds to combat pests or weeds, organic farmers use multi-annual crop rotations and resistant varieties to prevent such problems from occurring in the first place.</p>
                                        </div>
                                    </div>

                                    &lt;!&ndash; Single Accordian Area &ndash;&gt;
                                    <div class="panel single-accordion">
                                        <h6>
                                            <a role="button" aria-expanded="true" aria-controls="collapseFive" class="collapsed" data-parent="#accordion" data-toggle="collapse" href="#collapseFive">Are you a retailer interested in bringing in FARMIE products ?
                                                <span class="accor-open"><i class="arrow_carrot-up" aria-hidden="true"></i></span>
                                                <span class="accor-close"><i class="arrow_carrot-down" aria-hidden="true"></i></span>
                                            </a>
                                        </h6>
                                        <div id="collapseFive" class="accordion-content collapse">
                                            <p>Organic production methods differ from conventional ones – but the aim is nonetheless to produce top-quality food and drink. Organic produce has to meet the same safety standards as other foods and complies with EU General Food
                                                law. The difference is that instead of using chemical compounds to combat pests or weeds, organic farmers use multi-annual crop rotations and resistant varieties to prevent such problems from occurring in the first place.</p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </section>-->
        <!-- ##### FAQ Area End ##### -->

        <!-- ##### Contact Area Start ##### -->
        <!--        <section class="contact-area bg-gray section-padding-100-0">
                    <div class="container">
                        <div class="row align-items-end">

                            &lt;!&ndash; Contact Content &ndash;&gt;
                            <div class="col-12 col-lg-7">
                                <div class="contact-content section-padding-0-100">
                                    &lt;!&ndash; Section Heading &ndash;&gt;
                                    <div class="section-heading">
                                        <p>BECOME a FARMER</p>
                                        <h2><span>Start an</span> Apprenticeship Program</h2>
                                        <img src="/frontend-assets/img/core-img/decor.png" alt="">
                                    </div>
                                    &lt;!&ndash; Contact Form Area &ndash;&gt;
                                    <div class="contact-form-area">
                                        <form action="index.html" method="post">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <input type="text" class="form-control" name="name" placeholder="Your Name">
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="email" class="form-control" name="email" placeholder="Your Email">
                                                </div>
                                                <div class="col-12">
                                                    <input type="text" class="form-control" name="subject" placeholder="Your Subject">
                                                </div>
                                                <div class="col-12">
                                                    <textarea name="message" class="form-control" cols="30" rows="10" placeholder="Your Message"></textarea>
                                                </div>
                                                <div class="col-12">
                                                    <button type="submit" class="btn famie-btn">Send Message</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            &lt;!&ndash; Contact Maps &ndash;&gt;
                            <div class="col-lg-5">
                                <div class="consaltant-thumbnail text-center">
                                    &lt;!&ndash;                            <img src="/frontend-assets/img/bg-img/25.png" alt="">&ndash;&gt;
                                </div>
                            </div>
                        </div>
                    </div>
                </section>-->
        <!-- ##### Contact Area End ##### -->

    </div>
</template>
<script>
import {mapActions, mapGetters} from "vuex";
import Pagination from "../../components/pagination";
import CategoryListFrontend from "./category-list-frontend";

export default {
    name: 'Articles',
    components: {
        CategoryListFrontend,
        Pagination
        // CategoryListFrontend: () => import(/*webpackChunkName: "CategoryListFrontend"*/'./category-list-frontend'),
    },
    data() {
        return {
            loading: false,
            posts: {},
            errors: [],
            pagination: {
                current_page: 1
            },
            postCategories: {},
            postCategoryId: 0,
            filters: {
                articles_type: 'farming-practice',
                query: "",
                category_name: '',
                categories: [],
                limit: '8',
            }
        }
    },
    created() {
        this.getPosts();
        this.getPostCategories();
    },
    activated() {
        this.filters = {
            articles_type: 'farming-practice',
            query: "",
            category_name: '',
            categories: [],
            limit: '8',
        }
    },
    watch: {
        '$route.params.articles_type': {
            handler: function (newVal, oldVal) {
                if (newVal != oldVal) {
                    this.getPosts();
                }
            },
            deep: true,
            immediate: true
        },
        'filters.query': function () {
            this.getPosts()
        },
        postCategoryId: function () {
            this.getPosts()
        }

    }, computed: {
        ...mapGetters({
            postsFrontend: 'post/postsFrontend',
        }),
    },
    methods: {
        ...mapActions({
            getPostsFrontend: 'post/getPostsFrontend',
        }),
        async getPostCategories() {
            await axios.get('api/post/category/view').then((response) => {
                this.postCategories = response.data.data;
            });
        },
        showAllCategory() {
            this.postCategoryId = 0;
            this.filters.categories = [];
        },
        selectedCategories(category) {
            this.postCategoryId = category.id;
            this.filters.categories = [];
            this.filters.categories.push(category.id);
            if (category.children) {
                for (let x = 0; x < category.children.length; x++) {
                    this.filters.categories.push(category.children[x].id);
                }
            }
        },
        async getPosts(page = this.pagination.current_page) {
            if (this.$route.params.articles_type) {
                this.filters.articles_type = this.$route.params.articles_type;
                this.loading = true;

                await axios.get(`api/post/frontend?page=${page}`, {
                    params: _.omit(this.filters, 'category_name')
                    //params: this.filters,
                }).then((response) => {
                    this.posts = response.data.data;
                    this.pagination = response.data.meta;
                }).catch((error) => {

                }).finally(() => {
                    this.loading = false;
                    const el = this.$refs.ScrollPoint;
                    if (el) el.scrollIntoView({behavior: 'smooth'});
                });
            }
        },
        handleChange(page) {
            this.getPosts("", page);
            const el = this.$refs.ScrollPoint;
            if (el) el.scrollIntoView({behavior: 'smooth'});
        },
    }
}

</script>

<style scoped lang="css">
.hoverActive:hover {
    background: rgba(100, 100, 100, 0.2);
    color: rgba(40, 40, 20, 1);
}

.hoverActive {
    cursor: pointer;
    padding: 2px 4px;
    border-radius: 4px;
}

.hoverActive.active {
    background: dodgerblue;
    color: white;
}

.truncate {
    width: 100%;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>
