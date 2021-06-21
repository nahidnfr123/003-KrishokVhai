<template>
    <nav aria-label="Page navigation example">
        <ul class="pagination pagination-info justify-content-end">

            <li class="page-item previous" :class="{ disabled: pagination.current_page <= 1 }">
                <a class="page-link" href="#" @click.stop.prevent="changePage(1)">
                    <i class="fas fa-arrow-left"></i>
                </a>
            </li>

            <li class="page-item previous" :class="{ disabled: pagination.current_page <= 1 }">
                <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page - 1)">
                    <i class="fas fa-chevron-left"></i>
                </a>
            </li>

            <li class="page-item" v-for="page in pages" :key="page" :class="isCurrentPage(page) ? 'active cursor-default' : 'cursor-pointer'" aria-current="page">
                <a class="page-link" href="#" @click.stop.prevent="changePage(page)">{{ page }}
                    <span v-if="isCurrentPage(page)" class="sr-only">(current)</span>
                </a>
            </li>

            <!--<li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item active" aria-current="page"><a class="page-link" href="#">4</a></li>
            <li class="page-item"><a class="page-link" href="#">5</a></li>
            <li class="page-item"><a class="page-link" href="#">6</a></li>
            <li class="page-item"><a class="page-link" href="#">7</a></li>-->

            <li class="page-item next" :class="{ disabled: pagination.current_page >= pagination.last_page }">
                <a class="page-link" href="#" @click.stop.prevent="changePage(pagination.current_page + 1)">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </li>

            <li class="page-item next" :class="{ disabled: pagination.current_page >= pagination.last_page }">
                <a class="page-link" href="#" @click.stop.prevent="changePage(pagination.last_page)">
                    <i class="fas fa-arrow-right"></i>
                </a>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    name: "pagination",
    props: ['pagination', 'offset'],
    methods: {
        isCurrentPage(page) {
            return this.pagination.current_page === page
        },
        changePage(page) {
            if (page > this.pagination.last_page) page = this.pagination.last_page;
            this.$emit('paginate', page);
        }
    },
    computed: {
        pages() {
            let pages = []
            let from = this.pagination.current_page - Math.floor(this.offset / 2)
            if (from < 1) {
                from = 1
            }
            let to = from + this.offset - 1
            if (to > this.pagination.last_page) {
                to = this.pagination.last_page
            }
            while (from <= to) {
                pages.push(from)
                from++
            }
            return pages;
        }
    }
}
</script>

<style scoped>

</style>
