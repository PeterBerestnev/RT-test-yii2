import authService from '@/services/auth.service';
import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    name: 'home',
    meta: {layout:'main'},
    component: () => import('../views/user/HomeView.vue')
  },
  {
    path: '/article',
    name: 'article-main',
    meta: {layout: 'main'},
    props: (route) => ({ id: route.query.id }),
    component: () => import('../views/user/ArticleMain.vue')
  },
  {
    path: '/admin',
    name: 'admin-panel-main',
    meta: {layout:'admin'},
    component: () => import('../views/admin/AdminPanelMain.vue')
  },
  {
    path: '/login',
    name: 'login',
    meta: {layout:'auth'},
    component: () => import('../views/Login.vue')
  },
  {
    path: '/adminCreateArticle',
    name: 'admin-create-article',
    meta: {layout:'admin'},
    component: () => import('../views/admin/AdminCreateArticle.vue')
  },
  {
    path: "/:pathMatch(.*)*",
    name: "not-found",
    meta: {layout: 'auth'},
    component: ()=> import('../views/NotFound.vue'),
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

router.beforeEach((to, from, next) => {
  if (to.name === 'admin-panel-main' && !authService.isLoggedIn()) {
    next({name: 'login'})
  } else if (authService.isLoggedIn() && to.name == 'login'){
    next({name: 'admin-panel-main'})
  } else {
    next();
  }
});

export default router
