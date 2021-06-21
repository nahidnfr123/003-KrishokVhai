<template>
    <div class="content-body">
        <section class="row">
            <div class="col-sm-12">

                <!-- What is-->
                <div id="what-is" class="card">
                    <div class="card-header">
                        <h4 class="card-title">My Todo List</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <button class="btn btn-sm btn-primary" @click.stop.prevent="showTodoFormModal=true">Add todo item</button>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            <div class="card-text">

                                <div>
                                    <!-- Backend Group by Date -->
                                    <template v-if="todos && todos.length">
                                        <div class="mt-1 mb-1" v-for="(days, d) in groupedTodos" :key="d">
                                            <div class="text-sm text-info mb-1">
                                                <router-link :to="{name:'Todo Task', params:{date:d}}">{{ d | dateFormatCustom('ddd, DD MMM YYYY') }}</router-link>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-md-6" v-for="todo in days" :key="todo.id">
                                                    <div class="rounded shadow bg-white">
                                                        <h6 class="font-bold pt-1 pl-1"
                                                            :class="{'line-through text-success':todo.status==1}">
                                                            {{ todo.title | capitalize }}
                                                        </h6>
                                                        <hr class="divider">
                                                        <div class="text-xs pl-1" v-if="todo.todo_tasks">
                                                            <div class="d-flex flex-wrap justify-content-start align-items-center"
                                                                 v-for="task in todo.todo_tasks" :key="task.id" style="padding: 6px 0;">
                                                                    <span v-if="task.status == 'completed'">
                                                                        <svg class="stroke-current text-success feather feather-check-circle"
                                                                             style="height: 20px; width: 20px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                           <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                                                           <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                                                       </svg>
                                                                    </span>
                                                                <span v-else-if="task.status == 'doing'">
                                                                    <svg class="stroke-current text-warning"
                                                                         style="height: 20px; width: 20px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                      <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                                      <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"/>
                                                                      <rect x="9" y="3" width="6" height="4" rx="2"/>
                                                                      <path d="M9 14l2 2l4 -4"/>
                                                                    </svg>
                                                                </span>
                                                                <span v-else>
                                                                    <svg class="" style="height: 20px; width: 20px;" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                                                    </svg>
                                                                </span>
                                                                <div class="pl-1" :class="[{'line-through text-success':task.status=='completed'}, {'text-warning':task.status=='doing'}]">
                                                                    {{ task.title | capitalize }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            Showing todos for last 7 days.
                                        </div>
                                    </template>
                                    <div v-else>
                                        <Loading v-if="loading === true"/>
                                        <div v-else class=" alert alert-info text-center">
                                            <p>No data found!</p>
                                        </div>
                                    </div>

                                </div>


                            </div>
                        </div>
                    </div>
                </div>
                <!--/ What is-->
            </div>
        </section>

        <todo-form-modal v-if="showTodoFormModal"
                         :showTodoFormModal="showTodoFormModal"
                         :formType="formType"
                         @closeModal="showTodoFormModal=false"
                         :data="editTodoData"/>

    </div>
</template>

<script>
import {mapState} from 'vuex';
import TodoFormModal from "./TodoFormModal";

export default {
    name: 'Todo-Lists',
    components: {TodoFormModal},
    data() {
        return {
            env: process.env.MIX_APP_NAMES,
            loading: true,
            todo: [],
            formType: "create",
            showTodoFormModal: false,
            editTodoData: {},
        }
    },
    computed: {
        ...mapState({
            todos: state => state.todo.todos,
            groupedTodos: state => state.todo.groupedTodos,
        }),
    },
    created() {

    },
    mounted() {
        this.getTodos();
    },
    methods: {
        getTodos() {
            let __this = this;
            __this.$Progress.start();
            this.$store.dispatch('todo/fetchTodos').then(() => {
                __this.loading = false;
                __this.$Progress.finish();
            }).catch(error => {
                __this.loading = false;
                __this.$Progress.fail();
            });
        },
        getTodoForDate(date) {
            let __this = this;
            let res = __this.todos.filter(o => Object.values(o).includes(date));
            __this.todo = res;
            console.log(res);
        }
    }
}
</script>


<style scoped lang="scss">
[x-cloak] {
    display: none;
}

.line-through {
    text-decoration: line-through;
}

[type="checkbox"] {
    box-sizing: border-box;
    padding: 0;
}

.form-checkbox {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    -webkit-print-color-adjust: exact;
    color-adjust: exact;
    display: inline-block;
    vertical-align: middle;
    background-origin: border-box;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    flex-shrink: 0;
    color: currentColor;
    background-color: #fff;
    border-color: #e2e8f0;
    border-width: 1px;
    border-radius: 0.25rem;
    height: 1.2em;
    width: 1.2em;
}

.form-checkbox:checked {
    background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='M5.707 7.293a1 1 0 0 0-1.414 1.414l2 2a1 1 0 0 0 1.414 0l4-4a1 1 0 0 0-1.414-1.414L7 8.586 5.707 7.293z'/%3e%3c/svg%3e");
    border-color: transparent;
    background-color: currentColor;
    background-size: 100% 100%;
    background-position: center;
    background-repeat: no-repeat;
}
</style>
