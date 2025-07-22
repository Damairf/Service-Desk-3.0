<script setup>
  import {provide, onBeforeMount, ref, watch, onMounted, onBeforeUnmount} from 'vue'
  import './navbar.css'
  import { useRouter } from 'vue-router'
  import beranda from '../Beranda/beranda.vue'
  import pengajuanpermintaan from '../pengajuanPermintaan/pengajuanPermintaan.vue'
  import permintaanDiproses from '../permintaanDiproses/permintaanDiproses.vue'
  import Beranda from '../Beranda/beranda.vue'
  import axios from 'axios'


  // overlay
  const tampilinOverlay = ref(false)
  const overlayRef = ref(null)
  const akunRef = ref(null)

  function toggleOverlay(){
    tampilinOverlay.value = !tampilinOverlay.value
  }

  function logout(){
    localStorage.clear();
    router.push('/login')
  }

  // Handler to close overlay when clicking outside
  function handleClickOutside(event) {
    const overlay = overlayRef.value
    const akun = akunRef.value
    if (
      overlay && !overlay.contains(event.target) &&
      akun && !akun.contains(event.target)
    ) {
      tampilinOverlay.value = false
    }
  }

  watch(tampilinOverlay, (val) => {
    if (val) {
      document.addEventListener('mousedown', handleClickOutside)
    } else {
      document.removeEventListener('mousedown', handleClickOutside)
    }
  })

  onBeforeUnmount(() => {
    document.removeEventListener('mousedown', handleClickOutside)
  })



const nama_depan = ref('')
const nama_belakang = ref('')

onBeforeMount(() => {
  const token = localStorage.getItem('Token');
  axios.get('http://127.0.0.1:8000/api/user/profile', {
    headers: {
      Authorization: 'Bearer ' + token
    }
  })
  .then(response => {
    nama_depan.value = response.data.Nama_Depan
    nama_belakang.value = response.data.Nama_Belakang
  })
  .catch(error => {
    console.error(error)
  })
})



    

  // Sub halaman
  // formulir
  import halamanFormulirTiketBaru from '../pengajuanPermintaan/halaman-formulir-tiket-baru.vue'
  // profile
  import profileSaya from '../../profile/profileSaya.vue'
  import editProfile from '../../profile/editProfile.vue'

  const router = useRouter()

  /*buat collapse */
  const collapse = ref(false)
  function toggleSidebar() {
    collapse.value = !collapse.value
  }

  /* biar ada isi kliknya */
  const menuItem = [
  "Beranda","Permintaan Baru", "Lacak Permintaan",
  "Hasil Pemenuhan SLA dan BA", "Riwayat"]

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
    'Permintaan Baru': pengajuanpermintaan,
    'Halaman Formulir Tiket Baru': halamanFormulirTiketBaru,
    'Profile Saya': profileSaya,
    'Edit Profile': editProfile,
  }

  /* biar warna hovernya beda */
  const getHoverClass = (item) => {
    if(["Beranda", "Riwayat", "History"].includes(item)){
      return "hover-blue";
    }
    else if(["Permintaan Baru"].includes(item)){
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
      <div class="akun" ref="akunRef" @click="toggleOverlay">
        <h4>{{ nama_depan + " " + nama_belakang }}</h4>
      </div>
      <!-- overlay -->
      <div v-if="tampilinOverlay" class="menuOverlay" ref="overlayRef">
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