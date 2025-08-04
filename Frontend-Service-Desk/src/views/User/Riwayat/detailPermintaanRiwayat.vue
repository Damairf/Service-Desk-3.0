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
const nama_depanTeknis = ref('')
const nama_belakangTeknis = ref('')
const jenis_pelayanan = ref('')
const deskripsi = ref('')
const pesanPengelola = ref('')
const organisasi = ref('')
const status = ref('')

const surat_dinas = ref('')
const lampiran = ref('')
const SuratDinas_Path = ref(null)
const Lampiran_Path = ref(null)
const HasilBA_Path = ref(null)
const HasilSLA_Path = ref(null)
const HasilPemenuhan_Path = ref(null)
const src_HasilPemenuhan = ref(route.query.hasil_pemenuhan || '-')
const src_HasilBA = ref(route.query.hasil_ba || '-')
const src_HasilSLA = ref(route.query.hasil_sla || '-')

const activeTab = ref('informasi')


// Loading states
const isLoading = ref(true)
const isDataLoaded = ref(false)

// Cache untuk mencegah API calls berulang
const dataCache = ref(null)

// Computed properties untuk optimasi
const pelayananData = computed(() => ({
  deskripsi: deskripsi.value,
  pesanPengelola: pesanPengelola.value,
  organisasi: organisasi.value,
  surat_dinas: surat_dinas.value,
  lampiran: lampiran.value,
  src_HasilPemenuhan: src_HasilPemenuhan.value,
  src_HasilBA: src_HasilBA.value,
  src_HasilSLA: src_HasilSLA.value,
  jenis_pelayanan: jenis_pelayanan.value,
  nama_depanPengaju: nama_depanPengaju.value,
  nama_belakangPengaju: nama_belakangPengaju.value,
  nama_depanTeknis: nama_depanTeknis.value,
  nama_belakangTeknis: nama_belakangTeknis.value,
  perihal: perihal.value,
  tanggal: tanggal.value,
  steps: steps.value,
  stepsStatus: stepsStatus.value,
  rating: rating.value,
  reviewText: reviewText.value
}))

