<template>
    
    <!-- Main Sidebar Container -->
    <aside style="position:fixed" class="main-sidebar sidebar-dark-primary elevation-4">
        
        <!-- Brand Logo -->
        <a href="#" class="brand-link">
          <span class="brand-text font-weight-light ps-2">GoodNews</span>
        </a>
    
        <!-- Sidebar -->
        <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
              <a href="#" class="d-block">Петр Берестнев</a>
            </div>
          </div>
    
    
    
          <!-- Sidebar Menu -->
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <!-- Add icons to the links using the .nav-icon class
                   with font-awesome or any other icon font library -->
    
              <li class="nav-item">
                <routerLink to="/" class="nav-link">
                  <i class="nav-icon fa-solid fa-home"></i>
                  <p>
                    Главная
                  </p>
                </routerLink>
              </li>
              <li class="nav-item">
                <routerLink to="/notes" class="nav-link">
                  <i class="nav-icon fa-solid fa-note-sticky"></i>
                  <p>
                    Записи
                    <span class="badge badge-info right">2</span>
                  </p>
                </routerLink>
              </li>
              <li class="nav-item">
                <routerLink to="/entities" class="nav-link">
                  <i class="nav-icon fa-solid fa-cube"></i>
                  <p>
                    Сущности
                  </p>
                </routerLink>
              </li>
              <li class="nav-item">
                <routerLink to="/attributes" class="nav-link">
                  <i class="nav-icon fas fa-cubes"></i>
                  <p>
                    Атрибуты
                  </p>
                </routerLink>
              </li>
              <li class="nav-item">
                <routerLink to="/" class="nav-link">
                  <i class="nav-icon fas fa-search"></i>
                  <p>
                    Поиск
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