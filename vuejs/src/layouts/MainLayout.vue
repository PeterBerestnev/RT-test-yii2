<template>
    <UserNavbar></UserNavbar>
    <div class="mt-6">
        <router-view></router-view>
    </div>
    
</template>

<script>
import UserNavbar from '../components/User/UserNavbar.vue'
export default{
    name: "main-layout",
    components:{
        UserNavbar
    },
}
</script>

<style>
.mt-6{
    margin-top: 5rem !important;
}
</style>