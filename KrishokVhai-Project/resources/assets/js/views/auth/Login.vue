<template>
    <div class="container">
        <div class="col-12 col-md-6 col-lg-4 m-auto mb-4">
            <h3 class="text-center mt-4 text-muted">Login</h3>
            <div>
                <div class="">
                    <form @submit.stop.prevent="login" method="post" autofocus="autofocus">
                        <Custom_Text_Input
                            class="mb-3"
                            label="Phone number / Username / Email"
                            id="username"
                            type="text"
                            placeholder="john123, john@example.com, 01*********"
                            v-model="loginCredentials.username"
                            :error="errors.username && Array.isArray(errors.username) ? errors.username[0] : errors.username"
                            Add_Input_Class="h-10 dark:bg-gray-900"
                        />

                        <Custom_Text_Input
                            class="mb-3"
                            id="password"
                            placeholder="********"
                            v-model="loginCredentials.password"
                            label="Password"
                            type="password"
                            :error="errors.password && Array.isArray(errors.password) ? errors.password[0] : errors.password"
                            Add_Input_Class="h-10 dark:bg-gray-900"
                        />

                        <div class="mb-2">
                            <input type="checkbox" v-model="loginCredentials.remember" id="remember" name="remember" class="mr-1">
                            <label for="remember" class="text-sm text-gray-600">Remember me</label>
                        </div>

                        <div class="mb-2 text-gray-800 dark:text-gray-300 text-sm">
                            <router-link to="/forgot-password" class="text-blue-500">Forgot Password?</router-link>
                        </div>

                        <Custom_Loading_Button
                            class="mb-2"
                            Add_Input_Class="col-12"
                            @button_clicked="login" :processing="processing">
                            <span>Login</span>
                        </Custom_Loading_Button>
                    </form>
                </div>

                <!--<social-login-options @socialAuth="socialAuth($event)"/>-->

                <div class="text-center mt-4 text-gray-800 dark:text-gray-300">
                    Don't have an account?
                    <router-link to="/register" class="text-blue-500">Register</router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
// #-Notes: Form Components are registered as global components in app.js file.
//import axios from 'axios';
import {mapActions} from 'vuex';
import auth from '../../store/auth';
//import SocialLoginOptions from "./SocialLoginOptions";

export default {
    name: 'Login',
    components: {
        //SocialLoginOptions
    },
    data() {
        return {
            loginCredentials: {
                username: "",
                password: "",
                remember: false,
                csrf_token: null,
            },
            errors: {},
            processing: false,
        }
    },
    methods: {
        ...mapActions({
            loginAttempt: 'auth/login',
            socialAuthAction: 'auth/socialAuth',
            clearAuthError: 'auth/clearError',
        }),
        async login() {
            let __this = this;
            this.processing = true;
            __this.$Progress.start();
            __this.errors = {};
            this.clearAuthError(); /// If error is not cleared in VueX auth state... Home page is not shown on successful login ...

            if (!__this.loginCredentials.username.trim()) __this.errors.username = 'Username or Email is required!';
            if (!__this.loginCredentials.password.trim()) {
                __this.errors.password = 'Password is required!';
            } else if (__this.loginCredentials.password.trim().length < 8) {
                __this.errors.password = 'Password should be at least 8 characters!';
            }
            if (Object.keys(__this.errors).length) {
                __this.$Progress.fail();
                __this.processing = false;
                return
            }

            await this.loginAttempt(this.loginCredentials).finally(() => {
                __this.processing = false;
            });

            if (auth.state.error != null) {
                __this.$Progress.fail();
                __this.errors = auth.state.error;
                return
            }

            if (auth.state.user != null) {
                if (auth.state.user.email_verified_at != null) {
                    __this.$router.replace({name: 'Index'});
                    await this.$store.dispatch('snackbar/addSnack', {color: 'success', msg: 'Login Successful.', snakbarType: 'Success'}, {root: true});
                } else {
                    __this.$router.replace({name: 'EmailVerification'});
                    await this.$store.dispatch('snackbar/addSnack', {color: 'success', msg: 'Login Successful. Please verify email address.', snakbarType: 'Success'}, {root: true});
                }
                __this.$Progress.finish();
            } else {
                __this.$Progress.fail();
            }
            // this.$store.dispatch('currentUser/loginUser', this.user);
        },
        async socialAuth(provider) {
            this.$Progress.start();
            await this.socialAuthAction(provider)
                .then((response) => {
                    if (response.data.url) {
                        window.location.href = response.data.url;
                    }
                }).finally(() => {
                    this.$Progress.finish();
                });
        },
    }
}
</script>
