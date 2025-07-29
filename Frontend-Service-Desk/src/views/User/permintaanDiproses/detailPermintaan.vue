<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'
const router = useRouter()
const route = useRoute()

const pelayananId = ref(route.query.layanan || '-')
const steps = ref([])
const perihal = ref('') 
const tanggal = ref('') 
const nama_depanPengaju = ref('') 
const nama_belakangPengaju = ref('')
const jenis_pelayanan = ref('')
const deskripsi = ref('')
const surat_dinas = ref('')
const lampiran = ref('')
const organisasi = ref('')
const activeTab = ref(route.query.tab === 'informasi' ? 'informasi' : 'tracking')
const currentStep = ref(0)

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
  const id_jenis_pelayanan = ref(null)
  deskripsi.value = response.data.Deskripsi
  organisasi.value = response.data.user.user_organisasi.Nama_OPD
  surat_dinas.value = response.data.Surat_Dinas_Path
  lampiran.value = response.data.Lampiran_Path
  jenis_pelayanan.value = response.data.jenis__pelayanan.Nama_Jenis_Pelayanan
  id_jenis_pelayanan.value = response.data.ID_Jenis_Pelayanan
  nama_depanPengaju.value = response.data.user.Nama_Depan
  nama_belakangPengaju.value = response.data.user.Nama_Belakang
  perihal.value = response.data.Perihal
  tanggal.value = response.data.created_at

  axios.get(`http://127.0.0.1:8000/api/alur/jenis_pelayanan/${id_jenis_pelayanan.value}`, {
        headers: { Authorization: 'Bearer ' + token }
      })
      .then(response => {
        steps.value = response.data.map(a => a.isi_alur?.Isi_Bagian_Alur) || [];
        handleTabChange(activeTab.value)
      })
      .catch(error => {
        console.error('Gagal mengambil steps:', error);
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