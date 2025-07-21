import { createRouter, createWebHistory } from 'vue-router'

// Import halaman-halaman
import Login from '../views/loginPage.vue'
import navbar from '../views/User/Navbar/navbar.vue'
import beranda from '../views/User/Beranda/beranda.vue'

//import sub halaman
import HalamanFormulirTiketBaru from '../views/User/pengajuanPermintaan/halaman-formulir-tiket-baru.vue'

// Daftar rute
const routes = [
  { path: '/', name: 'Login', component: Login },
  { path: '/beranda', name: 'Beranda', component: navbar },
  { path: '/FormulirTikerBaru', name: 'FormulirTiketBaru', component:HalamanFormulirTiketBaru}
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
