<template>

    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"
         :class="showTodoFormModal?'show':''"
         style="display: block; padding-right: 5px; z-index: 2000000 !important; overflow-y: auto;" v-if="showTodoFormModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Todo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            @click.stop.prevent="closeModal"></button>
                </div>
                <div class="modal-body">

                    <!-- This example requires Tailwind CSS v2.0+ -->
                    <div class="fixed z-30 inset-0 overflow-y-auto" v-if="showTodoFormModal">
                        <div class="tasks-end text-center">

                            <div class="fixed inset-0 transition-opacity" aria-hidden="true" :class="[showTodoFormModal ? 'animateInFade' : '']"
                                 @click="closeModal">
                                <div class="absolute"></div>
                            </div>

                            <!-- This element is to trick the browser into centering the modal contents. -->
                            <span class="hidden" aria-hidden="true">&#8203;</span>
                            <div class="shadow-md inline-block align-bottom rounded text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full dark:bg-gray-900"
                                 role="dialog" aria-modal="true" aria-labelledby="modal-headline"
                                 :class="[showTodoFormModal ? 'animateInFadeDown' : '' , 'startPosition']">
                                <div class="">
                                    <section>
                                        <h1 class="text-center font-bold text-lg">
                                            {{ formType === 'update' ? 'Update Todo' : 'Add Todo' }}
                                        </h1>

                                        <Custom_Text_Input
                                            label="Todo Title"
                                            id="todo_title"
                                            type="text"
                                            placeholder="Todo Title"
                                            v-model="createFormData.title"
                                            :error="errors.title && Array.isArray(errors.title) ? errors.title[0] : errors.title"
                                        />

                                        <Custom_Text_Input
                                            label="Description"
                                            id="Description"
                                            type="textarea"
                                            placeholder="Description ..."
                                            v-model="createFormData.description"
                                            :error="errors.description && Array.isArray(errors.description) ? errors.description[0] : errors.description"
                                            Add_Input_Class="resize-none"
                                        />


                                        <Custom_Checkbox_Input
                                            id="for_today"
                                            type="checkbox"
                                            v-model="createFormData.forToday"
                                            :error="errors.forToday && Array.isArray(errors.forToday) ? errors.forToday[0] : errors.forToday"
                                            name="for_today"
                                            checkLabel="For Today...?"
                                            v-if="formType != 'update'"
                                        />


                                        <div v-if="formType != 'update'">
                                            <div class="d-flex justify-content-between mb-2">
                                                <h6 class="text-sm">Add Item to todo?</h6>
                                                <span @click="addFormInput" class="btn btn-sm btn-danger">+</span>
                                            </div>

                                            <div v-for="(task, i) in createFormData.tasks"
                                                 :key="i" class="relative">
                                                <div class="d-flex">
                                                    <Custom_Text_Input
                                                        class="mb-1"
                                                        :id="'todo_task-'+i"
                                                        type="text"
                                                        placeholder="Task title"
                                                        v-model="task.title"
                                                        :error="errors.tasks && Array.isArray(errors.tasks) ? errors.tasks[0].i.title : errors.tasks"
                                                        displayErrorMsg=false
                                                        Add_Input_Class="form-control-sm"
                                                    />
                                                    <div v-if="i !== 0" @click="removeFormInput(i)" class="mb-1 btn btn-sm btn-danger absolute cursor-pointer rounded text-white font-bold">x</div>
                                                </div>

                                                <p v-if="errors.length">
                                                    {{ errors.tasks[0].title[0] }}
                                                </p>
                                            </div>
                                            <p class="text-sm text-danger" v-if="errors && errors.tasks">
                                                {{ errors.tasks && Array.isArray(errors.tasks) ? errors.tasks[0] : errors.tasks }}
                                            </p>
                                        </div>


                                        <div>
                                            <button type="button" class="btn btn-primary"
                                                    @click.stop.prevent="submitUpdateForm()"
                                                    v-if="formType==='update'">
                                                Update
                                            </button>
                                            <button type="submit" class="btn btn-success "
                                                    @click.stop.prevent="submitCreateForm()"
                                                    v-else>
                                                Add New Todo
                                            </button>
                                            <button type="button" class="btn btn-primary"
                                                    @click="closeModal(true)">
                                                Cancel
                                            </button>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</template>

<script>
// Basic Use - Covers most scenarios
import {mapActions, mapState} from "vuex";
// Advanced Use - Hook into Quill's API for Custom Functionality
//import { VueEditor, Quill } from "vue2-editor";

