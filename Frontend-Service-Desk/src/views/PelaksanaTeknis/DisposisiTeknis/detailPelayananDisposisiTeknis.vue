<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'
const router = useRouter()
const route = useRoute()

const pelayananId = ref(route.query.layanan || '-')
const perihal = ref('') 
const tanggal = ref('') 
const nama_depanPengaju = ref('') 
const nama_belakangPengaju = ref('')
const jenis_pelayanan = ref('')
const id_jenis_pelayanan = ref('')
const deskripsi = ref('')
const surat_dinas = ref('')
const lampiran = ref('')
const organisasi = ref('')
const activeTab = ref(route.query.tab === 'informasi' ? 'informasi' : 'tracking')
const isLoading = ref(true)

// Fungsi untuk menangani perubahan tab
const handleTabChange = (tab) => {
  activeTab.value = tab
  if (tab === 'informasi') {
    router.push({
      name: 'HalamanInformasiDisposisiTeknis', 
      query: {
        layanan: pelayananId.value,
        perihal: perihal.value, 
        tanggal: tanggal.value, 
        nama_depanPengaju: nama_depanPengaju.value, 
        nama_belakangPengaju: nama_belakangPengaju.value, 
        jenis_pelayanan: jenis_pelayanan.value,
        organisasi: organisasi.value,
        deskripsi: deskripsi.value,
        surat_dinas: surat_dinas.value,
        lampiran: lampiran.value,
        tab: 'informasi'
      }
    })
  } else if (tab === 'tracking') {
    router.push({
      name: 'HalamanLacakDisposisiTeknis', 
      query: {
        layanan: pelayananId.value,
        tab: 'tracking'
      }
    })
  }
}

async function fetchDataAndNavigate() {
  try {
    const token = localStorage.getItem('Token')
    const response = await axios.get(`http://127.0.0.1:8000/api/pelayanan/${pelayananId.value}`, {
      headers: {
        Authorization: 'Bearer ' + token
      }
    })
    const data = response.data
    deskripsi.value = data.Deskripsi
    organisasi.value = data.user.user_organisasi.Nama_OPD
    surat_dinas.value = data.Surat_Dinas_Path
    lampiran.value = data.Lampiran_Path
    jenis_pelayanan.value = data.jenis__pelayanan.Nama_Jenis_Pelayanan
    id_jenis_pelayanan.value = data.ID_Jenis_Pelayanan
    nama_depanPengaju.value = data.user.Nama_Depan
    nama_belakangPengaju.value = data.user.Nama_Belakang
    perihal.value = data.Perihal
    tanggal.value = data.created_at

    // Now that the data is fetched, we can safely navigate to the correct tab with all the data.
    handleTabChange(activeTab.value)
  } catch (error) {
    console.error('Failed to fetch service details:', error)
  } finally {
    isLoading.value = false
  }
}

// Set default route saat komponen dimount
onMounted(() => {
  fetchDataAndNavigate()
  
  // Event listener untuk tombol back browser
  const handlePopState = () => {
    // Langsung dilempar ke permintaanDiproses
    router.push({ name: 'disposisi' })
  }
  
  window.addEventListener('popstate', handlePopState)
  
  // Cleanup event listener saat komponen unmount
  return () => {
    window.removeEventListener('popstate', handlePopState)
  }
})
</script>

<template>
  <div class="container">
    <!-- Tabs -->
    <div class="tabs">
      <div
        :class="['tab', activeTab === 'informasi' ? 'active-tab-info' : 'inactive-tab']"
        @click="handleTabChange('informasi')"
      >
        Informasi
      </div>
      <div
        :class="['tab', activeTab === 'tracking' ? 'active-tab-track' : 'inactive-tab']"
        @click="handleTabChange('tracking')"
      >
        Lacak
      </div>
    </div>

    <!-- Card -->
    <div class="card">
      <router-view/>
    </div>
  </div>
</template>

<style scoped>
.container {
  width: 100%;
  padding: 24px;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  padding: 32px;
}

/* Tabs */
.tabs {
  align-self: flex-start;
  display: flex;
  gap: 16px;
  background-color: white;
  padding: 8px 16px;
  border-radius: 8px 8px 0 0;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

.tab {
  padding: 8px 16px;
  border-radius: 8px 8px 0 0;
  font-weight: 600;
  cursor: pointer;
  transition: background-color 0.3s ease, transform 0.2s ease;
}

.tab:hover {
  transform: scale(1.05);
}

.active-tab-info {
  color: black;
  background-color: #fb923c;
}

.active-tab-track {
  background-color: #fb923c;
  color: black;
}

.inactive-tab {
  color: #6b7280;
}

/* Card */
.card {
  width: 100%;
  max-width: 1100px;
  background-color: white;
  padding: 32px;
  border-radius: 12px;
  border-top-left-radius: 0;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}
</style>