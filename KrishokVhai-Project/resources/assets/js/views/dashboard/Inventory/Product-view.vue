<template>
    <div>
        <div id="what-is" class="card">
            <div class="card-header">
                <h4 class="card-title"></h4>
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
<!--                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                    </ul>-->

                    <div class="pull-right">
                        <button class="btn btn-sm btn-success" @click="$router.back()">Back</button>
<!--                        <button class="btn btn-sm btn-primary" @click.stop.prevent="editPost(post)">Edit</button>
                        <button class="btn btn-sm btn-danger" @click.stop.prevent="deletePosts(post)">Delete</button>-->
                    </div>
                </div>
            </div>
            <div class="card-content collapse show" v-if="product && Object.keys(product).length">
                <div class="card-body">
                    <div class="card-text">
                        <div class="row">
                            <div class="col-12 col-md-6" v-if="product.imageUrls && product.imageUrls.length">
                                <img :src="product.imageUrls[0]" alt="image" class="rounded" style="width:100%; max-height: 400px;" ref="LargeImage">
                                <div v-if="product.imageUrls.length>1" class="mt-1 d-flex justify-content-start align-items-center">
                                    <div v-for="(image, im) in product.imageUrls" :key="im" class="position-relative displayImageContainer"
                                         :class="[displayImageKey == im?'active':'']">
                                        <img :src="image" alt="image" class="rounded" height="60" style="margin: 2px 2px 0 0;"
                                             @click.stop.prevent="showClickedImage(image, im)">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <h3>{{ product.product_name }}</h3>
                                <hr>
                                <div class="mt-1"><strong>Status: </strong>
                                    <span class="bg-success text-white" v-if="product.status">Active</span>
                                    <span class="bg-danger text-white" v-else>Inactive</span>
                                </div>
                                <div class="mt-1"><strong>Regular price: </strong>{{ product.regular_price }} {{ product.currency }}</div>
                                <div class="mt-1"><strong>Retail price: </strong>{{ product.retail_price }} {{ product.currency }}</div>
                                <div class="mt-1"><strong>Stock: </strong>{{ product.total_stock }} {{ product.stock_type }}</div>
                                <div class="mt-1" v-if="product.minimum_order_amount <= 1"><strong>Minimum order amount: </strong>{{ product.minimum_order_amount }} {{ product.stock_type }}</div>
                                <div class="mt-1" v-else><strong>Retail price starts from: </strong>{{ product.minimum_order_amount }} {{ product.stock_type }}</div>
                                <div class="mt-2">
                                    <h4>About:</h4>
                                    <div v-html=product.description></div>
                                </div>
                                <hr>
                                <div class="mt-2">
                                    <h4 class="text-muted">Seller: </h4>
                                    <div class="d-flex justify-content-start align-items-center">
                                        <img :src="product.seller.avatar" alt=""
                                             style="height: 60px; width:60px; border-radius: 50%; object-fit: cover; object-position: center; margin-right: 10px;">
                                        <div>
                                            <a :href="`dashboard/@${user.username}/profile`" v-if="user && user.id == product.seller.id"
                                               target="_blank">{{ product.seller.first_name }} {{ product.seller.last_name }}</a>

                                            <a :href="`/dashboard/@${user.username}/users/view-profile/${product.seller.id}`" v-else-if="user"
                                               target="_blank" class="post-author">{{ product.seller.first_name }} {{ product.seller.last_name }}</a>
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
import {mapGetters} from "vuex";

export default {
    name: "Product-view",
    data() {
        return {
            product: [],
            displayImageKey: 0,
        }
    },
    watch: {
        '$route': function () {
            if (this.$route.params.product_slug) this.current_product();
        },
    },
    updated() {
        //this.current_product();
    },
    computed: {
        ...mapGetters({
            user:'auth/user',
        })
    },
    mounted() {
        this.current_product();
    },
    methods: {
        current_product() {
            axios.get(`api/products/show/${this.$route.params.product_slug}`)
                .then((resp) => {
                    this.product = resp.data.data;
                })
                .catch((error) => {
                    let err = error.response.error
                    this.$store.dispatch('snackbar/addSnack', {color: 'danger', msg: err, snakbarType: 'Error'}, {root: true});
                });
        },
        showClickedImage(image, key) {
            this.displayImageKey = key;
            this.$refs.LargeImage.src = image;
        },
    }
}
</script>

<style scoped lang="scss">
.displayImageContainer {
    transition: all 200ms ease-in-out;
    cursor: pointer;

    &.active {
        opacity: 0.6;
        filter: grayscale(1);
    }

    &:hover {
        opacity: 0.7;
    }
}
</style>
