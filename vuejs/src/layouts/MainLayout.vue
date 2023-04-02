<template>
    <UserNavbar></UserNavbar>
    <router-view></router-view>
</template>

<script>
import UserNavbar from '../components/UserNavbar.vue'
export default{
    name: "main-layout",
    components:{
        UserNavbar
    }
}
</script>

<style>

</style>