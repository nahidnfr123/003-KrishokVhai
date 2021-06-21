<template>
    <!--<picture>
        <source srcset="https://www.vedicindiaorganics.com/wp-content/uploads/2020/10/organic-dry-fruits.jpg"
                type="image/webp" />
        <img src="https://www.vedicindiaorganics.com/wp-content/uploads/2020/10/organic-dry-fruits.jpg" alt=""
             loading="lazy" class="rounded-lg" width="100%">
    </picture>-->
    <figure v-lazyload class="image__wrapper">
        <div class="spinnerLoader" v-if="showLoader">
            <svg class="animate-spin h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                 viewBox="0 0 24 24" :class="loaderColor">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3"></circle>
                <path class="opacity-75" fill="currentColor"
                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
        <img
            :src="loadImage"
            class="image__item"
            :class="imageClass"
            :data-url="source"
            :alt="alt"
            loading="lazy"
        >
    </figure>
</template>

<script>
export default {
    data() {
        return {
            loadImage: "", //require("~/assets/images/loading.gif"),
            // errorImage: require("~/assets/images/error.png"),
        };
    },
    props: {
        source: {
            type: String,
            required: true,
        },
        imageClass: {
            type: [String, Array],
            default: "",
        },
        alt: {
            type: String,
            default: "image",
        },
        showLoader: {
            type: Boolean,
            default: true,
        },
        loaderColor: {
            type: String,
            default: "text-gray-800",
        },
    },
};
</script>

<style scoped>

</style>
