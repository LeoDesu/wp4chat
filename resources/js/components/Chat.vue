<template>
    <div>
        <nav-bar></nav-bar>
        <div class="container">
            <div v-if="receiver" class="card bg-dark text-white">
                <div class="card-header">
                    <h3>{{ receiver.name }}</h3>
                </div>
                <div class="card-body">
                    <div class="row d-flex mb-1" v-for="message in messages" :key="message.id" :class="{'flex-row-reverse': message.sender_id == user.id}">
                        <p class="rounded pt-1 pb-1 pl-3 pr-3 m-0"
                            :class="{'bg-primary': message.sender_id == user.id, 'border border-primary': message.sender_id != user.id}">
                            {{ message.content }}
                        </p>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row d-flex">
                        <input class="form-control w-auto flex-1" type="text" placeholder="Type here" v-model="text" @keydown.enter="sendMessage">
                        <input class="btn btn-primary" type="button" value="Send" @click="sendMessage">
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
                this.messages = res.data.reverse()
            })
        },
        sendMessage: function(){
            axios.post('/api/send', {receiver_id : this.receiver.id, content : this.text}).then( res => {
                this.text = ''
            }).catch( res => {
                this.text = ''
            })
        }
    },
    mounted(){
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
        Pusher.logToConsole = true;

        var pusher = new Pusher('125154b4f220c1830a26', {
            cluster: 'ap1'
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('send-message', function(data) {
            console.log(JSON.stringify(data));
            alert(JSON.stringify(data));
        });
    }
}
</script>
