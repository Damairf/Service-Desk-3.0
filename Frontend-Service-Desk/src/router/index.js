import { createRouter, createWebHistory } from 'vue-router'
//===============USER===============
// profile
import profileSaya from '../views/profile/profileSaya.vue'
import editProfile from '../views/profile/editProfile.vue'
// Import halaman-halaman
import Login from '../views/loginPage.vue'
import beranda from '../views/User/Beranda/beranda.vue'
// Permintaan baru
import permintaanBaru from '../views/User/pengajuanPermintaan/pengajuanPermintaan.vue'
import HalamanFormulirTiketBaru from '../views/User/pengajuanPermintaan/halaman-formulir-tiket-baru.vue'
// Permintaan Diproses
import permintaanDiproses from '../views/User/permintaanDiproses/permintaanDiproses.vue'
import detailPermintaan from '../views/User/permintaanDiproses/detailPermintaan.vue'
import halamanLacak from '../views/User/permintaanDiproses/halaman-lacak.vue'
import halamanInformasi from '../views/User/permintaanDiproses/halaman-informasi.vue'

// Hasil Pemenuhan BASLA
import HasilPemenuhanBASLA from '../views/User/HasilPemenuhan/hasilPemenuhanBASLA.vue'
import detailPermintaanHasil from '../views/User/HasilPemenuhan/detailPermintaanHasil.vue'
import halamanLacakHasil from '../views/User/HasilPemenuhan/halaman-lacakHasil.vue'
import halamanInformasiHasil from '../views/User/HasilPemenuhan/halaman-informasiHasil.vue'

//Riwayat
import riwayat from '../views/User/Riwayat/riwayat.vue'
import detailPermintaanRiwayat from '../views/User/Riwayat/detailPermintaanRiwayat.vue'
import halamanLacakRiwayat from '../views/User/Riwayat/halaman-lacakRiwayat.vue'
import halamanInformasiRiwayat from '../views/User/Riwayat/halaman-informasiRiwayat.vue'

//===============PENGELOLA===============
import berandaPengelola from '../views/Pengelola/BerandaPengelola/berandaPengelola.vue'
import pelayanan from '../views/Pengelola/Pelayanan/Pelayanan.vue'
import detailPelayanan from '../views/Pengelola/Pelayanan/detailPelayanan.vue'
import halamanLacakPengelola from '../views/Pengelola/Pelayanan/halaman-lacak-PelayananPengelola.vue'
import halamanInformasiPengelola from '../views/Pengelola/Pelayanan/halaman-informasi-PelayananPengelola.vue'
import PenggunaPengelola from '../views/Pengelola/Pengguna/PenggunaPengelola.vue'
import lembagaOrganisasi from '../views/Pengelola/LembagaOrganisasi/Organisasi.vue'
import tambahOrganisasi from '../views/Pengelola/LembagaOrganisasi/TambahOrganisasi.vue'
import ubahOrganisasi from '../views/Pengelola/LembagaOrganisasi/EditOrganisasi.vue'

// Daftar rute
const routes = [
  // Login page
  { path: '/', redirect: '/login' },
  { path: '/login', name: 'Login', component: Login },
  // Halaman Profile
  { path: '/profileSaya', name: 'ProfileSaya', component: profileSaya },
  { path: '/editProfile', name: 'EditProfile', component: editProfile},
  //===============USER===============
  // Halaman Beranda 
  { path: '/beranda', name: 'Beranda', component: beranda },
 
  // User
  
  // Halaman permintaan baru 
  { path: '/permintaanBaru', name: 'PermintaanBaru', component: permintaanBaru},
  { path: '/FormulirTiket', name: 'FormulirTiketBaru', component: HalamanFormulirTiketBaru},
  
  // Halaman permintaan diproses
  { path: '/permintaanDiproses', name: 'PermintaanDiproses', component: permintaanDiproses },
  { path: '/detailPermintaan', name: 'DetailPermintaan', component: detailPermintaan, 
    children: [
      { path: 'lacak', name: 'HalamanLacak', component: halamanLacak},
      { path: 'informasi', name: 'HalamanInformasi', component: halamanInformasi}
    ]
  },

  // Hasil Pemenuhan BASLA
  { path: '/hasilPemenuhanBASLA', name: 'hasilPemenuhanBASLA', component: HasilPemenuhanBASLA},
  { path: '/detailPermintaanHasil', name: 'DetailPermintaanHasil', component: detailPermintaanHasil,
    children: [
      {path: 'lacakHasil', name: 'HalamanLacakHasil', component: halamanLacakHasil},
      {path: 'informasiHasil', name: 'HalamanInformasiHasil', component: halamanInformasiHasil}  
    ]
  },

  // Riwayat
  { path: '/riwayat', name: 'Riwayat', component: riwayat},
  { path: '/detailPermintaanRiwayat', name: 'DetailPermintaanRiwayat', component: detailPermintaanRiwayat,
    children: [
      {path: 'lacakRiwayat', name: 'HalamanLacakRiwayat', component: halamanLacakRiwayat},
      {path: 'informasiRiwayat', name: 'HalamanInformasiRiwayat', component: halamanInformasiRiwayat}
    ]
  },

  //===============PENGELOLA===============
  { path: '/Beranda-Pengelola', name: 'Beranda-Pengelola', component: berandaPengelola},
  { path: '/pelayanan', name: 'pelayanan', component: pelayanan},
  { path: '/DetailPelayanan', name: 'Detail-Pelayanan', component: detailPelayanan,
    children: [
      { path: 'lacakPengelola', name: 'HalamanLacakPengelola', component: halamanLacakPengelola},
      { path: 'informasiPengelola', name: 'HalamanInformasiPengelola', component: halamanInformasiPengelola}
    ]
  },
  { path: '/pengguna', name: 'penggunaPengelola', component: PenggunaPengelola},
  { path: '/lembaga', name: 'lembaga/Organisasi', component: lembagaOrganisasi  },
  { path: '/tambahLembaga', name: 'TambahLembaga', component:  tambahOrganisasi },
  { path: '/ubahLembaga', name: 'UbahLembaga', component: ubahOrganisasi},
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router