<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
const router = useRouter()
const route = useRoute()

onMounted(() => {
  window.scrollTo(0, 0);
  });

const idLayanan = ref(route.query.layanan || '-')
const perihal = ref(route.query.perihal || '-')
const tanggal = ref(route.query.tanggal || '-')
const organisasi = ref(route.query.organisasi || '-')
const nama_depanPengaju = ref(route.query.nama_depanPengaju || '-')
const nama_belakangPengaju = ref(route.query.nama_belakangPengaju || '-')
const jenis_pelayanan = ref(route.query.jenis_pelayanan || '-')
const deskripsi = ref(route.query.deskripsi || '-')
const surat_dinas = ref(route.query.surat_dinas || '-')
const lampiran = ref(route.query.lampiran || '-')
const activeTab = ref('tracking')
const currentStep = ref(0) // buat tau 

// Fungsi untuk menangani perubahan tab
const handleTabChange = (tab) => {
  activeTab.value = tab
  if (tab === 'tracking') {
    router.push({
      name: 'HalamanLacakPengelola', 
      query: {layanan: idLayanan.value}
    })
  } else if (tab === 'informasi') {
    router.push({
      name: 'HalamanInformasiPengelola', 
      query: {
        layanan: idLayanan.value, 
        perihal: perihal.value, 
        tanggal: tanggal.value, 
        organisasi: organisasi.value, 
        nama_depanPengaju: nama_depanPengaju.value, 
        nama_belakangPengaju: nama_belakangPengaju.value, 
        jenis_pelayanan: jenis_pelayanan.value,
        deskripsi: deskripsi.value,
        surat_dinas: surat_dinas.value,
        lampiran: lampiran.value
      }
    })
  }
}

// Set default route saat komponen dimount
onMounted(() => {
  window.scrollTo(0, 0)
  handleTabChange(activeTab.value)
  
  // Event listener untuk tombol back browser
  const handlePopState = () => {
    // Langsung dilempar ke layanan
    router.push('/pelayanan')
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
  max-width: 660px;
  background-color: white;
  padding: 32px;
  border-radius: 12px;
  border-top-left-radius: 0;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}
</style>