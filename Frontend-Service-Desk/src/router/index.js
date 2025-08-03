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

// Hasil Pemenuhan BASLA
import HasilPemenuhanBASLA from '../views/User/HasilPemenuhan/hasilPemenuhanBASLA.vue'
import detailPermintaanHasil from '../views/User/HasilPemenuhan/detailPermintaanHasil.vue'

//Riwayat
import riwayat from '../views/User/Riwayat/riwayat.vue'
import detailPermintaanRiwayat from '../views/User/Riwayat/detailPermintaanRiwayat.vue'

//===============PENGELOLA===============
import berandaPengelola from '../views/Pengelola/BerandaPengelola/berandaPengelola.vue'
import pelayanan from '../views/Pengelola/Pelayanan/Pelayanan.vue'
import detailPelayanan from '../views/Pengelola/Pelayanan/detailPelayanan.vue'
import PenggunaPengelola from '../views/Pengelola/Pengguna/PenggunaPengelola.vue'
import TambahPengguna from '../views/Pengelola/Pengguna/TambahPengguna.vue'
import UbahPengguna from '../views/Pengelola/Pengguna/UbahPengguna.vue'
import lihatPengguna from '../views/Pengelola/Pengguna/LihatPengguna.vue'
import lembagaOrganisasi from '../views/Pengelola/LembagaOrganisasi/Organisasi.vue'
import tambahOrganisasi from '../views/Pengelola/LembagaOrganisasi/TambahOrganisasi.vue'
import ubahOrganisasi from '../views/Pengelola/LembagaOrganisasi/EditOrganisasi.vue'
import referensiJabatan from '../views/Pengelola/Referensi/RefJabatan/jabatan.vue'
import TambahJabatan from '../views/Pengelola/Referensi/RefJabatan/TambahJabatan.vue'
import UbahJabatan from '../views/Pengelola/Referensi/RefJabatan/EditJabatan.vue'
import referensiPelayanan from '../views/Pengelola/Referensi/RefPelayanan/JenisPelayanan.vue'
import TambahPelayanan from '../views/Pengelola/Referensi/RefPelayanan/TambahJenisPelayanan.vue'
import UbahPelayanan from '../views/Pengelola/Referensi/RefPelayanan/EditJenisPelayanan.vue'
import permintaanBaruPengelola from '../views/Pengelola/PermintaanBaruPengelola/PermintaanBaruPengelola.vue'
import formulirTiketBaruPengelola from '../views/Pengelola/PermintaanBaruPengelola/FormulirTiketBaruPengelola.vue'

//===============UNIT PELAKSANA===============
import berandaUnit from '../views/UnitPelaksana/Beranda/BerandaUnit.vue'

// Approval
import approval from '../views/UnitPelaksana/ApprovalPermintaan/ApprovalUnit.vue'
import detailPelayananPelaksana from '../views/UnitPelaksana/ApprovalPermintaan/detailPelayananPelaksana.vue'

// Disposisi
import disposisi from '../views/UnitPelaksana/DisposisiPermintaan/DisposisiUnit.vue'
import detailPelayananDisposisi from '../views/UnitPelaksana/DisposisiPermintaan/detailPelayananDisposisi.vue'

//=============PELAKSANA TEKNIS================

//Beranda
import berandaTeknis from '../views/PelaksanaTeknis/BerandaTeknis/BerandaTeknis.vue'

//Disposisi Teknis
import disposisiTeknis from '../views/PelaksanaTeknis/DisposisiTeknis/disposisiTeknis.vue'
import detailPelayananDisposisiTeknis from '../views/PelaksanaTeknis/DisposisiTeknis/detailPelayananDisposisiTeknis.vue'
import halamanInformasiDisposisiTeknis from '../views/PelaksanaTeknis/DisposisiTeknis/halaman-informasi-DisposisiTeknis.vue'
import halamanLacakDisposisiTeknis from '../views/PelaksanaTeknis/DisposisiTeknis/halaman-lacak-DisposisiTeknis.vue'

// Hasil Pengerjaan
import hasilPengerjaan from '../views/PelaksanaTeknis/HasilPengerjaan/hasilPengerjaan.vue'

