<template>
    <div>
        <modal modalTitle="Update password" @closeModal="closeUpdatePasswordModal()" @submitFormModal="updatePassword()">
            <form method="post" @submit.stop.prevent="updatePassword">
                <div class="row">
                    <div class="col">
                        <Custom_Text_Input
                            class="mb-3"
                            type="password"
                            label="Current Password"
                            placeholder="********"
                            id="current_password"
                            v-model="updatePasswordForm.current_password"
                            :error="errors.current_password && Array.isArray(errors.current_password) ? errors.current_password[0] : errors.current_password"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <Custom_Text_Input
                            class="mb-3"
                            type="password"
                            label="New Password"
                            placeholder="********"
                            id="password"
                            v-model="updatePasswordForm.password"
                            :error="errors.password && Array.isArray(errors.password) ? errors.password[0] : errors.password"/>
                    </div>
                    <div class="col">
                        <Custom_Text_Input
                            class="mb-3"
                            type="password"
                            label="Confirm New Password"
                            placeholder="********"
                            id="password_confirmation"
                            v-model="updatePasswordForm.password_confirmation"/>
                    </div>
                </div>
            </form>
        </modal>
    </div>
</template>

<script>
import Modal from './modal';
import {mapActions, mapState} from "vuex";

export default {
    name: 'updatePassword',
    components: {Modal},
    data() {
        return {
            user: {},
            updatePasswordForm: {
                current_password: "",
                password: "",
                password_confirmation: "",
            },
            errors: [],
            processing: false,
        }
    },
    beforeMount() {
        this.user = this.$store.state.auth.user;
    },
    computed: {
        ...mapState({
            getErrors: state => state.user_state.error
        }),
    },
    methods: {
        ...mapActions({
            updateUserPassword: 'user_state/updateUserPassword',
            clearError: 'user_state/clearError'
        }),
        closeUpdatePasswordModal() {
            let __this = this;
            __this.updatePasswordForm.current_password = "";
            __this.updatePasswordForm.password = "";
            __this.updatePasswordForm.password_confirmation = "";
            this.$emit('closeUpdatePasswordModal', false)
        },
        validateRequest() {
            let __this = this;
            if (!__this.updatePasswordForm.current_password.trim()) {
                __this.errors.current_password = 'Old password is required!'
            }

            if (!__this.updatePasswordForm.password.trim()) {
                __this.errors.password = 'New password is required!'
            } else if (__this.updatePasswordForm.password.trim().length < 8) {
                __this.errors.password = 'Password should be at least 8 characters!';
            } else if (__this.updatePasswordForm.password.trim() === __this.updatePasswordForm.current_password.trim()) {
                __this.errors.password = 'Old password and New password cannot be same.';
            } else if (__this.updatePasswordForm.password.trim() !== __this.updatePasswordForm.password_confirmation.trim()) {
                __this.errors.password = 'New password and Confirm password does not match.';
            }

            if (!__this.updatePasswordForm.password_confirmation.trim()) {
                __this.errors.password_confirmation = 'Confirm password is required!'
            } else if (__this.updatePasswordForm.password_confirmation.trim().length < 8) {
                __this.errors.password_confirmation = 'Confirm password should be at least 8 characters!';
            }
        },
        async updatePassword() {
            let __this = this;
            __this.$Progress.start();
            __this.clearErrors();
            __this.processing = true;

            __this.validateRequest();

            if (Object.keys(__this.errors).length) {
                __this.$Progress.fail();
                __this.processing = false;
                return;
            }

            await this.updateUserPassword(__this.updatePasswordForm)
                .finally(() => {
                    __this.processing = false;
                });

            if (__this.getErrors != null) {
                __this.errors = __this.getErrors;
                __this.$Progress.fail();
                return;
            }
            __this.closeUpdatePasswordModal();
            __this.$Progress.finish();
        },
        clearErrors() {
            this.errors = {};
            this.clearError();
        },
    }
}
</script>
