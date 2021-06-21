<template>
    <div id="mainContainer">
        <Dashboard v-if="isDashboard && user" :BaseUrl="BaseUrl" :user="user"/>
        <Home v-else :BaseUrl="BaseUrl" :user="user"/>

        <snackbar/>
        <vue-progress-bar/>

        <!--        <component :is="layout"></component>-->
    </div>
</template>

<script>
import {mapGetters, mapActions, mapState} from 'vuex';
import dayjs from "dayjs";
import Snackbar from "../CustomComponents/Snackbar/components/Snackbar";
import Home from "../layouts/Home";
import Dashboard from "../layouts/Dashboard";

export default {
    name: 'SmartAgro',
    components: {
        Dashboard,
        Home,
        Snackbar,
        //Dashboard: () => import(/*webpackChunkName: "Dashboard"*/'../layouts/Dashboard.vue'),
        //Home: ()=> import(/*webpackChunkName: "Home"*/'../layouts/Home.vue'),
        //Snackbar: ()=> import(/*webpackChunkName: "Snackbar"*/'../CustomComponents/Snackbar/components/Snackbar.vue'),
    },
    data() {
        return {
            BaseUrl: process.env.MIX_BASE_URL,
            currentDateTimeValue: {
                time: '',
                date: ''
            },
            isDashboard: false,
            onlineUsers: [],
        }
    },
    computed: {
        ...mapGetters({
            authenticated: 'auth/authenticated',
            user: 'auth/user',
            roles: 'auth/roles',
        }),
        ...mapState({
            stateOnlineUser: 'user_state/onlineUsers',
        }),
        layout() {
            return (this.$route.meta.layout);
        }
    },
    updated() {
        this.setUserOnline()
    },
    mounted() {
        this.setUserOnline();
        this.$Progress.finish();
        this.currentDateTime();
        this.checkPath();
        this.getUserLocation();
        this.checkSurvey();
    },
    methods: {
        checkPath() {
            const sPath = this.$router.currentRoute.path.split('/');
            if (sPath[1] == 'dashboard' && sPath[2] == '@' + this.user.username) {
                this.isDashboard = true;
            }
        },
        ...mapActions({
            logoutAction: 'auth/logout',
            getLocationData: 'weather/getLocationData',
            //getOnlineUsers: 'user_state/getOnlineUsers',
        }),
        async setUserOnline() {
            if (this.user != null) {
                Echo.join('online')
                    .here((users) => {
                        this.onlineUsers = users;
                        return this.$store.commit('user_state/SET_USER_ONLINE', this.onlineUsers, {root: true});
                    })
                    .joining((user) => {
                        this.onlineUsers.push(user);
                        return this.$store.commit('user_state/SET_USER_ONLINE', this.onlineUsers, {root: true});
                    })
                    .leaving((user) => {
                        this.onlineUsers = this.onlineUsers.filter((u) => {
                            return u != user;
                        });
                        return this.$store.commit('user_state/SET_USER_ONLINE', this.onlineUsers, {root: true});
                    });
            }
        },
        async logout() {
            await this.logoutAction();
            await this.$router.replace({name: 'Login'});
        },
        currentDateTime() {
            this.currentDateTimeValue.date = dayjs().format("DD MMM YYYY, dddd");
            this.currentDateTimeValue.time = dayjs().format("hh:mm:ss, A");
            setTimeout(this.currentDateTime, 1000);
        },
        async getUserLocation() {
            // Get user location ...
            await this.getLocationData();
        },
        checkSurvey() {
            const params = new URLSearchParams(window.location.search);
            if (params.has("verified") && params.get("verified") == 1) {
                let usertype = '';
                for (let role = 0; role < this.roles.length; role++) {
                    if (['farmer', 'retailer', 'agricultural-officer'].includes(this.roles[role])) {
                        usertype = usertype ? usertype + '-' : '' + this.roles[role];
                    }
                }
                if (usertype !== '') this.$router.replace({name: 'Survey', params: {usertype: usertype}});
            }
        },

    },
    created() {
        // **** Progressbar Start *** //
        //  [AppLayout.vue specific] When AppLayout.vue is first loaded start the progress bar
        this.$Progress.start();
        //  hook the progress bar to start before we move router-view
        this.$router.beforeEach((to, from, next) => {
            //  does the page we want to go to have a meta.progress object
            if (to.meta.progress !== undefined) {
                let meta = to.meta.progress;
                // parse meta tags
                this.$Progress.parseMeta(meta);
            }
            //  start the progress bar
            this.$Progress.start();
            // Scroll to top ...
            document.getElementById('mainContainer').scrollTo(0, 0);
            //  continue to next page
            next();
        })
        //  hook the progress bar to finish after we've finished moving router-view
        this.$router.afterEach((to, from) => {
            //  finish the progress bar
            this.$Progress.finish();
        })
        // **** Progressbar end **** //
    }
}
</script>

<style>
.isActiveIndicator {
    opacity: 0;
}

.router-link-exact-active.active-nav {
    background-color: dodgerblue !important;
    color: white;
}

.fade-enter, .fade-leave-to {
    opacity: 0;
    transform: translateX(2em);
}

.fade-enter-active, .fade-leave-active {
    transition: all .3s ease;
}
</style>
