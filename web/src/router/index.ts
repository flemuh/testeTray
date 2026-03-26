import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '@/views/HomeView.vue'
import CompleteRegistrationView from '@/views/CompleteRegistrationView.vue'
import UserListView from '@/views/UserListView.vue'

const routes = [
  { path: '/', name: 'home', component: HomeView },
  { path: '/complete-registration', name: 'complete-registration', component: CompleteRegistrationView },
  { path: '/users', name: 'users', component: UserListView },
]

export default createRouter({
  history: createWebHistory(),
  routes,
})
