<template>
    
    <!-- Main Sidebar Container -->
    <aside style="position:fixed" class="main-sidebar sidebar-dark-primary elevation-4">
        
        <!-- Brand Logo -->
        <a href="#" class="brand-link">
          <span class="brand-text font-weight-light ps-2">GoodNews</span>
        </a>
    
        <!-- Sidebar -->
        <div class="sidebar">
         <!-- Sidebar Menu -->
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <!-- Add icons to the links using the .nav-icon class
                   with font-awesome or any other icon font library -->
    
              <li class="nav-item">
                <routerLink to="/admin" class="nav-link">
                  <i class="nav-icon fa-solid fa-home"></i>
                  <p>
                    Главная
                  </p>
                </routerLink>
              </li>
              <li class="nav-item">
                <routerLink to="/adminCreateArticle" class="nav-link">
                  <i class="nav-icon fa-solid fa-pen-to-square"></i>
                  <p>
                    Создать статью
                  </p>
                </routerLink>
              </li>
              <li class="nav-item">
                <routerLink to="/" class="nav-link">
                  <i class="nav-icon fa-solid fa-person-walking-arrow-right"></i>
                  <p>
                    На сайт
                  </p>
                </routerLink>
              </li>
    
            </ul>
          </nav>
          <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
      </aside>
      
    </template>
    
    <script>
    export default{
        name:'side-bar'
    }
    </script>
    
    <style>
    
    </style>