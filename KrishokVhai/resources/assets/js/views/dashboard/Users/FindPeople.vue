<template>
    <div class="content-body position-relative">

        <div class="position-absolute overflow-loader d-flex justify-content-center" v-if="processing">
            <div class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="margin-top: 100px;"/>
        </div>

        <section class="row">
            <div class="col-sm-12">

                <div id="what-is" class="card">
                    <div class="card-header">
                        <h4 class="card-title">Find people</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                        <!--<div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                                </ul>
                            </div>-->
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            <div class="card-text">

                                <div class="users-list-filter px-1">
                                    <form v-on:submit.prevent="search()">
                                        <div class="row border rounded py-2 mb-2 bt-2">
                                            <h5 class="col-12">Search Options</h5>
                                            <div class="col-12 col-sm-6 col-lg-6">
                                                <label for="nameField">Name, Email or Mobile number</label>
                                                <fieldset class="form-group">
                                                    <input type="text" v-model="filters.searchQuery"
                                                           name="name" id="nameField" class="form-control" placeholder="name, email or mobile number ..." maxlength="120">
                                                </fieldset>
                                            </div>

                                            <div class="col-12 col-sm-6 col-lg-2">
                                                <label for="userRoleList">Role</label>
                                                <fieldset class="form-group">
                                                    <select name="role" v-model="filters.searchRole" id="userRoleList" class="form-control">
                                                        <option value="" selected>All</option>
                                                        <option :value="role.name" v-if="roles.length" v-for="(role, index) in roles" :key="role.name">
                                                            {{ role.name | ucWords }}
                                                        </option>
                                                    </select>
                                                </fieldset>
                                            </div>
                                            <!--                                            <div class="col-12 col-sm-6 col-lg-2">
                                                                                            <label for="userStatus">Status</label>
                                                                                            <fieldset class="form-group">
                                                                                                <select v-model="searchStatus" name="userStatus" id="userStatus" class="form-control">
                                                                                                    <option value="" selected>All</option>
                                                                                                    <option value="active">Active</option>
                                                                                                    <option value="pending">Pending</option>
                                                                                                    <option value="blocked">Blocked</option>
                                                                                                    <option value="not_verified">Not verified</option>
                                                                                                </select>
                                                                                            </fieldset>
                                                                                        </div>-->
                                            <div class="col-12 col-sm-6 col-lg-2 d-flex align-items-center">
                                                <button type="reset" class="btn btn-primary btn-block glow mb-0" @click.stop.prevent="clearForm()">Clear</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <loading v-if="processing" msg="Loading users ..."/>

                                <div class="text-center alert alert-warning" v-if="showingDeletedUsers && allUser.length">
                                    Showing removed users.
                                </div>
                                <div class="text-center alert alert-danger" v-if="errors.lenght">
                                    {{ errors }}
                                </div>

                                <div class="table-responsive" style="max-width: 100% !important; width: 100% !important;">


                                    <table class="table" style="width: 100% !important; font-size: 12px!important;" v-if="allUser.length">
                                        <thead class="bg-primary white">
                                        <tr>
                                            <th style="max-width: 10px !important;">#</th>
                                            <th>Name</th>
                                            <th>Username</th>
                                            <th style="max-width: 60px !important;">Email</th>
                                            <th>Role</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(user, us) in allUser" :key="user.id">
                                            <th scope="row">
                                                <img :src="user.avatar" alt="" class="rounded" style="width: 40px; height: 40px; border-radius: 100%; object-position: center center; object-fit: cover;">
                                            </th>
                                            <td>
                                                {{ user.first_name + ' ' + user.last_name }}
                                            </td>
                                            <td>{{ user.username }}</td>
                                            <td>{{ user.email }}</td>
                                            <td>
                                                <div v-for="role in user.roles">
                                                    {{ role }},
                                                </div>
                                            </td>

                                            <td>
                                                <div class="btn-group">
                                                    <router-link :to="{name: 'View Profile', params:{id:user.id}}" class="btn btn-sm btn-primary" title="View profile">
                                                        <i class="fas fa-eye"></i>
                                                    </router-link>
                                                    <router-link :to="{name: 'Chat-Conversation', params:{to_id:user.id}}" class="btn btn-sm btn-success" title="Send message"
                                                                 v-if="loggedInUser.status === 'active'">
                                                        <i class="fas fa-comment"></i>
                                                    </router-link>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div v-else>
                                        <div v-if="!processing" class="alert alert-info text-center">
                                            No user found in trash.
                                        </div>
                                    </div>


                                    <div v-if="allUser.length > 0" class="paginationLink row">
                                        <div class="col-12 col-md-6 my-2">
                                            Showing (
                                            <!--<span class="text-warning text-bold-600">{{ pagination.per_page * pagination.current_page }}</span>-->
                                            <span class="text-warning text-bold-600">{{ pagination.from }} -  {{ pagination.to }}</span> ) from
                                            <span class="text-warning text-bold-600">{{ pagination.total }}</span> users
                                        </div>

                                        <div class="col-12 col-md-6" style="margin-top: 10px;">
                                            <pagination
                                                v-if="pagination.last_page > 1"
                                                :pagination="pagination"
                                                :offset="5"
                                                @paginate="handleChange($event)"
                                                class="">
                                            </pagination>

                                            <div class="text-right">
                                                Current <span class="text-warning">page: {{ pagination.current_page }}</span>,
                                                Total <span class="text-warning">page: {{ pagination.last_page }}</span>
                                            </div>
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
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import Pagination from "../../../components/pagination";

export default {
    name: "FindPeople",
    components: {Pagination},
    data() {
        return {
            allUser: [],
            showingDeletedUsers: false,
            processing: false,
            errors: [],
            pagination: {
                current_page: 1
            },
            roles: [],
            filters: {
                searchQuery: "", // Search query from text box
                searchRole: "",
                searchStatus: "",
            }
        }
    },
    mounted() {
        this.getUser();
        this.loadRoles();
    },
    watch: {
        filters: {
            handler: _.debounce(function () {
                this.pagination.current_page = 1;
                this.getUser(this.pagination.current_page, false);
            }, 500), deep: true
        },
    },
    computed:{
        ...mapGetters({
            loggedInUser: 'auth/user',
        })
    },
    methods: {
        clearForm() {
            this.errors = '';
            /*this.searchQuery = '';
            this.searchRole = '';*/
            this.filters = {
                searchQuery: "", // Search query from text box
                searchRole: "",
                searchStatus: "",
            }
        },
        handleChange(page) {
            this.pagination.current_page = page;
            this.getUser(page, false);
        },
        async getUser(page = this.pagination.current_page, processing = true) {
            this.processing = processing;
            this.showingDeletedUsers = false;
            await axios.get(`api/search/people?page=${page}`, {
                params: this.filters,
            }).then(response => {
                this.allUser = response.data.data;
                this.pagination = response.data.meta;
            }).catch(errors => this.errors = errors)
                .finally(() => this.processing = false);
        },
        async loadRoles() {
            await axios.get('api/roles')
                .then(response => this.roles = response.data.data)
                .catch(errors => this.errors = errors.response.data.message);
        },
    }
}
</script>

<style scoped lang="css">
.overflow-loader {
    position: absolute !important;
    top: 0;
    left: 0;
    padding: 0;
    bottom: 0;
    z-index: 100000;
    background: rgba(20, 20, 20, .4);
    height: 100%;
    width: 100%;
    text-align: center;
    color: white;
}
</style>
