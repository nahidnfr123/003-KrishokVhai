<template>
    <div class="container">
        <div class="col-12 col-md-8 col-lg-6 m-auto mb-4">
            <h2 class="text-center mt-4 text-muted">Register</h2>
            <hr>
            <div class="container">

                <div class="row my-4 text-center">
                    <div class="col-12 text-center  text-muted">
                        <h3 class="text-muted">Who are you?</h3>
                    </div>
                    <div class="col-6 col-md-3 reg-links" @click.stop.prevent="registrationData.user_type='farmer'"
                         :class="[registrationData.user_type=='farmer' ? 'active-reg-link' : '']">
                        <img src="//image.flaticon.com/icons/png/512/773/773805.png" alt="" class="rounded">
                        <p>Farmer</p>
                    </div>
                    <div class="col-6 col-md-3 reg-links" @click.stop.prevent="registrationData.user_type='retailer'"
                         :class="[registrationData.user_type=='retailer' ? 'active-reg-link' : '']">
                        <img :src="BaseUrl+'frontend-assets/img/shops.png'" alt="" class="rounded">
                        <p>Retailer</p>
                    </div>
                    <div class="col-6 col-md-3 reg-links" @click.stop.prevent="registrationData.user_type='agricultural-officer'"
                         :class="[registrationData.user_type=='agricultural-officer' ? 'active-reg-link' : '']">
                        <img :src="BaseUrl+'frontend-assets/img/man.png'" alt="" class="rounded">
                        <p>Agro Officer</p>
                    </div>
                    <div class="col-6 col-md-3 reg-links" @click.stop.prevent="registrationData.user_type='customer'"
                         :class="[registrationData.user_type=='customer' ? 'active-reg-link' : '']">
                        <img :src="BaseUrl+'frontend-assets/img/vegetables.png'" alt="" class="rounded">
                        <p>Customer</p>
                    </div>
                </div>
            </div>
            <hr>
            <div>
                <div class="mx-auto" v-if="registrationData.user_type">
                    <h3 class="text-muted text-center my-2">Fill the form</h3>
                    <hr>
                    <form @submit.stop.prevent="register" method="post" autofocus="autofocus" autocomplete="off">
                        <div class="row">
                            <div class="col-12 col-lg-6 col-xl">
                                <Custom_Text_Input
                                    class="mb-3"
                                    type="text"
                                    label="First Name (*)"
                                    name="first_name"
                                    placeholder="John"
                                    v-model="registrationData.first_name"
                                    :error="errors.first_name && Array.isArray(errors.first_name) ? errors.first_name[0] : errors.first_name"
                                    id="first_name"/>
                            </div>
                            <div class="col-12 col-lg-6 col-xl">
                                <Custom_Text_Input
                                    class="mb-3"
                                    type="text"
                                    label="Last Name (*)"
                                    name="last_name"
                                    placeholder="Doe"
                                    v-model="registrationData.last_name"
                                    :error="errors.last_name && Array.isArray(errors.last_name) ? errors.last_name[0] : errors.last_name"
                                    id="last_name"/>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-12 col-lg-6 col-xl">
                                <Custom_Text_Input
                                    class="mb-3"
                                    v-model="registrationData.username"
                                    label="Username (*)"
                                    type="text"
                                    name="username"
                                    :error="errors.username && Array.isArray(errors.username) ? errors.username[0] : errors.username"
                                    placeholder="john123"
                                    id="username"/>
                            </div>
                            <div class="col-12 col-lg-6 col-xl">
                                <Custom_Text_Input
                                    class="mb-3"
                                    v-model="registrationData.email"
                                    label="Email (*)"
                                    type="email"
                                    name="email"
                                    :error="errors.email && Array.isArray(errors.email) ? errors.email[0] : errors.email"
                                    placeholder="example@gmail.com"
                                    id="email"/>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-lg-6 col-xl">
                                <Custom_Text_Input
                                    class="mb-3"
                                    type="password"
                                    label="Password (*)"
                                    placeholder="********"
                                    id="password"
                                    name="password"
                                    v-model="registrationData.password"
                                    :error="errors.password && Array.isArray(errors.password) ? errors.password[0] : errors.password"/>
                            </div>
                            <div class="col-12 col-lg-6 col-xl">
                                <Custom_Text_Input
                                    class="mb-3"
                                    type="password"
                                    label="Confirm Password (*)"
                                    placeholder="********"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    v-model="registrationData.password_confirmation"/>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-lg-6 col-xl">
                                <Custom_Text_Input
                                    class="mb-3"
                                    Add_Input_Class="no-arrow"
                                    v-model="registrationData.mobile_number"
                                    label="Mobile Number (*)"
                                    type="tel"
                                    name="phone"
                                    pattern="[01][0-9]{9}"
                                    minlength="11"
                                    maxlength="11"
                                    :error="errors.mobile_number && Array.isArray(errors.mobile_number) ? errors.mobile_number[0] : errors.mobile_number"
                                    placeholder="01*********"
                                    id="mobile_number"/>
                                <!--pattern="[+]{01}[0-9]{11,14}"-->
                            </div>
                            <div class="col-12 col-lg-6 col-xl"
                                 v-if="['farmer', 'retailer', 'agricultural-officer'].includes(registrationData.user_type)">
                                <Custom_Text_Input
                                    class="mb-3"
                                    type="text"
                                    label="Postal Code"
                                    placeholder="1205"
                                    id="postal_code"
                                    name="post_code"
                                    maxlength="6"
                                    v-model="registrationData.postal_code"
                                    :error="errors.postal_code && Array.isArray(errors.postal_code) ? errors.postal_code[0] : errors.postal_code"/>
                            </div>
                        </div>

                        <Custom_Loading_Button
                            class="mb-2"
                            Add_Input_Class="col-12"
                            @button_clicked="register"
                            :processing="processing">
                            <span>Register</span>
                        </Custom_Loading_Button>
                    </form>

                    <div class="text-center">
                        By creating an account you agree to our <a href="">terms of service</a>
                    </div>
                </div>

                <!--<social-login-options @socialAuth="socialAuth($event)" v-if="registrationData.user_type=='customer'"/>-->

                <div class="text-center mt-4 text-gray-800 dark:text-gray-100">
                    Already have an account ?
                    <router-link to="/login" class="text-blue-500">Login</router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
