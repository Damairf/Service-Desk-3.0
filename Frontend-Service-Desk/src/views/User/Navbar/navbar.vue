<script setup>
  import {provide, ref} from 'vue'
  import './navbar.css'
  import { useRouter } from 'vue-router'
  import beranda from '../Beranda/beranda.vue'
  import pengajuanpermintaan from '../pengajuanPermintaan/pengajuanPermintaan.vue'
  import permintaanDiproses from '../permintaanDiproses/permintaanDiproses.vue'
  import Beranda from '../Beranda/beranda.vue'

  //overlay
  const tampilinOverlay = ref(false)
  function toggleOverlay(){
    tampilinOverlay.value = !tampilinOverlay.value
  }
  function logout(){
  router.push('/login')
  }

  // nama profile
  const namaDepan = "Nama"
  const namaBelakang = "User4"

  // Sub halaman
  // formulir
  import halamanFormulirTiketBaru from '../pengajuanPermintaan/halaman-formulir-tiket-baru.vue'
  // profile
  import profileSaya from '../profile/profileSaya.vue'
  import editProfile from '../profile/editProfile.vue'

  const router = useRouter()

  /*buat collapse */
  const collapse = ref(false)
  function toggleSidebar() {
    collapse.value = !collapse.value
  }

  /* biar ada isi kliknya */
  const menuItem = [
  "Beranda", "Pengajuan Permintaan", 
  "Permintaan Baru", "Lacak Permintaan",
  "Hasil Pemenuhan SLA dan BA", "Riwayat",
  "History"]

  /* biar bisa diklik */
  const selected = ref('Beranda')
  function selectMenu(item) {
    selected.value = item
  }
  /*biar bisa dapet dari file lain */
  provide('selectMenu', selectMenu)

  /* biar bisa ganti2 */
  const componentsMap = {
    Beranda: beranda,
    /*Pengajuan Permintaan */
    'Pengajuan Permintaan': pengajuanpermintaan,
    'Halaman Formulir Tiket Baru': halamanFormulirTiketBaru,
    'Profile Saya': profileSaya,
    'Edit Profile': editProfile,
  }

  /* biar warna hovernya beda */
  const getHoverClass = (item) => {
    if(["Beranda", "Riwayat", "History"].includes(item)){
      return "hover-blue";
    }
    else if(["Pengajuan Permintaan", "Permintaan Baru"].includes(item)){
      return "hover-yellow";
    }
    else{
      return "hover-green";
    }
  }
</script>


<template>
  <div class="wrapperAtas">
    <div class="judul">
      <div>SERVICE</div>
      <div>DESK V3.0</div>
    </div>
    <!-- blok akun -->
    <div class="wrapperAkun">
      <div class="akun" @click="toggleOverlay">
      <h4>{{ namaDepan + " " + namaBelakang }}</h4>
      </div>
      <!-- overlay -->
      <div v-if="tampilinOverlay" class="menuOverlay">
        <button @click="() => { selectMenu('Profile Saya'); toggleOverlay(); }">Akun Saya</button>
        <button @click="logout()">Keluar</button>
      </div>
    </div>
  </div>

  <div class="layout">
    <aside class="sidebar" :class="{collapsed : collapse}">
      <button class="toggle-btn" @click="toggleSidebar">
        {{ collapse ? '→' : '←' }}
      </button>
      <ul>
        <li v-for="item in menuItem" key: item
        :class="[getHoverClass(item),
        {active: item === selected}]"
        @click="selectMenu(item)">
          <span class="menu-text" :class="{ collapsed: collapse }">
              {{ item }}
          </span>
        </li>
      </ul>
    </aside>
    <main class="content">
      <component :is="componentsMap[selected]"/>
    </main>
  </div>
</template>