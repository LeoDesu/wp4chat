<template>
    <div>
        <nav-bar></nav-bar>
        <div class="container">
            <div class="card bg-dark text-white">
                <div class="card-header">
                    <h4 class="text-center">Home</h4>
                </div>
                <div class="card-body">
                    <p class="text-center">Welcom to WP4Chat<br>a simple Single Page Wep Aplication for chating with your friends.</p>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import NavBar from './NavBar'
export default {
    components:{
        NavBar
    }
}
</script>