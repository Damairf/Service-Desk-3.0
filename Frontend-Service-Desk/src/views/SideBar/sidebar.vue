<script setup>
import { ref , onBeforeMount, onMounted, computed } from 'vue'
import { useRouter } from 'vue-router'
// buat backend
import axios from 'axios'

const nama_depan = ref(localStorage.getItem('nama_depan'));
const gambar = ref(localStorage.getItem('src_gambar'));
// const role = ref(localStorage.getItem('role_id'));
const role = ref(1)

// biar auto update
onMounted(() => {
  window.addEventListener('gambar-changed', () => {
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
  isOpen.value = !isOpen.value
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
  { icon: '🏠', label: 'Beranda', to: '/beranda' },
  { icon: '⚙️', label: 'Pelayanan', to: '/pelayanan' },
  { icon: '🔍', label: 'Lembaga/Organisasi', to: '/lembaga' },
  { icon: '📁', label: 'referensi', to: '/referensi' },
  { icon: '📁', label: 'pengguna', to: '/pengguna' },
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
        <span v-if="isOpen">Service<br>Desk V3.0</span>
        <span v-else>🚀</span>
      </div>
    </div>

    <!-- Tombol Toggle -->
    <button class="tombol-toggle" @click="toggleSidebar">
      ☰
    </button>

    <!-- Profile -->
    <div class="profile">
      <img
          :src="`http://localhost:8000/images/${gambar}`"
          alt="Foto Profil"
          class="gambar-profile"
          @click="toggleOverlay"
        />
    <span class="nama-profile">{{nama_depan}} <br> {{role}}</span>
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
  <!-- Overlay -->
    <div v-if="tampilinOverlay" :class="['menuOverlay', {collapsed: !isOpen}]" ref="overlayRef">
      <button @click="() => {toggleOverlay(); toProfile()}">Profile Saya</button>
      <button @click="logout()">Keluar</button>
    </div>
</template>


<style scoped>
.menuOverlay{
  position: absolute;
  left: 13rem;
  top: 13rem;
  background: white;
  border: 1px solid #ddd;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
  z-index: 100;
  padding: 8px;
  width: 180px;
}

.menuOverlay.collapsed {
  left: 4rem;
  top: 10rem;
}

.menuOverlay button{
  color: black;
  display: block;
  width: 100%;
  text-align: left;
  padding: 8px 12px;
  border: none;
  background: none;
  font-size: 14px;
  cursor: pointer;
}

.menuOverlay button:hover{
  background-color: #f0f0f0;
}

.profile{
  display: flex;
  flex-direction: column;
  align-items: center;
  background-color: #006920;
  cursor: pointer;
}

.gambar-profile{
  width: 100px;
  height: 100px;
  object-fit: cover;
  border-radius: 100%;
  margin-top: 0.5rem;
  border: 3px solid #099D49;
}

.sidebar.collapsed .profile .gambar-profile {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  object-fit: cover;
  transition: all 0.3s;
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
  width: 200px;
  transition: width 0.2s ease;
  /* overflow: hidden; */
  overflow-y: auto; /* Scrollable if content overflows */
  scrollbar-width: none; /* Firefox */
  -ms-overflow-style: none;  /* IE and Edge */
  display: flex;
  flex-direction: column;
  gap: 5px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
}

.sidebar.collapsed {
  width: 60px;
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
  text-align: center;
  padding: 30px 10px;
  width: 100%;
  box-sizing: border-box;
  color: white;
}

.tombol-toggle {
  background: none;
  color: white;
  border: none;
  cursor: pointer;
  padding: 5px;
  font-size: 18px;
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
  transition: background 0.2s;
}

.menu-item:hover {
  background: #006920;
}

.icon {
  font-size: 25px;
}

.label {
  white-space: nowrap;
}
</style>
