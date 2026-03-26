import { createRouter, createWebHistory, type RouteRecordRaw } from 'vue-router'
import HomeView from '@/views/HomeView.vue'
import CompleteRegistrationView from '@/views/CompleteRegistrationView.vue'
import UserListView from '@/views/UserListView.vue'

const routes: RouteRecordRaw[] = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path: '/complete-registration',
    name: 'complete-registration',
    component: CompleteRegistrationView
  },
  {
    path: '/users',
    name: 'users',
    component: UserListView
  },
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
})

export default router
