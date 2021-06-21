<template>
    <ul>
        <li v-for="(data, dat) in data" :key="data.id">
            <div class="d-flex justify-content-between align-items-center lists">
                <div class="cursor-pointer">
                    {{ data.title }} <span v-if="data.post_count != 0"> - ({{ data.post_count }})</span>
                </div>
                <div v-if="authUser && (authUser.id == data.user_id || buttons.includes('admin')) && user.status === 'active'">
                    <button class="btn btn-sm btn-primary" v-if="buttons && ( buttons.includes('add') || buttons.includes('admin') )"
                            @click.stop.prevent="toggleForm(data)"><i class="fas fa-plus"></i>
                    </button>
                    <button class="btn btn-sm btn-warning" v-if="buttons && ( buttons.includes('edit') || buttons.includes('admin') )"
                            @click.stop.prevent="editEvent(data)"><i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-danger" v-if="buttons && ( buttons.includes('delete') || buttons.includes('admin') )"
                            @click.stop.prevent="deleteEvent(data)"><i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            <div v-if="showForm && data.id == parent_id && user.status === 'active'">
                <div class="col-12 col-lg-10 row">
                    <div class="col">
                        <Custom_Text_Input
                            class="mb-2" type="text" placeholder="Post category title"
                            id="title" name="title" v-model="subCategoryData.title"
                            :error="errors.title && Array.isArray(errors.title) ? errors.title[0] : errors.title"/>
                    </div>
                    <div class="col">
                        <Custom_Text_Input
                            class="mb-2" type="text" placeholder="Post category title slug"
                            id="slug" name="slug" v-model="subCategoryData.slug" disabled="disabled"
                            :error="errors.slug && Array.isArray(errors.slug) ? errors.slug[0] : errors.slug"/>
                    </div>
                    <div class="col-3">
                        <Custom_Loading_Button
                            v-if="!editMode" class=" height-control"
                            @button_clicked="addEvent(data)" :processing="processing">
                            <span><span><i class="fas fa-plus"></i></span> Save</span>
                        </Custom_Loading_Button>

                        <Custom_Loading_Button
                            v-else class="height-control"
                            @button_clicked="updateEvent(data)" :processing="processing">
                            <span><span><i class="fas fa-edit"></i></span> Update</span>
                        </Custom_Loading_Button>

                        <button class="btn btn-sm btn-danger height-control" @click="closeForm()"><i class="fas fa-times"></i></button>
                    </div>
                </div>
            </div>

            <template v-if="data.children && Object.keys(data.children).length">
                <post-category-treeview
                    :data="data.children" :buttons="buttons"
                    @addEvent="addEvent($event)"
                    @editEvent="editEvent($event)"
                    @deleteEvent="deleteEvent($event)"
                    :authUser="authUser"
                    :userRole="userRole"/>
            </template>
        </li>
    </ul>
</template>

<script>
import postCategoryTreeview from "./post-category-treeview";
import {mapActions, mapGetters} from "vuex";

export default {
    name: "post-category-treeview",
    components: {postCategoryTreeview},
    data() {
        return {
            showForm: false,
            parent_id: '',
            subCategoryData: {
                title: '',
                slug: '',
                parent_id: null,
            },
            errors: {},
            processing: false,
            editMode: false,
        }
    },
    props: {
        data: {
            type: [Object, Array]
        },
        buttons: {
            type: [Object, Array]
        },
        permissions: {
            type: [Object, Array]
        },
        authUser: {
            type: [Object, Array]
        },
        userRole: {
            type: [Object, Array]
        },
    },
    computed: {
        ...mapGetters({
            user: 'auth/user',
            postCategoryErrors: 'postCategory/postCategoryErrors',
        })
    },
    watch: {
        'subCategoryData.title': function (newInput, oldInput) {
            if (newInput != oldInput) {
                this.subCategoryData.slug = this.slugify(newInput);
            }
        },
    },
    methods: {
        ...mapActions({
            addPostCategory: 'postCategory/addPostCategory',
            updatePostCategory: 'postCategory/updatePostCategory',
            clearError: 'postCategory/clearError',
        }),
        toggleForm(data) {
            this.clearForm();
            this.parent_id = data.id;
            this.showForm = true;
            this.editMode = false;
        },
        closeForm(data) {
            this.clearForm();
            this.parent_id = '';
            this.showForm = false;
            this.editMode = false;
        },
        addEvent(data) {
            this.subCategoryData.parent_id = data.id;
            this.createCategory();
            //this.$emit('addEvent', data);
        },
        editEvent(data) {
            this.subCategoryData.title = data.title;
            this.subCategoryData.slug = data.slug;
            this.parent_id = data.id;
            this.showForm = true;
            this.editMode = true;
            //this.$emit('editEvent', data);
        },
        deleteEvent(data) {
            this.$emit('deleteEvent', data);
        },

        async updateEvent(data) {
            this.processing = true;
            this.clearError();
            this.errors = {};

            let __this = this;
            if (!__this.subCategoryData.title.trim()) __this.errors.title = 'Title is required!';

            if (Object.keys(this.errors).length) {
                this.processing = false;
                return
            }

            const formData = {
                'title': this.subCategoryData.title,
                'slug': this.subCategoryData.slug,
                'id': data.id,
            }
            await this.updatePostCategory(formData).then(() => {
                this.showForm = true;
                this.editMode = false;
            }).finally(() => {
                this.processing = false;
            });

            if (this.postCategoryErrors != null) {
                this.errors = this.postCategoryErrors;
                return
            }
            this.clearForm();
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
            if (!__this.subCategoryData.title.trim()) __this.errors.title = 'Title is required!';

            if (Object.keys(this.errors).length) {
                this.processing = false;
                return
            }

            let formData = new FormData();
            formData.append('title', this.subCategoryData.title);
            formData.append('slug', this.subCategoryData.slug);
            formData.append('parent_id', this.subCategoryData.parent_id);

            await this.addPostCategory(formData).finally(() => {
                this.processing = false;
            });

            if (this.postCategoryErrors != null) {
                this.errors = this.postCategoryErrors;
                return
            }
            this.clearForm();
        },
        clearForm() {
            this.parent_id = null;
            this.subCategoryData = {
                title: '',
                slug: '',
                parent_id: '',
            }
        },
    }
}
</script>

<style scoped lang="css">
.lists {
    border-radius: 4px;
    padding: 4px 10px;
}

.lists:hover {
    background: rgba(100, 100, 100, 0.2);
    color: rgba(40, 40, 20, 1);
}

.cursor-pointer {
    cursor: pointer;
}

.height-control {
    height: 40px !important;
}
</style>
