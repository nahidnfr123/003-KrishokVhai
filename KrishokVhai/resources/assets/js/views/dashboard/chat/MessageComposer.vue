<template>
    <section class="chat-app-form" v-if="!hideTextBox">
        <form class="chat-app-input d-flex" @submit.stop.prevent="send">
            <fieldset class="col-10 m-0">
                <div class="input-group position-relative has-icon-left">
                    <!--                    <div class="form-control-position">
                                            <span id="basic-addon3"><i class="fas fa-file"></i></span>
                                        </div>-->
                    <textarea class="form-control" aria-describedby="button-addon2"
                              v-model="message" @keydown.enter="send"></textarea>
                    <!--                    <input type="text" class="form-control" placeholder="Send message" aria-describedby="button-addon2">-->
                </div>
            </fieldset>
            <fieldset class="form-group position-relative has-icon-left col-3 m-0">
                <button type="button" class="btn btn-secondary btn-sm">
                    <i class="fas fa-file"></i>
                    <!--                    <span class="d-none d-lg-none d-xl-block">Send Message </span>-->
                </button>
                <button type="submit" class="btn btn-danger btn-sm" @click.stop.prevent="send">
                    <i class="fas fa-paper-plane"></i>
                    <!--                    <span class="d-none d-lg-none d-xl-block">Send Message </span>-->
                </button>
            </fieldset>
        </form>
    </section>
</template>

<script>
export default {
    name: "MessageComposer",
    props: ['hideTextBox'],
    data() {
        return {
            message: '',
        }
    },
    methods: {
        send(e) {
            e.preventDefault();
            if (this.message == '') {
                return;
            }
            this.$emit('send', this.message);
            this.message = '';
        }
    }

}
</script>

<style scoped>

</style>
