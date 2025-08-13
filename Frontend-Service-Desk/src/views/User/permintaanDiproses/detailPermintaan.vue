<script setup>
import { ref, onMounted, computed, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'

const router = useRouter()
const route = useRoute()

// State management
const userId = ref(localStorage.getItem('user_id'));
const pelayananId = ref(route.query.layanan || '-')
const steps = ref([])
const stepsStatus = ref([])
const perihal = ref('') 
const tanggal = ref('') 
const nama_pelapor = ref('') 
const nama_depanTeknis = ref('')
const nama_belakangTeknis = ref('')
const sub_jenis_pelayanan = ref('')
const jenis_pelayanan = ref('')
const deskripsi = ref('')
const surat_dinas = ref('')
const lampiran = ref('')
const organisasi = ref('')
const SuratDinas_Path = ref(null)
const Lampiran_Path = ref(null)
const activeTab = ref('informasi')


const messages = ref([])
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
  sub_jenis_pelayanan: sub_jenis_pelayanan.value,
  jenis_pelayanan: jenis_pelayanan.value,
  nama_pelapor: nama_pelapor.value,
  nama_depanTeknis: nama_depanTeknis.value,
  nama_belakangTeknis: nama_belakangTeknis,
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
    sub_jenis_pelayanan.value = cached.sub_jenis_pelayanan
    jenis_pelayanan.value = cached.jenis_pelayanan
    nama_pelapor.value = cached.nama_pelapor
    nama_depanTeknis.value = cached.nama_depanTeknis
    nama_belakangTeknis.value = cached.nama_belakangTeknis
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
    sub_jenis_pelayanan.value = pelayananData.sub__jenis__pelayanan.Nama_Sub_Jenis_Pelayanan
    jenis_pelayanan.value = pelayananData.jenis__pelayanan.Nama_Jenis_Pelayanan
    nama_pelapor.value = [pelayananData.user.Nama_Depan, pelayananData.user.Nama_Belakang].filter(Boolean).join(' ');
    nama_depanTeknis.value = pelayananData.teknis_pelayanan?.Nama_Depan || 'Belum'
    nama_belakangTeknis.value = pelayananData.teknis_pelayanan?.Nama_Belakang || 'Tersedia'
    perihal.value = pelayananData.Perihal
    tanggal.value = pelayananData.created_at
    messages.value = pelayananData.pelayanan_pesan.map(pesan => ({
      id_user: pesan.ID_User,
      text: pesan.Pesan,
      sender: `${pesan.pesan_user.Nama_Depan} ${pesan.pesan_user.Nama_Belakang} - ${pesan.pesan_user.user_role.Nama_Role}`,
      time: new Date(pesan.created_at || Date.now()).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
      dokumen_path:pesan.Dokumen_Path
    }))


    // Set progress data
    const progressData = progressResponse.data
    steps.value = progressData.map(item =>
      item.progress_to_alur?.isi_alur?.Nama_Alur || 'Tidak Diketahui'
    )
    stepsStatus.value = progressData.map(item => item.Is_Done)

    // Cache data
    
    dataCache.value = {
      id: pelayananId.value,
      deskripsi: deskripsi.value,
      organisasi: organisasi.value,
      surat_dinas: surat_dinas.value,
      lampiran: lampiran.value,
      sub_jenis_pelayanan: sub_jenis_pelayanan.value,
      jenis_pelayanan: jenis_pelayanan.value,
      nama_pelapor: nama_pelapor.value,
      nama_depanTeknis: nama_depanTeknis.value,
      nama_belakangTeknis: nama_belakangTeknis.value,
      perihal: perihal.value,
      tanggal: tanggal.value,
      steps: steps.value,
      stepsStatus: stepsStatus.value
    }

    SuratDinas_Path.value = '/files/' + surat_dinas.value
    Lampiran_Path.value = '/files/' + lampiran.value

    isDataLoaded.value = true
  } catch (error) {
    console.error('Error fetching data:', error)
  } finally {
    isLoading.value = false
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

const dokumen = ref(null)
const newMessage = ref('')
const fileInput = ref(null);


// Cek ekstensi file apakah gambar
const isImage = (path) => {
  return /\.(jpg|jpeg|png)$/i.test(path);
};

const handleFileUpload = (event) => {
  dokumen.value = event.target.files[0];
};

const addMessage = async () => {
  if (!newMessage.value && !dokumen.value) return

  const formData = new FormData()
  formData.append('ID_User', userId.value)
  formData.append('Pesan', newMessage.value)
  if (dokumen.value) {
    formData.append('Dokumen_Path', dokumen.value)
  }

  const token = localStorage.getItem('Token')

  try {
    const res = await axios.post(`/api/pesan/${pelayananId.value}`, formData, {
      headers: {
        Authorization: 'Bearer ' + token,
        'Content-Type': 'multipart/form-data',
      },
    })

    messages.value.push({
      id_user: userId.value,
      text: newMessage.value,
      dokumen_path: res.data.dokumen, 
      sender: `${localStorage.getItem('nama_depan')} ${localStorage.getItem('nama_belakang')} - ${localStorage.getItem('nama_role')}`,
      time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
    })

    newMessage.value = ''
    dokumen.value = null
  } catch (error) {
    console.error('Gagal mengirim pesan:', error)
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

  // Event listener untuk tombol back browser
  const handlePopState = () => {
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
          <!-- Info Card -->
          <div class="info-card">
            <h3>Informasi Umum</h3>
            <div class="info-row"><strong>Layanan:</strong> <span>{{ sub_jenis_pelayanan }}</span></div>
            <div class="info-row"><strong>Tipe Layanan:</strong> <span>{{ jenis_pelayanan }}</span></div>
            <div class="info-row"><strong>No. Tiket:</strong> <span>{{ pelayananId }}</span></div>
            <div class="info-row"><strong>Pelapor:</strong> <span>{{ nama_pelapor }}</span></div>
            <div class="info-row"><strong>Organisasi:</strong> <span>{{ organisasi }}</span></div>
            <div class="info-row"><strong>Tanggal Laporan:</strong> <span>{{ new Date(tanggal).toLocaleDateString('id-ID') }}</span></div>
            <div class="info-row"><strong>Perihal:</strong> <span>{{ perihal }}</span></div>
            <div class="info-row textarea-row">
              <strong>Deskripsi</strong>
              <textarea class="input" :value="deskripsi" placeholder="Deskripsi Pelayanan" rows="5" readonly></textarea>

              <strong class="link-surat">Surat Dinas</strong>
              <div v-if="surat_dinas">
                <a :href="SuratDinas_Path" target="_blank" rel="noopener" style="color: #2196f3; text-decoration: underline;">
                  {{ namaFileSuratDinas }}
                </a>
              </div>

              <strong class="link-surat">Lampiran</strong>
              <div v-if="lampiran">
                <a :href="Lampiran_Path" target="_blank" rel="noopener" style="color: #2196f3; text-decoration: underline;">
                  {{ namaFileLampiran }}
                </a>
              </div>
            </div>
          </div>

          <!-- Chat Card -->
          <div class="chat-card">
            <h3>Chat</h3>
            <div class="chat-content">
              <div v-if="messages.length === 0" 
              class='message-bubble'>Belum ada pesan</div>
              <div
                v-for="(message, index) in messages"
                :key="index"
                :class="['message-bubble', message.id_user == userId ? 'sent' : 'received']"
              >
                <strong class="message-text">{{ message.sender }}</strong>  
                <div class="message-text">{{ message.text }}</div>
                <div v-if="message.dokumen_path" class="message-doc">
                  <template v-if="isImage(message.dokumen_path)">
                    <img :src="'/files/' + message.dokumen_path" alt="dokumen" class="message-image" />
                  </template>
                  <template v-else>
                    <a :href="'/files/' + message.dokumen_path" target="_blank" class="message-link">📎 Lihat Dokumen</a>
                  </template>
                </div>
                <div class="message-time">{{ message.time }}</div>
              </div>
            </div>
            <div class="chat-input">
              <label for="file-upload" class="upload-btn">Tambah File</label>
              <input
                type="file"
                id="file-upload"
                ref="fileInput"
                @change="handleFileUpload"
                accept=".pdf,.jpg,.jpeg,.png"
                style="display: none;"
              />
              <!-- Tampilkan nama file -->
            <span v-if="dokumen" class="file-info">
              File terpilih: {{ dokumen.name }}
            </span>
              <textarea
                v-model="newMessage"
                class="message"
                placeholder="Pesan"
              ></textarea>
              <button class="send-btn-chat" @click="addMessage">Kirim</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Tab Tracking -->
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
      </div> <!-- End Tracking -->
    </div> <!-- End Card -->
  </div> <!-- End Content -->

  <!-- Error State -->
  <div v-else class="error-container">
    <p>Gagal memuat data. Silakan coba lagi.</p>
  </div>
</div> <!-- End Container -->
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

.error-container {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 200px;
  width: 100%;
  color: #ef4444;
}

/* Card */
.card {
  width: 100%;
  width: 1100px;
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

.info-row {
  display: flex;
  padding: 0.8rem 0;
}

.info-row-PelaksanaTeknis {
  display: block;
  padding: 0.8rem 0;
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
  display: flex;
  padding: 0.8rem 0;
}

.info-row-PelaksanaTeknis {
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
  width: 97%;
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

.input {
  background-color: white;
  color: black;
}
</style>