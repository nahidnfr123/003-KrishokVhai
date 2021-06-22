import Vue from 'vue';
import VueRouter from 'vue-router';
import store from './store';

Vue.use(VueRouter);

// import NotFound from './views/404';
const NotFound = () => import(/* webpackChunkName: "NotFound" */ "./views/404.vue");
// import Index from './views/Index';
const Index = () => import(/* webpackChunkName: "Index" */ "./views/Index.vue");
//import Weather from './views/Weather';
const Weather = () => import(/* webpackChunkName: "Weather" */ "./views/Weather.vue");
import Test from './views/Test';

///////////////// ------------------------- \\\\\\\\\\\\\\\\\\\\\\\

// import Register from './views/auth/Register';
const Register = () => import(/* webpackChunkName: "Register" */ "./views/auth/Register.vue");
// import Login from './views/auth/Login';
const Login = () => import(/* webpackChunkName: "Login" */ "./views/auth/Login.vue");
// import SocialLogin from './views/auth/SocialLogin';
const SocialLogin = () => import(/* webpackChunkName: "SocialLogin" */ "./views/auth/SocialLogin.vue");
// import EmailVerification from './views/auth/EmailVerification';
const EmailVerification = () => import(/* webpackChunkName: "EmailVerification" */ "./views/auth/EmailVerification.vue");
// import ForgotPassword from './views/auth/ForgotPassword';
const ForgotPassword = () => import(/* webpackChunkName: "ForgotPassword" */ "./views/auth/ForgotPassword.vue");
// import ResetPassword from './views/auth/ResetPassword';
const ResetPassword = () => import(/* webpackChunkName: "ResetPassword" */ "./views/auth/ResetPassword.vue");

///////////////// ------------------------- \\\\\\\\\\\\\\\\\\\\\\\

import Profile from './views/dashboard/Users/Profile';
// import Survey from "./views/Survey";
const Survey = () => import(/* webpackChunkName: "ResetPassword" */ "./views/Survey.vue");

/////////////// -------------------  Dashboard .......
import DashboardContainer from './views/dashboard/DashboardContainer';
//const DashboardContainer = () => import(/* webpackChunkName: "DashboardContainer" */ "./views/dashboard/DashboardContainer.vue");
import DashboardIndex from './views/dashboard';
//const DashboardIndex = () => import(/* webpackChunkName: "DashboardIndex" */ "./views/dashboard/Index.vue");
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

