<template>
    <div class="content-body">
        <div class="row">

            <div class="col-md-12" ref="AddEditForm">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title d-flex justify-content-between align-items-center">
                            <h4>Products</h4>
                            <div>
                                <button type="button" class="btn btn-sm btn-primary btn-glow"
                                        @click.stop.prevent="showForm()" v-if="!AddEditForm && user.status === 'active'">Add Products
                                </button>
                                <button type="button" class="btn btn-sm btn-warning btn-glow"
                                        @click.stop.prevent="closeSearch()">
                                    <span v-if="searchFrom">Close search form</span>
                                    <span v-else>Search</span>
                                </button>
                            </div>
                        </div>
                        <div class="card-body" v-if="searchFrom">
                            <div class="d-flex">
                                <input type="text" v-model="filters.query"
                                       placeholder="Search: Product name, category, location" class="form-control">
                                <button class="btn bnt-sm btn-danger text-white"
                                        @click.stop.prevent="clearSearch()">
                                    Clear
                                </button>
                            </div>
                        </div>
                        <div class="card-body" v-if="AddEditForm && user.status === 'active'">
                            <form method="post" enctype="multipart/form-data">
                                <h3 v-if="editMode">Edit product</h3>
                                <h3 v-else>Add product</h3>
                                <hr>
                                <div class="row">
                                    <div class="col-12 col-lg-6">
                                        <Custom_Text_Input
                                            class="mb-2"
                                            type="text"
                                            label="Product name"
                                            placeholder=""
                                            id="product_name"
                                            name="product_name"
                                            v-model="productData.product_name"
                                            :error="errors.product_name && Array.isArray(errors.product_name) ? errors.product_name[0] : errors.product_name"/>
                                    </div>

                                    <div class="col-12 col-lg-6">
                                        <div class="row">
                                            <div class="col-12 col-lg-6">
                                                <Custom_Text_Input
                                                    class="mb-2"
                                                    type="number"
                                                    :label="'Total stock ('+ productData.stock_type+')'"
                                                    placeholder=""
                                                    id="total_stock"
                                                    name="total_stock"
                                                    v-model="productData.total_stock"
                                                    :error="errors.total_stock && Array.isArray(errors.total_stock) ? errors.total_stock[0] : errors.total_stock"/>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <div class="form-group">
                                                    <label for="stock_type">Stock type</label>
                                                    <select name="stock_type" id="stock_type" v-model="productData.stock_type" class="form-control">
                                                        <option value="kg" selected>Kg</option>
                                                        <option value="lbs">lbs (1 lbs = 40 kg)</option>
                                                        <option value="quantile">Quintal (1 quintal = 48.95 kg)</option>
                                                        <option value="ton">Ton (1 Ton = 1000 kg)</option>
                                                        <option value="dozen">Dozen</option>
                                                        <option value="piece">Piece</option>
                                                        <!--                                                        <option value="quantity">Quantity</option>-->
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-6">
                                        <div class="row">
                                            <div class="col-12 col-lg-6">
                                                <Custom_Text_Input
                                                    class="mb-2"
                                                    type="number"
                                                    label="Regular price (TK)"
                                                    placeholder=""
                                                    id="regular_price"
                                                    name="regular_price"
                                                    v-model="productData.regular_price"
                                                    :error="errors.regular_price && Array.isArray(errors.regular_price) ? errors.regular_price[0] : errors.regular_price"/>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <Custom_Text_Input
                                                    class="mb-2"
                                                    type="number"
                                                    label="Retail price (TK)"
                                                    placeholder=""
                                                    id="retail_price"
                                                    name="retail_price"
                                                    v-model="productData.retail_price"
                                                    :error="errors.retail_price && Array.isArray(errors.retail_price) ? errors.retail_price[0] : errors.retail_price"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-6">
                                        <Custom_Text_Input
                                            class="mb-2"
                                            type="number"
                                            label="Minimum order amount (in kg or number)"
                                            placeholder=""
                                            id="minimum_order_amount"
                                            name="minimum_order_amount"
                                            v-model="productData.minimum_order_amount"
                                            :error="errors.minimum_order_amount && Array.isArray(errors.minimum_order_amount) ? errors.minimum_order_amount[0] : errors.minimum_order_amount"/>
                                    </div>

                                    <div class="col-12 col-lg-6">
                                        <label for="status">Status</label>
                                        <div class="form-control">
                                            <div class="custom-control custom-switch form-check form-switch">
                                                <input type="checkbox" class="form-check-input" id="status" v-model="productData.status">
                                                <label class="form-check-label ml-2" for="status" v-if="productData.status">Active</label>
                                                <label class="form-check-label ml-2" for="status" v-else>Inactive</label>
                                            </div>
                                        </div>
                                        <div v-if="errors.status && Array.isArray(errors.status) ? errors.status[0] : errors.status">
                                            <p class="text-danger mt-1">{{ errors.status && Array.isArray(errors.status) ? errors.status[0] : errors.status }}</p>
                                        </div>
                                    </div>


                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="category">Category</label>
                                            <select name="category" id="category" v-if="productCategory && Object.keys(productCategory).length" class="form-control"
                                                    v-model="productData.category">
                                                <option value="" disabled selected>Select</option>
                                                <template v-for="cat in productCategory">
                                                    <option :value="cat.id" class="mainCate">{{ cat.title }}</option>
                                                    <option :value="subcat.id" v-if="cat.children" v-for="subcat in cat.children">{{ cat.title }} -> {{ subcat.title }}</option>
                                                </template>
                                            </select>

                                            <div v-if="errors.category && Array.isArray(errors.category) ? errors.category[0] : errors.category">
                                                <p class="text-danger mt-1">{{ errors.category && Array.isArray(errors.category) ? errors.category[0] : errors.category }}</p>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="productImage">Image</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="productImage" ref="fileInput"
                                                       multiple
                                                       accept="image/*"
                                                       @change="onFilePicked"
                                                >
                                                <label class="custom-file-label" for="productImage">Choose file...</label>
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
                                            <label for="description">Description</label>
                                            <ckeditor @ready="onCK_EditorReady"
                                                      :editor="editor"
                                                      v-model="productData.description"
                                                      :config="editorConfig"
                                                      id="description"></ckeditor>

                                            <div v-if="errors.description && Array.isArray(errors.description) ? errors.description[0] : errors.description">
                                                <p class="text-danger mt-1">{{ errors.description && Array.isArray(errors.description) ? errors.description[0] : errors.description }}</p>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Bid Form -->
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="can_bid">Enable bid ?</label>
                                            <div class="form-control">
                                                <div class="custom-control custom-switch form-check form-switch">
                                                    <input type="checkbox" class="form-check-input" id="can_bid" v-model="productData.can_bid">
                                                    <label class="form-check-label ml-2" for="can_bid" v-if="productData.can_bid">Enabled</label>
                                                    <label class="form-check-label ml-2" for="can_bid" v-else>Disabled</label>
                                                </div>
                                            </div>
                                            <div v-if="errors.can_bid && Array.isArray(errors.can_bid) ? errors.can_bid[0] : errors.can_bid">
                                                <p class="text-danger mt-1">{{ errors.can_bid && Array.isArray(errors.can_bid) ? errors.can_bid[0] : errors.can_bid }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <template v-if="productData.can_bid">
                                        <div class="col-12 col-lg-6">
                                            <div class="form-group">
                                                <label for="minimum_bid_amount">Bid amount: (*)</label>
                                                <input type="number" id="minimum_bid_amount" class="form-control" v-model="productData.minimum_bid_amount">
                                                <div v-if="errors.minimum_bid_amount && Array.isArray(errors.minimum_bid_amount) ? errors.minimum_bid_amount[0] : errors.minimum_bid_amount">
                                                    <p class="text-danger mt-1">{{ errors.minimum_bid_amount && Array.isArray(errors.minimum_bid_amount) ? errors.minimum_bid_amount[0] : errors.minimum_bid_amount }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <div class="form-group">
                                                <div>
                                                    <label for="timeLimit">Time Limit</label>
                                                </div>
                                                <!--                                        <date-picker v-model="time1" valueType="format"></date-picker>
                                                                                        <date-picker v-model="time2" type="datetime"></date-picker>-->
                                                <div>
                                                    <date-picker
                                                        v-model="productData.start_and_end_date"
                                                        range
                                                        readonly="readonly"
                                                        id="timeLimit"
                                                        :append-to-body="true"
                                                        input-class="form-control">
                                                    </date-picker>
                                                    <div v-if="errors.start_and_end_date && Array.isArray(errors.start_and_end_date) ? errors.minimum_bid_amount[0] : errors.start_and_end_date">
                                                        <p class="text-danger mt-1">{{ errors.start_and_end_date && Array.isArray(errors.start_and_end_date) ? errors.start_and_end_date[0] : errors.start_and_end_date }}</p>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </template>
                                    <!-- End Bid Form -->


                                    <div class="text-right">
                                        <Custom_Loading_Button
                                            v-if="!editMode"
                                            class=""
                                            @button_clicked="productAddOrUpdate()"
                                            :processing="processing">
                                            <span>Save</span>
                                        </Custom_Loading_Button>
                                        <Custom_Loading_Button
                                            v-else
                                            class=""
                                            @button_clicked="productAddOrUpdate(true)"
                                            :processing="processing">
                                            <span>Update</span>
                                        </Custom_Loading_Button>
                                        <button class="btn btn-danger" @click.stop.prevent="clearForm" v-if="AddEditForm">Close</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title d-flex justify-content-between align-items-center">
                            <div>
                                <button type="button" class="btn btn-sm btn-danger btn-glow"
                                        @click.stop.prevent="getDeletedProducts"
                                        v-if="!showingDeletedProducts">
                                    <i class="fas fa-trash"></i>
                                    Show deleted products <span v-if="deletedProductCount">({{ deletedProductCount }})</span>
                                </button>
                                <button type="button" class="btn btn-sm btn-primary btn-glow" v-else @click.stop.prevent="getProd">
                                    <i class="fas fa-arrow-left"></i>
                                    Show all products <span v-if="allProductCount">({{ allProductCount }})</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-12" v-if="loading">
                <loading v-if="loading" msg="Loading products ..."/>
            </div>

        </div>

        <div class="row" v-if="!loading && getProducts && getProducts.length">
            <div class="col-md-12" v-for="product in getProducts">
                <div class="card" :class="[product.can_bid ?'bg-primary text-white':'']">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <img :src="product.first_image" alt=""
                                     style="height: 60px; width: 60px; border-radius: 50%;">
                                <div class="pl-2">
                                    <div class="d-flex justify-content-start align-items-center">
                                        <h4>
                                            <router-link :to="{name:'View Product',params:{product_slug:product.product_slug}}">
                                                <strong>{{ product.product_name }}</strong>
                                            </router-link>
                                        </h4>
                                        <div style="font-size: 12px!important; line-height: 10px;" class="ml-1">
                                            ( <strong>Seller:</strong> {{ product.seller.first_name }} {{ product.seller.last_name }} )
                                        </div>
                                    </div>
                                    <div>
                                        <span>Regular price: <strong>{{ product.regular_price }} Tk</strong>,</span>
                                        <span>Retail price: <strong>{{ product.retail_price }} Tk</strong>,</span>
                                        <span v-if="product.total_stock==0" class="text-danger">Stock: <strong>{{ product.total_stock }}</strong></span>
                                        <span v-else>Stock: <strong>{{ product.total_stock }} {{ product.stock_type }}</strong></span>
                                    </div>
                                    <div>
                                        <span>Category: <strong v-for="category in product.categories">{{ category.title }}</strong></span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="btn-group">
                                    <button type="button" class="btn dropdown-toggle text-white box-shadow-0 bg-gradient-x-primary rounded" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Action
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <router-link :to="{name:'View Product',params:{product_slug:product.product_slug}}" class="dropdown-item">View</router-link>
                                        <template v-if="user.status === 'active'">
                                            <a class="dropdown-item" href="" v-if="!product.deleted_at" @click.stop.prevent="editProduct(product)">Edit</a>
                                            <a class="dropdown-item" href="" v-if="product.deleted_at" @click.stop.prevent="restore(product.id)">Restore</a>
                                            <a class="dropdown-item" href="" @click.stop.prevent="deleteProducts(product)" v-if="!product.deleted_at">Delete</a>
                                            <a class="dropdown-item" href="" @click.stop.prevent="deleteProducts(product)" v-else>Destroy</a>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="getProducts.length > 0" class="paginationLink row">
                <div class="col-12 col-md-6 my-2">
                    Showing (
                    <!--<span class="text-warning text-bold-600">{{ pagination.per_page * pagination.current_page }}</span>-->
                    <span class="text-warning text-bold-600">{{ pagination.from }} -  {{ pagination.to }}</span> ) from
                    <span class="text-warning text-bold-600">{{ pagination.total }}</span> products
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
        <div v-else>
            <div v-if="!loading" class="alert alert-info text-center">No products available!</div>
        </div>

    </div>
</template>

<script>
import CKEditor from '@ckeditor/ckeditor5-vue2';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import {mapActions, mapGetters} from "vuex";
import Pagination from "../../../components/pagination";
import CategoryList from "../../../components/category-list";
import BidForm from "./component/Bid-Form";

import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import dayjs from "dayjs";

export default {
    name: 'ManageProducts',
    components: {
        DatePicker,
        BidForm,
        CategoryList,
        ckeditor: CKEditor.component,
        Pagination,
    },
    data() {
        return {
            editor: ClassicEditor,
            editorConfig: {
                // The configuration of the editor.
            },
            disabledDateBefore: null,
            disabledDateAfter: null,
            loading: false,
            processing: false,
            searchFrom: false,
            AddEditForm: false,
            productData: {
                product_name: '',
                brand_id: '',
                status: 1,
                total_stock: '',
                stock_type: 'kg',
                regular_price: '',
                retail_price: '',
                minimum_order_amount: '',
                category: '',
                description: '',
                images: [],

                can_bid: 0,
                start_and_end_date: null,
                minimum_bid_amount: '',
            },
            imageUrls: [],
            uploadedImageUrls: [],
            errors: {},
            editMode: false,
            pagination: {
                current_page: 1
            },
            showingDeletedProducts: false,
            searchParams: {
                searchQuery: '',
                searchStatus: '',
            },
            deletedProductCount: 0,
            allProductCount: 0,
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
                this.getProductsAction(false);
            }, 500), deep: true
        },
        'productData.start_and_end_date': function () {
            this.validateDate()
        }
    },
    computed: {
        ...mapGetters({
            user: 'auth/user',
            productCategory: 'productCategory/productCategories',
            getProducts: 'product/products',
            productsErrors: 'product/productsErrors',
            productPagination: 'product/pagination',
        }),
    },
    activated() {
        this.disabledDateBefore = dayjs('MM/DD/YY');
        this.disabledDateAfter = dayjs('MM/DD/YY').add(7, 'day');
        this.clearForm();
    },
    mounted() {
        this.getProdCat();
        this.getProd();
    },
    methods: {
        ...mapActions({
            fetchProductCategories: 'productCategory/fetchProductCategory',
            fetchProducts: 'product/fetchProducts',
            fetchDeletedProducts: 'product/fetchDeletedProducts',
            addProduct: 'product/addProduct',
            updateProduct: 'product/updateProduct',
            clearError: 'product/clearError',
            deleteProduct: 'product/deleteProduct',
            restoreProduct: 'product/restore',
            deleteProductImage: 'product/deleteProductImage',
        }),
        onCK_EditorReady: function () {
            this.editorValue = this.productData.description;
        },
        validateDate() {
            if (this.productData.can_bid) {
                this.errors = {};
                // Date Validation ...
                if (this.productData.start_and_end_date && (this.productData.start_and_end_date != null || this.productData.start_and_end_date != [null, null])) {
                    let today = dayjs();
                    let startDate = this.productData.start_and_end_date[0];
                    let endDate = this.productData.start_and_end_date[1];
                    if (startDate <= today) {
                        this.errors.start_and_end_date = 'Start date should be alter: ' + dayjs().format('DD-MMM-YYYY');
                    } else if (endDate < startDate) {
                        this.errors.start_and_end_date = 'End date should be alter: ' + dayjs(startDate).format('DD-MMM-YYYY');
                    } else if (dayjs(endDate).diff(dayjs(startDate), 'day') > 7) {
                        this.errors.start_and_end_date = 'Bid time limit should be maximum 7 days.';
                    }
                } else {
                    this.errors.start_and_end_date = 'Bid time limit is required.';
                }
            }
        },
        handleChange(page) {
            //this.pagination.current_page = page; /// error occurs for this code ...
            const S = this.searchParams;
            if (S.searchQuery !== '' || S.searchStatus !== '') {
                this.search(page, false)
            } else if (this.showingDeletedProducts == true) {
                this.getDeletedProducts(page, false)
            } else {
                this.getProd(page, false)
            }
        },
        async getProdCat() {
            await this.fetchProductCategories();
        },
        async getProd(page, load = true) {
            this.loading = load;
            this.showingDeletedProducts = false;
            await this.fetchProducts(page || this.productPagination.current_page).then(() => {
                this.pagination = this.productPagination;
            }).finally(() => {
                this.loading = false;
                axios.get('api/products/deleted/count').then((resp) => {
                    this.deletedProductCount = resp.data.deleted;
                    this.allProductCount = resp.data.all;
                });
            });
        },
        async getProductsAction(load = true) {
            this.loading = load;
            await axios.get(`api/products/all?page=${this.pagination.current_page}`, {
                params: _.omit(this.filters, 'category_name')
            }).then((response) => {
                //this.products = response.data.data;
                this.$store.commit('product/setProducts', response.data.data);
                this.pagination = response.data.meta;
                if (this.searching) {
                    //const el = this.$refs.ScrollPoint;
                    //if (el) el.scrollIntoView({behavior: 'smooth'});
                }
            }).catch(error => {
                let err = error.response.data.errors;
                this.$store.dispatch('snackbar/addSnack', {color: 'danger', msg: 'Server error', snakbarType: 'Error'}, {root: true});
            }).finally(() => {
                this.loading = false;
                this.searching = false;
            });
        },
        async getDeletedProducts(page, load = true) {
            this.loading = load;
            this.showingDeletedProducts = true;
            this.fetchDeletedProducts(page || this.productPagination.current_page).then(() => {
                this.pagination = this.productPagination;
            }).finally(() => {
                this.loading = false;
            });
        },
        async deleteImageFromDatabase(key) {
            if (this.productData && this.productData.id) {
                let data = {
                    key: key,
                    id: this.productData.id
                }
                await this.deleteProductImage(data).then((response) => {
                    this.uploadedImageUrls.splice(key, 1);
                });
            }
        },
        async search(page, load = true) {
            this.loading = load;

        },
        async restore(id) {
            await this.restoreProduct(id);
        },
        editProduct(product) {
            this.editMode = true;
            this.AddEditForm = true;
            this.productData = {
                id: product.id,
                product_name: product.product_name,
                brand_id: product.brand_id,
                status: product.status,
                total_stock: product.total_stock,
                stock_type: product.stock_type,
                regular_price: product.regular_price,
                retail_price: product.retail_price,
                minimum_order_amount: product.minimum_order_amount,
                category: product.categories[0].id,
                description: product.description,
                images: [],
            }
            let categoryIds = []
            for (let i = 0; i < product.categories.length; i++) {
                categoryIds.push(product.categories[i].id);
            }
            this.uploadedImageUrls = product.imageUrls;
            this.productData.categoriesId = categoryIds;

            //document.querySelector('body').scrollTop = 0;
            const el = this.$refs.AddEditForm;
            if (el) el.scrollIntoView({behavior: 'smooth'});
            // Use el.scrollIntoView() to instantly scroll to the element

        },
        async productAddOrUpdate(editMode = this.editMode) {
            this.processing = true;
            this.clearError();
            this.errors = {};

            this.validateData();
            this.validateDate(); /// Date Validation ...
            if (Object.keys(this.errors).length) {
                this.processing = false;
                return
            }
            const formData = new FormData();
            if (editMode) {
                formData.append("_method", "put");
                formData.append('product_id', this.productData.id);
            } else formData.append("_method", "post");
            formData.append('product_name', this.productData.product_name);
            //formData.append('brand_id', this.productData.brand_id);
            formData.append('status', this.productData.status);
            formData.append('total_stock', this.productData.total_stock);
            formData.append('stock_type', this.productData.stock_type);
            formData.append('regular_price', this.productData.regular_price);
            formData.append('retail_price', this.productData.retail_price);
            formData.append('minimum_order_amount', this.productData.minimum_order_amount);
            formData.append('category', this.productData.category);
            formData.append('description', this.productData.description);

            formData.append('can_bid', this.productData.can_bid);
            formData.append('start_date', this.productData.start_and_end_date[0]);
            formData.append('end_date', this.productData.start_and_end_date[1]);
            formData.append('minimum_bid_amount', this.productData.minimum_bid_amount);

            if (this.productData.images.length) {
                for (let i = 0; i < this.productData.images.length; i++) {
                    formData.append('images[]', this.productData.images[i]);
                }
            } else formData.append('images', '');

            const config = {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                }
            }
            if (!editMode) {
                await this.addProduct(formData, config).finally(() => this.processing = false);
            } else {
                await axios.post(`api/products/${this.productData.id}`, formData, config).then((response) => {
                    this.$store.dispatch('product/fetchProducts', response, {root: true});
                    this.$store.dispatch('snackbar/addSnack', {color: 'success', msg: 'Product updated successfully', snakbarType: 'Success'}, {root: true});
                }).catch((error) => {
                    let err = error.response.data.errors;
                    this.$store.commit('product/SET_ERROR', err)
                    this.$store.dispatch('snackbar/addSnack', {color: 'danger', msg: 'Error updating product.', snakbarType: 'Error'}, {root: true});
                }).finally(() => this.processing = false);
                /*await this.updateProduct(this.productData.id, formData, config).finally(() => {
                    this.processing = false;
                });*/
            }

            if (this.productsErrors != null) {
                this.errors = this.productsErrors;
                return
            }
            this.clearForm();
        },
        validateData() {
            let __this = this;
            if (!__this.productData.product_name.trim()) __this.errors.product_name = 'Product name is required!';
            //if (!__this.productData.product_slug.trim()) __this.errors.product_slug = 'Product slug is required!';
            //if (__this.productData.status == '' || __this.productData.status == null) __this.errors.status = 'Status is required!';

            if (!__this.productData.total_stock) __this.errors.total_stock = 'Total stock is required!';
            else if (parseInt(__this.productData.total_stock) < 0) __this.errors.total_stock = 'Total stock should be 0 or more!';
            else if (parseInt(__this.productData.total_stock) > 2000) __this.errors.total_stock = 'Total stock should be less then or equal to 2000';

            if (!__this.productData.stock_type.trim()) __this.errors.stock_type = 'Stock price is required!';

            if (!__this.productData.regular_price) __this.errors.regular_price = 'Regular price is required!';
            else if (parseInt(__this.productData.regular_price) <= 0) __this.errors.regular_price = 'Regular price should be more then 0!';

            if (!__this.productData.retail_price) __this.errors.retail_price = 'Retail price is required!';
            else if (parseInt(__this.productData.retail_price) <= 0) __this.errors.retail_price = 'Retail price should be more then 0!';
            else if (parseInt(__this.productData.retail_price) > parseInt(__this.productData.regular_price))
                __this.errors.retail_price = 'Retail price should be less then regular price!';

            if (!__this.productData.minimum_order_amount) __this.errors.minimum_order_amount = 'Minimum order amount is required!';
            else if (parseInt(__this.productData.minimum_order_amount) <= 0) __this.errors.minimum_order_amount = 'Minimum order amount should be more then 0!';
            /*else if (parseInt(__this.productData.minimum_order_amount) > parseInt(__this.productData.total_stock))
                __this.errors.minimum_order_amount = 'Minimum order amount should be less then or equal to total stock!';*/

            if (!this.editMode) {
                if (!__this.productData.category) __this.errors.category = 'Product category is required!';
                if (!__this.productData.description.trim()) __this.errors.description = 'Product description is required!';
                if (__this.productData.images.length <= 0) __this.errors.images = 'Product image is required!';
            }
        },
        showForm() {
            this.clearForm();
            this.AddEditForm = true
        },
        clearForm() {
            this.errors = {};
            this.loading = false;
            this.processing = false;
            this.AddEditForm = false;
            this.editMode = false;
            this.productData = {
                product_name: '',
                brand_id: '',
                status: 1,
                total_stock: '',
                stock_type: 'kg',
                regular_price: '',
                retail_price: '',
                minimum_order_amount: '',
                category: '',
                description: '',
                images: [],
            };
            this.imageUrls = [];
            this.uploadedImageUrls = [];
        },
        async deleteProducts(event) {
            this.$swal.fire({
                title: 'Are you sure you want to delete this product?',
                text: 'You can view deleted products in trash.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    this.deleteProduct(event.id).then(() => {
                        this.$swal.fire(
                            'Deleted!',
                            'Product has been deleted.',
                            'success'
                        )
                        this.deletedProductCount++;
                        this.allProductCount--;
                    });
                }
            });
        },
        onFilePicked(event) {
            const files = event.target.files
            if (files.length > 4) {
                alert('You can upload maximum 4 images for a product.');
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
                            this.productData.images.push(files[i]);
                        }
                    } else {
                        alert('Invalid file type present! File must be jpeg, jpg or png.');
                        return false;
                    }
                }
            }
        },
        removeImageFromCollection(imageKey) {
            this.productData.images.splice(imageKey, 1);
            this.imageUrls.splice(imageKey, 1);
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
        closeSearch() {
            this.searchFrom = !this.searchFrom;
            this.clearSearch();
        }
    },
}
</script>

<style scoped lang="scss">
.mainCate {
    font-weight: 800;
}

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
