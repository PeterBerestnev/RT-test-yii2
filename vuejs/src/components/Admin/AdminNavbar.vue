<template>
    <nav class="main-header navbar navbar-expand navbar-dark ">
    <!-- Left navbar links -->
    
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <router-link @click="logout" to="/login">
        <i  class="fa-solid fa-arrow-right-from-bracket me-3 zoom"></i>
        
      </router-link>
    </ul>
</nav>
</template>
    
<script>
import authService from '@/services/auth.service';

export default {
    name: 'admin-navbar',
    methods:{
      logout(){
        authService.logout()
      }
    }
}
</script>
    
<style>
.zoom {
    color: white;
    opacity: 0.8
}

.zoom:hover {
    scale: 1.02;
    opacity: 1
}
</style>