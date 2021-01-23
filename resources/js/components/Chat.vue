<template>
    <div>
        <nav-bar></nav-bar>
        <div class="container">
            <div v-if="receiver" class="card bg-dark text-white">
                <div class="card-header">
                    <div class="row">
                        <div class="ml-2">
                            <h3 class="m-0">{{ receiver.name }}</h3>
                            <p class="m-0">{{ receiver.email }}</p>
                        </div>
                    </div>
                    <div class="row d-flex">
                        <input class="form-control w-auto flex-1" type="text" placeholder="ພິມຂໍ້ຄວາມທີ່ນີ້" v-model="text" @keydown.enter="sendMessage" autofocus>
                        <input class="btn btn-primary" type="button" value="ສົ່ງ" @click="sendMessage">
                    </div>
                </div>
                <div class="card-body">
                    <div class="row d-flex align-items-center mb-1" v-for="message in messages" :key="message.id" :class="{'flex-row-reverse': message.sender_id == user.id}">
                        <div>
                            <p class="rounded pt-1 pb-1 pl-3 pr-3 m-0" @click="toggleOptions(message.id)"
                                :class="{'bg-primary': message.sender_id == user.id, 'border border-primary': message.sender_id != user.id}">
                                {{ message.content }}
                            </p>
                            <small>
                                <p class="m-0 text-secondary" :class="{'text-right':message.sender_id == user.id}">
                                    {{ new Date(message.created_at).getFullYear() }}/{{ new Date(message.created_at).getMonth()+1 }}/{{ new Date(message.created_at).getDate() }}
                                    {{ new Date(message.created_at).getHours() }}:{{ new Date(message.created_at).getMinutes() }}
                                </p>
                            </small>
                        </div>
                        <svg :id="'delete-message-'+message.id" v-if="message.sender_id == user.id" @click="deleteMessage(message.id)"
                            class="mb-3 mr-1 cursor-pointer d-none" enable-background="new 0 0 512.001 512.001" height="1em" width="1em" viewBox="0 0 512.001 512.001">
                            <g>
                                <path d="m512.001 84.853-84.853-84.853-171.147 171.147-69.853 84.853 69.853 84.854 171.147 171.147 84.853-84.853-171.148-171.148z" fill="#cc3245"/>
                                <path d="m84.853 0-84.853 84.853 171.148 171.147-171.148 171.148 84.853 84.853 171.148-171.147v-169.707z" fill="#ff3e3a"/>
                            </g>
                        </svg>
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
import swal from 'sweetalert';
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
        toggleOptions: function(id){
            $('#delete-message-'+id).toggleClass('d-none')
        },
        deleteMessage: function(id){
            swal({
                icon: "warning",
                text: "ທ່ານແນ່ໃຈບໍວ່າຕ້ອງການລົບຂໍ້ຄວາມນີ້?",
                buttons:['nah', 'yes'],
                dangerMode: true,
                className:'swal-custom'
            }).then( res => {
                if(res) axios.post('/api/delete', {id})
            })
        },
        verifyThisPage: function(){
            axios.get('/api/getuser/'+this.$route.params.id).then( res => {
                this.receiver = res.data
                if(this.user.id == this.receiver.id){
                    this.$router.push({ name:"dashboard" })
                }
                this.fetchMessages()
            }).catch( () => {
                this.$router.push({ name:"notfound"})
            })
        }
    },
    mounted(){
        this.verifyThisPage()
        window.Echo.channel('my-channel')
            .listen('.send-message', (e) => {
                if(e.message.receiver_id == this.user.id || e.message.sender_id == this.user.id)
                    this.messages.unshift(e.message)
            })
            .listen('.delete-message', (e) => {
                this.messages = this.messages.filter( i => (i.id != e.message.id))
            })
    }
}
</script>
