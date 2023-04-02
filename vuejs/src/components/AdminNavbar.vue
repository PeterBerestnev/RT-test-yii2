<template>
    <nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <router-link to="/login">
        <i  class="fa-solid fa-arrow-right-from-bracket me-3 zoom"></i>
      </router-link>
    </ul>
</nav>
    <!-- <div class="w-100 bg-dark d-flex p-2 fs-4">
        <RouterLink class="text-decoration-none" to="/login">Login</RouterLink>
    </div> -->
</template>
    
<script>
export default {
    name: 'admin-navbar'
}
</script>
    
<style>
.zoom {
    color: white;
    opacity: 0.8
}

.zoom:hover {
    scale: 1.2;
    opacity: 1
}
</style>