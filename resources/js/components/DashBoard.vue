<template>
    <div>
        <nav-bar></nav-bar>
        <div class="container">
            <div v-if="user" class="card bg-dark text-white">
                <div class="card-header d-md-flex justify-content-between">
                    <div>
                        <h3 v-if="!edit">{{ user.name }}</h3>
                        <input v-else type="text" v-model="name" :class="{'is-invalid':errors.name}" class="form-control font-2" :placeholder="user.name">
                        <span v-if="errors.name" class="invalid-feedback">{{ errors.name[0] }}</span>
                        <p>{{ user.email }}</p>
                    </div>
                    <div>
                        <button v-if="edit" @click="updateProfile" class="btn btn-success">ບັນທຶກ</button>
                        <button @click="toggleEdit" class="btn btn-primary">{{ edit?'ຍົກເລີກ':'ແກ້ໄຂ' }}</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center mb-2">
                        <input type="text" v-model="search" @keyup="searchUsers" placeholder="ຄົ້ນຫາທີ່ນີ້" class="form-control col-md-6">
                    </div>
                    <div class="row justify-content-center">
                        <div v-if="search == ''" class="col-md-6">
                            <router-link v-for="conversation in conversations" :key="conversation.id"
                                :to="'/chat/'+conversation.id" class="d-block bg-primary rounded pt-2 pb-2 pl-4 pr-4 text-white mb-1 text-decoration-none">
                                {{ conversation.name }} : {{ conversation.email }}
                            </router-link>
                            <div v-if="conversations.length == 0" class="text-center">
                                ບໍ່ມີການສົນທະນາລ່າສຸດ. ຄົ້ນຫາຢູ່ຊ່ອງຂໍ້ຄວາມດ້ານເທິງເພື່ອຄົ້ນຫາໝູ່ຈາກເວັບໄຊທ໌ນີ້.
                            </div>
                        </div>
                        <div v-else class="col-md-6">
                            <router-link v-for="i in userlist" :key="i.id"
                                :to="'/chat/'+i.id" class="d-block bg-primary rounded pt-2 pb-2 pl-4 pr-4 text-white mb-1 text-decoration-none">
                                {{ i.name }} : {{ i.email }}
                            </router-link>
                            <div v-if="userlist.length == 0" class="text-center">
                                ບໍ່ມີຜົນການຄົ້ນຫາສໍາລັບ "{{search}}"
                            </div>
                        </div>
                    </div>
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
            userlist: [],
            search: '',
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
        },
        searchUsers: function(){
            this.userlist = []
            if(this.search != '')axios.get("/api/search/"+this.search).then( res => {
                this.userlist = (res.data).filter((i) => i.id != this.user.id)
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
