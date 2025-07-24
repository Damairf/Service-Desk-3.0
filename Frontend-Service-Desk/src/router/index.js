import { createRouter, createWebHistory } from 'vue-router'
//import sidebar
import Sidebar from '../views/SideBar/sidebar.vue' //apus aja kali ntar
// profile
import profileSaya from '../views/profile/profileSaya.vue'
// Import halaman-halaman
import Login from '../views/loginPage.vue'
import beranda from '../views/User/Beranda/beranda.vue'
// Permintaan baru
import permintaanBaru from '../views/User/pengajuanPermintaan/pengajuanPermintaan.vue'
import HalamanFormulirTiketBaru from '../views/User/pengajuanPermintaan/halaman-formulir-tiket-baru.vue'
// Permintaan Diproses
import permintaanDiproses from '../views/User/permintaanDiproses/permintaanDiproses.vue'

// Daftar rute
const routes = [
  // Login page
  { path: '/', redirect: '/login' },
  { path: '/login', name: 'Login', component: Login },
  // Halaman Profile
  {path: '/profileSaya', nama: 'ProfileSaya', component: profileSaya },
  // Halaman Beranda 
  { path: '/beranda', name: 'Beranda', component: beranda },
  // User
  // Halaman permintaan baru 
  { path: '/permintaanBaru', name: 'PermintaanBaru', component: permintaanBaru},
  { path: '/FormulirTiket', name: 'FormulirTiketBaru', component: HalamanFormulirTiketBaru},
  // Halaman permintaan diproses
  {path: '/permintaanDiproses', name: 'PermintaanDiproses', component: permintaanDiproses },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
