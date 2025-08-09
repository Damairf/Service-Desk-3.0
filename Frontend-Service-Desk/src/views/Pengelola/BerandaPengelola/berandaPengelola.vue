<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import ChartProgressKeseluruhan from './Chart/ChartPie-ProgressKeseluruhan.vue'
import ChartProgressBulanIni from './Chart/ChartPie-ProgressBulanIni.vue'
import ChartPermintaanLayanan from './Chart/ChartPie-PermintaanLayanan.vue'
import ChartBarPermintaanBerdasarkanStatus from './Chart/ChartBar-PermintaanBerdasarkanStatus.vue'
import ChartBarPermintaanBerdasarkanPengelolaTeknis from './Chart/ChartBar-PermintaanBerdasarkanPengelolaTeknis.vue'
import ChartBarPenilaianLayananServiceDesk from './Chart/ChartBar-PenilaianLayananServiceDesk-.vue'
import { useRouter } from 'vue-router'
import IconPermintaanBaru from '../../../../public/iconpermintaanbaru.svg'
import IconProfile from '../../../../public/profileicon.svg'
import IconLembagaOrganisasi from '../../../../public/iconlembagaorganisasi.svg'

const router = useRouter()
// ceritanya backend
const jumlahPermintaanBaru = ref('')
const jumlahPenggunaTerdaftar = ref('')
const jumlahOrganisasiTerdaftar = ref('')
const isLoading = ref(true)
const nip_user = ref('')
const nama_jabatan = ref('')
const nama_organisasi = ref('')
const nama_user = [localStorage.getItem('nama_depan'), localStorage.getItem('nama_belakang')].join(' ')

const noData = ref({
  progressKeseluruhan: false,
  progressBulanIni: false,
  permintaanLayanan: false,
  permintaanBerdasarkanStatus: false,
  permintaanBerdasarkanPengelolaTeknis: false,
  penilaianLayananServiceDesk: false
})

onMounted(async () => {
  const token = localStorage.getItem('Token')
  if (!token) {
    router.push('/login')
    return
  }

  await fetchDashboardData(token)
})

const fetchDashboardData = async (token) => {
  try {
    isLoading.value = true

    const [profileRes, userCountRes, layananRes, organisasiRes] = await Promise.all([
      axios.get('/api/user/profile', { headers: { Authorization: 'Bearer ' + token } }),
      axios.get('/api/userCount', { headers: { Authorization: 'Bearer ' + token } }),
      axios.get('/api/allPelayanan', { headers: { Authorization: 'Bearer ' + token } }),
      axios.get('/api/organisasiCount', { headers: { Authorization: 'Bearer ' + token } }),
    ])

    // Simpan data
    const profile = profileRes.data
    nip_user.value = profile.NIP
    nama_jabatan.value = profile.user_jabatan.Nama_Jabatan
    nama_organisasi.value = profile.user_organisasi.Nama_OPD

    jumlahPenggunaTerdaftar.value = userCountRes.data
    jumlahPermintaanBaru.value = layananRes.data
    jumlahOrganisasiTerdaftar.value = organisasiRes.data

    // Cache
    localStorage.setItem('nip_user', profile.NIP)
    localStorage.setItem('nama_jabatan', profile.user_jabatan.Nama_Jabatan)
    localStorage.setItem('nama_organisasi', profile.user_organisasi.Nama_OPD)

  } catch (error) {
    console.error('Gagal memuat dashboard:', error)
    router.push('/login') // Jika error karena token invalid
  } finally {
    isLoading.value = false
  }
}
</script>

<template>
    <h1 class="dashboard-title">Selamat datang, {{ nama_user }}</h1>

<!-- Ringkasan: 3 kotak atas -->
<div class="box-row">
  <div class="summary-box">
    <p class="label">Permintaan Baru</p>
    <div class="summary-content">
      <img :src="IconPermintaanBaru" alt="📄" class="icon"/>
      <div class="loading-data" v-if="isLoading">Memuat data...</div>
      <p class="value">{{ jumlahPermintaanBaru }}</p>
    </div>
  </div>
  <div class="summary-box">
    <p class="label">Pengguna Terdaftar</p>
    <div class="summary-content">
      <img :src="IconProfile" alt="👤" class="icon"/>
      <div class="loading-data" v-if="isLoading">Memuat data...</div>
      <p class="value">{{ jumlahPenggunaTerdaftar }}</p>
    </div>
  </div>
  <div class="summary-box">
    <p class="label">Organisasi Terdaftar</p>
    <div class="summary-content">
      <img :src="IconLembagaOrganisasi" alt="👥" class="icon"/>
      <div class="loading-data" v-if="isLoading">Memuat data...</div>
      <p class="value">{{ jumlahOrganisasiTerdaftar }}</p>
    </div>
  </div>
