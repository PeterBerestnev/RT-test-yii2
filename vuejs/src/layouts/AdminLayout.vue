<template>
    <Sidebar></Sidebar>
    <AdminNavbar></AdminNavbar>
    <div class="content-wrapper">
        <router-view></router-view>
    </div>  
</template>

<script>
import Sidebar from '../components/Sidebar.vue'
import AdminNavbar from '../components/AdminNavbar.vue'

    export default{
        name: 'admin-layout',
        components:{
            AdminNavbar,
            Sidebar
        }
    }
</script>