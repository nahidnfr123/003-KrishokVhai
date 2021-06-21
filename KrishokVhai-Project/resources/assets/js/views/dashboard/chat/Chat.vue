<template>
    <div class="app-content" v-if="user.status === 'active'">
        <contact-list :contacts="contacts" :selectedContact="selectedContact" :onlineUsers="onlineUsers"/>
        <conversations :contact="selectedContact" :messages="messages" @new="saveNewMessage($event)"/>
    </div>
</template>

<script>
import Conversations from "./Conversations";
import ContactList from "./ContactList";
import {mapGetters} from "vuex";

export default {
    name: "Chat",
    components: {ContactList, Conversations},
    data() {
        return {
            selectedContact: null,
            messages: [],
            contacts: [],
            onlineUsers: [],
        }
    },
    activated() {
        document.body.classList.add("content-left-sidebar")
        document.body.classList.add("chat-application")
    },
    deactivated() {
        document.body.classList.remove("content-left-sidebar")
        document.body.classList.remove("chat-application")
    },
    computed: {
        ...mapGetters({
            user: 'auth/user',
        })
    },
    mounted() {
        Echo.private(`messages.${this.user.id}`)
            .listen('NewMessage', (e) => {
                this.handleIncoming(e.message);
            });

        Echo.join('online')
            .here((users) => {
                this.onlineUsers = users
            })
            .joining((user) => {
                this.onlineUsers.push(user);
            })
            .leaving((user) => {
                this.onlineUsers = this.onlineUsers.filter((u) => {
                    return u != user;
                });
            });

        this.getAllContacts();
    },
    watch: {
        '$route': 'selectContact',
    },
    methods: {
        selectContact() {
            if (this.$route.params.to_id) {
                let to_id = this.$route.params.to_id;
                this.data = this.contacts.filter(obj => {
                    return obj.id == to_id;
                })
                this.selectedContact = this.data[0];
            } else {
                this.selectedContact = null;
            }
            if (this.selectedContact) {
                this.startConversationWith(this.selectedContact)
            }
        },
        async getAllContacts() {
            await axios.get('api/contacts').then((res) => {
                this.contacts = res.data;
                this.selectContact();
            });
        },
        startConversationWith(contact) {
            this.updateUnreadCount(contact, true);
            axios.get(`api/chat/messages/${contact.id}`).then((res) => {
                this.messages = res.data;
                this.selectedContact = contact;
            }).catch(() => {

            }).finally(() => {

            });
        },
        saveNewMessage(message) {
            this.messages.push(message);
        },
        handleIncoming(message) {
            if (this.selectedContact && message.from == this.selectedContact.id) {
                this.saveNewMessage(message);
                return;
            }
            this.updateUnreadCount(message.from_contact, false);
        },
        updateUnreadCount(contact, reset) {
            this.contacts = this.contacts.map((single) => {
                if (single.id !== contact.id) {
                    return single;
                }
                if (reset)
                    single.unread = 0;
                else
                    single.unread += 1;
                return single;
            })
        }

    }
}
</script>

<style scoped>

</style>
