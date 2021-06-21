<template>
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"
         style="z-index: 2000000 !important;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ modalTitle }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            @click.stop.prevent="closeModal"></button>
                </div>
                <div class="modal-body">
                    <form method="post" encType="multipart/form-data">
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <Custom_Text_Input
                                    class="mb-2"
                                    type="text"
                                    label="Post title"
                                    placeholder=""
                                    id="title"
                                    name="title"
                                    v-model="postData.title"
                                    :error="errors.title && Array.isArray(errors.title) ? errors.title[0] : errors.title"/>
                            </div>

                            <div class="col-12 col-lg-6">
                                <Custom_Text_Input
                                    class="mb-2"
                                    type="text"
                                    label="Post title slug"
                                    placeholder=""
                                    id="slug"
                                    name="slug"
                                    v-model="postData.slug"
                                    disabled="disabled"
                                    :error="errors.slug && Array.isArray(errors.slug) ? errors.slug[0] : errors.slug"/>
                            </div>

                            <div class="col-12 col-lg-6">
                                <Custom_Text_Input
                                    class="mb-2"
                                    type="text"
                                    label="Author"
                                    placeholder=""
                                    id="author"
                                    name="author"
                                    v-model="postData.author"
                                    :error="errors.author && Array.isArray(errors.author) ? errors.author[0] : errors.author"/>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label class="">Status</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="activeStatus" :value="true"
                                               v-model="postData.status" :checked="postData.status">
                                        <label class="form-check-label" for="activeStatus">Active</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="inactiveStatus" :value="false"
                                               v-model="postData.status" :checked="!postData.status">
                                        <label class="form-check-label" for="inactiveStatus">Inactive</label>
                                    </div>
                                    <div v-if="errors.status && Array.isArray(errors.status) ? errors.status[0] : errors.status">
                                        <p class="text-danger mt-1">{{ errors.status && Array.isArray(errors.status) ? errors.status[0] : errors.status }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label for="postType">Post type</label>
                                    <select name="postType" id="postType" class="form-control" v-model="postData.type">
                                        <option value="" selected disabled>Select</option>
                                        <option value="farming-practice">Farming Practice</option>
                                        <option value="news">News</option>
                                        <option value="blog">Blog</option>
                                    </select>
                                    <div v-if="errors.type && Array.isArray(errors.type) ? errors.type[0] : errors.type">
                                        <p class="text-danger mt-1">{{ errors.type && Array.isArray(errors.type) ? errors.type[0] : errors.type }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="postImage">Image</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="postImage" ref="fileInput"
                                               multiple
                                               accept="image/*"
                                               @change="onFilePicked"
                                        >
                                        <label class="custom-file-label" for="postImage">Choose file...</label>
                                    </div>

                                    <div v-if="imageUrls.length" class="mt-1">
                                        <div v-if="uploadedImageUrls && uploadedImageUrls.length">Ready to uploaded</div>
                                        <div class="d-flex flex-wrap">
                                            <div v-for="(image, im) in imageUrls" :key="im" class="position-relative formImageContainer">
                                                <img :src="image" alt="image" height="50px" class="rounded" style="margin: 2px 6px 2px 0;">
                                                <div class="imageCloseButton" @click.stop.prevent="removeImageFromCollection(im)">
                                                    <i class="fas fa-times text-white"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div v-if="editMode && uploadedImageUrls && uploadedImageUrls.length" class="mt-1">
                                        <div>Uploaded</div>
                                        <div class="d-flex flex-wrap">
                                            <div v-for="(image, ke) in uploadedImageUrls" :key="ke" class="position-relative formImageContainer">
                                                <img :src="image" alt="image" height="50px" class="rounded" style="margin: 2px 6px 2px 0;">
                                                <div class="imageCloseButton" @click.stop.prevent="deleteImageFromDatabase(ke)">
                                                    <i class="fas fa-times text-white"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div v-if="errors.images && Array.isArray(errors.images) ? errors.images[0] : errors.images">
                                        <p class="text-danger mt-1">{{ errors.images && Array.isArray(errors.images) ? errors.images[0] : errors.images }}</p>
                                    </div>

                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label for="searchCategory">Select category</label>
                                    <div v-if="postCategories && Object.keys(postCategories).length" style="height: 200px; overflow: scroll; border-radius: 4px; border: 2px solid gray;">
                                        <category-list :data="postCategories" id="searchCategory"
                                                       @nodeClicked="toggleCategory($event)"
                                                       :selectedCategories="postData.categoriesId"/>
                                    </div>
                                    <div v-if="errors.category && Array.isArray(errors.category) ? errors.category[0] : errors.category">
                                        <p class="text-danger mt-1">{{ errors.category && Array.isArray(errors.category) ? errors.category[0] : errors.category }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-lg-12">
                                <div class="form-group">
                                    <label for="description">Description</label>

                                    <ckeditor @ready="onCK_EditorReady"
                                              :editor="editor"
                                              v-model="postData.description"
                                              :config="editorConfig"
                                              id="description"></ckeditor>

                                    <div v-if="errors.description && Array.isArray(errors.description) ? errors.description[0] : errors.description">
                                        <p class="text-danger mt-1">{{ errors.description && Array.isArray(errors.description) ? errors.description[0] : errors.description }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="text-right">
                                <Custom_Loading_Button
                                    v-if="!editMode"
                                    class=""
                                    @button_clicked="createPost"
                                    :processing="processing">
                                    <span>Save</span>
                                </Custom_Loading_Button>
                                <Custom_Loading_Button
                                    v-else
                                    class=""
                                    @button_clicked="update()"
                                    :processing="processing">
                                    <span>Update</span>
                                </Custom_Loading_Button>
                                <button type="button" class="btn btn-secondary" @click="closeModal()">Close</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" ref="ModalClose" style="display: none;">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!--                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>-->
            </div>
        </div>
    </div>
</template>

<script>
import CKEditor from '@ckeditor/ckeditor5-vue2';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import {mapActions, mapGetters} from "vuex";
import CategoryList from "./category-list";

export default {
    name: "modal.vue",
    components: {
        CategoryList,
        // Use the <ckeditor> component in this view.
        ckeditor: CKEditor.component,
    },
    props: {
        modalTitle: String,
        editMode: {
            type: Boolean,
            default: false
        },
        postCategories: {
            type: [Object, Array]
        },
        postData: {
            type: [Object, Array],
            default: {
                title: '',
                slug: '',
                status: true,
                type: '',
                author: '',
                images: [],
                description: '',
                categoriesId: [],
            }
        },
        uploadedImageUrls: {
            type: [Object, Array],
        }
    },
    data() {
        return {
            editor: ClassicEditor,
            editorConfig: {
                // The configuration of the editor.
            },
            imageUrls: [],
            errors: {},
            processing: false,
            loading: false,
        }
    },
    watch: {
        'postData.title': function (newInput, oldInput) {
            if (newInput != oldInput) {
                this.postData.slug = this.slugify(newInput);
            }
        },
        editMode: function (newInput, oldInput) {
            if (this.editMode == false) {
                this.clearForm();
            }
        },
    },
    computed: {
        ...mapGetters({
            postErrors: 'post/postErrors',
            user: 'auth/user',
        })
    },
    mounted() {
        if (this.user) {
            this.postData.author = this.user.first_name + ' ' + this.user.last_name
        }
        this.clearForm();
    },
    beforeDestroy() {
        this.clearForm();
    },
    methods: {
        ...mapActions({
            fetchPostCategory: 'postCategory/fetchPostCategory',
            fetchPost: 'post/fetchPost',
            addPost: 'post/addPost',
            updatePost: 'post/updatePost',
            clearError: 'post/clearError',
        }),
        onCK_EditorReady: function () {
            this.editorValue = this.postData.description;
        },
        closeModal() {
            this.errors = [];
            this.$emit('closeFormModal', true);
            this.$refs.ModalClose.click();
        },
        onFilePicked(event) {
            const files = event.target.files
            if (files.length > 4) {
                alert('You can upload maximum 4 images for a post.');
                return false
            }
            if (files.length > 0) {
                for (let i = 0; i < files.length; i++) {
                    let filename = files[i].name;
                    let file = files[i];
                    if (/\.(jpe?g|png|gif)$/i.test(file.name)) {
                        if (file['size'] > 2111775) {
                            alert('File size can not be bigger than 2 MB');
                            return false;
                        } else {
                            let fileReader = new FileReader()
                            fileReader.addEventListener('load', () => {
                                this.imageUrls.push(fileReader.result)
                            })
                            fileReader.readAsDataURL(files[i])
                            this.postData.images.push(files[i]);
                        }
                    } else {
                        alert('Invalid file type present! File must be jpeg, jpg or png.');
                        return false;
                    }
                }
            }
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
        toggleCategory(id) {
            const index = this.postData.categoriesId.indexOf(id);
            if (index > -1) {
                this.postData.categoriesId.splice(index, 1);
            } else {
                this.postData.categoriesId.push(id);
            }
        },
        async createPost() {
            this.processing = true;
            this.clearError();
            this.errors = {};

            this.validateData();
            if (Object.keys(this.errors).length) {
                this.processing = false;
                return
            }
            const formData = new FormData();
            formData.append("_method", "post");
            formData.append('title', this.postData.title);
            formData.append('slug', this.postData.slug);
            formData.append('status', this.postData.status);
            formData.append('type', this.postData.type);
            formData.append('author', this.postData.author);
            formData.append('description', this.postData.description);
            //formData.append('categoriesId', this.postData.categoriesId);
            if (this.postData.categoriesId.length > 0) {
                for (let i = 0; i < this.postData.categoriesId.length; i++) {
                    formData.append('category[]', this.postData.categoriesId[i]);
                }
            } else formData.append('category', '');

            if (this.postData.images.length) {
                for (let i = 0; i < this.postData.images.length; i++) {
                    formData.append('images[]', this.postData.images[i]);
                }
            } else formData.append('images', '');

            const config = {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                }
            }
            await this.addPost(formData, config).finally(() => this.processing = false);

            if (this.postErrors != null) {
                this.errors = this.postErrors;
                return
            }

            this.$emit('postAdded')
            this.clearForm();
            this.$refs.ModalClose.click();
        },
        validateData() {
            let __this = this;
            if (!__this.postData.title.trim()) __this.errors.title = 'Post title is required!';
            if (!__this.postData.slug.trim()) __this.errors.slug = 'Post title slug is required!';
            if (!__this.postData.type.trim()) __this.errors.type = 'Post type is required!';
            if (!__this.postData.description.trim()) __this.errors.description = 'Post description is required!';
            if (!__this.postData.author.trim()) __this.errors.author = 'Post author is required!';
            if (!__this.postData.categoriesId.length > 0) __this.errors.category = 'Post category is required!';
        },
        clearForm() {
            this.errors = {};
            this.postData.id = '';
            this.postData.title = '';
            this.postData.slug = '';
            this.postData.status = true;
            this.postData.type = '';
            this.postData.images = [];
            this.postData.description = '';
            this.postData.categoriesId = [];
            this.imageUrls = [];
        },
        async update() {
            if (!this.postData.id) return false;

            this.processing = true;
            this.clearError();
            this.errors = {};

            this.validateData();
            if (Object.keys(this.errors).length) {
                this.processing = false;
                return
            }

            const formData = new FormData();
            formData.append("_method", "PUT");
            formData.append('id', this.postData.id);
            //data.append('_method', 'PUT');
            //formData.append("_method", "post");
            formData.append('title', this.postData.title);
            formData.append('slug', this.postData.slug);
            formData.append('status', this.postData.status);
            formData.append('type', this.postData.type);
            formData.append('author', this.postData.author);
            formData.append('category', this.postData.categoriesId);
            formData.append('description', this.postData.description);

            if (this.postData.categoriesId.length) {
                for (let i = 0; i < this.postData.categoriesId.length; i++) {
                    formData.append('category[]', parseInt(this.postData.categoriesId[i]));
                }
            }

            if (this.postData.images.length) {
                for (let i = 0; i < this.postData.images.length; i++) {
                    formData.append('images[]', this.postData.images[i]);
                }
            }

            const config = {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                }
            };
            await axios.post(`api/post/${this.postData.id}`, formData, config).then((response) => {
                this.$store.dispatch('post/fetchPost', response, {root: true});
                this.$store.dispatch('snackbar/addSnack', {color: 'success', msg: 'Post updated successfully', snakbarType: 'Success'}, {root: true});
                this.clearForm();
                this.$refs.ModalClose.click();
                this.$emit('updated');
            }).catch((error) => {
                let err = error.response.data.error
                if (error.response && error.response.status == 422) {
                    this.$store.dispatch('snackbar/addSnack', {color: 'danger', msg: err, snakbarType: 'Error'}, {root: true});
                } else {
                    this.$store.dispatch('snackbar/addSnack', {color: 'danger', msg: 'Error updating post', snakbarType: 'Error'}, {root: true});
                }
            }).finally(() => this.processing = false);
        },
        removeImageFromCollection(imageKey) {
            this.postData.images.splice(imageKey, 1);
            this.imageUrls.splice(imageKey, 1);
        },
        async deleteImageFromDatabase(key) {
            if (this.postData && this.postData.id) {
                await axios.delete(`api/post/image/${key}/${this.postData.id}/delete`)
                    .then((response) => {
                        this.$emit('imageDeleted', key);
                        this.$store.dispatch('snackbar/addSnack', {color: 'success', msg: 'Image deleted.', snakbarType: 'Success'}, {root: true});
                    }).catch((error) => {
                        this.$store.dispatch('snackbar/addSnack', {color: 'delete', msg: 'Error deleting image!', snakbarType: 'error'}, {root: true});
                    })
            }
        },
    },
}
</script>


<style scoped lang="scss">
.formImageContainer {
    &:hover {
        .imageCloseButton {
            background: red;
        }
    }

    .imageCloseButton {
        position: absolute;
        top: 0;
        right: 4px;
        border-radius: 50%;
        background: coral;
        color: white;
        height: 20px;
        width: 20px;
        text-align: center;
        font-size: 16px;
        line-height: 20px;
        z-index: 2;
        cursor: pointer;
        transition: all 200ms ease-in-out;
    }
}
</style>
