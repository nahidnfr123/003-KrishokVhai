window.axios = require('axios');


function generateErrors({commit, dispatch}, error, err, msg = "Error! ", showSnackBar = false) {
    if (error.response) {
        if (error.response.status == 401) {
            err = error.message;
            dispatch('snackbar/addSnack', {color: 'danger', msg: 'Unauthenticated: ' + err, snakbarType: snakbarType}, {root: true});
        } else if (error.response.status == 422) {
            err = error.response.data.errors;
        } else if (error.response.status == 403) {
            err = error.response.data.message
        } else if (error.response.status == 500) {
            err = error.response.data.message;
            dispatch('snackbar/addSnack', {color: 'red-500', msg: 'Backend server error!'}, {root: true});
        } else if (error.response.status == 419) {
            err = error.response.data.message;
            dispatch('snackbar/addSnack', {color: 'red-500', msg: err}, {root: true});
        } else {
            err = msg + error;
        }
        commit('SET_ERROR', err);
        if (showSnackBar === true && error.response.status != 419) {
            dispatch('snackbar/addSnack', {color: 'red-500', msg: err}, {root: true});
        }
    } else {
        dispatch('snackbar/addSnack', {color: 'red-500', msg: error}, {root: true});
    }
}

export default {
    namespaced: true,

    state: {
        todos: [],
        todo: [],
        groupedTodos: [],
        error: null,
    },
    init() {
        axios.get('api/todos')
            .then((response) => {
                this.state.todos = response.data;
            });
    },
    getters: {
        getTodos(state) {
            return state.todos
        },
        getTodoById: state => id => {
            return state.todos.find(todos => todo.id === id)
        },
    },
    mutations: {
        setTodos(state, todos) {
            state.todos = todos;
            // Arrange All the fetched todo items in groups by date ....
            state.groupedTodos = _.groupBy(state.todos, 'date');
        },
        setTodo(state, date) {
            state.todo = [];
            state.todo = state.todos.filter(o => Object.values(o).includes(date))
                .sort((a, b) => b.id - a.id);
        },
        newTodo(state, todo) {
            state.todos.push(todo);
            // Arrange todos ... by date ...
            state.todos.sort((a, b) => b.date > a.date ? 1 : -1);

            if (state.todo.length) {
                if (state.todo[0].date == todo.date) {
                    let date = state.todo[0].date;
                    state.todo = [];
                    state.todo = state.todos.filter(o => Object.values(o).includes(date))
                        .sort((a, b) => b.id - a.id);
                }
            }

            // Arrange todos grouped by date ...
            state.groupedTodos = _.groupBy(state.todos, 'date');
            /*for (let group in state.groupedTodos) {
                _.sortBy(state.groupedTodos[group], 'id').reverse();
            }*/

            // Todo Work
            function groupBy(key) {
                return function group(array) {
                    return array.reduce((acc, obj) => {
                        const property = obj[key];
                        acc[property] = acc[property] || [];
                        acc[property].push(obj);
                        return acc;
                    }, {});
                };
            }

            const groupByDate = groupBy("date");
            console.log(groupByDate(state.todos));
        },
        updateTodo(state, todo) {
            state.todo.map(to => {
                if (to.id == todo.id) {
                    for (let key in todo) {
                        to[key] = todo[key];
                    }
                }
            });
        },
        moveTodo(state, todo) {
            state.todo = state.todo.filter(obj => {
                return obj.id != todo.id;
            });
        },
        deleteTodo(state, todo) {
            state.todo = state.todo.filter(obj => {
                return obj.id != todo.id;
            });
        },
        newTask(state, todo) {
            const index = state.todo.findIndex(t => t.id === todo.id);
            if (index !== -1) {
                state.todo.splice(index, 1, todo);
            }
        },
        updateTask(state, todo) {
            /*state.todos.unshift(todo);
            state.groupedTodos = _.groupBy(state.todos, 'date');*/
            /*const index = state.todo.findIndex(t => t.id === todo.id);
            if (index !== -1) {*/
            //state.todo = [...state.todo.filter(element => element.id !== todo.id), todo]
            state.todo.map(to => {
                if (to.id == todo.id) {
                    for (let key in todo) {
                        to[key] = todo[key];
                    }
                }
            });
            /*}*/
            /*let data = state.todo[index].todo_tasks.findIndex(t => t.id === task.id);
            console.log(data, state.todo[index].todo_tasks[data].status);*/
        },
        deleteTask(state, task) {
            const index = state.todo.findIndex(t => t.id === task.todo_id);
            if (index !== -1) {
                //const data = state.todo[index].todo_tasks.findIndex(t => t.id === task.id);
                state.todo[index].todo_tasks = state.todo[index].todo_tasks.filter(obj => {
                    return obj.id != task.id;
                });
            }
        },
        SET_ERROR(state, value) {
            return state.error = value
        },
        SET_ERROR_TO_NULL(state, value) {
            return state.error = value
        }
    },
    actions: {
        clearError({commit}) {
            commit('SET_ERROR_TO_NULL', null)
        },
        async fetchTodos({commit, dispatch}) {
            let err = null;
            return await axios.get('api/todos')
                .then(response => {
                    commit('setTodos', response.data.data);
                }).catch(error => {
                    generateErrors({commit, dispatch}, error, err, "Error fetching todos!", true);
                });
        },
        async addTodo({commit, dispatch}, todo) {
            let err = null;
            return await axios.post('api/todos', todo)
                .then(response => {
                    commit('newTodo', response.data.data);
                    dispatch('snackbar/addSnack', {color: 'success', msg: 'Todo List successfully added.', snakbarType: 'Success'}, {root: true});
                }).catch(error => {
                    generateErrors({commit, dispatch}, error, err, "Error adding todo!");
                });
        },
        getTodoForDate({commit}, date) {
            commit('setTodo', date);
        },
        async updateTodo({commit, dispatch}, todo) {
            let err = null;
            return await axios.put(`api/todos/${todo.id}`, todo)
                .then(response => {
                    commit('updateTodo', response.data.data);
                    dispatch('snackbar/addSnack', {color: 'success', msg: 'Todo updated successfully.', snakbarType: 'Success'}, {root: true});
                }).catch(error => {
                    generateErrors({commit, dispatch}, error, err, "Error updating todo!");
                });
        },
        async moveTodo({commit, dispatch}, data) {
            let err = null;
            return await axios.put(`api/todos/move/${data.todoId}`, data)
                .then(response => {
                    commit('moveTodo', response.data.data);
                    dispatch('snackbar/addSnack', {color: 'success', msg: 'Todo moved successfully.', snakbarType: 'Success'}, {root: true});
                }).catch(error => {
                    generateErrors({commit, dispatch}, error, err, "Error moving todo!", true);
                });
        },
        async deleteTodo({commit, dispatch}, todo) {
            let err = null;
            return await axios.delete('api/todos/' + todo.id)
                .then(response => {
                    commit('deleteTodo', response.data.data);
                    dispatch('snackbar/addSnack', {color: 'success', msg: 'Todo deleted successfully.', snakbarType: 'Success'}, {root: true});
                }).catch(error => {
                    generateErrors({commit, dispatch}, error, err, "Error deleting todo!", true);
                });
        },
        async addTask({commit, dispatch}, task) {
            let err = null;
            return await axios.post('api/todos/addTask', task)
                .then(response => {
                    commit('newTask', response.data.data);
                    dispatch('snackbar/addSnack', {color: 'success', msg: 'Task successfully added.', snakbarType: 'Success'}, {root: true});
                }).catch(error => {
                    generateErrors({commit, dispatch}, error, err, "Error adding task!");
                });
        },
        async updateTask({commit, dispatch}, taskData) {
            let err = null;
            return await axios.put("api/todos/updateTask/" + taskData.taskId, taskData)
                .then(response => {
                    commit('updateTask', response.data.data);
                    dispatch('snackbar/addSnack', {color: 'success', msg: 'Task updated successfully.', snakbarType: 'Success'}, {root: true});
                }).catch(error => {
                    generateErrors({commit, dispatch}, error, err, "Error updating task!");
                });
        },
        async deleteTask({commit, dispatch}, taskData) {
            let err = null;
            return await axios.delete('api/todos/deleteTask/' + taskData.id)
                .then(response => {
                    commit('deleteTask', response.data.data);
                    dispatch('snackbar/addSnack', {color: 'success', msg: 'Task deleted successfully.', snakbarType: 'Success'}, {root: true});
                }).catch(error => {
                    generateErrors({commit, dispatch}, error, err, "Error deleting task!", true);
                });
        },
    }
}


