<template>
    <div class="rounded border bg-white col-12 col-lg-4" style="padding: 6px;"
         :class="AddClass">
        <h3 class="text-center font-bold">{{ title }}</h3>
        <div class="listDropZone position-relative rounded pb-1 px-1 pt-1 text-sm bg-dark"
             :id="id"
             :cardType="status"
             @dragover.prevent
             @dragenetr.prevent
             @drop.prevent="dropItem($event, todoId)">

            <slot name="Item"/>

        </div>

        <slot name="Button"/>

    </div>
</template>

<script>
import {mapActions, mapState} from "vuex";

export default {
    name: 'TodoItem',
    props: ['id', 'title', 'AddClass', 'status', 'todoId', 'todoData'],
    data() {
        return {
            taskUpdateData: {
                taskId: '',
                status: this.status,
            },
            errors: {},
        }
    },
    computed: {
        ...mapState({
            getErrors: state => state.todo.error
        }),
    },
    methods: {
        ...mapActions({
            updateTask: 'todo/updateTask',
        }),
        dropItem(e, todoId) {
            const card_id = e.dataTransfer.getData('card_id');
            const todo_id = e.dataTransfer.getData('todo_Id');
            const card = document.getElementById(card_id);
            // Prevent from dropping tasks in different todo ...
            if (todoId == todo_id) {
                e.target.appendChild(card);
                card.style.display = "block";
                this.taskUpdateData.taskId = card_id.replace('item-', '');
                this.updateTaskStatus();
            } else {
                this.$store.dispatch('snackbar/addSnack', {color: 'danger', msg: 'Task dropped in wrong todo list!', snakbarType: 'Error'}, {root: true});
            }
        },
        async updateTaskStatus() {
            let __this = this;
            __this.$Progress.start();

            await __this.updateTask(this.taskUpdateData);

            if (__this.getErrors != null) {
                __this.errors = __this.getErrors;
                this.$store.dispatch('snackbar/addSnack', {color: 'danger', msg: 'Error: ' + __this.errors.task, snakbarType: 'Error'}, {root: true})
                    .then(() => {
                        __this.$Progress.fail();
                    });
                return;
            }
            __this.$Progress.finish();
        }
    },
}
</script>

<style scoped>
.listDropZone {
    min-height: 40px;
    max-height: 100%;
    width: 100%;

}
</style>
