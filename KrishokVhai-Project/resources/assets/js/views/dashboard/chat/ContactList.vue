<template>
    <div class="sidebar-left sidebar-fixed">
        <div class="sidebar">
            <div class="sidebar-content card d-none d-lg-block">
                <div class="card-body chat-fixed-search">
                    <fieldset class="form-group position-relative has-icon-left m-0  w-75 display-inline">
                        <input type="text" class="form-control round" id="searchUser" placeholder="Search user">
                        <div class="form-control-position">
                            <i class="fas fa-search"></i>
                        </div>
                    </fieldset>
                    <span class="float-right  primary font-large-1 cursor-pointer"> <i class="fas fa-edit"></i> </span>
                </div>
                <div id="users-list" class="list-group position-relative">
                    <div class="users-list-padding media-list">

                        <div v-for="(contact, index) in sortedContacts" :key="contact.id">
                            <router-link href="#" class="media border-bottom-blue-grey border-bottom-lighten-5" :to="{name: 'Chat-Conversation', params:{to_id:contact.id}}"
                                         :class="{'selected': selectedContact && contact.id==selectedContact.id}">
                                <div class="media-left pr-1">
                    <span class="avatar avatar-md">
                        <img class="media-object rounded-circle" :src="contact.avatar" alt=""
                             style="width: 40px; height: 40px; object-fit: cover; object-position: center center;">
                         <i class="online-status" v-if="checkOnlineUsers(contact.id)"></i>
                    </span>
                                </div>
                                <div class="media-body w-100">
                                    <h6 class="list-group-item-heading font-medium-1 text-bold-700">
                                        {{ contact.first_name + ' ' + contact.last_name }}

                                        <span class="float-right primary" v-if="contact.unread">
                                            <span class="badge badge-pill badge-danger lighten-3">{{ contact.unread }}</span>
                                        </span>
                                    </h6>
                                    <!--                                    <p class="font-small-3 text-muted text-bold-500">3:55 PM</p>
                                                                        <p class="list-group-item-text text-muted mb-0 lighten-1">I was looking at your profile. The design looks better... </p>-->
                                </div>
                            </router-link>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    name: "ContactList",
    props: {
        contacts: {
            type: [Object, Array],
            default: []
        },
        selectedContact: {
            type: [Object, Array],
            default: []
        },
        /*onlineUsers: {
            type: [Object, Array],
            default: []
        },*/
    },
    data() {
        return {}
    },
    methods: {
        checkOnlineUsers(userid) {
            return _.find(this.onlineUsers, {id: userid});
        },
    },
    computed: {
        ...mapGetters({
            onlineUsers: 'user_state/onlineUsers'
        }),
        sortedContacts() {
            //return this.contacts;
            return _.sortBy(this.contacts, [(contact) => {
                if (contact == this.selectedContact) {
                    return Infinity;
                }
                //return contact.unread;
            }])//.reverse();
        },
    }
}
</script>

<style scoped lang="scss">
.avatar {
    position: relative;
}

.avatar .online-status {
    position: absolute;
    bottom: -2px;
    right: -2px;
    height: 16px;
    width: 16px;
    background: #2ecc71;
    border-radius: 50%;
}
</style>
