<template>
    <div class="w-24 min-w-max mx-auto max-w-prose bg-gray-200 shadow-xl rounded my-10 place-content-center lg:min-w-max md:w-auto dark:bg-gray-800" style="min-width: 340px!important;">
        <p class="text-center text-gray-800 py-4 mt-2 dark:text-gray-300">Login with {{ $route.params.provider }} please wait.</p>
        <Loading v-if="loading == true"/>
    </div>
</template>

<script>
// #-Notes: Form Components are registered as global components in app.js file.
// import axios from 'axios';
import {mapActions, mapGetters} from 'vuex';

export default {
    name: 'SocialLogin',
    data() {
        return {
            loading: true,
            errors: {},
            timer: null,
        }
    },
    computed: {
        ...mapGetters({
            authenticated: 'auth/authenticated',
            user: 'auth/user',
        }),
    },
    methods: {
        ...mapActions({
            socialAuthCallbackAction: 'auth/socialAuthCallback',
            addSnack: 'snackbar/addSnack'
        }),
        socialAuthCallback() {
            this.socialAuthCallbackAction({
                code: this.$route.query.code,
                provider: this.$route.params.provider,
            }).then((response) => {
                if (response && response.data.user) {
                    this.$nextTick().then(() => {
                        this.timer = setInterval(() => {
                            if (this.user) this.$router.push({name: 'Home'});
                        }, this.user);
                    });
                } else {
                    this.loading = false;
                    this.$store.dispatch('snackbar/addSnack', {color: 'red-500', msg: 'Failed to authenticate user account. Please try again later'}, {root: true});
                    this.$router.replace({name: 'Login'});
                }
            }).catch(() => {
                this.$store.dispatch('snackbar/addSnack', {color: 'red-500', msg: 'Failed to authenticate user account. Please try again later'}, {root: true});
                this.$router.replace({name: 'Login'});
            });
        }
    },
    created() {
        this.socialAuthCallback();
    },
    beforeDestroy() {
        this.loading = false;
        clearInterval(this.timer);
    },
}
</script>
