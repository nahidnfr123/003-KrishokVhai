<template>
    <div class="content-body">
        <div class="row">
            <div class="col-md-12" v-if="post && Object.keys(post).length">
                <div class="card">
                    <div class="card-header">
                        <h1 class="card-title" id="horz-layout-colored-control">{{ post.type | capitalize }}</h1>
                        <div class="pull-right">
                            <button class="btn btn-sm btn-success" @click="$router.back()">Back</button>
                            <div class="mt-2" v-if="user.id == post.user_id || canAccess(['developer', 'super admin', 'admin'])">
                                <button class="btn btn-sm btn-primary" @click.stop.prevent="editPost(post)" v-if="user.status === 'active'">Edit</button>
                                <button class="btn btn-sm btn-danger" @click.stop.prevent="deletePosts(post)" v-if="user.status === 'active'">Delete</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            <div class="card-text">
                                <h2 class="card-title" id="horz-layout-colored-controls">{{ post.title }}</h2>

                                <div v-if="post.imageUrls" class="mb-1">
                                    <img v-for="img in post.imageUrls" :src="img" alt="image" class="rounded" height="200px" style="margin: 3px; border-radius: 6px;">
                                </div>

                                <div>
                                    <h6 class="text-bold-600 mt-1"> Published at:
                                        <span class="blue-grey">{{ post.created_at | dateFormatMDY }}</span>
                                    </h6>
                                    <h6 class="text-bold-600 mt-1"> Status
                                        <span class="blue-grey">{{ post.status == 1 ? 'Active' : 'Inactive' }}</span>
                                    </h6>
                                    <h6 class="text-bold-600 mt-1"> Author:
                                        <span class="blue-grey">{{ post.author }}</span>
                                    </h6>
                                    <h6 class="text-bold-600 mt-1"> Post type:
                                        <span class="blue-grey">{{ post.type }}</span>
                                    </h6>
                                    <h6 class="text-bold-600 mt-1"> Categories:
                                        <span class="blue-grey" v-if="post.categories && Object.keys(post.categories).length">
                                        <span v-for="categories in post.categories">{{ categories.title + ' | ' }} </span>
                                    </span>
                                    </h6>
                                    <br>
                                </div>

                                <div v-html=post.description></div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <button type="button" style="display: none;" data-toggle="modal" data-target=".bd-example-modal-lg" ref="modalOpenButton"></button>

            <manage-post-modal
                v-if="post && editMode"
                :modalTitle="!editMode?'Add post':'Edit Post'"
                :postCategories="postCategories"
                :editMode="editMode"
                :postData="postData"
                @updated="getAPost()"
                :uploadedImageUrls="uploadedImageUrls"
                @imageDeleted="refreshPostImages($event)"/>

        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import ManagePostModal from "../../../components/ManagePostModal";

export default {
    name: 'ReadPost',
    components: {
        ManagePostModal,
    },
    data() {
        return {
            post: {},
            postData: {
                title: '',
                slug: '',
                status: 1,
                type: '',
                author: '',
                images: [],
                description: '',
                categoriesId: [],
            },
            uploadedImageUrls: [],
            editMode: false,
        }
    },
    computed: {
        ...mapGetters({
            postCategories: 'postCategory/postCategories',
            postErrors: 'post/postErrors',
            user: 'auth/user',
        })
    },
    mounted() {
        this.getAPost();
    },
    activated() {
        // this.getAPost();
        this.getPostCategories();
    },
    methods: {
        ...mapActions({
            fetchPostCategory: 'postCategory/fetchPostCategory',
            deletePost: 'post/deletePost',
            clearError: 'post/clearError',
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
        async getPostCategories() {
            await this.fetchPostCategory().finally(() => {
            });
        },
        refreshPostImages(value) {
            this.uploadedImageUrls.splice(value, 1);
            this.getAPost();
        },
        async getAPost() {
            const slug = this.$route.params.post_slug;
            await axios.get(`api/post/${slug}`).then((response) => {
                this.post = response.data.data
            }).catch(error => {
                this.$router.replace({name: 'page_not_found'});
            });
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
                text: 'You will not be able to retrieve it.',
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
                        );
                        this.$router.back();
                    });
                }
            });
        },
    },
}
</script>
