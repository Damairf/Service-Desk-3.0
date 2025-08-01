import { createRouter, createWebHistory } from 'vue-router'
import axios from 'axios'
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
import TambahPengguna from '../views/Pengelola/Pengguna/TambahPengguna.vue'
import UbahPengguna from '../views/Pengelola/Pengguna/UbahPengguna.vue'
import lembagaOrganisasi from '../views/Pengelola/LembagaOrganisasi/Organisasi.vue'
import tambahOrganisasi from '../views/Pengelola/LembagaOrganisasi/TambahOrganisasi.vue'
import ubahOrganisasi from '../views/Pengelola/LembagaOrganisasi/EditOrganisasi.vue'
import referensiJabatan from '../views/Pengelola/Referensi/jabatan.vue'

//===============UNIT PELAKSANA===============
import berandaUnit from '../views/UnitPelaksana/Beranda/BerandaUnit.vue'

// Approval
import approval from '../views/UnitPelaksana/ApprovalPermintaan/ApprovalUnit.vue'
import detailPelayananPelaksana from '../views/UnitPelaksana/ApprovalPermintaan/detailPelayananPelaksana.vue'
import halamanInformasiApproval from '../views/UnitPelaksana/ApprovalPermintaan/halaman-informasi-PelayananPelaksana.vue'
import halamanLacakApproval from '../views/UnitPelaksana/ApprovalPermintaan/halaman-lacak-PelayananPelaksana.vue'

// Disposisi
import disposisi from '../views/UnitPelaksana/DisposisiPermintaan/DisposisiUnit.vue'
import halamanLacakDisposisi from '../views/UnitPelaksana/DisposisiPermintaan/halaman-lacak-DisposisiUnit.vue'
import halamanInformasiDisposisi from '../views/UnitPelaksana/DisposisiPermintaan/halaman-informasi-DisposisiUnit.vue'
import detailPelayananDisposisi from '../views/UnitPelaksana/DisposisiPermintaan/detailPelayananDisposisi.vue'

//=============PELAKSANA TEKNIS================

//Beranda
import berandaTeknis from '../views/PelaksanaTeknis/BerandaTeknis/BerandaTeknis.vue'

//Disposisi Teknis
import disposisiTeknis from '../views/PelaksanaTeknis/DisposisiTeknis/disposisiTeknis.vue'
import detailPelayananDisposisiTeknis from '../views/PelaksanaTeknis/DisposisiTeknis/detailPelayananDisposisiTeknis.vue'
import halamanInformasiDisposisiTeknis from '../views/PelaksanaTeknis/DisposisiTeknis/halaman-informasi-DisposisiTeknis.vue'
import halamanLacakDisposisiTeknis from '../views/PelaksanaTeknis/DisposisiTeknis/halaman-lacak-DisposisiTeknis.vue'