// Fungsi untuk fetch data dengan caching
const fetchPelayananData = async () => {
  if (dataCache.value && dataCache.value.id === pelayananId.value) {
    // Gunakan data dari cache
    const cached = dataCache.value
    deskripsi.value = cached.deskripsi
    pesanPengelola.value = pesanPengelola.deskripsi
    organisasi.value = cached.organisasi
    surat_dinas.value = cached.surat_dinas
    lampiran.value = cached.lampiran
    src_HasilPemenuhan.value = cached.src_HasilPemenuhan
    src_HasilBA.value = cached.src_HasilBA
    src_HasilSLA.value = cached.src_HasilSLA
    jenis_pelayanan.value = cached.jenis_pelayanan
    nama_depanPengaju.value = cached.nama_depanPengaju
    nama_belakangPengaju.value = cached.nama_belakangPengaju
    nama_depanTeknis.value = cached.nama_depanTeknis
    nama_belakangTeknis.value = cached.nama_belakangTeknis
    perihal.value = cached.perihal
    tanggal.value = cached.tanggal
    rating.value = cached.rating,
    reviewText.value = cached.reviewText
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
    pesanPengelola.value = pelayananData.Pesan_Pengelola
    organisasi.value = pelayananData.user.user_organisasi.Nama_OPD
    surat_dinas.value = pelayananData.Surat_Dinas_Path
    lampiran.value = pelayananData.Lampiran_Path
    src_HasilPemenuhan.value = pelayananData.Hasil_Pemenuhan_Path || '-'
    src_HasilBA.value = pelayananData.BA_Path || '-'
    src_HasilSLA.value = pelayananData.SLA_Path || '-'
    jenis_pelayanan.value = pelayananData.jenis__pelayanan.Nama_Jenis_Pelayanan
    nama_depanPengaju.value = pelayananData.user.Nama_Depan
    nama_belakangPengaju.value = pelayananData.user.Nama_Belakang
    nama_depanTeknis.value = pelayananData.teknis_pelayanan?.Nama_Depan || ''
    nama_belakangTeknis.value = pelayananData.teknis_pelayanan?.Nama_Belakang || ''
    perihal.value = pelayananData.Perihal
    tanggal.value = pelayananData.created_at
    rating.value = pelayananData.Rating,
    reviewText.value = pelayananData.Isi_Survey
    status.value = pelayananData.ID_Status


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
      pesanPengelola: pesanPengelola.value,
      organisasi: organisasi.value,
      surat_dinas: surat_dinas.value,
      lampiran: lampiran.value,
      jenis_pelayanan: jenis_pelayanan.value,
      nama_depanPengaju: nama_depanPengaju.value,
      nama_belakangPengaju: nama_belakangPengaju.value,
      nama_depanTeknis: nama_depanTeknis.value,
      nama_belakangTeknis: nama_belakangTeknis.value,
      perihal: perihal.value,
      tanggal: tanggal.value,
      rating: rating.value,
      reviewText: reviewText.value,
      steps: steps.value,
      stepsStatus: stepsStatus.value,
      status: status.value
    }

    SuratDinas_Path.value = '/files' + surat_dinas.value
    Lampiran_Path.value = '/files' + lampiran.value
    HasilPemenuhan_Path.value = '/files' + src_HasilPemenuhan.value
    HasilBA_Path.value = '/files' + src_HasilBA.value
    HasilSLA_Path.value = '/files' + src_HasilSLA.value

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

const namaFileHasilPemenuhan = computed(() => {
  if (!src_HasilPemenuhan.value) return 'Tidak ada file'
  const fileName = src_HasilPemenuhan.value.split('/').pop() 
  const parts = fileName.split('_')
  const tanggal = parts[0]
  const waktu = parts[1]
  return `${tanggal}_${waktu}_HasilPemenuhan.pdf`
})

const namaFileHasilBA = computed(() => {
  if (!src_HasilBA.value) return 'Tidak ada file'
  const fileName = src_HasilBA.value.split('/').pop() 
  const parts = fileName.split('_')
  const tanggal = parts[0]
  const waktu = parts[1]
  return `${tanggal}_${waktu}_HasilBA.pdf`
})

const namaFileHasilSLA = computed(() => {
  if (!src_HasilSLA.value) return 'Tidak ada file'
  const fileName = src_HasilSLA.value.split('/').pop() 
  const parts = fileName.split('_')
  const tanggal = parts[0]
  const waktu = parts[1]
  return `${tanggal}_${waktu}_HasilSLA.pdf`
})

const rating = ref(null)
const hoverRating = ref(0)
const reviewText = ref('')
const reviewSubmitted = ref(false)

const messages = ref([
{
    text: "Halo, bagaimana saya bisa membantu?",
    sender: "Admin",
    time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
  }
])

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
            <!-- Informasi Card -->
            <div class="info-card">
              <h3>Informasi Umum</h3>
              <div class="info-row"><strong>Layanan:</strong> <span>{{ jenis_pelayanan }}</span></div>
              <div class="info-row"><strong>No. Tiket:</strong> <span>{{ pelayananId }}</span></div>
              <div class="info-row"><strong>Pengaju:</strong> <span>{{ nama_depanPengaju + ' ' + nama_belakangPengaju }}</span></div>
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

              <!-- Review Section -->
              <div v-if="status !== 3" class="review-section">
                <div v-if="!reviewSubmitted">
                  <h4 class="review-title">Ulasan Anda</h4>
                  <div class="star-rating">
                    <span
                      v-for="star in 5"
                      :key="star"
                      class="star"
                      :class="{ 'filled': star <= (hoverRating || rating) }"
                    >
                      ★
                    </span>
                  </div>
                  <textarea v-model="reviewText" class="review-textarea" placeholder="Bagikan pengalaman Anda..." rows="4" readonly></textarea>
                </div>
                <div v-else class="thank-you-message">
                  <p>Terima kasih! Ulasan Anda telah kami terima.</p>
                </div>
              </div>
            </div> <!-- end info-card -->

            <!-- Chat Card -->
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

              <div class="alasan-tolak" v-if="status === 3">
                <strong>Alasan Penolakan</strong>
                <div class="textarea-row">
                  <textarea class="input" :value="pelayananData.pesanPengelola" placeholder="Alasan Penolakan" rows="5" readonly></textarea>
                </div>
              </div>
              
              <div class="info-row-PelaksanaTeknis" v-if="status !== 3">
                <strong>Nama Pelaksana Teknis:</strong>
                <div>{{ (nama_depanTeknis || 'Belum') + ' ' + (nama_belakangTeknis || 'Tersedia') }}</div>
              </div>

              <div v-if="status !== 3" class="document-links">
                <div class="info-row-docs">
                  <strong>Hasil Pemenuhan</strong>
                  <div v-if="HasilPemenuhan_Path">
                    <a :href="HasilPemenuhan_Path" target="_blank" rel="noopener" style="color: #2196f3; text-decoration: underline;">
                      {{ namaFileHasilPemenuhan }}
                    </a>
                  </div>
                </div>

                <div class="info-row-docs">
                  <strong>Hasil BA</strong>
                  <div v-if="HasilBA_Path">
                    <a :href="HasilBA_Path" target="_blank" rel="noopener" style="color: #2196f3; text-decoration: underline;">
                      {{ namaFileHasilBA }}
                    </a>
                  </div>

                  <div class="info-row-docs">
                    <strong>Hasil SLA</strong>
                    <div v-if="HasilSLA_Path">
                      <a :href="HasilSLA_Path" target="_blank" rel="noopener" style="color: #2196f3; text-decoration: underline;">
                        {{ namaFileHasilSLA }}
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div> <!-- end chat-card -->
          </div> <!-- end layout-container -->
        </div> <!-- end informasi tab -->

        <!-- Tracking Tab -->
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
        </div> <!-- end tracking tab -->
      </div> <!-- end card -->
    </div> <!-- end isDataLoaded -->

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
  border: 4px solid #0D47A1;
  border-top: 4px solid #64B5F6;
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
  width: 12.9rem;
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

/* Informasi */
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

.document-links {
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
  width: 97%;
  border: 1px solid #aaa;
  border-radius: 8px;
  padding: 0.5rem;
  resize: vertical;
  margin-bottom: 1rem;
  background-color: white;
  color: black;
  font-family: poppins, sans-serif;
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

.review-section {
  border-top: 1px solid #eee;
  padding-top: 0.5rem;
}

.review-title {
  font-size: 1.1rem;
  font-weight: 600;
  margin-bottom: 0.5rem;
}

.star-rating {
  display: flex;
  gap: 0.5rem;
  margin-bottom: 1rem;
}

.star {
  font-size: 2rem;
  color: #ccc;
  cursor: pointer;
  transition: color 0.2s;
}

.star.filled {
  color: #ffc107;
}

.review-textarea {
  width: 95%;
  border: 1px solid #ccc;
  border-radius: 8px;
  padding: 0.75rem;
  resize: vertical;
  margin-bottom: 1rem;
  background-color: white;
  color: black;
  font-family: poppins, sans-serif;
}

.thank-you-message {
  margin-top: 1rem;
  padding: 1rem;
  background-color: #e8f5e9;
  color: #2e7d32;
  border-radius: 8px;
  text-align: center;
  font-weight: 500;
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