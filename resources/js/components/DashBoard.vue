<template>
    <div>
        <nav-bar></nav-bar>
        <div class="container">
            <div v-if="user" class="card bg-dark text-white">
                <div class="card-header">
                    <h3>{{ user.name }}</h3>
                </div>
                <div class="card-body">
                    <p>{{ user.email }}</p>
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
    computed:{
        ...mapGetters(['user'])
    }
}
</script>