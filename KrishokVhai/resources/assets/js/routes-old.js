import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import NotFound from './views/404';
import Index from './views/Index';
import Test from './views/Test';
import Weather from './views/Weather';

///////////////// ------------------------- \\\\\\\\\\\\\\\\\\\\\\\

import Register from './views/auth/Register';
import Login from './views/auth/Login';
import SocialLogin from './views/auth/SocialLogin';
import EmailVerification from './views/auth/EmailVerification';
import ForgotPassword from './views/auth/ForgotPassword';
import ResetPassword from './views/auth/ResetPassword';

///////////////// ------------------------- \\\\\\\\\\\\\\\\\\\\\\\

import Profile from './views/dashboard/Users/Profile';
import Survey from "./views/Survey";

/////////////// -------------------  Dashboard .......
import DashboardContainer from './views/dashboard/DashboardContainer';
import DashboardIndex from './views/dashboard';
import Activities from './views/dashboard/Activities';
import Posts from './views/dashboard/Posts/ManagePost';
import ManagePostCategory from './views/dashboard/Posts/ManagePostCategory';

import ManageCategory from "./views/dashboard/Inventory/ManageCategory";
import ManageProduct from "./views/dashboard/Inventory/ManageProduct";
import ProductView from "./views/dashboard/Inventory/Product-view";
import ManageOrders from "./views/dashboard/Inventory/ManageOrders";
import ManageUsers from "./views/dashboard/Users/ManageUsers";
import ViewProfile from "./views/dashboard/Users/ViewProfile";
//import Treeview from "./views/unused/treeview";

import store from './store';
import ReadPost from "./views/dashboard/Posts/ReadPost";
import Articles from "./views/posts/Articles";
import News from "./views/posts/News";
import ReadPostFrontEnd from "./views/posts/ReadPost";
import Blogs from "./views/posts/Blogs";
import Market from "./views/market/Market";
import CheckOut from "./views/market/CheckOut";
import OrderSummary from "./views/market/OrderSummary";
import Chat from "./views/dashboard/chat/Chat";
import FindPeople from "./views/dashboard/Users/FindPeople";
import AccountBlocked from "./views/AccountBlocked";
import ContactUs from "./views/ContactUs";
import About from "./views/About";
import Todo from "./views/dashboard/todos/Todo";
import TodoItem from "./views/dashboard/todos/TodoItem";
import ContactUsMessages from "./views/dashboard/ContactUsMessages";

function requireAuthenticated(to, from, next) {
    const authenticated = store.getters["auth/authenticated"];
    const user = store.getters["auth/user"];

    if (to.name !== 'Login' && !authenticated || !user) next({path: '/login'})
    else {
        next();
    }
}

function requireEmailVerified(to, from, next) {
    const authenticated = store.getters["auth/authenticated"];
    const user = store.getters["auth/user"];

    if (to.name !== 'Login' && !authenticated || !user) {
        //checkUserDetails();
        next({path: '/login'});
    } else {
        if (user.email_verified_at != null) {
            next();
        } else {
            next({name: "EmailVerification"});
        }
    }
}


function preventOrderProduct(to, from, next) { // Prevent and redirect ....
    const roles = store.getters["auth/roles"];
    if (roles && roles.length) {
        for (let key in roles) {
            if (!['customer', 'retailer'].includes(roles[key])) {
                localStorage.removeItem("cart");
            }
        }
    }
    next();
}

function checkCartAccessibility() { // Only prevent no redirect ...
    const roles = store.getters["auth/roles"];
    if (roles && roles.length) {
        for (let key in roles) {
            if (!['customer', 'retailer'].includes(roles[key])) {
                localStorage.removeItem("cart");
            }
        }
    }
}

function checkAbility(to, from, next) {
    const user = store.getters["auth/user"];
    const roles = store.getters["auth/roles"];
    checkCartAccessibility();
    if (user && roles && roles.length) {
        const {accessibleTo} = to.meta;
        if (!accessibleTo) {
            next();
            return;
        } else {
            for (let key in roles) {
                if (accessibleTo.includes(roles[key])) {
                    next();
                    return;
                }
            }
        }
        /*if (router.currentRoute.name == 'Dashboard') router.push({name: 'Dashboard', params: {username: user.username}});
        else next({path: '/',});*/
        router.back();

        store.dispatch('snackbar/addSnack', {color: 'danger', msg: 'Access Permission Denied.', snakbarType: 'Error'}, {root: true});
        return;
    }
    //next({path: '/',});
    router.back();
}

