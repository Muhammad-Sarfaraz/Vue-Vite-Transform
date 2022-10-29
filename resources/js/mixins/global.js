export default {
    computed: {
        asset() {
            return `${laravel.baseurl}/public/images/`;
        },
        site() {
            return this.$store.state.global.site
        },
        global() {
            return this.$store.state.global.global
        },
        menus() {
            return this.$store.state.global.menus
        },
        permissions() {
            return this.$store.state.global.permissions
        },
        loggedIn() {
            return this.$store.state.auth.user ? true : false;
        },
        user() {
            return this.$store.state.auth.user
        },
        role_name() {
            return this.$store.state.auth.role
        },
        breadcrumbs() {
            return this.$store.state.breadcrumb.levels
        },
        noimage() {
            return `${laravel.baseurl}/images/noimage.png`;
        },
        attach() {
            return `${laravel.baseurl}/images/attach.png`;
        },
    },
}