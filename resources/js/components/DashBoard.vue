<template>
    <div>
        <nav-bar></nav-bar>
        <div class="container">
            <div v-if="user" class="card bg-dark text-white">
                <div class="card-header d-flex justify-content-between">
                    <div>
                        <h3 v-if="!edit">{{ user.name }}</h3>
                        <input v-else type="text" v-model="name" :class="{'is-invalid':errors.name}" class="form-control font-2" :placeholder="user.name">
                        <span v-if="errors.name" class="invalid-feedback">{{ errors.name[0] }}</span>
                        <p>{{ user.email }}</p>
                    </div>
                    <div>
                        <button v-if="edit" @click="updateProfile" class="btn btn-success">Save</button>
                        <button @click="toggleEdit" class="btn btn-primary">{{ edit?'Cancel':'Edit' }}</button>
                    </div>
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
import { mapGetters, mapActions } from "vuex";
export default {
    components: {
        Spinner,
        NavBar
    },
    data(){
        return {
            conversations: [],
            edit: false,
            name: '',
            errors: []
        }
    },
    methods:{
        ...mapActions(['fetchUser']),
        toggleEdit: function(){
            this.edit = !this.edit
            this.name = this.user.name
        },
        updateProfile: function(){
            axios.patch('/api/updateprofile', {name:this.name}).then( res => {
                this.fetchUser()
                this.edit = false
            }).catch( err => {
                this.errors = err.response.data.errors
            })
        }
    },
    computed:{
        ...mapGetters(['user'])
    },
    mounted(){
        axios.get('/api/conversations').then( res => {
            this.conversations = res.data
        }).catch( res => {

        })
    }
}
</script>
