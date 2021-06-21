<template>
    <div class="container">
        <div class="col-12 col-md-6 col-lg-4 m-auto mb-4">
            <h3 class="text-center mt-4 text-muted">Reset Password</h3>
            <div>
                <div class="">
                    <form @submit.stop.prevent="resetPasswordSubmit" method="post" autofocus="autofocus">
                        <Custom_Text_Input
                            class="mb-4"
                            label="Email"
                            id="email"
                            type="email"
                            placeholder="example@email.com"
                            v-model="credentials.email"
                            :error="errors.email && Array.isArray(errors.email) ? errors.email[0] : errors.email"
                            Add_Input_Class="h-10 dark:bg-gray-900"
                        />
                        <Custom_Text_Input
                            class="mb-4"
                            label="Password"
                            id="password"
                            type="password"
                            placeholder="********"
                            v-model="credentials.password"
                            :error="errors.password && Array.isArray(errors.password) ? errors.password[0] : errors.password"
                            Add_Input_Class="h-10 dark:bg-gray-900"
                        />
                        <Custom_Text_Input
                            class="mb-4"
                            label="Password Confirmation"
                            id="password_confirmation"
                            type="password"
                            placeholder="********"
                            v-model="credentials.password_confirmation"
                            Add_Input_Class="h-10 dark:bg-gray-900"
                        />
                        <Custom_Text_Input
                            class="invisible"
                            id="token"
                            type="text"
                            placeholder="token"
                            v-model="credentials.token"
                            :hidden="true"
                        />

                        <Custom_Loading_Button
                            Add_Input_Class="mb-4 mt-6 block mx-auto uppercase rounded"
                            @button_clicked="resetPasswordSubmit" :processing="processing" :disabled="btnDisabled">
                            <span>Reset password</span>
                        </Custom_Loading_Button>
                    </form>

                </div>

                <div class="text-center mt-4 text-gray-800 dark:text-gray-300">
                    Back to <router-link to="/login" class="text-blue-500"> login.</router-link>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import auth from "../../store/auth";
import {mapActions} from "vuex";

export default {
    data() {
        return {
            credentials: {
                email: "",
                password: "",
                password_confirmation: "",
                token: "",
            },
            errors: {},
            processing: false,
            btnDisabled: false,
        }
    },
    mounted() {
        if (this.$route.params.token) {
            this.credentials.token = this.$route.params.token;
        } else {
            this.$store.dispatch('snackbar/addSnack', {color: 'danger', msg: 'Password reset token is missing.', snakbarType: 'Error'}, {root: true});
            this.$router.replace({name: 'ForgotPassword'});
        }
    },
    methods: {
        ...mapActions({
            resetPassword: 'auth/resetPassword',
            clearAuthError: 'auth/clearError',
        }),
        async resetPasswordSubmit() {
            let __this = this;

            __this.processing = true;
            __this.$Progress.start();
            __this.errors = {};
            __this.clearAuthError(); /// If error is not cleared in VueX auth state... Home page is not shown on successful login ...
            if (!__this.credentials.email.trim()) __this.errors.email = 'Email is required!';
            if (!__this.credentials.password.trim()) {
                __this.errors.password = 'Password is required!';
            } else if (__this.credentials.password.trim().length < 8) {
                __this.errors.password = 'Password should be at least 8 characters!';
            } else if (__this.credentials.password.trim() !== __this.credentials.password_confirmation.trim()) {
                __this.errors.password = 'Password confirmation does not match!';
            }

            if (Object.keys(__this.errors).length) {
                __this.$Progress.fail();
                __this.processing = false;
                return
            }

            await this.resetPassword(this.credentials).finally(() => {
                __this.processing = false;
            });

            if (auth.state.error != null) {
                __this.$Progress.fail();
                __this.errors = auth.state.error;
                return
            }
            __this.formDisabled = true;
            await this.$router.replace({name: 'Login'});
        }
    }
}
</script>