import ReadPost from "./views/dashboard/Posts/ReadPost";
// import Articles from "./views/posts/Articles";
const Articles = () => import(/* webpackChunkName: "Articles" */ "./views/posts/Articles.vue");
// import News from "./views/posts/News";
const News = () => import(/* webpackChunkName: "News" */ "./views/posts/News.vue");
// import ReadPostFrontEnd from "./views/posts/ReadPost";
const ReadPostFrontEnd = () => import(/* webpackChunkName: "ReadPostFrontEnd" */ "./views/posts/ReadPost.vue");
// import Blogs from "./views/posts/Blogs";
const Blogs = () => import(/* webpackChunkName: "Blogs" */ "./views/posts/Blogs.vue");
// import Market from "./views/Market/Market";
const Market = () => import(/* webpackChunkName: "Market" */ "./views/market/Market.vue");
// import CheckOut from "./views/market/CheckOut";
const CheckOut = () => import(/* webpackChunkName: "CheckOut" */ "./views/market/CheckOut.vue");
// import OrderSummary from "./views/market/OrderSummary";
const OrderSummary = () => import(/* webpackChunkName: "OrderSummary" */ "./views/market/OrderSummary.vue");
import Chat from "./views/dashboard/chat/Chat";
import FindPeople from "./views/dashboard/Users/FindPeople";
// import AccountBlocked from "./views/AccountBlocked";
const AccountBlocked = () => import(/* webpackChunkName: "AccountBlocked" */ "./views/AccountBlocked.vue");
// import ContactUs from "./views/ContactUs";
const ContactUs = () => import(/* webpackChunkName: "ContactUs" */ "./views/ContactUs.vue");
// import About from "./views/About";
const About = () => import(/* webpackChunkName: "About" */ "./views/About.vue");
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
        //component: () => import(/*webpackChunkName: "Register"*/'./views/auth/Register.vue'),
        beforeEnter: preventAuthenticated
    },
    {
        path: '/login', name: 'Login',
        component: Login,
        //component: () => import(/*webpackChunkName: "Login"*/'./views/auth/Login.vue'),
        beforeEnter: preventAuthenticated
    },
    {
        path: '/contact', name: 'Contact',
        component: ContactUs,
        //component: () => import(/*webpackChunkName: "ContactUs"*/'./views/ContactUs.vue'),
    },
    {
        path: '/about', name: 'About',
        component: About,
        //component: () => import(/*webpackChunkName: "About"*/'./views/About.vue'),
    },
    {
        path: '/account_blocked', name: 'AccountBlocked',
        component: AccountBlocked,
        //component: () => import(/*webpackChunkName: "AccountBlocked"*/'./views/AccountBlocked.vue'),
        beforeEnter: preventAuthenticated
    },
    {
        path: '/social-login/callback/:provider', name: 'SocialLogin',
        component: SocialLogin,
        //component: () => import(/*webpackChunkName: "SocialLogin"*/'./views/auth/SocialLogin.vue'),
        beforeEnter: preventAuthenticated
    },
    {
        path: '/forgot-password', name: 'ForgotPassword',
        component: ForgotPassword,
        //component: () => import(/*webpackChunkName: "ForgotPassword"*/'./views/auth/ForgotPassword.vue'),
        beforeEnter: preventAuthenticated
    },
    {
        path: '/reset-password/:token', name: 'ResetPassword',
        component: ResetPassword,
        //component: () => import(/*webpackChunkName: "ResetPassword"*/'./views/auth/ResetPassword.vue'),
        beforeEnter: preventAuthenticated
    },
    {
        path: '/email/verify', name: 'EmailVerification',
        component: EmailVerification,
        //component: () => import(/*webpackChunkName: "EmailVerification"*/'./views/auth/EmailVerification.vue'),
        beforeEnter: requireAuthenticated
    },
    {
        path: '/:usertype/survey', name: 'Survey',
        component: Survey,
        //component: () => import(/*webpackChunkName: "Survey"*/'./views/Survey.vue'),
        props: true, meta: {accessibleTo: ['agricultural-officer', 'farmer', 'retailer']},
        beforeEnter: checkAbility,
    },

    {
        path: '', name: 'Index',
        component: Index,
        //component: () => import(/*webpackChunkName: "Index"*/'./views/Index.vue'),
    },

    {
        path: '/weather', name: 'Weather',
        component: Weather,
        //component: () => import(/*webpackChunkName: "Weather"*/'./views/Weather.vue'),
    },
    {
        path: '/articles/:articles_type', name: 'Articles',
        component: Articles,
        //component: () => import(/*webpackChunkName: "Articles"*/'./views/posts/Articles.vue'),
        props: true,
    },
    {
        path: '/blogs', name: 'Blogs', props: true,
        component: Blogs,
        //component: () => import(/*webpackChunkName: "Blogs"*/'./views/posts/Blogs.vue'),
    },
    {
        path: '/read/:articles_type/:post_slug', name: 'Read Article', props: true,
        component: ReadPostFrontEnd,
        //component: () => import(/*webpackChunkName: "ReadPost"*/'./views/posts/ReadPost.vue'),
    },
    {
        path: '/news', name: 'News',
        component: News,
        //component: () => import(/*webpackChunkName: "News"*/'./views/posts/News.vue'),
    },

    {
        path: '/market', name: 'Market',
        component: Market,
        //component: () => import(/*webpackChunkName: "Market"*/'./views/market/Market.vue'),
        beforeEnter: preventOrderProduct,
    },
    {
        path: '/checkout', name: 'CheckOut',
        component: CheckOut,
        //component: () => import(/*webpackChunkName: "CheckOut"*/'./views/market/CheckOut.vue'),
        meta: {accessibleTo: ['developer', 'super admin', 'admin', 'retailer', 'customer', 'agricultural-officer']},
        beforeEnter: checkAbility
    },
    {
        path: '/market/order-summary', name: 'OrderSummary',
        component: OrderSummary,
        //component: () => import(/*webpackChunkName: "OrderSummary"*/'./views/market/OrderSummary.vue'),
        meta: {accessibleTo: ['developer', 'super admin', 'admin', 'retailer', 'customer', 'agricultural-officer']},
        beforeEnter: checkAbility
    },

    {
        path: '/dashboard/@:username', component: DashboardContainer, props: true,
        redirect: '/dashboard/@:username/home',
        children: [
            // Child elements should not have "/" in front of url ...
            {
                path: 'home', name: 'Dashboard',
                component: DashboardIndex,
                //component: () => import(/*webpackChunkName: "[DashboardIndex]"*/'./views/dashboard/Index.vue'),
            },
            {
                path: 'profile', name: 'Profile',
                props: true, meta: {hideBread: true},
                component: Profile,
                //component: () => import(/*webpackChunkName: "[Profile]"*/'./views/dashboard/Users/Profile.vue'),
            },
            {
                path: 'users', name: 'Manage Users', component: ManageUsers,
                meta: {accessibleTo: ['developer', 'super admin', 'admin']},
                beforeEnter: checkAbility
            },
            {
                path: 'users/view-profile/:id', name: 'View Profile',
                component: ViewProfile,
                props: true, meta: {hideBread: true}
            },
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
                path: 'messages', name: 'Chat', props: true, meta: {hideBread: true},
                component: Chat,
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
        //component: () => import(/*webpackChunkName: "404"*/'./views/404.vue'),
        beforeEnter: function () {
            window.location = '/404_page_not_found';
        }
    },
    {
        path: '/404_page_not_found',
        alias: '*', name: 'page_not_found',
        component: NotFound,
        //component: () => import(/*webpackChunkName: "404"*/'./views/404.vue'),
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
