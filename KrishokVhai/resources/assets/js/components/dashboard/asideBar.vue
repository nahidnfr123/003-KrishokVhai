<template>
    <!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow menu-dark" data-scroll-to-active="true"
    style="overflow-y: auto !important;">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row text-center">
                <li class="nav-item mr-auto text-center">
                    <a class="navbar-brand text-center m-auto" href="/">
                        <img alt="Chameleon admin logo" height="40" src="/admin/app-assets/images/logo/krishokvhai.png"
                             style="background: white; !important; padding: 2px 6px; border-radius: 10px"/>
<!--                        <img class="brand-logo" alt="Chameleon admin logo" src="/admin/app-assets/images/logo/krishokvhai.png"/>-->
<!--                        <h3 class="brand-text">Smart Agro</h3>-->
                    </a>
                </li>
                <li class="nav-item d-md-none"><a class="nav-link close-navbar"><i class="ft-x"></i></a></li>
            </ul>
        </div>
        <div class="navigation-background"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation" v-if="navigationLinks.length">

                <li :class="[Link.subLinks?'has-sub':'', subIsActive(Link)?'open':'']"
                    class=" nav-item open" v-for="(Link, i) in navigationLinks" :key="i" v-if="isAccessible(Link.accessibleTo)">

                    <router-link v-if="!Link.subLinks" :to="Link.to">
                        <i :class="Link.icon"></i>
                        <span class="menu-title" data-i18n="">{{ Link.label }}</span>
                    </router-link>

                    <a href="#" v-else>
                        <i :class="Link.icon"></i>
                        <span class="menu-title" data-i18n="">{{ Link.label }}</span>
                    </a>
                    <ul class="menu-content" v-if="Link.subLinks">
                        <li v-for="(subLink, x) in Link.subLinks" :key="x" v-if="isAccessible(subLink.accessibleTo)"
                        class="is-shown">
                            <router-link :to="subLink.to" class="menu-item" style="padding-left: 50px;">
                                {{ subLink.label }}
                            </router-link>
                        </li>
                        <li class="navigation-divider"></li>
                    </ul>

                </li>
            </ul>
        </div>
    </div>
    <!-- END: Main Menu-->
</template>


<script>
import {mapGetters} from "vuex";

