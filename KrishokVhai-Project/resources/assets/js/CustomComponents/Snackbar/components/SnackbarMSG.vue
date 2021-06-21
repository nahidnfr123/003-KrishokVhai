<template>
    <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true"
         @mouseenter.prevent="clearTimer()"
         @mouseleave.prevent="createTimer(1000)" style="transition: all ease-in-out 300ms;color:white!important;">
        <div class="toast-header">
            <strong class="me-auto">{{ snack.snakbarType ? snack.snakbarType: 'Notification' }}</strong>
<!--            <small class="text-muted">just now</small>-->
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close" @click="closeSnack(snack)"></button>
        </div>
        <div class="toast-body" :class="typeClass">
            {{ snack.msg }}
        </div>
        <div style="width: 100%; height: 4px; padding: 0 2px;">
            <div class="rounded" style="height:4px; margin: 1px 1px 2px 1px; background: dodgerblue;width: 0" :style="'width:'+progressBar.progress+'%'"></div>
        </div>
    </div>
</template>

<script>
import {mapActions} from "vuex";

export default {
    name: 'SnackbarMSG',
    props: ['snack'],
    data() {
        return {
            timeout: null,
            progressBar: {
                timer: null,
                progress: 0,
            },
        }
    },
    computed: {
        typeClass() {
            return `bg-${this.snack.color} dark:bg-${this.snack.color}`;
        }
    },
    created() {
        this.createTimer()
    },
    beforeDestroy() {
        clearTimeout(this.timeout);
        clearTimeout(this.progressBar.timer);
    },
    methods: {
        ...mapActions({
            removeSnack: 'snackbar/removeSnack'
        }),
        clearTimer() {
            clearTimeout(this.timeout);
            this.progressBar.progress = 0;
            clearInterval(this.progressBar.timer);
        },
        createTimer(time = 4000) {
            this.progressBarStart(time / 100);
            this.timeout = setTimeout(() => {
                this.closeSnack();
            }, time);
        },
        closeSnack(snack = this.snack) {
            this.removeSnack(snack);
        },
        progressBarStart(time = 30) {
            this.progressBar.progress = 0;
            this.progressBar.timer = setInterval(() => {
                if (this.progressBar.progress >= 100) {
                    clearInterval(this.progressBar.timer);
                } else {
                    this.progressBar.progress++;
                }
            }, time);
        }
    },
}
</script>

<style scoped>
.animateInSnackbar {

}
</style>
