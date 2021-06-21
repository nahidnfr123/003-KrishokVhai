<template>
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 50000000000000" v-if="snacks.length">
        <snackbar-m-s-g v-for="snack in snacks" :key="snack.id" :snack="snack"/>
    </div>
</template>

<script>
import SnackbarMSG from "./SnackbarMSG";
import { mapState } from "vuex"
export default {
    name: 'Snackbar',
    components: {
        SnackbarMSG
    },
    computed:{
        ...mapState({
            snacks: state => state.snackbar.snacks,
        })
    }
}
</script>

