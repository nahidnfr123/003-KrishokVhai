<template>

    <div class="content-right">
        <div class="content-wrapper">
            <div class="content-wrapper-before"></div>
            <div class="content-header row"></div>
            <div class="content-body">
                <section class="chat-app-window" style="max-height: calc(90vh - 100px); height: calc(90vh - 100px); overflow-y: auto;"
                         ref="feed">
                    <div class="mb-1 secondary text-bold-700">{{ contact ? contact.first_name + ' ' + contact.last_name : 'Select a contact' }}</div>
                    <button class="btn btn-sm btn-datk" v-if="contact">Load more</button>

                    <message-feeds :contact="contact" :messages="messages" v-if="!hideTextBox"/>

                </section>

                <message-composer @send="sendMessage" :hideTextBox="hideTextBox"/>

            </div>
        </div>
    </div>
</template>

<script>
import MessageComposer from "./MessageComposer";
import MessageFeeds from "./MessageFeeds";

export default {
    name: "Conversations",
    data() {
        return {
            hideTextBox: false,
        }
    },
    components: {MessageFeeds, MessageComposer},
    props: {
        contact: {
            type: [Object, Array],
            default: []
        },
        messages: {
            type: [Array],
            default: []
        },
    },
    mounted() {
        if (!this.contact) {
            this.hideTextBox = true;
        }
        //this.scrollToBottom();
    },
    watch: {
        contact() {
            this.scrollToBottom();
        },
        messages() {
            this.scrollToBottom();
        }
    },
    updated() {
        if (!this.contact) {
            this.hideTextBox = true;
        }else{
            this.hideTextBox = false;
        }
    },
    methods: {
        sendMessage(text) {
            if (!this.contact) {
                return;
            }

            axios.post('api/chat/message/send', {
                contact_id: this.contact.id,
                text: text
            }).then((res) => {
                this.$emit('new', res.data);
            });
        },
        scrollToBottom() {
            setTimeout(() => {
                this.$refs.feed.scrollTop = this.$refs.feed.scrollHeight - this.$refs.feed.clientHeight;
            }, 50);
        }
    }
}
</script>

<style scoped>

</style>
