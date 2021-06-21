<template>
    <transition leave-active-class="duration-200">
        <transition enter-active-class="ease-out duration-300">
            <div class="container mt-4 mb-4">
                <div class="flex flex-col justify-center align-middle items-center text-center">
                    <h3 class="text-muted">Email verification</h3>
                    <div class="mb-4 text-muted">
                        Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just e-mailed to you? If you haven't receive the email, we will gladly send you another.
                    </div>

                    <div class="mb-4 text-success" v-if="verificationLinkSent">
                        A new verification link has been sent to the email address you provided during registration.
                    </div>
                    <div class="text-xs">
                        <p>Please verify your email first.
                            ( <a class="cursor-pointer pb-2" href="#" @click.stop.prevent="sendEmailVerificationCode"> {{ verificationLinkSent ? "Resend email ?" : "Send email ?" }} </a> )</p>

                        <div class="mt-4 inline-flex" v-if="processing">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            <span class="text-sm">Sending Email. Please wait ...</span>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </transition>
</template>

<script>
import {mapActions} from 'vuex';
import auth from "../../store/auth";

export default {
    name: "EmailVerification",
    data() {
        return {
            verificationLinkSent: false,
            processing: false,
            errors: {},
        }
    },
    beforeMount() {
        this.getUsed()
    },
    methods: {
        ...mapActions({
            emailVerificationAction: 'auth/emailVerification',
            clearAuthError: 'auth/clearError',
            getMe: 'auth/me'
        }),
        async getUsed() {
            await this.getMe();
            if (this.$store.state.auth.user.email_verified_at != null) {
                await this.$router.replace({name: 'Home'})
            }
        },
        async sendEmailVerificationCode() {
            let __this = this;
            __this.processing = true;
            __this.$Progress.start();
            __this.errors = {};

            await this.clearAuthError();

            await this.emailVerificationAction().finally(() => {
                __this.processing = false;
                __this.verificationLinkSent = true;
            });

            if (auth.state.error != null) {
                __this.$Progress.fail();
                __this.errors = auth.state.error;
                return
            }
            __this.$Progress.finish();
        }
    }
}
</script>
