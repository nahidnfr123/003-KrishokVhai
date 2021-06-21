<template>
    <!-- Navbar Area -->
    <div class="famie-main-menu">
        <div class="classy-nav-container breakpoint-off">
            <div class="container">
                <!-- Menu -->
                <nav class="classy-navbar justify-content-between" id="famieNav">
                    <!-- Nav Brand -->
                    <router-link to="/" class="nav-brand">
                        <img src="/frontend-assets/img/core-img/krishokvhai.png" alt="" style="max-height: 100px;">
                    </router-link>
                    <!-- Navbar Toggler -->
                    <div class="classy-navbar-toggler">
                        <span class="navbarToggler"><span></span><span></span><span></span></span>
                    </div>
                    <!-- Menu -->
                    <div class="classy-menu">
                        <!-- Close Button -->
                        <div class="classycloseIcon">
                            <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                        </div>
                        <!-- Navbar Start -->
                        <div class="classynav">
                            <ul>
                                <li v-for="(links, i) in navigationLinks" :key="i">

                                    <router-link :to="links.to" v-if="!links.subLinks" exact>{{ links.label }}</router-link>

                                    <a href="#" @click.stop.prevent="" v-else>
                                        {{ links.label }}
                                    </a>

                                    <ul v-if="links.subLinks" class="dropdown">
                                        <li v-for="sub in links.subLinks">
                                            <router-link :to="sub.to" exact>{{ sub.label }}</router-link>
                                        </li>
                                    </ul>
                                </li>
                            </ul>

                            <!-- Cart Icon -->
                            <div id="cartIcon">
                                <a href="" @click.stop.prevent="$emit('showCartModal', true)">
                                    <i class="icon_cart_alt" aria-hidden="true"></i>
                                    <span class="cart-quantity" v-if="$store.state.cart.cart.length">{{ $store.state.cart.cart.length }}</span>
                                </a>
                            </div>
                        </div>
                        <!-- Navbar End -->
                    </div>
                </nav>

                <!-- Search Form -->
                <div class="search-form">
                    <form action="#" method="get">
                        <input type="search" name="search" id="search" placeholder="Type keywords &amp; press enter...">
                        <button type="submit" class="d-none"></button>
                    </form>
                    <!-- Close Icon -->
                    <div class="closeIcon"><i class="fa fa-times" aria-hidden="true"></i></div>
                </div>
            </div>
        </div>



    </div>
</template>

<script>

export default {
    name: 'Nav',
    data() {
        return {
            navigationLinks: [
                {to: '/', label: 'Home'},
                {to: '/market', label: 'Market'},
                {
                    label: 'Posts', subLinks: [
                        {to: {name: 'Articles', params: {articles_type: 'farming-practice'}}, label: 'Farming Practice'},
                        {to: {name: 'Blogs', params: {articles_type: 'blog'}}, label: 'Blog'},
                        {to: '/news', label: 'News'},
                    ]
                },
                {to: '/weather', label: 'Weather'},
                /*{to: '/agriculture-materials', label: 'Agro materials'},*/
                {to: '/contact', label: 'Contact'},
                {to: '/about', label: 'About'},
            ],
        }
    },
    props: {
        user: Object,
        BaseUrl: String,
    },
    methods: {}
}
</script>

<style lang="scss" scoped>
.classynav ul li a.active,
.classynav ul li a .active {
    color: dodgerblue !important;
    font-weight: bold !important;
    text-decoration: dodgerblue dotted;
}
</style>
