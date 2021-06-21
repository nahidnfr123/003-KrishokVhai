<template xmlns="http://www.w3.org/1999/html">
    <div class="content-body">
        <section class="row">
            <div class="col-sm-12">

                <!-- What is-->
                <div id="what-is" class="card">
                    <div class="card-header">
                        <h4 class="card-title">Contact us messages</h4>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            <div class="card-text">

                                <div class="row mb-2">
                                    <div v-if="messages && Object.keys(messages).length">
                                        <div v-for="message in messages" :key="message.id"
                                             class="shadow rounded p-2 m-2 d-flex justify-content-between align-items-center flex-wrap">
                                            <div class="mb-1">
                                                <div><strong>Name: </strong>{{ message.name }}, <strong>Email: </strong>{{ message.email }}</div>
                                                <div v-if="expandMessage == message.id"><strong>Subject: </strong>{{ message.subject }}</div>
                                                <div v-else><strong>Subject: </strong>{{ message.subject|truncate(50) }}</div>

                                                <div v-if="expandMessage == message.id"><strong>Message: </strong>{{ message.message }}</div>
                                                <div v-else><strong>Message: </strong>{{ message.message|truncate(50) }}</div>
                                            </div>
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-success" title="View" @click="viewMessages(message.id)"><i class="fas fa-eye"></i></button>
                                                <button class="btn btn-sm btn-warning" title="Reply" @click="replyForm(message)"><i class="fas fa-reply"></i></button>
                                                <button class="btn btn-sm btn-danger" title="Delete" @click="deleteMessage(message.id)"><i class="fas fa-trash"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-else>
                                        <div class="alert alert-info text-center">
                                            No contact messages found.
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!--/ What is-->
            </div>
        </section>


        <div class="modal fade show" id="exampleModal" tabindex="4" aria-labelledby="exampleModalLabel" aria-hidden="true"
             style="display: block; padding-right: 17px;" v-if="showModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Contact Message</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                @click.stop.prevent="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <div v-if="msg && Object.keys(msg).length">
                            <div class="shadow rounded p-2 m-2">
                                <div class="mb-1">
                                    <!--<div><strong>Email: </strong>{{ msg.email }}</div>
                                    <div><strong>Name: </strong>{{ msg.name }}</div>
                                    <div><strong>Subject: </strong>{{ msg.subject }}</div>
                                    <div><strong>Message: </strong>{{ msg.message }}</div>-->

                                    <form @submit.stop.prevent="reply()">
                                        <div><strong>To:</strong> {{ replyMessage.to }}</div>
                                        <br>
                                        <Custom_Text_Input
                                            class="mb-2"
                                            label="Subject"
                                            id="subject"
                                            type="text"
                                            placeholder="Subject"
                                            v-model="replyMessage.subject"
                                            :error="errors.subject && Array.isArray(errors.subject) ? errors.subject[0] : errors.subject"
                                        />
                                        <Custom_Text_Input
                                            class="mb-2"
                                            label="Message"
                                            id="message"
                                            type="textarea"
                                            placeholder="Message go here ..."
                                            v-model="replyMessage.message"
                                            :error="errors.message && Array.isArray(errors.message) ? errors.message[0] : errors.message"
                                        />
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-warning" title="Reply">
                                                <i class="fas fa-reply"></i> Reply
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</template>

<script>
// import Common_modal from "../../components/modals/common_modal";

export default {
    name: "ContactUsMessages",
    components: {
        // Common_modal
    },
    data() {
        return {
            showModal: false,
            messages: {},
            msg: [],
            errors: {},
            expandMessage: 0,
            replyMessage: {
                to: "",
                subject: "",
                message: ""
            },
            sendingReplyMessage: false,
        }
    },
    mounted() {
        this.getContactUsMessages();
    },
    methods: {
        async getContactUsMessages() {
            await axios.get('api/contact').then((res) => {
                this.messages = res.data;
            }).catch((err) => {
                this.errors = err.response.data;
                this.$store.dispatch('snackbar/addSnack', {color: 'danger', msg: this.errors, snakbarType: 'Error'}, {root: true});
            });
        },
        replyForm(message) {
            this.showModal = true;
            this.msg = message;

            this.replyMessage = {
                to: message.email,
                subject: message.subject,
                message: "",
            }
        },

        async reply() {
            this.errors = {};
            this.sendingReplyMessage = true;
            await axios.post('api/contact/reply', this.replyMessage)
                .then(() => {
                    this.closeModal();
                    this.$store.dispatch('snackbar/addSnack', {color: 'success', msg: 'Email sent successful!', snakbarType: 'Success'}, {root: true});
                    this.errors = {};
                    this.replyMessage = {
                        to: "",
                        subject: "",
                        message: "",
                    }
                })
                .catch((error) => {
                    if (error && error.response && error.response.status == 422) {
                        this.errors = error;
                    } else if (error && error.response) {
                        this.errors = error.response.data.errors;
                    }
                })
                .finally(() => {
                    this.sendingReplyMessage = false;
                });
        },
        viewMessages(id) {
            this.expandMessage = id;
        },
        closeModal() {
            this.showModal = false;
            this.msg = [];
        },
        deleteMessage(contact_message_id) {
            axios.delete(`api/contact/${contact_message_id}`).then((res) => {
                this.messages.filter(obj => {
                    return res.data.id != obj.id;
                });
                this.closeModal();
                this.$store.dispatch('snackbar/addSnack', {color: 'success', msg: 'Message deleted.', snakbarType: 'Success'}, {root: true});
            }).catch((err) => {
                this.errors = err.response.data;
                this.$store.dispatch('snackbar/addSnack', {color: 'danger', msg: this.errors, snakbarType: 'Error'}, {root: true});
            });
        }
    }
}
</script>

<style scoped>

</style>
