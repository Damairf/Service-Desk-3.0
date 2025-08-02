<script setup>
import { ref, onMounted, computed, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'

const router = useRouter()
const route = useRoute()

// State management
const pelayananId = ref(route.query.layanan || '-')
const steps = ref([])
const stepsStatus = ref([])
const perihal = ref('') 
const tanggal = ref('') 
const nama_depanPengaju = ref('') 
const nama_belakangPengaju = ref('')
const jenis_pelayanan = ref('')
const deskripsi = ref('')
const surat_dinas = ref('')
const lampiran = ref('')
const organisasi = ref('')
const SuratDinas_Path = ref(null)
const Lampiran_Path = ref(null)
const activeTab = ref(route.query.tab === 'informasi' ? 'informasi' : 'tracking')

// Loading states
const isLoading = ref(true)
const isDataLoaded = ref(false)

// Cache untuk mencegah API calls berulang
const dataCache = ref(null)

// Computed properties untuk optimasi
const pelayananData = computed(() => ({
  deskripsi: deskripsi.value,
  organisasi: organisasi.value,
  surat_dinas: surat_dinas.value,
  lampiran: lampiran.value,
  jenis_pelayanan: jenis_pelayanan.value,
  nama_depanPengaju: nama_depanPengaju.value,
  nama_belakangPengaju: nama_belakangPengaju.value,
  perihal: perihal.value,
  tanggal: tanggal.value,
  steps: steps.value,
  stepsStatus: stepsStatus.value
}))

// Fungsi untuk fetch data dengan caching
const fetchPelayananData = async () => {
  if (dataCache.value && dataCache.value.id === pelayananId.value) {
    // Gunakan data dari cache
    const cached = dataCache.value
    deskripsi.value = cached.deskripsi
    organisasi.value = cached.organisasi
    surat_dinas.value = cached.surat_dinas
    lampiran.value = cached.lampiran
    jenis_pelayanan.value = cached.jenis_pelayanan
    nama_depanPengaju.value = cached.nama_depanPengaju
    nama_belakangPengaju.value = cached.nama_belakangPengaju
    perihal.value = cached.perihal
    tanggal.value = cached.tanggal
    steps.value = cached.steps
    stepsStatus.value = cached.stepsStatus
    isDataLoaded.value = true
    isLoading.value = false
    return
  }

  try {
    isLoading.value = true
    const token = localStorage.getItem('Token')
    
    const [pelayananResponse, progressResponse] = await Promise.all([
      axios.get(`/api/pelayanan/${pelayananId.value}`, {
        headers: { Authorization: 'Bearer ' + token }
      }),
      axios.get(`/api/pelayanan/alur/progress/${pelayananId.value}`, {
        headers: { Authorization: 'Bearer ' + token }
      })
    ])

    // Set data
    const pelayananData = pelayananResponse.data
    deskripsi.value = pelayananData.Deskripsi
    organisasi.value = pelayananData.user.user_organisasi.Nama_OPD
    surat_dinas.value = pelayananData.Surat_Dinas_Path
    lampiran.value = pelayananData.Lampiran_Path
    jenis_pelayanan.value = pelayananData.jenis__pelayanan.Nama_Jenis_Pelayanan
    nama_depanPengaju.value = pelayananData.user.Nama_Depan
    nama_belakangPengaju.value = pelayananData.user.Nama_Belakang
    perihal.value = pelayananData.Perihal
    tanggal.value = pelayananData.created_at

    // Set progress data
    const progressData = progressResponse.data
    steps.value = progressData.map(item =>
      item.progress_to_alur?.isi_alur?.Nama_Alur || 'Tidak Diketahui'
    )
    stepsStatus.value = progressData.map(item => item.Is_Done)

  handleTabChange(activeTab.value)
  })
  .catch(error => {
    console.error(error)
  })
})
.catch(function(error) {
  console.log(error)
});

// Fungsi untuk menangani perubahan tab
const handleTabChange = async (tab) => {
  activeTab.value = tab;

  if (tab === 'tracking') {
    if (steps.value.length > 0) {
      router.push({
        name: 'HalamanLacak',
        query: {
          layanan: pelayananId.value,
          tab: 'tracking',
          steps: JSON.stringify(steps.value),
          stepsStatus: JSON.stringify(stepsStatus.value)
        }
      });
      return;
    }
  } else if (tab === 'informasi') {
    router.push({
      name: 'HalamanInformasi',
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
        tab: 'informasi',
      }
    });
  }
};

// Set default route saat komponen dimount
onMounted(() => {
  handleTabChange(activeTab.value)
  
  // Event listener untuk tombol back browser
  const handlePopState = () => {
    // Langsung dilempar ke permintaanDiproses
    router.push({ name: 'PermintaanDiproses' })
  }

})
</script>

<template>
  <div class="container">
    <!-- Loading State -->
    <div v-if="isLoading" class="loading-container">
      <div class="loading-spinner"></div>
      <p>Memuat data...</p>
    </div>

    <!-- Content -->
    <div v-else-if="isDataLoaded">
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
  box-sizing: border-box;
  overflow-x: hidden;
}

/* Loading States */
.loading-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 200px;
  width: 100%;
}

.loading-spinner {
  width: 40px;
  height: 40px;
  border: 4px solid #f3f3f3;
  border-top: 4px solid #fb923c;
  border-radius: 50%;
  animation: spin 1s linear infinite;
  margin-bottom: 16px;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.error-container {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 200px;
  width: 100%;
  color: #ef4444;
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