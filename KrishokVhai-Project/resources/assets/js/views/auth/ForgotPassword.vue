<template>
    <div class="container">
        <div class="col-12 col-md-6 col-lg-4 m-auto mb-4">
            <h3 class="text-center mt-4 text-muted">Forgot Password</h3>
            <div>
                <div class="">
                    <form @submit.stop.prevent="sendResetLink" method="post" autofocus="autofocus">
                        <Custom_Text_Input
                            class="mb-3"
                            label="Email"
                            id="email"
                            type="email"
                            placeholder="example@email.com"
                            v-model="credentials.email"
                            :error="errors.email && Array.isArray(errors.email) ? errors.email[0] : errors.email"
                            :disabled="formDisabled"
                        />
                        <Custom_Loading_Button
                            Add_Input_Class="mb-4 mt-6 block mx-auto uppercase rounded"
                            @button_clicked="sendResetLink" :processing="processing" :disabled="formDisabled">
                            <span v-if="!emailSent">Send password reset link</span>
                            <span v-else>Resend password reset link</span>
                        </Custom_Loading_Button>
                    </form>

                    <div class="text-center text-xs mt-2 text-gray-800 dark:text-gray-300" v-if="countdownTimer">
                        Email sent successfully. You can retry in {{ countdownTimer }} sec.
                    </div>
                </div>

                <div class="text-center mt-4 text-gray-800 dark:text-gray-300">
                    Back to
                    <router-link to="/login" class="text-blue-500"> login.</router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions} from "vuex";
import auth from "../../store/auth";

export default {
    name: 'ForgetPassword',
    data() {
        return {
            credentials: {
                email: '',
            },
            errors: {},
            emailSent: false,
            formDisabled: false,
            processing: false,
            timerInterval: null,
            countdownTimer: null,
        }
    },
    methods: {
        ...mapActions({
            forgotPassword: 'auth/forgotPassword',
            clearAuthError: 'auth/clearError',
        }),
        async sendResetLink() {
            let __this = this;

            __this.processing = true;
            __this.$Progress.start();
            __this.errors = {};
            __this.clearAuthError(); /// If error is not cleared in VueX auth state... Home page is not shown on successful login ...
            if (!__this.credentials.email.trim()) __this.errors.email = 'Email is required!';

            if (Object.keys(__this.errors).length) {
                __this.$Progress.fail();
                __this.processing = false;
                return
            }

            await this.forgotPassword(this.credentials).finally(() => {
                __this.processing = false;
            });

            if (auth.state.error != null) {
                __this.$Progress.fail();
                __this.errors = auth.state.error;
                return
            }
            __this.formDisabled = true;
            __this.startTimer();
        },
        startTimer() {
            const TIME_LIMIT = 60;
            let timePassed = 0;
            this.countdownTimer = TIME_LIMIT;
            this.timerInterval = setInterval(() => {
                timePassed += 1;
                this.countdownTimer = TIME_LIMIT - timePassed;
                if (this.countdownTimer == 0) {
                    this.onTimesUp();
                }
            }, 1000);
        },
        onTimesUp() {
            clearInterval(this.timerInterval);
            this.formDisabled = false;
            this.countdownTimer = null;
            this.emailSent = true;
        }
    }
}
</script>