// #-Notes: Form Components are registered as global components in app.js file.
import {mapActions, mapGetters} from 'vuex';
import auth from "../../store/auth";
//import SocialLoginOptions from "./SocialLoginOptions";

export default {
    name: 'Register',
    components: {
       // SocialLoginOptions
    },
    props: {
        BaseUrl: String,
    },
    data() {
        return {
            registrationData: {
                first_name: "",
                last_name: "",
                username: "",
                mobile_number: "",
                email: "",
                password: "",
                password_confirmation: "",
                user_type: "",
                postal_code: "",
            },
            hasError: [],
            errors: {},
            processing: false,
        }
    },
    watch: {
        'registrationData.user_type': function (newValue, oldValue) {
            if (newValue !== oldValue) {
                this.errors = {};
                this.clearFormData();
            }
        },
    },
    computed: {
        ...mapGetters({
            locationData: 'weather/locationData'
        })
    },
    mounted() {

    },
    methods: {
        ...mapActions({
            registerAction: 'auth/register',
            socialAuthAction: 'auth/socialAuth',
            clearAuthError: 'auth/clearError',
        }),
        clearFormData() {
            this.registrationData.first_name = '';
            this.registrationData.last_name = '';
            this.registrationData.username = '';
            this.registrationData.mobile_number = '';
            this.registrationData.email = '';
            this.registrationData.password = '';
            this.registrationData.password_confirmation = '';
            this.registrationData.postal_code = '';
            this.errors = {};

            if (Object.keys(this.locationData).length) {
                let postalCode = this.locationData.address.postcode;
                let codeArray = postalCode.split('-');
                if (codeArray.length == 1) {
                    this.registrationData.postal_code = codeArray[0];
                }
                if (codeArray.length == 2) {
                    this.registrationData.postal_code = codeArray[1];
                }
            }
        },
        validateRequest() {
            let __this = this;
            if (!__this.registrationData.first_name.trim()) __this.errors.first_name = 'First Name is required!';

            if (!__this.registrationData.last_name.trim()) __this.errors.last_name = 'Last Name is required!';

            if (!__this.registrationData.username.trim()) __this.errors.username = 'Username is required!';

            if (!__this.registrationData.mobile_number.trim()) __this.errors.mobile_number = 'Mobile number is required!';

            if (!__this.registrationData.email.trim()) __this.errors.email = 'Email is required!'

            if (!__this.registrationData.password.trim()) {
                __this.errors.password = 'Password is required!';
            } else if (__this.registrationData.password.trim().length < 8) {
                __this.errors.password = 'Password should be at least 8 characters!';
            } else if (__this.registrationData.password.trim() !== __this.registrationData.password_confirmation.trim()) {
                __this.errors.password = 'Password confirmation does not match!';
            }

            if (!__this.registrationData.password_confirmation.trim()) {
                __this.errors.password_confirmation = 'Confirm password is required!';
            } else if (__this.registrationData.password_confirmation.trim().length < 8) {
                __this.errors.password_confirmation = 'Confirm password should be at least 8 characters!';
            }
        },
        async register() {
            let __this = this;
            __this.$Progress.start();
            this.clearAuthError();
            __this.errors = {};
            __this.processing = true;

            this.validateRequest();

            if (Object.keys(__this.errors).length) {
                __this.$Progress.fail();
                __this.processing = false;
                return
            }

            await this.registerAction(__this.registrationData).finally(() => {
                __this.processing = false;
            });

            if (auth.state.error != null) {
                __this.$Progress.fail();
                __this.errors = auth.state.error;
                return
            }
            __this.$Progress.finish();

            // Automatic login is enabled after Registration ...
            if (auth.state.user) window.location.href = 'email/verify'; // Reload window to fetch user data ....
            else await __this.$router.replace({name: 'Login'});
        },
        validateNumber: event => {
            const charCode = String.fromCharCode(event.keyCode);
            if (!/[0-9]/.test(charCode)) {
                event.preventDefault();
                console.log('error')
            }
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
        }
        ,
    }
}
</script>


<style scoped lang="scss">
.reg-links {
    cursor: pointer;
    border-radius: 10px;
    padding-top: 10px;
    transition: all ease-in-out 200ms;

    img {
        border-radius: 50%;
    }
}

.reg-links.active-reg-link {
    background-color: #3fc1f5;

    &:hover {
        background-color: #3fc1f5;

        p {
            color: white !important;
        }
    }

    p {
        color: white !important;
    }
}

.reg-links:hover {
    background-color: #f1e5be;
}

.no-arrow {
    -moz-appearance: textfield;
}

.no-arrow::-webkit-inner-spin-button {
    display: none;
}

.no-arrow::-webkit-outer-spin-button,
.no-arrow::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
</style>
