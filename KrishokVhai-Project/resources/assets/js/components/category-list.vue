<template>
    <ul>
        <li v-for="(data, dat) in data" :key="data.id">
            <div class="cursor-pointer hoverActive" @click.stop.prevent="nodeClicked(data.id)" :class="[selectedCategories.indexOf(data.id)>-1?'active':'']">
                {{ data.title }}
            </div>
            <template v-if="data.children && Object.keys(data.children).length">
                <category-list :data="data.children" @nodeClicked="nodeClicked($event)"
                               :selectedCategories="selectedCategories"/>
            </template>
        </li>
    </ul>
</template>

<script>
export default {
    name: "category-list",
    data(){
        return{
            errors:[],
        }
    },
    props: {
        data: {
            type: [Object, Array]
        },
        selectedCategories: {
            type: Array,
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
