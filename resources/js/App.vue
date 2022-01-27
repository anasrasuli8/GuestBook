<template>
<div class="custom-body">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light justify-content-center">
            <div class="navbar-nav" v-if="authenticated">
                <a class="nav-item nav-link" style="cursor: pointer;" @click="logout">LOGOUT</a>
            </div>
            <div class="navbar-nav" v-else>
                <router-link to="/" class="nav-item nav-link">Welcome</router-link>
                <router-link to="/login" class="nav-item nav-link">Login</router-link>
                <router-link to="/register" class="nav-item nav-link">Register</router-link>
            </div>
            </nav>
        <br/>
        <router-view/>
    </div>
</div>
</template>

<script>
import {mapActions} from 'vuex'

export default {
    name: "App",
    computed: {
        authenticated () {
            return this.$store.state.auth.authenticated;
        },
        user () {
            return this.$store.state.auth.user;
        }
    },
    mounted() {
        console.log(this.user);
    },
    methods: {
        ...mapActions({
            signOut:"auth/logout"
        }),
        async logout(){
            await axios.post('api/logout').then(({data})=>{
                this.signOut()
                this.$router.push({ name:"login"})
            })
        },
    },
}
</script>
<style>
.custom-body{
    background: #f4f7fb;
}
.navbar-nav a.router-link-exact-active {
    color: #42b983;
}
</style>
