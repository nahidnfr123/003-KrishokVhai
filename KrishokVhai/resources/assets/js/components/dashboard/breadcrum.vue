<template>
    <div>
        <div class="content-wrapper-before"></div>
        <div class="content-header row">
            <div class="content-header-left col-md-4 col-12 mb-2">
                <h3 class="content-header-title">{{ pageName }}</h3>
            </div>
            <div class="content-header-right col-md-8 col-12">
                <div class="breadcrumbs-top float-md-right">
                    <div class="breadcrumb-wrapper mr-1">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index-2.html">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">Layouts</a>
                            </li>
                            <li class="breadcrumb-item active">{{ pageName }}
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'Breadcrum',
    props: {
        pageName: String,
    }
}
</script>
