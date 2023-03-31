<template>
    <Sidebar></Sidebar>
    <MyNavbar></MyNavbar>
    <div class="content-wrapper">
        <router-view></router-view>
    </div>
    
</template>

<script>
import Sidebar from '../components/Sidebar.vue'
import MyNavbar from '../components/MyNavbar.vue'

    export default{
        name: 'MainLayout',
        components:{
            MyNavbar,
            Sidebar
        }
    }
</script>