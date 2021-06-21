<template>
    <div class="d-flex justify-content-center align-items-center bg-info py-2 rounded text-white my-2">
        <div class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="margin-top: 1px;"/>
        <div  style="margin-left: 10px;">{{ msg }}</div>
    </div>
</template>

<script>
export default {
    name: 'Loading',
    props: {
        msg: {
            type: String,
            default: "loading ... "
        }
    }
}
</script>
