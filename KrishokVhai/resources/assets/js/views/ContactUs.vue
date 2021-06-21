<template>
    <div>
        <!-- ##### Breadcrumb Area Start ##### -->
        <div class="breadcrumb-area bg-img bg-overlay jarallax" style="background-image: url('/frontend-assets/img/bg-img/18.jpg');">
            <div class="container h-100">
                <div class="row h-100 align-items-center">
                    <div class="col-12">
                        <div class="breadcrumb-text">
                            <h2>CONTACT US</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="famie-breadcrumb">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i> Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contact</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- ##### Breadcrumb Area End ##### -->

        <!-- ##### Contact Information Area Start ##### -->
        <section class="contact-info-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <!-- Section Heading -->
                        <div class="section-heading text-center">
                            <p>CONTACT INFO</p>
                            <h2><span>The Best Way</span> To Contact Us For The Help</h2>
                            <img src="/frontend-assets/img/core-img/decor2.png" alt="">
                        </div>
                    </div>
                </div>

                <div class="row">

                    <!-- Single Information Area -->
                    <div class="col-12 col-md-4">
                        <div class="single-information-area text-center mb-100 wow fadeInUp" data-wow-delay="100ms">
                            <div class="contact-icon">
                                <i class="icon_pin_alt"></i>
                            </div>
                            <h5>Address</h5>
                            <h6>Boro-bondor, dinajpur Town, Bangladesh</h6>
                        </div>
                    </div>

                    <!-- Single Information Area -->
                    <div class="col-12 col-md-4">
                        <div class="single-information-area text-center mb-100 wow fadeInUp" data-wow-delay="500ms">
                            <div class="contact-icon">
                                <i class="icon_phone"></i>
                            </div>
                            <h5>Phone</h5>
                            <h6>01856823546</h6>
                        </div>
                    </div>

                    <!-- Single Information Area -->
                    <div class="col-12 col-md-4">
                        <div class="single-information-area text-center mb-100 wow fadeInUp" data-wow-delay="1000ms">
                            <div class="contact-icon">
                                <i class="icon_mail_alt"></i>
                            </div>
                            <h5>Email</h5>
                            <h6>info.krishivhai@gmail.com</h6>
                        </div>
                    </div>

                </div>
                <div class="c-border"></div>
            </div>
        </section>
        <!-- ##### Contact Information Area End ##### -->

        <!-- ##### Contact Area Start ##### -->
        <section class="contact-area section-padding-100-0">
            <div class="container">
                <div class="row justify-content-between">

                    <!-- Contact Content -->
                    <div class="col-12 col-md-8 col-lg-6 m-auto">
                        <div class="contact-content mb-100">
                            <!-- Section Heading -->
                            <div class="section-heading">
                                <p>Contact now</p>
                                <h2><span>Get In Touch</span> With Us</h2>
                                <img src="/frontend-assets/img/core-img/decor.png" alt="">
                            </div>
                            <!-- Contact Form Area -->
                            <div class="contact-form-area">
                                <form action="" method="post">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <Custom_Text_Input
                                                class="mb-2"
                                                type="text"
                                                label="Full name"
                                                placeholder="name"
                                                id="name"
                                                name="name"
                                                v-model="contactForm.name"
                                                :error="errors.name && Array.isArray(errors.name) ? errors.name[0] : errors.name"/>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <Custom_Text_Input
                                                    class="mb-2"
                                                    type="email"
                                                    label="Email"
                                                    placeholder="email"
                                                    id="email"
                                                    name="email"
                                                    v-model="contactForm.email"
                                                    :error="errors.email && Array.isArray(errors.email) ? errors.email[0] : errors.email"/>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <Custom_Text_Input
                                                    class="mb-2"
                                                    type="text"
                                                    label="Subject"
                                                    placeholder="subject"
                                                    id="subject"
                                                    name="subject"
                                                    v-model="contactForm.subject"
                                                    :error="errors.subject && Array.isArray(errors.subject) ? errors.subject[0] : errors.subject"/>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <Custom_Text_Input
                                                    class="mb-2"
                                                    type="textarea"
                                                    label="Message"
                                                    placeholder="message"
                                                    id="message"
                                                    name="message"
                                                    v-model="contactForm.message"
                                                    :error="errors.message && Array.isArray(errors.message) ? errors.message[0] : errors.message"/>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn famie-btn"
                                                    @click.stop.prevent="sendMessage()">
                                                <span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                Send Message
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Maps -->
                    <div class="col-lg-6">
                        <div class="contact-maps mb-100">

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ##### Contact Area End ##### -->

    </div>
</template>

<script>
export default {
    name: "ContactUs",
    data() {
        return {
            contactForm: {
                name: '',
                email: '',
                subject: '',
                message: '',
            },
            loading: false,
            errors: {},
        }
    },
    methods: {
        clearForm() {
            this.contactForm = {
                name: '',
                email: '',
                subject: '',
                message: '',
            }
        },
        validateData() {
            if (!this.contactForm.name.trim()) this.errors.name = 'Name is required!';
            if (!this.contactForm.email.trim()) this.errors.email = 'Email is required!';
            if (!this.contactForm.subject.trim()) this.errors.subject = 'Subject is required!';
            if (!this.contactForm.message.trim()) this.errors.message = 'Message is required!';
        },
        async sendMessage() {
            this.loading = true;
            this.errors = {};
            this.$Progress.start();

            this.validateData();

            if (Object.keys(this.errors).length) {
                this.$Progress.fail();
                this.loading = false;
                return false;
            }

            await axios.post('api/contact', this.contactForm).then((res) => {
                this.$Progress.finish();
                this.clearForm();
                this.$store.dispatch('snackbar/addSnack', {color: 'success', msg: 'Message sent successfully. We will reply as soon as possible.', snakbarType: 'Success'}, {root: true});
            }).catch((err) => {
                this.errors = err.response.status == 422 ? err.response.data.errors : 'The given data is invalid.';
                this.$store.dispatch('snackbar/addSnack', {color: 'danger', msg: err, snakbarType: 'error'}, {root: true});
                this.$Progress.fail();
            }).finally(() => {
                this.loading = false;
            });
        }
    }
}
</script>

<style scoped>

</style>
