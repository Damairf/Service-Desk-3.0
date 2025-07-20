import { createRouter, createWebHistory } from 'vue-router'

// Import halaman-halaman
import Login from '../views/loginPage.vue'
import navbar from '../views/User/Navbar/navbar.vue'
import beranda from '../views/User/Beranda/beranda.vue'

// Daftar rute
const routes = [
  { path: '/', name: 'Login', component: Login },
  { path: '/beranda', name: 'Beranda', component: navbar },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
