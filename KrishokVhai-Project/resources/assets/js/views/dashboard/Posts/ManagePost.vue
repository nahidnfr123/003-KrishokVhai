<template>
    <div class="content-body">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title d-flex justify-content-between align-items-center">
                            <h4>Posts</h4>
                            <div>
                                <button type="button" style="display: none;" data-toggle="modal" data-target=".bd-example-modal-lg" ref="modalOpenButton"></button>
                                <button type="button" class="btn btn-sm btn-primary btn-glow" v-if="user.status === 'active'"
                                        @click="addPost()">Add post
                                </button>
                                <button type="button" class="btn btn-sm btn-warning btn-glow"
                                        @click.stop.prevent="searchFrom = !searchFrom">Search
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-12" v-if="searchFrom">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h4>Search Post</h4>
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <Custom_Text_Input
                                        class="mb-2"
                                        type="text"
                                        label="Search Query"
                                        placeholder="Search"
                                        id="search"
                                        name="search"
                                        v-model="searchFields.searchQuery"
                                        :error="errors.searchQuery && Array.isArray(errors.searchQuery) ? errors.searchQuery[0] : errors.searchQuery"
                                        Add_Input_Class="form-control-sm"/>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="searchPostType">Post type</label>
                                        <select name="postType" id="searchPostType" class="form-control form-control-sm" v-model="searchFields.searchByType">
                                            <option value="" selected>All</option>
                                            <option value="farming-practice">Farming Practices</option>
                                            <option value="news">News</option>
                                            <option value="blog">Blog</option>
                                        </select>
                                        <div v-if="errors.searchByType && Array.isArray(errors.searchByType) ? errors.searchByType[0] : errors.searchByType">
                                            <p class="text-danger mt-1">{{ errors.searchByType && Array.isArray(errors.searchByType) ? errors.searchByType[0] : errors.searchByType }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="form-group">
                                        <label for="searchByStatus">Status</label>
                                        <select name="postType" id="searchByStatus" class="form-control form-control-sm" v-model="searchFields.searchByStatus">
                                            <option value="" selected>All</option>
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                        <div v-if="errors.searchByStatus && Array.isArray(errors.searchByStatus) ? errors.searchByStatus[0] : errors.searchByStatus">
                                            <p class="text-danger mt-1">{{ errors.searchByStatus && Array.isArray(errors.searchByStatus) ? errors.searchByStatus[0] : errors.searchByStatus }}</p>
                                        </div>
                                    </div>
                                </div>
                                <!--                                <div class="col-12 col-lg-6">
                                                                    <div class="form-group">
                                                                        <label for="postCategory">Category</label>
                                                                        <select name="postType" id="postCategory" class="form-control" v-model="searchFields.postCategory">
                                                                            <option value="" selected>All</option>
                                                                        </select>
                                                                        <div v-if="errors.postCategory && Array.isArray(errors.postCategory) ? errors.postCategory[0] : errors.postCategory">
                                                                            <p class="text-danger mt-1">{{ errors.postCategory && Array.isArray(errors.postCategory) ? errors.postCategory[0] : errors.postCategory }}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>-->
                            </div>
                            <!--                            <button class="btn btn-warning btn-glow"><i class="fas fa-search"></i> Search</button>-->
                            <button class="btn btn-danger btn-glow" @click.stop.prevent="clearSearchForm()">Close</button>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title d-flex justify-content-between align-items-center">
                            <div>
                                <button type="button" class="btn btn-sm btn-glow"
                                        :class="[showingAllPost?'btn-primary':'btn-default']" @click.stop.prevent="showingAllPost=true">All Post
                                </button>
                                <button type="button" class="btn btn-sm btn-glow"
                                        :class="[!showingAllPost?'btn-primary':'btn-default']" @click.stop.prevent="showingAllPost=false">My post
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-12" v-if="loading">
                <loading v-if="loading" msg="Loading posts ..."/>
            </div>


            <div class="col-md-12">
                <div class="row" v-if="Object.keys(posts).length && !loading">
                    <div class="col-12 col-lg-6" v-for="post in posts" :key="post.id">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">{{ post.title }}</h4>
                                <span class="text-medium-1 danger line-height-2 text-uppercase"><strong>Post Type:</strong> {{ post.type }}, </span>
                                <span class="text-medium-1 danger line-height-2 text-uppercase"><strong>Status:</strong> {{ post.status ? 'Active' : 'Inactive' }}</span>
                                <div class="heading-elements">
                                    <ul class="list-inline mb-0 display-block">
                                        <li>
                                            <router-link :to="{name:'Read Posts', params:{post_slug:post.slug}}"
                                                         class="btn btn-md btn-success box-shadow-2 round pull-right">
                                                Read More
                                            </router-link>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body pt-0 pb-1">

                                    <div v-if="post.imageUrls && post.imageUrls.length" class="mb-1" style="max-height: 60px; overflow: hidden;">
                                        <img v-for="img in post.imageUrls" :src="img" alt="image" class="rounded" height="60px" style="margin-right: 6px;">
                                    </div>

                                    <div>{{ post.description | truncate(200) }}</div>
                                    <!--                                    <div v-html=post.description style="max-height: 100px; overflow: hidden; padding: 0 0 20px 0!important;"></div>-->

                                    <div class="mt-2" v-if="user.id == post.user_id || canAccess(['developer', 'super admin', 'admin'])">
                                        <button class="btn btn-sm btn-primary" @click.stop.prevent="editPost(post)" v-if="user.status === 'active'">Edit</button>
                                        <button class="btn btn-sm btn-danger" @click.stop.prevent="deletePosts(post)" v-if="user.status === 'active'">Delete</button>
                                    </div>
                                    <div class="media d-flex">
                                        <div class="align-self-center">
                                            <h6 class="text-bold-600 mt-1"> Categories:
                                                <span class="blue-grey" v-if="post.categories && post.categories !=null && Object.keys(post.categories).length">
                                                    <span v-for="categories in post.categories">{{ categories.title + ' | ' }} </span>
                                                </span>
                                            </h6>
                                            <h6 class="text-bold-600 mt-1"> Author:
                                                <span class="blue-grey">{{ post.author }}</span>
                                            </h6>
                                            <h6 class="text-bold-600 mt-1"> Published at:
                                                <span class="blue-grey">{{ post.created_at | dateFormatMDY }}</span>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div v-if="Object.keys(posts).length > 0" class="paginationLink row">
                        <div class="col-12 col-md-6 my-2">
                            Showing (
                            <!--<span class="text-warning text-bold-600">{{ pagination.per_page * pagination.current_page }}</span>-->
                            <span class="text-warning text-bold-600">{{ pagination.from }} -  {{ pagination.to }}</span> ) from
                            <span class="text-warning text-bold-600">{{ pagination.total }}</span> posts
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

                <div class="col-12" v-else>
                    <div class="alert alert-danger" v-if="!loading">
                        No posts available!
                    </div>
                </div>
            </div>
        </div>


        <manage-post-modal
            :modalTitle="!editMode?'Add post':'Edit Post'"
            :postCategories="postCategories"
            :editMode="editMode"
            :postData="postData"
            @postAdded="fetchAllPost()"
            @updated="fetchAllPost()"
            :uploadedImageUrls="uploadedImageUrls"
            @imageDeleted="refreshPostImages($event)"/>

    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import Pagination from "../../../components/pagination.vue";
import ManagePostModal from "../../../components/ManagePostModal.vue";
import _ from "lodash";

export default {
    name: 'ManagePosts',
    components: {
        ManagePostModal,
        //ManagePostModal: () => import(/*webpackChunkName: "DashboardManagePostModal"*/'../../../components/ManagePostModal.vue'),
        Pagination,
    },
    data() {
        return {
            searchFrom: false,
            showingAllPost: true,
            posts: {},
            postData: {
                title: '',
                slug: '',
                status: true,
                type: '',
                author: '',
                images: [],
                description: '',
                categoriesId: [],
            },
            uploadedImageUrls: [],
            pagination: {
                current_page: 1
            },
            errors: {},
            processing: false,
            loading: false,
            editMode: false,

            searchFields: {
                searchQuery: '',
                postCategory: '',
                searchByType: '',
                searchByStatus: '',
            },
        }
    },
    watch: {
        'searchFields.searchQuery': _.debounce(function (newQuery) {
            this.pagination.current_page = 1;
            let fields = this.searchFields;
            newQuery == '' && fields.postCategory == '' && fields.searchByType == '' && fields.searchByStatus == '' && fields.userId == null ?
                this.fetchAllPost() : this.search();
        }, 800),
        'searchFields.searchByType': function (type) {
            this.pagination.current_page = 1;
            let fields = this.searchFields;
            type == '' && fields.searchQuery == '' && fields.postCategory == '' && fields.searchByType == '' && fields.searchByStatus == '' && fields.userId == null ?
                this.fetchAllPost() : this.search();
        },
        'searchFields.searchByStatus': function (status) {
            this.pagination.current_page = 1;
            let fields = this.searchFields;
            status == '' && fields.searchQuery == '' && fields.postCategory == '' && fields.searchByType == '' && fields.searchByStatus == '' && fields.userId == null ?
                this.fetchAllPost() : this.search();
        },
        showingAllPost: function (newValue, oldValue) {
            this.pagination.current_page = 1;
            this.showingAllPost == true ? this.fetchAllPost() : this.search();
        },
    },
    computed: {
        ...mapGetters({
            postCategories: 'postCategory/postCategories',
            getPosts: 'post/posts',
            getPagination: 'post/getPagination',
            postErrors: 'post/postErrors',
            user: 'auth/user',
            userRole: 'auth/roles',
        })
    },
    mounted() {
        this.getPostCategories();
        this.fetchAllPost();
    },
    methods: {
        ...mapActions({
            fetchPostCategory: 'postCategory/fetchPostCategory',
            addPost: 'post/addPost',
            deletePost: 'post/deletePost',
            clearError: 'post/clearError',
            fetchPost: 'post/fetchPost',
        }),
        canAccess(accessibleTo = ['developer', 'super admin']) {
            if (this.userRole && this.userRole.length) {
                for (let i = 0; i < this.userRole.length; i++) {
                    if (accessibleTo.includes(this.userRole[i])) {
                        return true;
                    }
                }
            }
        },
        refreshPostImages(value) {
            this.uploadedImageUrls.splice(value, 1);
            this.fetchAllPost();
        },
        async getPostCategories() {
            await this.fetchPostCategory();
        },
        handleChange(page) {
            //this.pagination.current_page = page; /// error occurs for this code ...
            const S = this.searchFields;
            if (S.searchQuery !== '' || S.postCategory !== '' || S.searchByType !== '') {
                this.search(page, false)
            } else {
                this.fetchAllPost(page, false)
            }
        },
        async fetchAllPost(page, load = true) {
            this.loading = load;
            await this.fetchPost(page || this.pagination.current_page).then(() => {
                this.posts = this.getPosts;
                //this.showingAllPost = false;
                this.pagination = this.getPagination;
            }).finally(() => {
                this.loading = false;
            });
        },
        clearSearchForm() {
            this.searchFrom = false;
            this.searchFields = {
                searchQuery: '',
                postCategory: '',
                searchByType: '',
                searchByStatus: '',
            };
        },
        addPost() {
            this.editMode = false;
            this.$refs.modalOpenButton.click();
        },
        async search(page, load = true) {
            this.loading = load;
            await axios.get("api/post/search?query=" +
                this.searchFields.searchQuery + '&postCategory=' +
                this.searchFields.postCategory + "&postType=" +
                this.searchFields.searchByType + "&postStatus=" +
                this.searchFields.searchByStatus + "&showingAllPost=" +
                this.showingAllPost + "&page=" +
                page || this.pagination.current_page)
                .then(response => {
                    this.posts = response.data.data;
                    this.pagination = response.data.meta;
                })
                .catch(errors => this.errors = errors)
                .finally(() => this.loading = false);
        },
        editPost(post) {
            this.postData.id = post.id;
            this.postData.title = post.title;
            this.postData.slug = post.slug;
            this.postData.status = post.status == 1 ? true : false;
            this.postData.type = post.type;
            this.postData.images = [];
            this.postData.description = post.description;
            let categoryIds = []
            for (let i = 0; i < post.categories.length; i++) {
                categoryIds.push(post.categories[i].id);
            }
            this.uploadedImageUrls = post.imageUrls;
            this.postData.categoriesId = categoryIds;
            this.editMode = true;
            this.$refs.modalOpenButton.click();
        },
        async deletePosts(event) {
            this.$swal.fire({
                title: 'Are you sure you want to delete this post?',
                text: 'You cannot retrieve the post.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    this.deletePost(event.id).then(() => {
                        this.$swal.fire(
                            'Deleted!',
                            'Post has been deleted.',
                            'success'
                        )
                    });
                }
            });
        }
    },
}
</script>
