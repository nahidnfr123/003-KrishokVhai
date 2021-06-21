<template>
    <div class="chats" v-if="contact && (messages && messages.length)">
        <div class="chat" v-for="message in messages" :class="[message.to == contact.id?' ':'chat-left']" :key="message.id">
            <div class="chat-avatar">
                <a class="avatar" data-toggle="tooltip" href="#" data-placement="right" title="" data-original-title="">
                    <img :src="message.to == contact.id?user.avatar:contact.avatar" class="box-shadow-4" alt="avatar" style="object-fit: cover; object-position: center center; height: 40px; width: 40px;"/>
                </a>
            </div>
            <div class="chat-body">
                <div class="chat-content">
                    <p style="max-width: 100%;white-space: nowrap;word-wrap:break-word;">{{ message.body }}</p>
                </div>
            </div>
        </div>

        <!--        <div class="chat">
                    <div class="chat-avatar">
                        <a class="avatar" data-toggle="tooltip" href="#" data-placement="right" title="" data-original-title="">
                            <img src="/admin/app-assets/images/portrait/small/avatar-s-1.png" class="box-shadow-4" alt="avatar"/>
                        </a>
                    </div>
                    <div class="chat-body">
                        <div class="chat-content">
                            <img class="img-thumbnail img-fluid" src="/admin/app-assets/images/portrait/small/avatar-s-1.png"
                                 alt="Image description">
                        </div>
                        <div class="chat-content">
                            <p>Here you go! Let me know if you need anything else.</p>
                        </div>
                    </div>
                </div>-->
        <!--        <p class="time">25 minutes ago</p>-->

    </div>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    name: "MessageFeeds",
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
    computed: {
        ...mapGetters({
            user: 'auth/user',
        })
    }
}
</script>

<style scoped>

</style>
