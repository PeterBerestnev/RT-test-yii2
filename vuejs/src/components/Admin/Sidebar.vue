<template>
  <aside style="position:fixed" class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
      <span class="brand-text font-weight-light ps-2">GoodNews</span>
    </a>
    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <routerLink to="/admin" class="nav-link">
              <i class="nav-icon fa-solid fa-home"></i>
              <p>
                Главная
              </p>
            </routerLink>
          </li>
          <li class="nav-item">
            <routerLink to="/adminPopular" class="nav-link">
              <i class="nav-icon fa-solid fa-fire"></i>
              <p>
                Популярное
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
            <routerLink to="/adminSettings" class="nav-link">
              <i class="nav-icon fa-solid fa-gear"></i>
              <p>
                Настройки
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
    </div>
  </aside>
</template>
    
<script>
export default {
  name: 'side-bar'
}
</script>