//===============KEPALA DINAS===============
import berandaKD from '../views/KepalaDinas/BerandaKD/BerandaKD.vue'
import KepuasanUserKeseluruhan from '../views/KepalaDinas/KepuasanUser/Keseluruhan/KepuasanUserKeseluruhanKD.vue'
import KepuasanUserBulanIni from '../views/KepalaDinas/KepuasanUser/BulanIni/KepuasanUserBulanKD.vue'
import DetailKepuasanUserKeseluruhan from '../views/KepalaDinas/KepuasanUser/Keseluruhan/detailKepuasanKeseluruhanKD.vue'
import LacakKepuasanUserKeseluruhan from '../views/KepalaDinas/KepuasanUser/Keseluruhan/halaman-lacakKepuasanKKD.vue'
import InformasiKepuasanUserKeseluruhan from '../views/KepalaDinas/KepuasanUser/Keseluruhan/halaman-informasiKepuasannKKD.vue'
import DetailKepuasanUserBulanIni from '../views/KepalaDinas/KepuasanUser/BulanIni/detailKepuasanBulanKD.vue'
import LacakKepuasanUserBulanIni from '../views/KepalaDinas/KepuasanUser/BulanIni/halaman-lacakKepuasanBKD.vue'
import InformasiKepuasanUserBulanIni from '../views/KepalaDinas/KepuasanUser/BulanIni/halaman-informasiKepuasanBKD.vue'

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
  { path: '/beranda', name: 'Beranda', component: beranda , meta: {allowedRoles: [1]}},
 
  // User
  
  // Halaman permintaan baru 
  { path: '/permintaanBaru', name: 'PermintaanBaru', component: permintaanBaru, meta: {allowedRoles: [1]}},
  { path: '/FormulirTiket', name: 'FormulirTiketBaru', component: HalamanFormulirTiketBaru, meta: {allowedRoles: [1]}},
  
  // Halaman permintaan diproses
  { path: '/permintaanDiproses', name: 'PermintaanDiproses', component: permintaanDiproses, meta: {allowedRoles: [1]}},
  { path: '/detailPermintaan', name: 'DetailPermintaan', component: detailPermintaan, meta: {allowedRoles: [1]}, 
    children: [
      { path: 'lacak', name: 'HalamanLacak', component: halamanLacak, meta: {allowedRoles: [1]}},
      { path: 'informasi', name: 'HalamanInformasi', component: halamanInformasi, meta: {allowedRoles: [1]}}
    ]
  },

  // Hasil Pemenuhan BASLA
  { path: '/hasilPemenuhanBASLA', name: 'hasilPemenuhanBASLA', component: HasilPemenuhanBASLA, meta: {allowedRoles: [1]}},
  { path: '/detailPermintaanHasil', name: 'DetailPermintaanHasil', component: detailPermintaanHasil, meta: {allowedRoles: [1]},
    children: [
      {path: 'lacakHasil', name: 'HalamanLacakHasil', component: halamanLacakHasil, meta: {allowedRoles: [1]}},
      {path: 'informasiHasil', name: 'HalamanInformasiHasil', component: halamanInformasiHasil, meta: {allowedRoles: [1]}}  
    ]
  },

  // Riwayat
  { path: '/riwayat', name: 'Riwayat', component: riwayat, meta: {allowedRoles: [1]}},
  { path: '/detailPermintaanRiwayat', name: 'DetailPermintaanRiwayat', component: detailPermintaanRiwayat, meta: {allowedRoles: [1]},
    children: [
      {path: 'lacakRiwayat', name: 'HalamanLacakRiwayat', component: halamanLacakRiwayat, meta: {allowedRoles: [1]}},
      {path: 'informasiRiwayat', name: 'HalamanInformasiRiwayat', component: halamanInformasiRiwayat, meta: {allowedRoles: [1]}}
    ]
  },

  //===============PENGELOLA===============
  { path: '/Beranda-Pengelola', name: 'Beranda-Pengelola', component: berandaPengelola, meta: {allowedRoles: [2]}},
  { path: '/pelayanan', name: 'pelayanan', component: pelayanan, meta: {allowedRoles: [2]}},
  { path: '/DetailPelayanan', name: 'Detail-Pelayanan', component: detailPelayanan, meta: {allowedRoles: [2]},
    children: [
      { path: 'lacakPengelola', name: 'HalamanLacakPengelola', component: halamanLacakPengelola, meta: {allowedRoles: [2]}},
      { path: 'informasiPengelola', name: 'HalamanInformasiPengelola', component: halamanInformasiPengelola, meta: {allowedRoles: [2]}}
    ]
  },
  { path: '/pengguna', name: 'penggunaPengelola', component: PenggunaPengelola, meta: {allowedRoles: [2]}},
  { path: '/tambahPengguna', name: 'TambahPengguna', component: TambahPengguna, meta: {allowedRoles: [2]}},
  { path: '/ubahPengguna', name: 'UbahPengguna', component: UbahPengguna, meta: {allowedRoles: [2]}},
  { path: '/lembaga', name: 'lembaga/Organisasi', component: lembagaOrganisasi, meta: {allowedRoles: [2]}},
  { path: '/tambahLembaga', name: 'TambahLembaga', component:  tambahOrganisasi, meta: {allowedRoles: [2]}},
  { path: '/ubahLembaga', name: 'UbahLembaga', component: ubahOrganisasi, meta: {allowedRoles: [2]}},
  { path: '/referensi/jabatan', name: 'referensiJabatan', component: referensiJabatan}, 

    
  //===============UNIT PELAKSANA===============

  //Beranda Unit Pelaksana
  { path: '/berandaUnit', name: 'BerandaUnit', component: berandaUnit, meta: {allowedRoles: [3]}},
  { path: '/approval', name: 'Approval', component: approval, meta: {allowedRoles: [3]}},
  { path: '/disposisi', name: 'Disposisi', component: disposisi, meta: {allowedRoles: [3]}},
  //Approval
  { path: '/detailPelayananPelaksana', name: 'DetailPelayananPelaksana', component: detailPelayananPelaksana, meta: {allowedRoles: [3]},
    children: [
      { path: 'informasiApproval', name: 'InformasiPelaksana' , component: halamanInformasiApproval, meta: {allowedRoles: [3]}},
      { path: 'lacakApproval', name:'LacakPelaksana', component: halamanLacakApproval, meta: {allowedRoles: [3]}}
    ]
  },
  //Disposisi
  { path: '/detailPelayananDisposisi', name: 'DetailPelayananDisposisi', component: detailPelayananDisposisi, meta: {allowedRoles: [3]},
    children: [
      { path: 'lacakDisposisi', name: 'HalamanLacakDisposisi', component: halamanLacakDisposisi, meta: {allowedRoles: [3]}},
      { path: 'informasiDisposisi', name: 'HalamanInformasiDisposisi', component: halamanInformasiDisposisi, meta: {allowedRoles: [3]}}
    ]
  },

  //=============PELAKSANA TEKNIS===============
  { path: '/berandaTeknis', name: 'Beranda Teknis', component: berandaTeknis, meta: {allowedRoles: [4]}},

  //Disposisi
  { path: '/disposisiTeknis', name: 'DisposisiTeknis', component: disposisiTeknis, meta: {allowedRoles: [4]}},
  { path: '/detailDisposisiTeknis', name: 'DetailDisposisiTeknis', component: detailPelayananDisposisiTeknis, meta: {allowedRoles: [4]},
    children: [
      {path: 'informasiDisposisiTeknis', name: 'HalamanInformasiDisposisiTeknis', component: halamanInformasiDisposisiTeknis, meta: {allowedRoles: [4]}},
      {path: 'lacakDisposisiTeknis', name: 'HalamanLacakDisposisiTeknis', component: halamanLacakDisposisiTeknis, meta: {allowedRoles: [4]}}
    ]
  },

  //===============KEPALA DINAS===============
  { path: '/berandaKD', name: 'BerandaKepalaDinas', component: berandaKD, meta: {allowedRoles: [5]}},
  // Kepuasan User Keseluruhan
  { path: '/KepuasanUserKeseluruhan', name: 'KepuasanUserKeseluruhan', component: KepuasanUserKeseluruhan, meta: {allowedRoles: [5]}},
  { path: '/detailKepuasanUserKeseluruhan', name: 'DetailKepuasanUserKeseluruhan', component: DetailKepuasanUserKeseluruhan, meta: {allowedRoles: [5]},
    children: [
      { path: 'lacakKepuasanUserKeseluruhan', name: 'LacakKepuasanUserKeseluruhan', component: LacakKepuasanUserKeseluruhan, meta: {allowedRoles: [5]}},
      { path: 'informasiKepuasanUserKeseluruhan', name: 'InformasiKepuasanUserKeseluruhan', component: InformasiKepuasanUserKeseluruhan, meta: {allowedRoles: [5]}}
    ]
  },
  { path: '/KepuasanUserBulanIni', name: 'KepuasanUserBulanIni', component: KepuasanUserBulanIni, meta: {allowedRoles: [5]}},
  { path: '/detailKepuasanUserBulanIni', name: 'DetailKepuasanUserBulanIni', component: DetailKepuasanUserBulanIni, meta: {allowedRoles: [5]},
    children: [
      { path: 'lacakKepuasanUserBulanIni', name: 'LacakKepuasanUserBulanIni', component: LacakKepuasanUserBulanIni, meta: {allowedRoles: [5]}},
      { path: 'informasiKepuasanUserBulanIni', name: 'InformasiKepuasanUserBulanIni', component: InformasiKepuasanUserBulanIni, meta: {allowedRoles: [5]}}
    ]
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    return { top: 0 };
  }
})

router.beforeEach(async (to, from, next) => {
  const token = localStorage.getItem('Token');

  if (!to.meta.allowedRoles) return next();

  if (!token) {
    localStorage.clear();
    return next({ name: 'Login' });
  }

  try {
    const response = await axios.get('http://127.0.0.1:8000/api/user/profile', {
      headers: { Authorization: 'Bearer ' + token }
    });
    const userRole = response.data.ID_Role;


    if (!to.meta.allowedRoles.includes(userRole)) {
      localStorage.clear();
      return next({ name: 'Login' });
    }

    return next();
  } catch (error) {
    localStorage.clear();
    return next({ name: 'Login' });
  }
});

export default router