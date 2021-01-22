<template>
    <div>
        <nav-bar></nav-bar>
        <div class="container">
            <div v-if="user" class="card bg-dark text-white">
                <div class="card-header">
                    <h3>{{ user.name }}</h3>
                    <p>{{ user.email }}</p>
                </div>
                <div class="card-body">
                    <router-link v-for="conversation in conversations" :key="conversation.id" :to="'/chat/'+conversation.id">
                        <div class="col-md-6 bg-primary rounded pt-2 pb-2 pl-4 pr-4 text-white mb-1">
                            {{ conversation.name }}
                        </div>
                    </router-link>
                </div>
            </div>
            <div v-else class="card bg-dark">
                <div class="card-body d-flex justify-content-center">
                    <spinner/>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Spinner from 'vue-loading-spinner/src/components/Circle2';
import NavBar from './NavBar.vue';
import { mapGetters } from "vuex";
export default {
    components: {
        Spinner,
        NavBar
    },
    data(){
        return {
            conversations: []
        }
    },
    computed:{
        ...mapGetters(['user'])
    },
    mounted(){
        axios.get('/api/conversations').then( res => {
            this.conversations = res.data
        }).catch( res => {
            console.log("can not retreive conversations.")
        })
    }
}
</script>
