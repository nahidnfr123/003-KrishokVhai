<template>
    <div>
        <header class="header-area">
            <tops-bar :user="user" :base-url="BaseUrl"></tops-bar>
            <nav-bar :BaseUrl="BaseUrl" :user="user" @showCartModal="toggleCartModal($event)"></nav-bar>
        </header>

        <transition name="slide-fade">
            <router-view :BaseUrl="BaseUrl" :user="user"/>
        </transition>

        <cart v-show="showCartModal" @showCartModal="toggleCartModal($event)"/>

        <footer-bar :BaseUrl="BaseUrl"></footer-bar>
    </div>
</template>

<script>
import TopsBar from "../components/frontend/topBar.vue";
import NavBar from "../components/frontend/nav.vue";
import FooterBar from "../components/frontend/footer.vue";
import Cart from "../views/market/Cart.vue";

export default {
    name: 'Home',
    components: {
        /*TopsBar: ()=> import(/!*webpackChunkName: "FrontendTopsBar"*!/'../components/frontend/topBar.vue'),
        NavBar: ()=> import(/!*webpackChunkName: "FrontendNavBar"*!/'../components/frontend/nav.vue'),
        FooterBar: ()=> import(/!*webpackChunkName: "FrontendFooterBar"*!/'../components/frontend/footer.vue'),
        Cart: ()=> import(/!*webpackChunkName: "FrontendCart"*!/'../views/market/Cart.vue'),*/

        TopsBar,
        NavBar,
        FooterBar,
        Cart,
    },
    props: {
        BaseUrl: String,
        user: [Array, Object],
    },
    data() {
        return {
            showCartModal: false,
        }
    },
    methods: {
        toggleCartModal(e) {
            this.showCartModal = e;
        },
    },
    created() {

    }
}
</script>

<style scoped lang="scss">
/* Enter and leave animations can use different */
/* durations and timing functions.              */
.slide-fade-enter-active {
    transition: all .4s ease;
}

.slide-fade-leave-active {
    transition: all .4s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}

.slide-fade-enter, .slide-fade-leave-to {
    transform: translateX(10px);
    opacity: 0;
}
</style>
