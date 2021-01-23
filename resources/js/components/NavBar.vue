<template>
    <nav class="navbar bg-dark navbar-dark text-white mb-3 pt-1 pb-1">
        <div class="d-md-flex" :class="{'d-none':switchMenu}">
            <router-link v-if="user" to="/dashboard" class="btn btn-primary mr-1">ຫນ້າຫຼັກ</router-link>
            <router-link to="/about" class="btn btn-primary">ກ່ຽວກັບເວັບໄຊທ໌ນີ້</router-link>
        </div>
        <div class="d-none d-md-flex" :class="{'d-flex':switchMenu}">
            <router-link v-if="!user" to="/login" class="btn btn-primary mr-1">ເຂົ້າສູ່ລະບົບ</router-link>
            <router-link v-if="!user" to="/register" class="btn btn-primary">ລົງທະບຽນ</router-link>
            <button v-if="user" @click.prevent="logout" class="btn btn-primary">ອອກຈາກລະບົບ</button>
        </div>
        <div class="d-flex d-md-none">
            <img class="w-5em" :class="{'rotate-180': switchMenu}"  @click.prevent="toggleMenu" src="/storage/img/down-arrow.svg"/>

        </div>
    </nav>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
export default {
    data(){
        return{
            switchMenu: false
        }
    },
    computed:{
        ...mapGetters(['user'])
    },
    methods:{
        ...mapActions(['resetUser']),
        ...mapActions(['fetchUser']),
        logout: function(){
            axios.post("/api/logout").then(() => {
                this.resetUser()
                this.$router.push({name: 'login'})
            })
        },
        toggleMenu: function(){
            this.switchMenu = !this.switchMenu
        }
    },
    mounted(){
        if(!user){
            this.fetchUser();
        }
    }
}
</script>
