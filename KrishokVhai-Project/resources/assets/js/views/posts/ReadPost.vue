<template>
    <div>

        <!-- ##### Breadcrumb Area Start ##### -->
        <div class="breadcrumb-area bg-img bg-overlay jarallax" style="background-image: url('/frontend-assets/img/bg-img/18.jpg');">
            <div class="container h-100">
                <div class="row h-100 align-items-center">
                    <div class="col-12">
                        <div class="breadcrumb-text">
                            <h2>{{ $route.params.articles_type }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="famie-breadcrumb">
            <div class="container">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <router-link to="/"><i class="fa fa-home"></i> Home</router-link>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">{{ $route.params.articles_type }}</li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $route.params.post_slug }}</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- ##### Breadcrumb Area End ##### -->

        <!-- ##### News Details Area Start ##### -->
        <section class="news-details-area section-padding-0-100" v-if="post">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <!-- News Details Content -->
                        <div class="col-12" v-if="loading">
                            <loading v-if="loading" msg="Loading posts ..."/>
                        </div>
                        <div class="news-details-content">
                            <h6>Post on <a href="#" class="post-date">{{ post.created_at | dateFormatMDY }}</a> / <a href="#" class="post-author">{{ post.author }}</a></h6>
                            <h2 class="post-title">{{ post.title }}
                                <!--                                <span>
                                                                    <button class="btn btn-sm btn-warning" @click.stop.prevent="postReader(post.title)">
                                                                        <i class="fas fa-volume-down"></i>
                                                                    </button>
                                                                </span>-->
                            </h2>

                            <div v-if="post.imageUrls" class="row mb-3">
                                <div v-for="img in post.imageUrls" class="col-12 col-lg-4 text-center">
                                    <img :src="img" alt="image" class="rounded"
                                         style="margin: 3px; border-radius: 6px; min-height: 100px; height: 200px; max-height: 300px; object-fit: cover; object-position: center center;">
                                </div>
                            </div>

                            <!--                            <div class="mx-1">
                                                            <button class="btn btn-sm btn-warning" @click.stop.prevent="postReader(post.description)">
                                                                <i class="fas fa-volume-down"></i>
                                                            </button>
                                                        </div>-->
                            <div v-html=post.description></div>
                        </div>

                        <!-- Post Author -->

                        <div v-if="author.length" class="post-author-area" style="margin-top: 20px !important;">
                            <h5 class="mb-2 text-muted">Authors:</h5>
                            <div class="d-flex align-items-center">
                                <div class="post-author-img">
                                    <img :src="author.avatar" alt="" style="height: 80px !important; width: 80px !important; object-fit: cover; object-position: center center;">
                                </div>
                                <div class="post-author-description">
                                    <a href="#">
                                        <h5>{{ author.first_name }} {{ author.last_name }}</h5>
                                    </a>
                                    <p>{{ author.about }}</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <!-- ##### News Details Area End ##### -->

    </div>
</template>

<script>
export default {
    name: "ArticlesView",
    data() {
        return {
            post: [],
            author: [],
            slug: '',
            loading: false,
        }
    },
    watch: {
        '$route': 'getPost',
        /*'$route.params.articles_type': {
            handler: function (newVal, oldVal) {
                if (newVal != oldVal) {
                }
            },
            deep: true,
            immediate: true
        },*/
    },
    created() {
        this.getPost();
    },
    methods: {
        async getPost() {
            if (this.$route.params.post_slug) {
                this.loading = true;
                this.slug = this.$route.params.post_slug;
                await axios.get(`api/post/${this.slug}`).then((response) => {
                    this.post = response.data.data
                    axios.get(`api/getAuthor/${response.data.data.user_id}`).then((res) => {
                        this.author = res.data.data;
                    });
                }).finally(() => {
                    this.loading = false;
                });
            }
        },
        postReader(textToRead) {
            if ('speechSynthesis' in window) {
                // Speech Synthesis supported 🎉
                var msg = new SpeechSynthesisUtterance();
                msg.text = textToRead;
                window.speechSynthesis.speak(msg);
            } else {
                // Speech Synthesis Not Supported 😣
                alert("Sorry, your browser doesn't support text to speech!");
            }
        },
    }
}
</script>

<style scoped>

</style>
