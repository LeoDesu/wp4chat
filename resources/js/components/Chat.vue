<template>
    <div>
        <nav-bar></nav-bar>
        <div class="container">
            <div v-if="receiver" class="card bg-dark text-white">
                <div class="card-header">
                    <div class="row"><h3>{{ receiver.name }}</h3></div>
                    <div class="row d-flex">
                        <input class="form-control w-auto flex-1" type="text" placeholder="Type here" v-model="text" @keydown.enter="sendMessage">
                        <input class="btn btn-primary" type="button" value="Send" @click="sendMessage">
                    </div>
                </div>
                <div class="card-body">
                    <div class="row d-flex mb-1" v-for="message in messages" :key="message.id" :class="{'flex-row-reverse': message.sender_id == user.id}">
                        <p class="rounded pt-1 pb-1 pl-3 pr-3 m-0"
                            :class="{'bg-primary': message.sender_id == user.id, 'border border-primary': message.sender_id != user.id}">
                            {{ message.content }}
                        </p>
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
import { mapGetters } from "vuex";
export default {
    components: {
        Spinner,
        NavBar
    },
    data(){
        return {
            text: '',
            messages: [],
            receiver: null
        }
    },
    computed:{
        ...mapGetters(['user'])
    },
    methods:{
        fetchMessages: function(){
            axios.get('/api/messages/'+this.receiver.id+'/20').then( res => {
                this.messages = res.data
            })
        },
        sendMessage: function(){
            axios.post('/api/send', {receiver_id : this.receiver.id, content : this.text}).then( res => {
                this.text = ''
            }).catch( res => {
                this.text = ''
            })
        },
        verifyThisPage: function(){
            axios.get('/api/getuser/'+this.$route.params.id).then( res => {
                this.receiver = res.data
                if(this.user.id == this.receiver.id){
                    console.log("trigger redirect to dashboard")
                    this.$router.push({ name:"dashboard" })
                }
                this.fetchMessages()
            }).catch( () => {
                console.log("not found")
                this.$router.push({ name:"notfound"})
            })
        }
    },
    mounted(){
        this.verifyThisPage()
        window.Echo.channel('my-channel')
            .listen('.send-message', (e) => {
                console.log(e.message)
                alert(e.message)
                this.messages.unshift(e.message)
            })
    }
}
</script>
