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
        <div class="famie-breadcrumb" ref="ScrollPoint">
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


        <!-- ##### Blog Area Start ##### -->
        <section class="famie-blog-area">
            <div class="container">
                <div class="row">
                    <!-- Posts Area -->
                    <div class="col-12 col-md-8">
                        <div class="posts-area">

                            <div class="col-12" v-if="loading">
                                <loading v-if="loading" msg="Loading posts ..."/>
                            </div>

                            <!-- Single Blog Post Area -->
                            <template v-if="posts && Object.keys(posts).length">
                                <div v-for="post in posts" class="single-blog-post-area mb-50 wow fadeInUp" data-wow-delay="100ms">
                                    <h6>Post on <a class="post-date">{{ post.created_at | dateFormatMDY }}</a>
                                        /
                                        <router-link to="/login" v-if="!user">{{ post.author }}</router-link>

                                        <a :href="`dashboard/@${user.username}/profile`" v-if="user && user.id == post.user_id"
                                           target="_blank">{{ post.author }}</a>

                                        <a :href="`/dashboard/@${user.username}/users/view-profile/${post.user_id}`" v-else-if="user"
                                           target="_blank" class="post-author">{{ post.author }}</a>
                                    </h6>

                                    <!--                                    <a href="#">Rising cattle supplies see beef export lifted</a>-->
                                    <router-link :to="{name:'Read Article', params:{articles_type: filters.articles_type, post_slug:post.slug}}" class="post-title">
                                        {{ post.title }}
                                    </router-link>
                                    <img :src="post.first_image?post.first_image:'/frontend-assets/placeholder.gif'" alt="" class="post-thumb rounded"
                                         style="width:100%; max-height: 400px; object-fit: cover; object-position: center center;">

                                    <div class="post-excerpt">{{ post.description | truncate(160) }}</div>
                                </div>
                            </template>


                            <div v-else role="alert">
                                <div class="alert alert-danger" v-if="!loading">
                                    No blogs found ...
                                </div>
                            </div>


                        </div>

                        <!-- pagination -->
                        <div v-if="posts && Object.keys(posts).length" class="paginationLink row">
                            <div class="col-12 col-md-6" style="margin-top: 10px;">
                                <pagination
                                    v-if="pagination.last_page > 1"
                                    :pagination="pagination"
                                    :offset="5"
                                    @paginate="getPosts()"
                                    class="">
                                </pagination>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar Area -->
                    <div class="col-12 col-md-4">
                        <div class="sidebar-area">

                            <!-- Single Widget Area -->
                            <div class="single-widget-area">
                                <div>
                                    <label for="_search_">Search</label>
                                    <input type="text" class="form-control" v-model="filters.query" id="_search_">
                                </div>
                            </div>

                            <!-- Single Widget Area -->
                            <div class="single-widget-area">
                                <!-- Title -->
                                <h5 class="widget-title">Categories</h5>
                                <!-- Cata List -->
                                <div v-if="postCategories && Object.keys(postCategories).length"
                                     style="border-radius: 4px;">
                                    <h6 class="cursor-pointer hoverActive" :class="[postCategoryId==0?'bg-primary text-white':'']"
                                        @click.stop.prevent="showAllCategory">All</h6>
                                    <category-list-frontend
                                        categoryProductCountFilter="news"
                                        :data="postCategories" id="searchCategory"
                                        @nodeClicked="selectedCategories($event)"
                                        :selectedCategory="postCategoryId"/>
                                </div>
                            </div>

                            <!-- Single Widget Area -->
                            <!--                            <div class="single-widget-area">
                                                            &lt;!&ndash; Title &ndash;&gt;
                                                            <h5 class="widget-title">Recent News</h5>

                                                            &lt;!&ndash; Single Recent News Start &ndash;&gt;
                                                            <div class="single-recent-blog style-2 d-flex align-items-center">
                                                                <div class="post-thumbnail">
                                                                    <img src="img/bg-img/30.jpg" alt="">
                                                                </div>
                                                                <div class="post-content">
                                                                    <a href="#" class="post-title">US milk production continues its upward trajectory for 2018</a>
                                                                    <div class="post-date">18 Aug 2018</div>
                                                                </div>
                                                            </div>

                                                            &lt;!&ndash; Single Recent News Start &ndash;&gt;
                                                            <div class="single-recent-blog style-2 d-flex align-items-center">
                                                                <div class="post-thumbnail">
                                                                    <img src="img/bg-img/31.jpg" alt="">
                                                                </div>
                                                                <div class="post-content">
                                                                    <a href="#" class="post-title">USDA'S crop ratings more ahead for corn, drop for soybeans</a>
                                                                    <div class="post-date">18 Aug 2018</div>
                                                                </div>
                                                            </div>

                                                            &lt;!&ndash; Single Recent News Start &ndash;&gt;
                                                            <div class="single-recent-blog style-2 d-flex align-items-center">
                                                                <div class="post-thumbnail">
                                                                    <img src="img/bg-img/32.jpg" alt="">
                                                                </div>
                                                                <div class="post-content">
                                                                    <a href="#" class="post-title">Auction report: Bids aplenty for massive John Deere collection</a>
                                                                    <div class="post-date">18 Aug 2018</div>
                                                                </div>
                                                            </div>

                                                            &lt;!&ndash; Single Recent News Start &ndash;&gt;
                                                            <div class="single-recent-blog style-2 d-flex align-items-center">
                                                                <div class="post-thumbnail">
                                                                    <img src="img/bg-img/33.jpg" alt="">
                                                                </div>
                                                                <div class="post-content">
                                                                    <a href="#" class="post-title">Wool prices expected to remain competitive as demand is grow</a>
                                                                    <div class="post-date">18 Aug 2018</div>
                                                                </div>
                                                            </div>
                                                        </div>-->

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ##### Blog Area End ##### -->
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import Pagination from "../../components/pagination";
import CategoryListFrontend from "./category-list-frontend";

export default {
    name: "Blogs",
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
            postCategories: {},
            pagination: {
                current_page: 1
            },
            postCategoryId: 0,
            filters: {
                articles_type: 'news',
                query: "",
                category_name: '',
                categories: [],
                limit: '8',
            }
        }
    },
    activated() {
        this.filters = {
            articles_type: 'news',
            query: "",
            category_name: '',
            categories: [],
            limit: '8',
        }
    },
    created() {
        this.getPosts();
        this.getPostCategories();
    },
    watch: {
        '$route': {
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
        },
    }, computed: {
        ...mapGetters({
            postsFrontend: 'post/postsFrontend',
            user: 'auth/user',
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
            this.filters.articles_type = 'news';
            this.loading = true;

            await axios.get(`api/post/frontend?page=${page}`, {
                params: this.filters,
            }).then((response) => {
                this.posts = response.data.data;
                this.pagination = response.data.meta;
            }).catch((error) => {

            }).finally(() => {
                const el = this.$refs.ScrollPoint;
                if (el) el.scrollIntoView({behavior: 'smooth'});
                this.loading = false;
            });
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

