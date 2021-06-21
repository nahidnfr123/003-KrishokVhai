<template>
    <ul>
        <li v-for="(data, dat) in data" :key="data.id">
            <div class="cursor-pointer hoverActive" @click.stop.prevent="nodeClicked(data)" :class="[selectedCategory == data.id?'active':'']">
                {{ data.title }}
                <span style="margin-left: 10px;">
                    <span v-if="categoryProductCountFilter && categoryProductCountFilter == 'news'">( {{ data.news_count }} )</span>
                    <span v-else-if="categoryProductCountFilter && categoryProductCountFilter == 'blog'">( {{ data.blog_count }} )</span>
                    <span v-else-if="categoryProductCountFilter && categoryProductCountFilter == 'farming-practice'">( {{ data.practice_count }} )</span>
                    <span v-else>( {{ data.post_count }} )</span>
                </span>
            </div>
            <template v-if="data.children && Object.keys(data.children).length">
                <category-list-frontend
                    :categoryProductCountFilter = "categoryProductCountFilter"
                    :data="data.children"
                    @nodeClicked="nodeClicked($event)"
                    :selectedCategory="selectedCategory"/>
            </template>
        </li>
    </ul>
</template>

<script>
export default {
    name: "category-list-frontend",
    data() {
        return {
            errors: [],
        }
    },
    props: {
        data: {
            type: [Object, Array]
        },
        selectedCategory: {
            type: [Number],
        },
        categoryProductCountFilter: {
            type: [String],
        }
    },
    methods: {
        nodeClicked(data_id) {
            this.$emit('nodeClicked', data_id);
        }
    }
}
</script>

<style scoped lang="css">
.hoverActive:hover {
    background: rgba(100, 100, 100, 0.2);
    color: rgba(40, 40, 20, 1);
}

.hoverActive {
    cursor: pointer;
    padding: 2px 4px;
    border-radius: 4px;
}

.hoverActive.active {
    background: dodgerblue;
    color: white;
}
</style>
