<script setup>
import { ref , onBeforeMount, onMounted, computed } from 'vue'
import { useRouter } from 'vue-router'
// buat backend
import axios from 'axios'
import LogoServiceDesk from '../../assets/LogoServiceDesk.svg'

const nama_depan = ref(localStorage.getItem('nama_depan'));
const nama_belakang = ref(localStorage.getItem('nama_belakang'));
const gambar = ref(localStorage.getItem('src_gambar'));
const role = ref(localStorage.getItem('id_role'))

// biar auto update
onMounted(() => {
  window.addEventListener('gambar-changed', () => {
    gambar.value = localStorage.getItem('src_gambar');
  });
  window.addEventListener('sudahLogin', () => {
    nama_depan.value = localStorage.getItem('nama_depan');
    nama_belakang.value = ref(localStorage.getItem('nama_belakang'));
    gambar.value = localStorage.getItem('src_gambar');
  });
});

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

//ovelay
const tampilinOverlay = ref(false)
function toggleOverlay(){
    tampilinOverlay.value = !tampilinOverlay.value
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
  { icon: '📁', label: 'Hasil Pemenuhan SLA dan BA', to: '/hasilPemenuhanBASLA' },
  { icon: '📁', label: 'Riwayat', to: '/riwayat' },
];
} else if (role.value == 2) {
  role.value = "Pengelola"
  menuItem.value = [
  { icon: '🏠', label: 'Beranda', to: '/Beranda-Pengelola' },
  { icon: '⚙️', label: 'Pelayanan', to: '/pelayanan' },
  { icon: '🔍', label: 'Lembaga/Organisasi', to: '/lembaga' },
  { icon: '📁', label: 'Referensi', to: '/referensi' },
  { icon: '📁', label: 'Pengguna', to: '/pengguna' },
];
} else if (role.value == 3) {
  role.value = "Unit Pelaksana"
  menuItem.value = [
  { icon: '🏠', label: 'Beranda', to: '/beranda' },
  { icon: '⚙️', label: 'Approval Permintaan Layanan', to: '/approval' },
  { icon: '🔍', label: 'Lembaga/Organisasi', to: '/lembaga' },
  { icon: '📁', label: 'Disposisi Permintaan Layanan', to: '/disposisi' },
];
} else if (role.value == 4) {
  role.value = "Pelaksana Teknis"
  menuItem.value = [
  { icon: '🏠', label: 'Beranda', to: '/beranda' },
  { icon: '⚙️', label: 'User Portal', to: '/portal' },
  { icon: '🔍', label: 'Request User', to: '/request' },
  { icon: '📁', label: 'Laporan Insiden', to: '/laporan' },
  { icon: '📁', label: 'Disposisi Permintaan Layanan', to: '/disposisi' },
  { icon: '📁', label: 'Hasil Pengerjaan Permintaan Layanan', to: '/hasil' },
];
} else if (role.value == 5) {
  role.value = "Kepala Dinas"
  menuItem.value = [
  { icon: '🏠', label: 'Beranda', to: '/beranda' },
  { icon: '⚙️', label: 'Reporting dan Hasil Kepuasaan User Keseluruhan', to: '/reportingKeseluruhan' },
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
      <div class="logo">
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
    <button class="tombol-toggle" @click="()=> {toggleSidebar(); toggleOverlay(); toggleOverlay();}">
      ☰
    </button>

    <!-- Profile -->
    <div class="profile" @click="toggleOverlay">
      <img
          :src="`http://localhost:8000/images/${gambar}`"
          alt="Foto Profil"
          class="gambar-profile"
        />
    <span class="nama-profile">{{nama_depan + " " + nama_belakang}} <br> {{role}}</span>
    
    <!-- Profile Dropdown Menu -->
    <div v-if="tampilinOverlay" 
      class="profile-dropdown"
      :class="{'collapsed': !isOpen}"
    >
      <button class="dropdown-item" @click="() => {toggleOverlay(); toProfile()}">
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
    <router-link
      :to="item.to"
      v-for="item in menuItem"
      :key="item.label"
      class="menu-item"
    >
      <span class ="icon">{{item.icon}}</span>
      <span v-if="isOpen" class="">{{item.label}}</span>
    </router-link>
  </div>
</template>


<style scoped>
.nama-profile{
  text-align: center;
  padding-bottom: 5px;
  padding-top: 5px;
  font-weight: 600;
  transition: all 0.3s ease;
}

/* Profile Dropdown Menu */
.profile-dropdown {
  width: 100%;
  background: #07883e;
  align-items: center;
  gap: 10px;
  overflow: hidden;
  animation: slideDown 0.3s ease;
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
  padding-left: 8px;
  border: none;
  background: none;
  color: #ffffff;
  font-size: 15px;
  cursor: pointer;
  transition: all 0.2s ease;
  text-align: left;
}

.dropdown-item:hover {
  background-color: #077b39;
}

.dropdown-icon {
  font-size: 24px;
  min-width: 20px;
}

.dropdown-text {
  font-weight: 500;
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
  background-color: #006920;
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
  border: 3px solid #099D49;
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
  background: #099D49;
  color: white;
  width: 16rem;
  transition: all 0.3s ease;
  /* overflow: hidden; */
  overflow-y: auto; /* Scrollable if content overflows */
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

/* Tambahan untuk bungkus logo */
.logo-wrapper {
  width: 100%;
  background-color: #0185DA;
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
  padding: 30px 10px;
  width: 100%;
  box-sizing: border-box;
  color: white;
  transition: all 0.3s ease;
}

.logo-text {
  display: inline-block;
  text-align: left;
  margin-left: 0;
  font-size: 20px;
  font-weight: bold;
}

.tombol-toggle {
  background: none;
  color: white;
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
  color: white;
  transition: all 0.3s ease;
}

.menu-item:hover {
  background: #07883e;
}

.tombol-toggle:hover {
  background: #07883e;
}

.icon {
  font-size: 25px;
  transition: all 0.3s ease;
}

.label {
  white-space: nowrap;
}
</style>
