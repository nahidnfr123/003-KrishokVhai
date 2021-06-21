<template>
    <div class="modal fade show" id="exampleModal" tabindex="4" aria-labelledby="exampleModalLabel" aria-hidden="true"
         style="display: block; padding-right: 17px;" v-if="showModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ modalTitle }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            @click.stop.prevent="closeModal"></button>
                </div>
                <div class="modal-body">
                    <slot></slot>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click.stop.prevent="closeModal">Close</button>
                    <button type="button" class="btn btn-primary" @click.stop.prevent="submitFormModal">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "common_modal",
    props:{
        modalTitle:String,
        showModal:Boolean,
    },
    methods:{
        closeModal(){
            this.$emit('closeModal', false);
        },
        submitFormModal(){
            this.$emit('submitFormModal', true);
        }
    }
}
</script>

<style scoped>

</style>
