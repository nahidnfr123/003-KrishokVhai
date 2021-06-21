<template>
    <div class="content-body position-relative">

        <div class="position-absolute overflow-loader d-flex justify-content-center" v-if="loading">
            <div class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="margin-top: 100px;"/>
        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="horz-layout-colored-controls">Manage Post category</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <!--<div class="heading-elements">
                                                    <ul class="list-inline mb-0">
                                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                                                    </ul>
                                                </div>-->
                    </div>
                    <div class="card-content collpase show">
                        <div class="card-body">
                            <div class="card-text">
                                <form method="post">
                                    <div class="row" v-if="user.status === 'active'">
                                        <h3 class="text-muted">Add new post category</h3>
                                        <div class="col-12 col-lg-6">
                                            <Custom_Text_Input
                                                class="mb-2"
                                                type="text"
                                                label="Post category title"
                                                placeholder="Crop health and nutrition"
                                                id="title"
                                                name="title"
                                                v-model="categoryData.title"
                                                :error="errors.title && Array.isArray(errors.title) ? errors.title[0] : errors.title"/>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <Custom_Text_Input
                                                class="mb-2"
                                                type="text"
                                                label="Post category title slug"
                                                placeholder="Crop-health-and-nutrition"
                                                id="slug"
                                                name="slug"
                                                v-model="categoryData.slug"
                                                disabled="disabled"
                                                :error="errors.slug && Array.isArray(errors.slug) ? errors.slug[0] : errors.slug"/>

                                            <div class="text-right">
                                                <Custom_Loading_Button
                                                    class="mb-2"
                                                    @button_clicked="createCategory"
                                                    :processing="processing">
                                                    <span>Save</span>
                                                </Custom_Loading_Button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>


                            <div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3 class="text-muted">Category list</h3>
                                    <button class="btn btn-sm btn-info" title="Refresh" @click.stop.prevent="getPostCategories()"><i class="fas fa-redo-alt"></i></button>
                                </div>
                                <hr>
                                <div v-if="Object.keys(postCategories).length">
                                    <post-category-treeview
                                        :data="postCategories"
                                        :buttons="buttons"
                                        @addEvent=""
                                        @editEvent=""
                                        @deleteEvent="deleteCategory($event)"
                                        :authUser="user"
                                        :userRole="userRole"
                                    />
                                </div>
                                <div v-else>
                                    <div v-if="!loading">
                                        <div class="alert alert-danger">
                                            No category available.
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import postCategoryTreeview from "./post-category-treeview";
import {mapActions, mapGetters} from "vuex";

export default {
    name: "ManageProductCategory",
    components: {postCategoryTreeview},
    data() {
        return {
            processing: false,
            loading: false,
            categoryData: {
                title: '',
                slug: '',
                parent_id: null,
            },
            errors: [],
            buttons: ['add', 'edit'],
        }
    },
    watch: {
        'categoryData.title': function (newInput, oldInput) {
            if (newInput != oldInput) {
                this.categoryData.slug = this.slugify(newInput);
            }
        },
    },
    computed: {
        ...mapGetters({
            postCategories: 'postCategory/postCategories',
            postCategoryErrors: 'postCategory/postCategoryErrors',
            user: 'auth/user',
            userRole: 'auth/roles',
        })
    },
    mounted() {
        this.getPostCategories();
    },
    methods: {
        ...mapActions({
            fetchPostCategory: 'postCategory/fetchPostCategory',
            addPostCategory: 'postCategory/addPostCategory',
            deletePostCategory: 'postCategory/deletePostCategory',
            clearError: 'postCategory/clearError',
        }),
        checkButtons() {
            this.buttons = ['add', 'edit']
            if (this.userRole && Object.keys(this.userRole).length) {
                for (let x = 0; x < Object.keys(this.userRole).length; x++) {
                    if (this.userRole[x].includes('developer') || this.userRole[x].includes('super admin') || this.userRole[x].includes('admin')) {
                        this.buttons = ['admin', 'add', 'edit', 'delete']
                    }
                }
            }
        },
        async getPostCategories() {
            this.loading = true;
            await this.fetchPostCategory().then(() => {
                this.checkButtons();
            }).finally(() => {
                this.loading = false
            });
        },
        slugify(text, ampersand = 'and') {
            const a = 'àáäâèéëêìíïîòóöôùúüûñçßÿỳýœæŕśńṕẃǵǹḿǘẍźḧ'
            const b = 'aaaaeeeeiiiioooouuuuncsyyyoarsnpwgnmuxzh'
            const p = new RegExp(a.split('').join('|'), 'g')

            return text.toString().toLowerCase()
                .replace(/[\s_]+/g, '-')
                .replace(p, c =>
                    b.charAt(a.indexOf(c)))
                .replace(/&/g, `-${ampersand}-`)
                .replace(/[^\w-]+/g, '')
                .replace(/--+/g, '-')
                .replace(/^-+|-+$/g, '');
        },
        async createCategory() {
            this.processing = true;
            this.clearError();
            this.errors = {};

            let __this = this;
            if (!__this.categoryData.title.trim()) __this.errors.title = 'Title is required!';

            if (Object.keys(this.errors).length) {
                this.processing = false;
                return
            }

            let formData = new FormData();
            formData.append('title', this.categoryData.title);
            formData.append('slug', this.categoryData.slug);

            await this.addPostCategory(formData).finally(() => {
                this.processing = false
            });

            if (this.postCategoryErrors != null) {
                this.errors = this.postCategoryErrors;
                return
            }
            this.clearForm();
        },
        clearForm() {
            this.categoryData = {
                title: '',
                slug: '',
            }
        },
        async deleteCategory(event) {
            this.$swal.fire({
                title: 'Are you sure you want to delete this category?',
                text: 'All the sub-categories will also be deleted.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    this.deletePostCategory(event.id).then(() => {
                        this.$swal.fire(
                            'Deleted!',
                            'Category has been deleted.',
                            'success'
                        )
                    });
                }
            });
        }
    }
}
</script>

<style scoped lang="css">
.overflow-loader {
    position: absolute !important;
    top: 0;
    left: 0;
    padding: 0;
    bottom: 0;
    z-index: 100000;
    background: rgba(20, 20, 20, .4);
    height: 100%;
    width: 100%;
    text-align: center;
    color: white;
}
</style>