export default {
    props: {
        user: Object,
    },
    computed: {
        ...mapGetters({
            roles: 'auth/roles',
        }),
    },
    data() {
        return {
            navigationLinks: [
                {to: {name: 'Dashboard', params: {username: this.user.username}}, label: 'Dashboard', icon: 'fas fa-tachometer-alt'},
                {
                    label: 'Manage post', icon: 'fas fa-th',
                    accessibleTo: ['developer', 'super admin', 'admin', 'agricultural-officer'], subLinks: [
                        {to: {name: 'Manage Post Category', params: {username: this.user.username}}, label: 'Manage Category'},
                        {to: {name: 'Manage Posts', params: {username: this.user.username}}, label: 'Manage Post'},
                    ]
                },
                {
                    label: 'Inventory', heading: 'Market', icon: 'fas fa-th',
                    accessibleTo: ['developer', 'super admin', 'admin', 'farmer'],
                    subLinks: [
                        {to: {name: 'Manage Product Category', params: {username: this.user.username}}, label: 'Manage Category'},
                        {to: {name: 'Manage Product', params: {username: this.user.username}}, label: 'Manage Product'},
                        {to: {name: 'Manage Order', params: {username: this.user.username}}, label: 'Manage Orders'},
                        /*{
                            to: {name: 'Manage Shipment', params: {username: this.user.username}}, label: 'Manage Shipments',
                            accessibleTo: ['developer', 'super admin', 'admin']
                        },*/
                    ]
                },
                {
                    to: {name: 'Manage Order', params: {username: this.user.username}}, label: 'Manage Orders', icon: 'fas fa-th',
                    accessibleTo: ['retailer', 'customer'],
                },
                {
                    to: {name: 'Manage Users'}, label: 'Manage Users', icon: 'fas fa-user',
                    accessibleTo: ['super admin'],
                },
                {
                    to: {name: 'Todo List'}, label: 'Activities', icon: 'fa-file',
                    accessibleTo: ['farmer'],
                },
                /*{
                    label: 'Plan', icon: 'fas fa-copy',
                    accessibleTo: ['farmer'],
                    subLinks: [
                        {to: {name: 'Manage Land'}, label: 'Manage Land'},
                        {to: {name: 'Manage Map'}, label: 'Map'},
                    ]
                },*/
                {to: {name: 'Chat'}, label: 'Chat', icon: 'fas fa-comment'},
                {
                    label: 'People', icon: 'fas fa-user',
                    subLinks: [
                        /*{to: {name: 'Manage Worker'}, label: 'Workers', icon: 'fas fa-user'},
                        {to: {name: 'Manage Connection'}, label: 'Connections', icon: 'fas fa-user'},*/
                        {to: {name: 'Find People'}, label: 'Find people', icon: 'fas fa-user'},
                    ]
                },
                {to: {name: 'Contact Us'}, label: 'Contact Us', icon: 'fas fa-envelope-open', accessibleTo: ['developer', 'super admin', 'admin'],},
                /*{to: {name: 'Loan'}, label: 'Loan', icon: '', accessibleTo: ['farmer'],},*/
                /*{to: {name: 'Disease Center'}, label: 'Disease Center', icon: 'far fa-bell', accessibleTo: ['farmer'],},*/
                /*{to: {name: 'Help'}, label: 'Help', icon: 'fas fa-question-circle'},
                {to: {name: 'Notification'}, label: 'Notifications', icon: 'far fa-bell'},
                {
                    to: {name: 'Settings'}, label: 'Settings', icon: 'fas fa-cogs',
                    accessibleTo: ['developer', 'super admin', 'admin'],
                },*/
            ],
        }
    },
    methods: {
        isAccessible(accessibleTo) {
            if (!accessibleTo) {
                return true;
            }
            let Roles = this.roles;
            for (let key in Roles) {
                //console.log(Roles[key]);
                if (accessibleTo.includes(Roles[key])) {
                    return true;
                }
            }
        },
        subIsActive(Link) {
            if (Link.subLinks) {
                let subLinks = Link.subLinks;
                for (let i = 0; i < subLinks.length; i++) {
                    if (this.$router.currentRoute.name == subLinks[i].to.name) {
                        return true;
                    }
                }
            }
        },
        callMe: function () {
            //setTimeout(function () {
            //     alert('h');
            const plugin = document.createElement("script");
            plugin.setAttribute(
                "src", process.env.MIX_Asset_BASE_URL + "/adminLTE/dist/js/demo.js"
            );
            plugin.async = true;
            document.body.appendChild(plugin);
            //}, 2000);
        },
        toggleMenu(event, links, refs) {
            if (links.subLinks) {
                console.log(event.target, refs);
                event.target.classList.add('menu-open');
                //this.$refs[refs].classList.add('menu-open');
                this.$refs[refs].$el.classList.add('menu-open');
            }
        },
        init() {
            let mainSidebar = document.querySelector('.main-sidebar');
            let mainSidebarNavUL = document.getElementById('sideBarNav');
            if (mainSidebarNavUL) {
                console.log('Got element');
                let navItem = mainSidebarNavUL.getElementsByClassName('nav-item');
                navItem.addEventListener('click', function (e) {
                    e.preventDefault();
                    alert('hello')
                });
            }
        },
    },
    mounted() {
        //this.callMe();
        //this.init();
    },
}
</script>


<style scoped lang="css">
.menu-content .menu-item.active {

}

/*.menu-item.active{
    color: #fa626b !important;
}*/
.menu-item.exact-active {
    color: #fa626b !important;
}
</style>
