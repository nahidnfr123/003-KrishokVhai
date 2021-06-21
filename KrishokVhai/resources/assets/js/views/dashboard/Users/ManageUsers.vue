<template>
    <div class="content-body position-relative">

        <div class="position-absolute overflow-loader d-flex justify-content-center" v-if="processing">
            <div class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="margin-top: 100px;"/>
        </div>

        <section class="row">
            <div class="col-sm-12">

                <div id="what-is" class="card">
                    <div class="card-header">
                        <h4 class="card-title">Manage Users</h4>
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
                                                    <input type="text" v-model="searchQuery"
                                                           name="name" id="nameField" class="form-control" placeholder="name, email or mobile number ..." maxlength="120">
                                                </fieldset>
                                            </div>

                                            <div class="col-12 col-sm-6 col-lg-2">
                                                <label for="userRoleList">Role</label>
                                                <fieldset class="form-group">
                                                    <select name="role" v-model="searchRole" id="userRoleList" class="form-control">
                                                        <option value="" selected>All</option>
                                                        <option :value="role.name" v-if="roles.length" v-for="(role, index) in roles" :key="role.name">
                                                            {{ role.name | ucWords }}
                                                        </option>
                                                    </select>
                                                </fieldset>
                                            </div>
                                            <div class="col-12 col-sm-6 col-lg-2">
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
                                            </div>
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

                                    <button class="btn btn-danger btn-glow mb-2"
                                            @click.stop.prevent="getDeletedUsers()"
                                            v-if="!showingDeletedUsers">
                                        <i class="fas fa-trash"></i>
                                        Show removed user
                                    </button>
                                    <button class="btn btn-success btn-glow mb-2"
                                            @click.stop.prevent="getAllUser()"
                                            v-else>
                                        <i class="fas fa-arrow-left"></i>
                                        Show all users
                                    </button>

                                    <table class="table" style="width: 100% !important; font-size: 12px!important;" v-if="allUser.length">
                                        <thead class="bg-primary white">
                                        <tr>
                                            <th style="max-width: 10px !important;">#</th>
                                            <th>Name</th>
                                            <th>Username</th>
                                            <th style="max-width: 60px !important;">Email</th>
                                            <th>Mobile</th>
                                            <th>Status</th>
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
                                            <td>{{ user.mobile_number }}</td>
                                            <td>
                                                <div class="text-center" :class="[user.status == 'blocked'? 'bg-danger' : user.status == 'pending'?'bg-warning':'bg-success']">
                                                    <strong>{{ user.status }}</strong>
                                                </div>
                                            </td>
                                            <td>
                                                <div v-for="role in user.roles">
                                                    {{ role }},
                                                </div>
                                            </td>

                                            <td>
                                                <div class="dropdown text-dark">
                                                    <button class="btn btn-sm btn-glow btn-bg-gradient-x-orange-yellow col-12 col-md-5 mr-1 mb-1 dropdown-toggle"
                                                            type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <router-link :to="{name: 'View Profile', params:{id:user.id}}" class="dropdown-item">
                                                            <i class="fas fa-eye"></i> View profile
                                                        </router-link>
                                                        <a class="dropdown-item" href="#" @click.stop.prevent="changeStatus(user.id)" v-if="user.status != 'active'">
                                                            <template v-if="working"><div class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="margin-top: 1px;"/></template>
                                                             <i class="fas fa-user-check"></i> Active
                                                        </a>
                                                        <a class="dropdown-item" href="#" @click.stop.prevent="changeStatus(user.id)" v-if="user.status == 'active'">
                                                            <template v-if="working"><div class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="margin-top: 1px;"/></template>
                                                            <i class="fas fa-user-times"></i> Block
                                                        </a>
                                                        <template v-if="loggedInUser.status === 'active'">
                                                            <router-link :to="{name: 'Chat-Conversation', params:{to_id:user.id}}" class="dropdown-item">
                                                                <i class="fas fa-comment"></i> Send message
                                                            </router-link>
                                                            <a class="dropdown-item" href="#" @click.stop.prevent="restoreAccount(user.id)" v-if="user.deleted_at">
                                                                <i class="fas fa-trash-restore"></i> Restore
                                                            </a>
                                                            <a class="dropdown-item" href="#" @click.stop.prevent="deleteAccount(user.id)" v-if="!user.deleted_at">
                                                                <i class="fas fa-trash"></i> Delete
                                                            </a>
                                                            <a class="dropdown-item" href="#" @click.stop.prevent="deleteAccount(user.id, 'destroy')" v-else>
                                                                <i class="fas fa-trash"></i> Destroy
                                                            </a>
                                                        </template>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div v-else>
                                        <div v-if="!processing" class="alert alert-info text-center">
                                            No user found.
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
                                                @paginate="searchQuery !== '' || searchRole !== '' || searchStatus !== '' ? search() :showingDeletedUsers == true ? getDeletedUsers() : getAllUser()"
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
    name: "ManageUsers",
    components: {Pagination},
    data() {
        return {
            allUser: [],
            working: false,
            showingDeletedUsers: false,
            processing: false,
            errors: [],
            pagination: {
                current_page: 1
            },
            searchQuery: "", // Search query from text box
            searchRole: "",
            searchStatus: "",
            roles: [],
        }
    },
    mounted() {
        this.getAllUser();
        this.loadRoles();
    },
    watch: {
        searchQuery: _.debounce(function (newQuery) {
            this.pagination.current_page = 1;
            newQuery == '' && this.searchRole == '' && this.searchStatus == '' && this.showingDeletedUsers == false ?
                this.getAllUser() : this.search();
        }, 800),
        searchRole(role) {
            this.pagination.current_page = 1;
            role == '' && this.searchQuery == '' && this.searchStatus == '' && this.showingDeletedUsers == false ?
                this.getAllUser() : this.search();
        },
        searchStatus(status) {
            this.pagination.current_page = 1;
            status == '' && this.searchRole == '' && this.searchQuery == '' && this.showingDeletedUsers == false ?
                this.getAllUser() : this.search();
        },
    },
    computed: {
        ...mapGetters({
            loggedInUser: 'auth/user',
        })
    },
    methods: {
        clearForm() {
            this.errors = '';
            this.searchQuery = '';
            this.searchRole = '';
        },
        async search() {
            this.processing = true;
            axios.get("api/search/users?query=" +
                this.searchQuery + '&role_name=' +
                this.searchRole + "&status=" +
                this.searchStatus + "&trashed=" +
                this.showingDeletedUsers + "&page=" +
                this.pagination.current_page)
                .then(response => {
                    this.allUser = response.data.data;
                    this.pagination = response.data.meta;
                })
                .catch(errors => this.errors = errors)
                .finally(() => this.processing = false);
        },
        async getAllUser() {
            this.processing = true;
            this.showingDeletedUsers = false;
            let $this = this;
            //let baseUrl = this.url.split('page=')[0];
            axios.get(`api/all-users/?page=${this.pagination.current_page}`)
                .then(response => {
                    $this.allUser = response.data.data;
                    $this.pagination = response.data.meta;
                    $this.errors = [];
                })
                .catch(errors => $this.errors = errors.response.data.message)
                .finally(() => $this.processing = false);
        },
        async getDeletedUsers() {
            this.processing = true;
            this.showingDeletedUsers = false;
            let $this = this;
            axios.get(`api/all-users/deleted/?page=${this.pagination.current_page}`)
                .then(response => {
                    $this.allUser = response.data.data;
                    $this.pagination = response.data.meta;
                    $this.errors = [];
                    $this.showingDeletedUsers = true;
                })
                .catch(errors => $this.errors = errors.response.data.message)
                .finally(() => $this.processing = false);
        },
        deleteAccount(user_id, queryType = 'delete') {
            let url = '';
            let text = '';
            if (queryType == 'destroy') {
                url = "api/user/destroy/";
                text = "You won't be able to revert this!";
            } else {
                url = "api/user/delete/";
            }

            this.$swal.fire({
                title: 'Are you sure you want to delete the user?',
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    await axios.delete(`${url + user_id}`)
                        .then((response) => {
                            if (response) {
                                this.allUser = this.allUser.filter(obj => {
                                    return obj.id != user_id;
                                });
                                this.$swal.fire(
                                    'Deleted!',
                                    'User has been deleted.',
                                    'success'
                                )
                            }
                        })
                        .catch(errors => {
                            console.log(errors)
                        });
                }
            });
        },
        restoreAccount(user_id) {
            this.$swal.fire({
                title: 'Are you sure you want to restore the user',
                //text: "You won't be able to revert this!",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#65fa61',
                confirmButtonText: 'Yes, restore it!'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    await axios.put(`api/all-users/restore/${user_id}`)
                        .then((response) => {
                            if (response) {
                                this.allUser = this.allUser.filter(obj => {
                                    return obj.id != user_id;
                                });
                                this.$swal.fire(
                                    'Restored!',
                                    'User account is restored.',
                                    'success'
                                )
                            }
                        })
                        .catch(errors => {
                            console.log(errors)
                        });
                }
            });
        },
        async loadRoles() {
            await axios.get('api/roles')
                .then(response => this.roles = response.data.data)
                .catch(errors => this.errors = errors.response.data.message);
        },
        async changeStatus(userId) {
            this.working = true;
            let formData = new FormData();
            formData.append('_method', 'PUT')
            await axios.post(`api/user/${userId}/status/update`, formData)
                .then(response => {
                    if (response.data.data && response.data.data) {
                        this.$store.dispatch('snackbar/addSnack', {color: 'success', msg: 'User status updated.', snakbarType: 'Success'}, {root: true});
                        this.getAllUser();
                    }
                })
                .catch(errors => this.errors = errors.response.data.message)
                .finally(() => {
                    this.working = false;
                });
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