function preventAuthenticated(to, from, next) {
    const authenticated = store.getters["auth/authenticated"];
    const user = store.getters["auth/user"];
    if (authenticated && user) {
        next({
            path: '/',
        })
    } else {
        next()
    }
}

const routes = [
    {
        path: '/register', name: 'Register',
        component: Register,
        beforeEnter: preventAuthenticated
    },
    {
        path: '/login', name: 'Login',
        component: Login,
        beforeEnter: preventAuthenticated
    },
    {
        path: '/contact', name: 'Contact',
        component: ContactUs,
    },
    {
        path: '/about', name: 'About',
        component: About,
    },
    {
        path: '/account_blocked', name: 'AccountBlocked',
        component: AccountBlocked,
        beforeEnter: preventAuthenticated
    },
    {
        path: '/social-login/callback/:provider', name: 'SocialLogin',
        component: SocialLogin,
        beforeEnter: preventAuthenticated
    },
    {
        path: '/forgot-password', name: 'ForgotPassword',
        component: ForgotPassword,
        beforeEnter: preventAuthenticated
    },
    {
        path: '/reset-password/:token', name: 'ResetPassword',
        component: ResetPassword,
        beforeEnter: preventAuthenticated
    },
    {
        path: '/email/verify', name: 'EmailVerification',
        component: EmailVerification,
        beforeEnter: requireAuthenticated
    },
    {
        path: '/:usertype/survey', name: 'Survey',
        component: Survey,
        props: true, meta: {accessibleTo: ['agricultural-officer', 'farmer', 'retailer']},
        beforeEnter: checkAbility,
    },

    {path: '', name: 'Index',
        component: Index,},

    {path: '/weather', name: 'Weather',
        component: Weather,},
    {
        path: '/articles/:articles_type', name: 'Articles',
        component: Articles,
        props: true,
    },
    {path: '/blogs', name: 'Blogs',
        component: Blogs, props: true,},
    {path: '/read/:articles_type/:post_slug', name: 'Read Article',
        component: ReadPostFrontEnd, props: true,},
    {path: '/news', name: 'News',
        component: News,},

    {
        path: '/market', name: 'Market',
        component: Market,
        beforeEnter: preventOrderProduct,
    },
    {
        path: '/checkout', name: 'CheckOut',
        component: CheckOut,
        meta: {accessibleTo: ['developer', 'super admin', 'admin', 'retailer', 'customer', 'agricultural-officer']},
        beforeEnter: checkAbility
    },
    {
        path: '/market/order-summary', name: 'OrderSummary',
        component: OrderSummary,
        meta: {accessibleTo: ['developer', 'super admin', 'admin', 'retailer', 'customer', 'agricultural-officer']},
        beforeEnter: checkAbility
    },

    {
        path: '/dashboard/@:username', component: DashboardContainer, props: true,
        redirect: '/dashboard/@:username/home',
        children: [
            // Child elements should not have "/" in front of url ...
            {path: 'home', name: 'Dashboard', component: DashboardIndex,},
            {
                path: 'profile', name: 'Profile', component: Profile, props: true, meta: {hideBread: true}
            },
            {
                path: 'users', name: 'Manage Users', component: ManageUsers,
                meta: {accessibleTo: ['developer', 'super admin', 'admin']},
                beforeEnter: checkAbility
            },
            {path: 'users/view-profile/:id', name: 'View Profile', component: ViewProfile, props: true, meta: {hideBread: true}},
            {
                path: 'posts/category', name: 'Manage Post Category', component: ManagePostCategory,
                meta: {accessibleTo: ['super admin', 'admin', 'agricultural-officer']},
                beforeEnter: checkAbility
            },
            {
                path: 'posts', name: 'Manage Posts', component: Posts,
                meta: {accessibleTo: ['super admin', 'admin', 'agricultural-officer']},
                beforeEnter: checkAbility
            },
            {
                path: 'posts/:post_slug', name: 'Read Posts', component: ReadPost,
                meta: {accessibleTo: ['super admin', 'admin', 'agricultural-officer']},
                beforeEnter: checkAbility
            },
            {
                path: 'products/category', name: 'Manage Product Category', component: ManageCategory,
                meta: {accessibleTo: ['super admin', 'admin', 'farmer']},
                beforeEnter: checkAbility
            },
            {
                path: 'products', name: 'Manage Product', component: ManageProduct,
                meta: {accessibleTo: ['super admin', 'admin', 'farmer']},
                beforeEnter: checkAbility
            },
            {
                path: 'products/orders', name: 'Manage Order', component: ManageOrders,
                meta: {accessibleTo: ['super admin', 'admin', 'farmer', 'retailer', 'customer']},
                beforeEnter: checkAbility
            },
            {
                path: 'products/:product_slug', name: 'View Product', component: ProductView,
                meta: {accessibleTo: ['super admin', 'admin', 'farmer']},
                beforeEnter: checkAbility
            },

            {
                path: 'messages', name: 'Chat', component: Chat, props: true, meta: {hideBread: true}
            },
            {
                path: 'messages/:to_id', name: 'Chat-Conversation', component: Chat, props: true, meta: {hideBread: true}
            },
            {
                path: 'todos', name: 'Todo List',
                //component: Todo,
                component: Todo,
            },
            {
                path: 'todo-tasks/:date', name: 'Todo Task',
                //component: TodoItem,
                component: TodoItem,
                props: true,
            },


            // not done ...
            {
                path: 'activities', name: 'Activities', component: Activities,
                meta: {accessibleTo: ['farmer']},
                beforeEnter: checkAbility
            },


            // No Components ..............
            {
                path: 'manage-workers', name: 'Manage Worker', component: Test,
                meta: {accessibleTo: ['farmer']},
                beforeEnter: checkAbility
            },
            {
                path: 'manage-land', name: 'Manage Land', component: Test,
                meta: {accessibleTo: ['farmer']},
                beforeEnter: checkAbility
            },
            {
                path: 'manage-map', name: 'Manage Map', component: Test,
                meta: {accessibleTo: ['farmer']},
                beforeEnter: checkAbility
            },
            {
                path: 'manage-connections', name: 'Manage Connection', component: Test,
            },
            {
                path: 'find-people', name: 'Find People', component: FindPeople,
            },
            {
                path: 'contact-us', name: 'Contact Us', component: ContactUsMessages,
            },
            {
                path: 'agro/loan', name: 'Loan', component: Test,
                meta: {accessibleTo: ['super admin', 'farmer']},
                beforeEnter: checkAbility
            },
            {
                path: 'disease-center', name: 'Disease Center', component: Test,
                meta: {accessibleTo: ['super admin', 'agricultural-officer', 'farmer']},
                beforeEnter: checkAbility
            },
            {
                path: 'notification', name: 'Notification', component: Test,
            },
            {
                path: 'messages', name: 'Messages', component: Test,
            },
            {
                path: 'settings', name: 'Settings', component: Test,
                meta: {accessibleTo: ['developer', 'super admin', 'admin']},
                beforeEnter: checkAbility
            },
            // No Components ............ End .............
        ],
        beforeEnter: requireEmailVerified
    },
    {
        path: '/help', name: 'Help',
    },
    {
        path: '/dashboard/*',
        meta: {layout: 'blank'},
        component: NotFound,
        beforeEnter: function () {
            window.location = '/404_page_not_found';
        }
    },
    {
        path: '/404_page_not_found',
        alias: '*', name: 'page_not_found',
        component: NotFound,
    },
    /*{
        path: '*', name: 'page_not_found',
        meta: {layout: 'blank'},
        component: NotFound,
    },*/
]

const router = new VueRouter({
    mode: 'history',
    saveScrollPosition: true,
    base: process.env.MIX_BASE_URL,
    routes,
    linkActiveClass: "active",
    linkExactActiveClass: "exact-active",
});

router.beforeEach((to, from, next) => {
    document.title = `${to.name == 'Index' ? '' : to.name + ' | '} ${process.env.MIX_APP_NAME} | Nahid Ferdous`;
    window.scrollTo(0, 0);
    checkCartAccessibility();
    next();
});

/*function isLoggedIn() {
    return localStorage.getItem("auth");
}
router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.authOnly)) {
        // this route requires auth, check if logged in
        // if not, redirect to login page.
        if (!isLoggedIn()) {
            next({
                path: "/login",
                query: { redirect: to.fullPath }
            });
        } else {
            next();
        }
    } else if (to.matched.some(record => record.meta.guestOnly)) {
        // this route requires auth, check if logged in
        // if not, redirect to login page.
        if (isLoggedIn()) {
            next({
                path: "/dashboard",
                query: { redirect: to.fullPath }
            });
        } else {
            next();
        }
    } else {
        next(); // make sure to always call next()!
    }
});*/


export default router
