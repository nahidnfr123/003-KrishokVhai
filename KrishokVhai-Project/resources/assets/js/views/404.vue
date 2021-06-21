<template>
    <div class="flex items-center justify-center align-middle">
        <div class="text-center py-4">
            <div class="p-2 bg-primary items-center rounded flex lg:inline-flex" role="alert" style="color: white !important;">
                <span class="flex rounded-full uppercase px-2 py-1 text-xs font-bold mr-3">404</span>
                <span class="font-semibold mr-2 text-left flex-auto">Page Not Found!</span>
                <button class="btn btn-sm btn-default rounded p-1 ml-2 text-dark" @click="$router.go(-1)" style="height: 30px; width: 30px;">
                    <i class="fas fa-angle-left" style="font-size: 20px;"></i>
<!--                    <span>Go Back</span>-->
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'page_not_found',
}
</script>