</div>

<!-- Chart Pie: 2 kotak -->
<div class="box-row">
  <div class="chart-box">
    <div class="chart-container">
      <div v-if="isLoading" class="loading-data">Memuat data...</div>
      <div v-else-if="noData.progressKeseluruhan" class="no-data">Belum ada data untuk ditampilkan</div>
      <ChartProgressKeseluruhan v-else @no-data="noData.progressKeseluruhan = $event" />
    </div>
  </div>
  <div class="chart-box">
    <div class="chart-container">
      <div v-if="isLoading" class="loading-data">Memuat data...</div>
      <div v-else-if="noData.progressBulanIni" class="no-data">Belum ada data untuk ditampilkan</div>
      <ChartProgressBulanIni v-else @no-data="noData.progressBulanIni = $event" />
    </div>
  </div>
</div>

<!-- Chart Bar: 4 baris -->
<div class="bar-chart-section">
  <div class="chart-full">
    <div v-if="isLoading" class="loading-data">Memuat data...</div>
    <div v-else-if="noData.permintaanLayanan" class="no-data">Belum ada data untuk ditampilkan</div>
    <ChartPermintaanLayanan v-else @no-data="noData.permintaanLayanan = $event" />
  </div>
  <div class="chart-full">
    <div v-if="isLoading" class="loading-data">Memuat data...</div>
    <div v-else-if="noData.permintaanBerdasarkanStatus" class="no-data">Belum ada data untuk ditampilkan</div>
    <ChartBarPermintaanBerdasarkanStatus v-else @no-data="noData.permintaanBerdasarkanStatus = $event" />
  </div>
  <div class="chart-full">
    <div v-if="isLoading" class="loading-data">Memuat data...</div>
    <div v-else-if="noData.permintaanBerdasarkanPengelolaTeknis" class="no-data">Belum ada data untuk ditampilkan</div>
    <ChartBarPermintaanBerdasarkanPengelolaTeknis v-else @no-data="noData.permintaanBerdasarkanPengelolaTeknis = $event" />
  </div>
  <div class="chart-full">
    <div v-if="isLoading" class="loading-data">Memuat data...</div>
    <div v-else-if="noData.penilaianLayananServiceDesk" class="no-data">Belum ada data untuk ditampilkan</div>
    <ChartBarPenilaianLayananServiceDesk v-else @no-data="noData.penilaianLayananServiceDesk = $event" />
  </div>
</div>
</template>

<style scoped>
.dashboard {
  padding: 30px;
  background-color: #f5f2fb;
  min-height: 100vh;
}

.dashboard-title {
  text-align: left;
  color: black;
  font-size: 32px;
  font-weight: bold;
  margin-bottom: 24px;
}

.box-row {
  display: flex;
  flex-wrap: wrap;
  gap: 16px;
  margin-bottom: 24px;
}

.summary-box {
  text-align: left;
  flex: 1;
  min-width: 250px;
  background-color: white;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  padding: 16px;
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.label {
  color: black;
  font-weight: 600;
  font-size: 16px;
  margin: 0;
}

.summary-content {
  display: flex;
  align-items: center;
  gap: 16px;
}

.icon {
  font-size: 40px;
  width: 55px;
}

.value {
  color: black;
  font-size: 36px;
  font-weight: bold;
  margin: 0;
}

.chart-box {
  flex: 1;
  min-width: 250px;
  background-color: white;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  padding-left: 16px;
  padding-right: 16px;
  height: 300px; /* Match the chart height for consistency */
  display: flex;
  align-items: center;
  justify-content: center;
}

.chart-container {
  margin: 0;
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.bar-chart-section {
  display: flex;
  flex-direction: column;
  gap: 24px;
  margin-top: 24px;
}

.chart-full {
  width: 100%;
  background-color: white;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  padding: 24px;
  box-sizing: border-box;
  height: 300px; /* Match the chart height for consistency */
  display: flex;
  align-items: center;
  justify-content: center;
}

.chart-title {
  color: black;
  font-weight: 600;
  margin-bottom: 12px;
}

.loading-data {
  text-align: center;
  font-size: 1.1rem;
}

.no-data {
  text-align: center;
  font-size: 1.1rem;
  color: #666;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  height: 100%; /* Ensure it fills the container */
}
</style>