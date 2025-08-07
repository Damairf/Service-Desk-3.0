<script setup>
import { ref , onBeforeUnmount, onMounted, computed } from 'vue'
import { useRouter } from 'vue-router'
import LogoServiceDesk from '../../assets/LogoServiceDesk.svg'

const nama_depan = ref(localStorage.getItem('nama_depan'));
const nama_belakang = ref(localStorage.getItem('nama_belakang'));
const gambar = ref(localStorage.getItem('src_gambar'));
const role = ref(localStorage.getItem('id_role'))

const imageSrc = computed(() => {
  if (gambar.value && gambar.value !== 'null') {
    return `/images/${gambar.value}`;
  }
  return '/images/default.jpeg'; // Default image
});
const profileRef = ref(null)

// dropdown referensi
const dropdownref = ref(false)
function togglereferensi() {
  dropdownref.value = !dropdownref.value
}


// biar auto update
onMounted(() => {
  window.addEventListener('gambar-changed', () => {
    gambar.value = localStorage.getItem('src_gambar');
  });

  window.addEventListener('sudahLogin', () => {
    nama_depan.value = localStorage.getItem('nama_depan');
    nama_belakang.value = localStorage.getItem('nama_belakang');
    gambar.value = localStorage.getItem('src_gambar');
  });
  //buat close dropdown click di luar
  document.addEventListener('click', handleClickOutside);
});


const tampilinOverlay = ref(false)

// Refs untuk elemen wrapper

function toggleOverlay() {
  tampilinOverlay.value = !tampilinOverlay.value
}

function handleClickOutside(event) {
  if (
    tampilinOverlay.value &&
    profileRef.value &&
    !profileRef.value.contains(event.target)
  ) {
    tampilinOverlay.value = false
  }
}

onBeforeUnmount(() => {
  document.removeEventListener('click', handleClickOutside)
})

const menuItem = ref([])
const router = useRouter()
//logout
function logout(){
    localStorage.clear();
    router.push('/login')
  }
//ke profile
function toProfile(){
    router.push('/profileSaya')
  }


// biar bisa buka tutup
const isOpen = ref(true)
function toggleSidebar() {
  const newState = !isOpen.value
  isOpen.value = newState
  // Dispatch custom event to notify parent components
  window.dispatchEvent(new CustomEvent('sidebar-toggle', {
    detail: { isCollapsed: !newState }
  }))
}
//menu items
if (role.value == 1) {
  role.value = "User"
  menuItem.value = [
  { icon: '🏠', label: 'Beranda', to: '/beranda' },
  { icon: '⚙️', label: 'Permintaan Baru', to: '/permintaanBaru' },
  { icon: '🔍', label: 'Permintaan Diproses', to: '/permintaanDiproses' },
  { icon: '📁', label: 'Hasil Pemenuhan BA dan SLA', to: '/hasilPemenuhanBASLA' },
  { icon: '📁', label: 'Riwayat', to: '/riwayat' },
];
} else if (role.value == 2) {
  role.value = "Pengelola"
  menuItem.value = [
  { icon: '🏠', label: 'Beranda', to: '/Beranda-Pengelola' },
  { icon: '⚙️', label: 'Permintaan Baru', to: '/permintaanBaruPengelola' },
  { icon: '📁', label: 'Daftar Pelayanan', to: '/pelayanan' },
  { icon: '📁', label: 'Referensi', children: [ 
    { label: 'Lembaga/Organisasi', to: '/lembaga'},
    { label: "Jabatan", to: '/referensi/jabatan'},
    { label: "Status", to: '/referensi/status'},
    { label: "Jenis Pelayanan", to: '/referensi/jenis-pelayanan'},
    { label: "Sub Jenis Pelayanan", to: '/referensi/sub-jenis-pelayanan'},
    { label: "Tipe Permintaan", to: '/referensi/tipe-permintaan'},
    { label: "Urgensi", to: '/referensi/urgensi'},
  ] },
  { icon: '📁', label: 'Pengguna', to: '/pengguna' },
];
} else if (role.value == 3) {
  role.value = "Unit Pelaksana"
  menuItem.value = [
  { icon: '🏠', label: 'Beranda', to: '/berandaUnit' },
  { icon: '⚙️', label: 'Persetujuan Permintaan Layanan', to: '/approval' },
  { icon: '📁', label: 'Disposisi Permintaan Layanan', to: '/disposisi' },
];
} else if (role.value == 4) {
  role.value = "Pelaksana Teknis"
  menuItem.value = [
  { icon: '🏠', label: 'Beranda', to: '/berandaTeknis' },
  { icon: '📁', label: 'Disposisi Permintaan Layanan', to: '/disposisiTeknis' },
  { icon: '📁', label: 'Hasil Pengerjaan Permintaan Layanan', to: '/hasilPengerjaan' },
];
} else if (role.value == 5) {
  role.value = "Kepala Dinas"
  menuItem.value = [
  { icon: '🏠', label: 'Beranda', to: '/berandaKD' },
  { icon: '📁', label: 'Reporting dan Hasil Kepuasaan User Keseluruhan', to: '/KepuasanUserKeseluruhan'},
  { icon: '📁', label: 'Reporting dan Hasil Kepuasaan User Bulan ini', to: '/KepuasanUserBulanIni'}
];
} else {
  role.value = null
  menuItem.value = null
}

