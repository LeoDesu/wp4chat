<template>
    <nav class="navbar bg-dark navbar-dark text-white mb-3">
        <div class="d-flex">
            <router-link to="/" class="btn btn-primary mr-2" exact>Home</router-link>
            <router-link to="/about" class="btn btn-primary mr-2">About</router-link>
            <router-link v-if="user" to="/dashboard" class="btn btn-primary mr-2">Dashboard</router-link>
        </div>
        <div class="d-flex">
            <router-link v-if="!user" to="/login" class="btn btn-primary mr-2">Login</router-link>
            <router-link v-if="!user" to="/register" class="btn btn-primary mr-2">Register</router-link>
            <button v-if="user" @click.prevent="logout" class="btn btn-primary mr-2">Logout</button>
        </div>
    </nav>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
export default {
    computed:{
        ...mapGetters(['user'])
    },
    methods:{
        ...mapActions(['resetUser']),
        ...mapActions(['fetchUser']),
        logout: function(){
            axios.post("/api/logout").then(() => {
                this.resetUser()
                this.$router.push({name: 'home'})
            })
        }
    },
    mounted(){
        if(!user){
            this.fetchUser();
        }
    }
}
</script>