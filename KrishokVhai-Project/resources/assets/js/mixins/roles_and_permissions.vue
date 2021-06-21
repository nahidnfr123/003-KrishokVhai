<script>
import {mapActions, mapGetters} from "vuex";


export default {
    computed: {
        ...mapGetters({
            authenticateds: 'auth/authenticated',
            userss: 'auth/user',
            UserRoles: 'auth/roles',
        }),
    },
    methods: {
        $can(permissionName) {
            return this.UserPermissions.indexOf(permissionName) !== -1;
        },
        $is(roleName) {
            console.log(this.userss, this.UserRoles, roleName);
            //return this.Roles.indexOf(roleName) !== -1;
        },
    },
};
</script>