</script>

<template>
  <div :class="['sidebar', { collapsed: !isOpen }]">
    <!-- Logo -->
    <div class="logo-wrapper">
      <div :class="['logo', { collapsed: !isOpen }]">
        <template v-if="isOpen">
          <img :src="LogoServiceDesk" alt="Logo" class="sidebar-logo-large" />
          <span class="logo-text">Service<br>Desk V3.0</span>
        </template>
        <template v-else>
          <img :src="LogoServiceDesk" alt="Logo" class="sidebar-logo" />
        </template>
      </div>
    </div>

    <!-- Tombol Toggle -->
    <button class="tombol-toggle" @click="()=> {toggleSidebar(); toggleOverlay();}">
      ☰
    </button>

    <!-- Profile -->
    <div class="profile" ref="profileRef" @click="toggleOverlay">
      <img
        :src="imageSrc"
        alt="Foto Profil"
        class="gambar-profile"
      />
      <span class="nama-profile">{{ nama_depan + " " + nama_belakang }} <br> {{ role }}</span>

      <!-- Profile Dropdown Menu -->
      <div v-if="tampilinOverlay" class="profile-dropdown" :class="{ 'collapsed': !isOpen }">
        <button class="dropdown-item" @click="() => { toggleOverlay(); toProfile() }">
          <span class="dropdown-icon">👤</span>
          <span v-if="isOpen" class="dropdown-text">Profil Saya</span>
        </button>
        <button class="dropdown-item" @click="logout()">
          <span class="dropdown-icon">🚪</span>
          <span v-if="isOpen" class="dropdown-text">Keluar</span>
        </button>
      </div>
    </div>

    <!-- Menu -->
    <template v-for="item in menuItem" :key="item.label">
      <template v-if="item.children">
        <!-- Menu dengan dropdown -->
        <div class="menu-item" @click="togglereferensi">
          <span class="icon">{{ item.icon }}</span>
          <span v-if="isOpen">{{ item.label }}</span>
        </div>
        <!-- Dropdown anak -->
        <ul v-if="dropdownref" class="dropdown-list">
          <li v-for="child in item.children" :key="child.label">
            <router-link :to="child.to" class="dropdown-item" active-class="active">
              {{ child.label }}
            </router-link>
          </li>
        </ul>
      </template>
      <template v-else>
        <!-- Menu biasa -->
        <router-link
          :to="item.to"
          class="menu-item"
        >
          <span class="icon">{{ item.icon }}</span>
          <span v-if="isOpen">{{ item.label }}</span>
        </router-link>
      </template>
    </template>
  </div>
</template>




<style scoped>
.nama-profile{
  text-align: center;
  /* padding-bottom: 5px;
  padding-top: 5px; */
  color: white;
  font-size: 16px;
  font-weight: 600;
  line-height: 1.3;
  padding: 8px 12px;
  transition: all 0.3s ease;
}

/* Profile Dropdown Menu */
.profile-dropdown {
  width: 100%;
  background: #ffffff; /*07883e Warna Lama*/
  color: #0F172A;
  align-items: center;
  gap: 10px;
  overflow: hidden;
}