//===============KEPALA DINAS===============
import berandaKD from '../views/KepalaDinas/BerandaKD/BerandaKD.vue'
import KepuasanUserKeseluruhan from '../views/KepalaDinas/KepuasanUser/Keseluruhan/KepuasanUserKeseluruhanKD.vue'
import KepuasanUserBulanIni from '../views/KepalaDinas/KepuasanUser/BulanIni/KepuasanUserBulanKD.vue'
import DetailKepuasanUserKeseluruhan from '../views/KepalaDinas/KepuasanUser/Keseluruhan/detailKepuasanKeseluruhanKD.vue'
import DetailKepuasanUserBulanIni from '../views/KepalaDinas/KepuasanUser/BulanIni/detailKepuasanBulanKD.vue'

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
  { path: '/permintaanBaru', name: 'PermintaanBaru', component: permintaanBaru, meta: {allowedRoles: [1, 2]}},
  { path: '/FormulirTiket', name: 'FormulirTiketBaru', component: HalamanFormulirTiketBaru, meta: {allowedRoles: [1, 2]}},
  
  // Halaman permintaan diproses
  { path: '/permintaanDiproses', name: 'PermintaanDiproses', component: permintaanDiproses, meta: {allowedRoles: [1]}},
  { path: '/detailPermintaan', name: 'DetailPermintaan', component: detailPermintaan, meta: {allowedRoles: [1]},},

  // Hasil Pemenuhan BASLA
  { path: '/hasilPemenuhanBASLA', name: 'hasilPemenuhanBASLA', component: HasilPemenuhanBASLA, meta: {allowedRoles: [1], keepAlive: true}},
  { path: '/detailPermintaanHasil', name: 'DetailPermintaanHasil', component: detailPermintaanHasil, meta: {allowedRoles: [1]}},

  // Riwayat
  { path: '/riwayat', name: 'Riwayat', component: riwayat, meta: {allowedRoles: [1]}},
  { path: '/detailPermintaanRiwayat', name: 'DetailPermintaanRiwayat', component: detailPermintaanRiwayat, meta: {allowedRoles: [1]}},

  //===============PENGELOLA===============
  { path: '/Beranda-Pengelola', name: 'Beranda-Pengelola', component: berandaPengelola, meta: {allowedRoles: [2]}},
  { path: '/pelayanan', name: 'pelayanan', component: pelayanan, meta: {allowedRoles: [2]}},
  { path: '/DetailPelayanan', name: 'Detail-Pelayanan', component: detailPelayanan, meta: {allowedRoles: [2]}},
  { path: '/pengguna', name: 'penggunaPengelola', component: PenggunaPengelola, meta: {allowedRoles: [2]}},
  { path: '/tambahPengguna', name: 'TambahPengguna', component: TambahPengguna, meta: {allowedRoles: [2]}},
  { path: '/ubahPengguna', name: 'UbahPengguna', component: UbahPengguna, meta: {allowedRoles: [2]}},
  { path: '/lihatPengguna', name: 'lihatPengguna', component: lihatPengguna, meta: {allowedRoles: [2]}},
  { path: '/lembaga', name: 'lembaga/Organisasi', component: lembagaOrganisasi, meta: {allowedRoles: [2]}},
  { path: '/tambahLembaga', name: 'TambahLembaga', component:  tambahOrganisasi, meta: {allowedRoles: [2]}},
  { path: '/ubahLembaga', name: 'UbahLembaga', component: ubahOrganisasi, meta: {allowedRoles: [2]}},
  { path: '/referensi/jabatan', name: 'referensiJabatan', component: referensiJabatan},
  { path: '/tambahJabatan', name: 'TambahJabatan', component: TambahJabatan, meta: {allowedRoles: [2]}},
  { path: '/ubahJabatan', name: 'UbahJabatan', component: UbahJabatan, meta: {allowedRoles: [2]}},
  { path: '/referensi/jenis-pelayanan', name: 'referensiPelayanan', component: referensiPelayanan, meta: {allowedRoles: [2]}},
  { path: '/tambahPelayanan', name: 'TambahPelayanan', component: TambahPelayanan, meta: {allowedRoles: [2]}},
  { path: '/ubahPelayanan', name: 'UbahPelayanan', component: UbahPelayanan, meta: {allowedRoles: [2]}},
  { path: '/permintaanBaruPengelola', name: 'PermintaanBaruPengelola', component: permintaanBaruPengelola, meta: {allowedRoles: [2]}},
  { path: '/formulirTiketBaruPengelola', name: 'FormulirTiketBaruPengelola', component: formulirTiketBaruPengelola, meta: {allowedRoles: [2]}},  

  //===============UNIT PELAKSANA===============

  //Beranda Unit Pelaksana
  { path: '/berandaUnit', name: 'BerandaUnit', component: berandaUnit, meta: {allowedRoles: [3]}},
  { path: '/approval', name: 'Approval', component: approval, meta: {allowedRoles: [3]}},
  { path: '/disposisi', name: 'Disposisi', component: disposisi, meta: {allowedRoles: [3]}},
  //Approval
  { path: '/detailPelayananPelaksana', name: 'DetailPelayananPelaksana', component: detailPelayananPelaksana, meta: {allowedRoles: [3]}},
  //Disposisi
  { path: '/detailPelayananDisposisi', name: 'DetailPelayananDisposisi', component: detailPelayananDisposisi, meta: {allowedRoles: [3]}},

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

  // Hasil Pengerjaan
  { path: '/hasilPengerjaan', name: 'HasilPengerjaan', component: hasilPengerjaan, meta: {allowedRoles: [4]}},

  //===============KEPALA DINAS===============
  { path: '/berandaKD', name: 'BerandaKepalaDinas', component: berandaKD, meta: {allowedRoles: [5]}},
  // Kepuasan User Keseluruhan
  { path: '/KepuasanUserKeseluruhan', name: 'KepuasanUserKeseluruhan', component: KepuasanUserKeseluruhan, meta: {allowedRoles: [5]}},
  { path: '/detailKepuasanUserKeseluruhan', name: 'DetailKepuasanUserKeseluruhan', component: DetailKepuasanUserKeseluruhan, meta: {allowedRoles: [5]}},
  { path: '/KepuasanUserBulanIni', name: 'KepuasanUserBulanIni', component: KepuasanUserBulanIni, meta: {allowedRoles: [5]}},
  { path: '/detailKepuasanUserBulanIni', name: 'DetailKepuasanUserBulanIni', component: DetailKepuasanUserBulanIni, meta: {allowedRoles: [5]}
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