<template>
    <div class="modal fade bd-example-modal-lg show" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: block; padding-right: 17px;"
         v-if="showProductModal && (product && Object.keys(product).length)">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ product.product_name }}</h4>
                    <button type="button" class="close btn btn-sm btn-danger text-white" data-dismiss="modal" aria-label="Close"
                            @click.stop.prevent="closeViewProductModal()">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-6" v-if="product.imageUrls && product.imageUrls.length">
                            <img :src="product.imageUrls[0]" alt="image" class="rounded" style="width:100%; max-height: 400px !important;" ref="LargeImage">
                            <div v-if="product.imageUrls.length>1" class="mt-1 d-flex justify-content-start align-items-center">
                                <div v-for="(image, im) in product.imageUrls" :key="im" class="position-relative displayImageContainer"
                                     :class="[displayImageKey == im?'active':'']">
                                    <img :src="image" alt="image" class="rounded" style="margin: 2px 2px 0 0; height: 80px !important;"
                                         @click.stop.prevent="showClickedImage(image, im)">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <h3 v-text="product.product_name"></h3>
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
                            <template v-if="!roles || !roles.includes('farmer')">
                                <button class="btn btn-sm btn-warning mt-3"
                                        v-if="product.total_stock && canAddToCart"
                                        @click.stop.prevent="addToCart(product)">
                                    Add to cart
                                </button>
                            </template>
                            <div class="mt-3 mb-4">
                                <h4 class="text-muted">About:</h4>
                                {{ product.description }}
                            </div>
                            <hr>
                            <div class="mb-4">
                                <h5 class="text-muted">Seller: </h5>
                                <div class="d-flex justify-content-start align-items-center">
                                    <img :src="product.seller.avatar" alt=""
                                         style="height: 60px; width:60px; border-radius: 50%; object-fit: cover; object-position: center; margin-right: 10px;">
                                    <div>
                                        <router-link to="/login" v-if="!user">{{ product.seller.first_name }} {{ product.seller.last_name }}</router-link>

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
</template>

<script>
export default {
    name: "ViewProducts",
    props: {
        showProductModal: {
            type: Boolean,
            default: false
        },
        canAddToCart: {
            type: Boolean,
            default: false
        },
        product: {
            type: [Object, Array],
            default: {}
        },
        user: {
            type: [Object, Array],
            default: {}
        },
        roles: {
            type: [Object, Array],
            default: {}
        },
    },
    data() {
        return {
            displayImageKey: 0,
        }
    },
    activated() {
        this.displayImageKey = 0;
    },
    methods: {
        closeViewProductModal() {
            this.$emit('closeViewProductModal');
        },
        showClickedImage(image, key) {
            this.displayImageKey = key;
            this.$refs.LargeImage.src = image;
            //this.$emit('showClickedImage', {image, im});
        },
        addToCart(product) {
            this.$emit('addToCart', product);
        }
    },
}
</script>

<style scoped lang="scss">
.cata-list li.active a {
    color: dodgerblue !important;
    font-size: 16px;
}

.price {
    font-size: 18px !important;
}

.modal {
    position: fixed;
    overflow-y: scroll;

    &::before {
        height: 100vh;
        width: 100vw;
        content: '';
        background: rgba(40, 40, 40, .6);
        position: fixed;
    }
}

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