// #-Notes: Form Components are registered as global components in app.js file.

export default {
    name: 'TodoFormModal',
    props: {
        showTodoFormModal: {
            type: Boolean,
            default: false,
        },
        formType: {
            type: String,
            default: "create",
        },
        data: {
            type: [Object],
            default: () => [],
        },
    },
    data() {
        return {
            createFormData: {
                title: '',
                description: '',
                forToday: false,
                tasks: [
                    {
                        title: ''
                    },
                ],
            },
            errors: [],
        }
    },
    computed: {
        ...mapState({
            getErrors: state => state.todo.error
        }),
    },
    methods: {
        closeModal(clearForm = false) {
            this.$emit('closeModal', false);
            if (clearForm === true) {
                this.clearForm();
            }
        },
        addFormInput() {
            this.createFormData.tasks.push({title: ''});
        },
        removeFormInput(index) {
            this.createFormData.tasks.splice(index, 1);
        },
        ...mapActions({
            addTodo: 'todo/addTodo',
            updateTodo: 'todo/updateTodo',
            clearError: 'todo/clearError',
        }),
        clearErrors() {
            this.errors = {};
            this.clearError();
        },
        validateFormData() {
            let __this = this;
            // Todo Title validation ....
            if (__this.createFormData.title.trim() == '') {
                __this.errors.title = 'Title is required.';
            } else if (__this.createFormData.title.trim().length < 3) {
                __this.errors.title = 'Title should be at least 3 characters.';
            }

            // Task title Validation ....
            if (Object.keys(__this.createFormData.tasks).length) {
                let i = 0;
                __this.createFormData.tasks.forEach(e => {
                    if (e.title == "") i++;
                    else {
                        if (e.title.length < 3) __this.errors.tasks = "Task should be at least 'Three' characters";
                    }
                });
                /*if (Object.keys(__this.createFormData.tasks).length === i) __this.errors.tasks = 'Please add at-least one task.';
                else*/
                if (Object.keys(__this.createFormData.tasks).length - i > 5) __this.errors.tasks = 'Task must not be more then 5.';
            } /*else {
                __this.errors.tasks = 'Task is missing from this todo! Please add task.'
            }*/
        },
        async submitCreateForm() {
            let __this = this;
            __this.$Progress.start();
            __this.clearErrors();

            this.validateFormData();

            if (Object.keys(__this.errors).length) {
                __this.$Progress.fail();
                return;
            }

            await this.addTodo(__this.createFormData);

            if (__this.getErrors != null) {
                __this.errors = __this.getErrors;
                __this.$Progress.fail();
                return;
            }
            __this.$Progress.finish();
            __this.closeModal(true);
            //console.clear();
        },
        async submitUpdateForm() {
            let __this = this;
            __this.$Progress.start();
            __this.clearErrors();

            // Todo Title validation ....
            if (__this.createFormData.title.trim() == '') {
                __this.errors.title = 'Title is required.';
            } else if (__this.createFormData.title.trim().length < 3) {
                __this.errors.title = 'Title should be at least 3 characters.';
            }

            if (Object.keys(__this.errors).length) {
                __this.$Progress.fail();
                return;
            }
            __this.createFormData.id = this.data.id;

            await this.updateTodo(__this.createFormData);

            if (__this.getErrors != null) {
                __this.errors = __this.getErrors;
                __this.$Progress.fail();
                return;
            }
            __this.$Progress.finish();
            __this.closeModal(true);
            //console.clear();
        },
        clearForm() {
            this.createFormData.title = '';
            this.createFormData.description = '';
            this.createFormData.tasks = [{title: ''}];
        },
    },
    mounted() {
        if (this.formType == "update") {
            if (Object.keys(this.data).length > 0) {
                this.createFormData.title = this.data.title;
                this.createFormData.description = this.data.description == null ? "" : this.data.description;
            }
        }
    }
}
</script>

<style scoped>
.animateInFade {
    animation: animateInFade 200ms forwards cubic-bezier(0.25, 0.1, 0.25, 1.0);
}

@keyframes animateInFade {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

.startPosition {
    transform: scale(1) translateY(-100px);
}

.animateInFadeDown {
    animation: animateInFadeDown 400ms forwards cubic-bezier(0.25, 0.1, 0.25, 1.0);
}

@keyframes animateInFadeDown {
    to {
        transform: translateY(0);
    }
}

</style>
