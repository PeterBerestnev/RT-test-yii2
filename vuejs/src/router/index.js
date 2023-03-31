import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    name: 'home',
    meta: {layout:'main'},
    component: () => import('../views/HomeView.vue')
  },
  {
    path: '/login',
    name: 'login',
    meta: {layout:'auth'},
    component: () => import('../views/Login.vue')
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

export default router
