<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'
const router = useRouter()
const route = useRoute()

const pelayananId = ref(route.query.layanan || '-')
const steps = ref([])
const stepsStatus = ref([])
const perihal = ref('')
const tanggal = ref('')
const organisasi = ref('')
const nama_depanPengaju = ref('')
const nama_belakangPengaju = ref('')
const nama_depanUnit = ref('')
const nama_belakangUnit = ref('')
const jenis_pelayanan = ref('')
const deskripsi = ref('')
const surat_dinas = ref('')
const lampiran = ref('')
const status = ref('')
const activeTab = ref('informasi')

onMounted(() => {
  if (route.query.steps) {
    try {
      steps.value = JSON.parse(route.query.steps);
    } catch (e) {
      console.error('Gagal parse steps dari query:', e);
    }
  }
});

const token = localStorage.getItem('Token');
axios.get(`http://127.0.0.1:8000/api/pelayanan/${pelayananId.value}`, {
  headers: {
    Authorization: 'Bearer ' + token
  }
})
.then(response => {
  console.log()
  nama_depanUnit.value = response.data.unit_pelayanan?.Nama_Depan || '-'
  nama_belakangUnit.value = response.data.unit_pelayanan?.Nama_Belakang || '-'
  deskripsi.value = response.data.Deskripsi
  organisasi.value = response.data.user.user_organisasi.Nama_OPD
  surat_dinas.value = response.data.Surat_Dinas_Path
  lampiran.value = response.data.Lampiran_Path
  jenis_pelayanan.value = response.data.jenis__pelayanan.Nama_Jenis_Pelayanan
  nama_depanPengaju.value = response.data.user.Nama_Depan
  nama_belakangPengaju.value = response.data.user.Nama_Belakang
  perihal.value = response.data.Perihal
  tanggal.value = response.data.created_at
  status.value = response.data.ID_Status

  axios.get(`http://127.0.0.1:8000/api/pelayanan/alur/progress/${pelayananId.value}`, {
  headers: {
    Authorization: 'Bearer ' + token
    }
  })
  .then(response => {
  steps.value = response.data.map(item =>
    item.progress_to_alur?.isi_alur?.Nama_Alur || 'Tidak Diketahui'
  )

  stepsStatus.value = response.data.map(item => item.Is_Done)

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
const handleTabChange = (tab) => {
  activeTab.value = tab;

  if (tab === 'tracking') {
    if (steps.value.length > 0) {
      router.push({
        name: 'HalamanLacakPengelola',
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
      name: 'HalamanInformasiPengelola',
      query: {
        layanan: pelayananId.value, 
        perihal: perihal.value, 
        tanggal: tanggal.value, 
        organisasi: organisasi.value, 
        nama_depanPengaju: nama_depanPengaju.value, 
        nama_belakangPengaju: nama_belakangPengaju.value, 
        nama_depanUnit: nama_depanUnit.value, 
        nama_belakangUnit: nama_belakangUnit.value, 
        jenis_pelayanan: jenis_pelayanan.value,
        deskripsi: deskripsi.value,
        surat_dinas: surat_dinas.value,
        lampiran: lampiran.value,
        status: status.value,
        tab: 'informasi',
        steps: JSON.stringify(steps.value),
        stepsStatus: JSON.stringify(stepsStatus.value)
      }
    });
  }
};

// Set default route saat komponen dimount
onMounted(() => {
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
  box-sizing: border-box;
  overflow-x: hidden;
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