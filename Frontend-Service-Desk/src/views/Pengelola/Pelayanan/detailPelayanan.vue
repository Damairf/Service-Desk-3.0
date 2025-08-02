<script setup>
import { ref, onMounted, onUnmounted, computed, watch } from 'vue'
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
const nama_pelapor = ref('')
const nama_depanUnit = ref('') 
const nama_belakangUnit = ref('')
const jenis_pelayanan = ref('')
const deskripsi = ref('')
const surat_dinas = ref('')
const lampiran = ref('')
const organisasi = ref('')
const SuratDinas_Path = ref(null)
const Lampiran_Path = ref(null)
const activeTab = ref('informasi')
const pelaksana = ref([])
const idUnitTerpilih = ref('')
const pesan = ref('')
const status = ref(Number(''))
const progress = ref(null)
const stepsID = ref([]) 

// Loading states
const isLoading = ref(true)
const isDataLoaded = ref(false)

// Cache untuk mencegah API calls berulang
const dataCache = ref(null)

const pilihan = ref('')
function handlePilihan(klik){
  pilihan.value = klik
}

// Computed properties untuk optimasi
const pelayananData = computed(() => ({
  deskripsi: deskripsi.value,
  organisasi: organisasi.value,
  surat_dinas: surat_dinas.value,
  lampiran: lampiran.value,
  jenis_pelayanan: jenis_pelayanan.value,
  nama_pelapor: nama_pelapor.value,
  perihal: perihal.value,
  tanggal: tanggal.value,
  steps: steps.value,
  stepsStatus: stepsStatus.value,
  status: status.value
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
    nama_pelapor.value = cached.nama_pelapor
    nama_depanUnit.value = cached.nama_depanUnit
    nama_belakangUnit.value = cached.nama_belakangUnit
    perihal.value = cached.perihal
    tanggal.value = cached.tanggal
    steps.value = cached.steps
    stepsStatus.value = cached.stepsStatus
    status.value = cached.status
    isDataLoaded.value = true
    isLoading.value = false
    return
  }

  try {
    isLoading.value = true
    const token = localStorage.getItem('Token')
    
    const [pelayananResponse, progressResponse, unitResponse] = await Promise.all([
      axios.get(`/api/pelayanan/${pelayananId.value}`, {
        headers: { Authorization: 'Bearer ' + token }
      }),
      axios.get(`/api/pelayanan/alur/progress/${pelayananId.value}`, {
        headers: { Authorization: 'Bearer ' + token }
      }),
      axios.get('/api/pelayanan/unit', {
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
    nama_pelapor.value = pelayananData.Nama_Pelapor
    nama_depanUnit.value = pelayananData.unit_pelayanan?.Nama_Depan
    nama_belakangUnit.value = pelayananData.unit_pelayanan?.Nama_Belakang
    perihal.value = pelayananData.Perihal
    tanggal.value = pelayananData.created_at
    status.value = pelayananData.ID_Status

    // Set progress data
    const progressData = progressResponse.data
    steps.value = progressData.map(item =>
      item.progress_to_alur?.isi_alur?.Nama_Alur || 'Tidak Diketahui'
    )
    stepsStatus.value = progressData.map(item => item.Is_Done)
    stepsID.value = progressData.map(item => item.ID_Progress_Alur)

    // Set pelaksana data
    pelaksana.value = unitResponse.data.map(item => ({
      id_user: item.ID_User,
      nama_depan: item.Nama_Depan,
      nama_belakang: item.Nama_Belakang
    }))
    idUnitTerpilih.value = ''

    // Cache data
    dataCache.value = {
      id: pelayananId.value,
      deskripsi: deskripsi.value,
      organisasi: organisasi.value,
      surat_dinas: surat_dinas.value,
      lampiran: lampiran.value,
      jenis_pelayanan: jenis_pelayanan.value,
      nama_pelapor: nama_pelapor.value,
      perihal: perihal.value,
      tanggal: tanggal.value,
      steps: steps.value,
      stepsStatus: stepsStatus.value,
      status: status.value
    }

    SuratDinas_Path.value = '/files' + surat_dinas.value
    Lampiran_Path.value = '/files' + lampiran.value

    if (status.value === 2 || status.value === 3 || status.value === 4 || status.value === 5 || status.value === 6 ) {
      progress.value = true
    }

    isDataLoaded.value = true
  } catch (error) {
    console.error('Error fetching data:', error)
  } finally {
    isLoading.value = false
  }
}

const handleSelesai = async () => {
  try {
    const token = localStorage.getItem('Token')
    const url = `/api/pelayanan/disposisi/${pelayananId.value}`

    if (pilihan.value === 'Setuju') {
      await axios.put(url, {
        ID_Unit: idUnitTerpilih.value,
        ID_Status: 2,
        Pesan_Pengelola: pesan.value
      }, {
        headers: { Authorization: 'Bearer ' + token }
      })
    } else if (pilihan.value === 'Tolak') {
      await axios.put(url, {
        ID_Status: 3,
        Pesan_Pengelola: pesan.value,
        ID_Unit: null
      }, {
        headers: { Authorization: 'Bearer ' + token }
      })
    }
    // ✅ Update langkah ke-3 menjadi selesai (Is_Done = 1)
    const idProgressLangkah3 = stepsID.value[2] // pastikan ini terisi
    if (idProgressLangkah3) {
      const progressUrl = `/api/progress-alur/update-status/${idProgressLangkah3}`

      await axios.put(progressUrl, {
        Is_Done: 1
      }, {
        headers: { Authorization: 'Bearer ' + token }
      })

      console.log('Langkah ke-3 berhasil ditandai selesai.')
    } else {
      console.warn('ID Progress langkah ke-3 tidak tersedia.')
    }

    router.push('/pelayanan')
  } catch (err) {
    console.error('Gagal menyelesaikan proses:', err)
  }
}

const namaFileSuratDinas = computed(() => {
      const fileName = surat_dinas.value.split('/').pop() 
      const parts = fileName.split('_')
      const tanggal = parts[0]
      const waktu = parts[1]
      return `${tanggal}_${waktu}_Surat_Dinas.pdf`
    })

const namaFileLampiran = computed(() => {
      const fileName = lampiran.value.split('/').pop() 
      const parts = fileName.split('_')
      const tanggal = parts[0]
      const waktu = parts[1]
      return `${tanggal}_${waktu}_Lampiran.pdf`
    })

const messages = ref([
{
    text: "Halo, bagaimana saya bisa membantu?",
    sender: "Admin",
    time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
  }
])
const newMessage = ref('')

const addMessage = () => {
  if (newMessage.value.trim()) {
    messages.value.push({
      text: newMessage.value,
      sender: "User",
      time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
    })
    newMessage.value = ''
  }
}

// Fungsi untuk menangani perubahan tab (tanpa router navigation)
const handleTabChange = (tab) => {
  activeTab.value = tab
  // Update URL tanpa navigation
  const newQuery = { ...route.query, tab }
  router.replace({ query: newQuery })
}

// Watch untuk perubahan pelayananId
watch(() => pelayananId.value, (newId) => {
  if (newId && newId !== '-') {
    fetchPelayananData()
  }
})

onMounted(() => {
  if (pelayananId.value && pelayananId.value !== '-') {
    fetchPelayananData()
  }

  const handlePopState = () => {
    router.push('/pelayanan')
  }

  window.addEventListener('popstate', handlePopState)

  onUnmounted(() => {
    window.removeEventListener('popstate', handlePopState)
  })
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
        <!-- Tab Content -->
        <div v-if="activeTab === 'informasi'" class="tab-content">
          <div class="layout-container">
            <div class="info-card">
              <h3>Informasi Umum</h3>
              <div class="info-row"><strong>Layanan:</strong> <span>{{ jenis_pelayanan }}</span></div>
              <div class="info-row"><strong>No. Tiket:</strong> <span>{{ pelayananId }}</span></div>
              <div class="info-row"><strong>Pelapor:</strong> <span>{{ nama_pelapor }}</span></div>
              <div class="info-row"><strong>Organisasi:</strong> <span>{{ organisasi }}</span></div>
              <div class="info-row"><strong>Tanggal Laporan:</strong> <span>{{ new Date(tanggal).toLocaleDateString('id-ID') }}</span></div>
              <div class="info-row"><strong>Perihal:</strong> <span>{{ perihal }}</span></div>
              <div class="info-row textarea-row">
                <strong>Deskripsi</strong>
                <textarea class="input" :value="deskripsi" placeholder="Deskripsi Pelayanan" rows="5" readonly></textarea>
                <strong>Surat Dinas</strong>
                <div v-if="surat_dinas">
                  <a :href="SuratDinas_Path" target="_blank" rel="noopener" style="color: #2196f3; text-decoration: underline;">
                    {{ namaFileSuratDinas }}
                  </a>
                </div>  
                <strong>Lampiran</strong>
                <div v-if="lampiran">
                  <a :href="Lampiran_Path" target="_blank" rel="noopener" style="color: #2196f3; text-decoration: underline;">
                    {{ namaFileLampiran }}
                  </a>
                </div>
              </div>
            </div>

            <div class="chat-card">
              <h3>Chat</h3>
              <div class="chat-content view-only-chat">
                <div
                  v-for="(message, index) in messages"
                  :key="index"
                  :class="['message-bubble', message.sender === 'User' ? 'sent' : 'received']"
                >
                  <div class="message-text">{{ message.text + " " }}</div>
                  <div class="message-time">{{ message.time + " " }}</div>
                </div>
              </div>
              <div v-if="progress">
                <strong>Nama Unit Pelaksana</strong>
                <div>{{ nama_depanUnit + ' ' + nama_belakangUnit }}</div>
              </div>
              <div class="tinjau-card" v-else>
                <h3>Tinjau Pelayanan</h3>
                <!-- taro link pdfnya disini -->
                <div class="wrapper-btn">
                  <button class="btn-setuju" @click="handlePilihan('Setuju')">Setuju</button>
                  <button class="btn-tolak" @click="handlePilihan('Tolak')">Tolak</button>
                </div>
                <!-- Setuju  -->
                <div class='wrapper-setuju'v-if='pilihan == "Setuju"'>
                  <h4>Unit Pelaksana</h4>
                  <select id="status" v-model="idUnitTerpilih">
                    <option value="" disabled>Pilih Unit Pelaksana</option>
                    <option v-for="option in pelaksana" :key="option.id_user" :value="option.id_user">
                      {{ option.nama_depan }} {{ option.nama_belakang }}
                    </option>
                  </select>
                  <h4>Pesan untuk Unit Pelaksana</h4>
                  <textarea class="input" v-model="pesan"></textarea>
                  <button class="btn-selesai" @click="handleSelesai">Selesai</button>
                </div>
                <div class="wrapper-tolak" v-if='pilihan =="Tolak"'>
                  <h4>Alasan Ditolak</h4>
                  <textarea class="input" v-model="pesan"></textarea>
                  <button class="btn-selesai" @click="handleSelesai">Selesai</button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div v-else-if="activeTab === 'tracking'" class="tab-content">
          <div>
            <h2 class="card-title">Detail Progress<br>{{ pelayananId }}</h2>
            <div class="step-wrapper">
              <div
                v-for="(step, index) in steps"
                :key="index"
                class="step-row"
              >
                <div
                  class="circle"
                  :class="stepsStatus[index] === 1 ? 'circle-blue' : 'circle-inactive'"
                >
                  {{ index + 1 }}
                </div>
                <div
                  class="step-label"
                  :class="stepsStatus[index] === 1 ? 'label-blue' : ''"
                >
                  {{ step }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Error State -->
    <div v-else class="error-container">
      <p>Gagal memuat data. Silakan coba lagi.</p>
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

.tab-content {
  animation: fadeIn 0.1s ease-in-out;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}

/* Layout Container */
.layout-container {
  display: flex;
  gap: 2rem;
  align-items: flex-start;
}

.info-card,
.chat-card {
  background-color: white;
  padding: 0rem 1.5rem 1.5rem 1.5rem;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
  width: 50%;
}

.info-row {
  display: block;
  padding: 0.8rem 0;
}

.info-row strong {
  width: 12rem;
  flex-shrink: 0;
}

.info-row span {
  margin-left: 10px;
  flex-grow: 1;
}

.textarea-row {
  flex-direction: column;
  align-items: start;
}

.textarea-row textarea {
  width: 100%;
  margin-top: 0.5rem;
  padding: 0.5rem;
  border-radius: 8px;
  border: 1px solid #ccc;
  resize: vertical;
  font-family: poppins, sans-serif;
  background-color: #e6e6e6;
}

.chat-content {
  background-color: #e6e6e6;
  border-radius: 8px;
  padding: 1rem;
  margin-bottom: 1rem;
  max-height: 200px;
  overflow-y: auto;
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.view-only-chat {
  min-height: 300px;
  max-height: 400px;
}

.message-bubble {
  padding: 0.5rem 1rem;
  border-radius: 8px;
  max-width: 70%;
  font-size: 0.9rem;
}

.received {
  background-color: #fff;
  align-self: flex-start;
}

.sent {
  background-color: #2196f3;
  color: white;
  align-self: flex-end;
}

.message-time {
  font-size: 0.7rem;
  margin-top: 5px;
  text-align: right;
  opacity: 0.7;
}

.message {
  width: 100%;
  border: 1px solid #aaa;
  border-radius: 8px;
  padding: 0.5rem;
  resize: vertical;
  margin-bottom: 1rem;
  background-color: white;
  color: black;
}

.send-btn {
  background: #006920;
  color: white;
  padding: 0.5rem 1.5rem;
  border: none;
  border-radius: 12px;
  cursor: pointer;
  margin-bottom: 1rem;
}

.note {
  color: #888;
  font-size: 0.8rem;
  margin-top: -0.3rem;
}

.input {
  background-color: white;
  color: black;
}

.tinjau-card {
  background-color: white;
  padding: 1.5rem;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.wrapper-btn{
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
}

.btn-setuju{
  color: white;
  background-color: #4CAF50;
  border-radius: 12px;
  padding: 0.5rem 2.5rem;
  border: none;
  cursor: pointer;
  transition: transform 0.2s ease;
}
.btn-setuju:hover{
  background-color: #66BB6A;
  transform: scale(1.02);
}
.wrapper-setuju {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}
select {
  padding: 0.5rem;
  border-radius: 8px;
  border: 1px solid #ccc;
  color: black;
  background-color: white;
}
.btn-tolak{
  color: white;
  background-color: #D51518;
  border-radius: 12px;
  padding: 0.5rem 2.5rem;
  border: none;
  cursor: pointer;
}
.btn-tolak:hover{
  background-color: #E53935;
  transform: scale(1.02);
}
.wrapper-setuju {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
  align-self: flex-start;
}
.wrapper-tolak{
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}
.btn-selesai{
  color: white;
  background-color: #2BA9E4;
  border-radius: 12px;
  padding: 0.5rem 2rem;
  border: none;
  cursor: pointer;
  transition: transform 0.2s ease;
  width: fit-content;         /* <-- biar lebarnya mengikuti konten */
  align-self: center;     
}
.btn-selesai:hover{
  transform: scale(1.02);
  background-color: #48B7ED;
}

/* Steps */
.card-title {
  font-size: 20px;
  font-weight: bold;
  margin-bottom: 32px;
}

.step-wrapper {
  position: relative;
  padding-left: 36px;
}

.step-row {
  position: relative;
  display: flex;
  align-items: center;
  margin-bottom: 32px;
  z-index: 10;
}

.circle {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  font-weight: bold;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-right: 16px;
  flex-shrink: 0;
  transition: transform 0.2s ease;
  font-size: 16px;
}

.circle:hover {
  transform: scale(1.1);
}

.circle-inactive {
  background-color: #d1d5db;
  color: white;
}

.step-label {
  font-size: 16px;
  font-weight: 600;
  color: #1f2937;
}

.circle-blue {
  background-color: #0185DA !important;
  color: white;
}

.label-blue {
  color: #0185DA !important;
}
</style>