@keyframes slideDown {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.sidebar-logo-large {
  width: 65px;
  height: 65px;
  transition: all 0.3s ease;
}

.sidebar-logo {
  width: 32px;
  height: 32px;
  display: block;
  margin: 0 auto;
  transition: all 0.3s ease;
}


.dropdown-item {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  width: 100%;
  padding: 0.7rem;
  border: none;
  background: none;
  color: #0F172A;
  font-size: 13px;
  cursor: pointer;
  transition: all 0.3s ease;
  text-align: left;
}

.dropdown-item:hover {
  background-color: #E0F2F1; /*077b39 Warna Lama*/
  font-size: 15px;
}

.dropdown-icon {
  font-size: 24px;
  min-width: 20px;
}

.dropdown-text {
  font-weight: 550;
  font-size: 13px;
}

/* Responsive untuk sidebar collapsed */
.sidebar.collapsed .profile-dropdown {
  position: absolute;
  left: 100%;
  top: 0;
  width: 150px;
  margin-top: 0;
  margin-left: 0.5rem;
  z-index: 1000;
}

.sidebar.collapsed .dropdown-text {
  display: block;
}

.profile{
  display: flex;
  flex-direction: column;
  align-items: center;
  background-color: #14B8A6; /*006920 Warna Lama*/
  cursor: pointer;
  transition: all 0.3s ease;
  position: relative;
}

.gambar-profile{
  width: 100px;
  height: 100px;
  object-fit: cover;
  border-radius: 100%;
  margin-top: 0.5rem;
  border: 3px solid #bcbcbc;
  transition: all 0.3s ease;
}

.sidebar.collapsed .profile .gambar-profile {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  object-fit: cover;
  transition: all 0.3s ease;
  margin-top: 0;
}

.sidebar.collapsed .nama-profile {
  display: none;
}


.sidebar {
  position: fixed;
  top: 0;
  left: 0;
  height: 100vh;
  background: #F8FAFC; /*099D49 Warna Lama*/
  color: #0F172A;
  width: 16rem;
  transition: all 0.3s ease;
  font-size: 13px;
  /* overflow: hidden; */
  overflow-y: auto; /* Scrollable if content overflows */
  overflow-x: hidden;
  scrollbar-width: none; /* Firefox */
  -ms-overflow-style: none;  /* IE and Edge */
  display: flex;
  flex-direction: column;
  /* gap: 5px; */
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
}

.sidebar.collapsed {
  width: 50px;
}

.logo.collapsed {
  padding: 30px 10px;
}

/* Tambahan untuk bungkus logo */
.logo-wrapper {
  width: 100%;
  background-color: #14B8A6; /*0185DA Warna Lama*/
  display: flex;
  justify-content: center;
  align-items: center;
}

.logo {
  font-size: 20px;
  font-weight: bold;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  padding: 30px 30px 30px 10px;
  width: 100%;
  box-sizing: border-box;
  color: #F1F5F9;
  transition: all 0.3s ease;
}

.logo-text {
  display: inline-block;
  text-align: left;
  margin-left: 0;
  margin-top: 10px;
  font-size: 20px;
  font-weight: bolder;
  line-height: 1.2;
}

.tombol-toggle {
  background:#E0F2F1; /*a1a1a1*/
  color: #0F172A;
  border: none;
  cursor: pointer;
  padding: 5px;
  font-size: 18px;
  transition: all 0.3s ease;
}

nav {
  display: flex;
  flex-direction: column;
  gap: 10px;
  padding: 0 10px;
}

.menu-item {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 8px;
  text-decoration: none;
  color: #0F172A;
  transition: all 0.3s ease;
  cursor: pointer;
  font-weight: bold;
}

.menu-item:hover {
  background: #E0F2F1; /*07883e Warna Lama*/
  font-size: 15px;
}

.menu-container {
  flex-grow: 1;
  padding-top: 20px;
  overflow-y: auto;
}

/* Dropdown referensi */
.dropdown-list{
  background: #ffffff;
  margin-top: 0px;
}
.tombol-toggle:hover {
  background: #CCFBF1;
}

.icon {
  font-size: 25px;
  transition: all 0.3s ease;
}

.label {
  white-space: nowrap;
}
</style>
