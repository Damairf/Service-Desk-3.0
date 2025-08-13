<script setup>
import { ref, onMounted, onUnmounted, computed, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'

const router = useRouter()
const route = useRoute()

// dummy for insiden
const urgensi = ref([])
const idUrgensiTerpilih = ref('')

// State management
const userId = ref(localStorage.getItem('user_id'));
const pelayananId = ref(route.query.layanan || '-')
const steps = ref([])
const stepsStatus = ref([])
const perihal = ref('') 
const id_user = ref('') 
const tanggal = ref('') 
const nama_pelapor = ref('')
const nama_urgensi = ref('')
const nama_depanTeknis = ref('') 
const nama_belakangTeknis = ref('')
const nama_depanUnit = ref('') 
const nama_belakangUnit = ref('')
const sub_jenis_pelayanan = ref('')
const jenis_pelayanan = ref('')
const deskripsi = ref('')
const surat_dinas = ref('')
const lampiran = ref('')
const organisasi = ref('')
const SuratDinas_Path = ref(null)
const Lampiran_Path = ref(null)
const activeTab = ref('informasi')
const unit = ref([])
const idUnitTerpilih = ref('')
const pesan = ref('')
const status = ref(Number(''))
const progress = ref(null)
const stepsID = ref([]) 

const messages = ref([])

const HasilBA_Path = ref(null)
const HasilSLA_Path = ref(null)
const HasilPemenuhan_Path = ref(null)
const src_HasilPemenuhan = ref('-')
const src_HasilBA = ref('-')
const src_HasilSLA = ref('-')

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
  sub_jenis_pelayanan: sub_jenis_pelayanan.value,
  jenis_pelayanan: jenis_pelayanan.value,
  nama_urgensi: nama_urgensi.value,
  nama_pelapor: nama_pelapor.value,
  nama_depanTeknis: nama_depanTeknis.value,
  nama_belakangTeknis: nama_belakangTeknis.value,
  perihal: perihal.value,
  tanggal: tanggal.value,
  steps: steps.value,
  stepsStatus: stepsStatus.value,
  status: status.value,
  src_HasilPemenuhan: src_HasilPemenuhan.value,
  src_HasilBA: src_HasilBA.value,
  src_HasilSLA: src_HasilSLA.value,
}))

// Fungsi untuk fetch data dengan caching
const fetchPelayananData = async () => {
  if (dataCache.value && dataCache.value.id === pelayananId.value) {
    // Gunakan data dari cache
    const cached = dataCache.value
    deskripsi.value = cached.deskripsi
    organisasi.value = cached.organisasi
    surat_dinas.value = cached.surat_dinas
    src_HasilPemenuhan.value = cached.src_HasilPemenuhan
    src_HasilBA.value = cached.src_HasilBA
    src_HasilSLA.value = cached.src_HasilSLA
    lampiran.value = cached.lampiran
    sub_jenis_pelayanan.value = cached.sub_jenis_pelayanan
    jenis_pelayanan.value = cached.jenis_pelayanan
    nama_urgensi.value = cached.nama_urgensi
    nama_pelapor.value = cached.nama_pelapor
    nama_depanTeknis.value = cached.nama_depanTeknis
    nama_belakangTeknis.value = cached.nama_belakangTeknis
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
    
    const [pelayananResponse, progressResponse, unitResponse, urgensiResponse] = await Promise.all([
      axios.get(`/api/pelayanan/${pelayananId.value}`, {
        headers: { Authorization: 'Bearer ' + token }
      }),
      axios.get(`/api/pelayanan/alur/progress/${pelayananId.value}`, {
        headers: { Authorization: 'Bearer ' + token }
      }),
      axios.get('/api/pelayanan/unit', {
        headers: { Authorization: 'Bearer ' + token }
      }),
      axios.get('/api/urgensi', {
        headers: { Authorization: 'Bearer ' + token }
      })
    ])

    // Set data
    const pelayananData = pelayananResponse.data
    id_user.value = pelayananData.ID_User
    deskripsi.value = pelayananData.Deskripsi
    organisasi.value = pelayananData.user.user_organisasi.Nama_OPD
    surat_dinas.value = pelayananData.Surat_Dinas_Path
    lampiran.value = pelayananData.Lampiran_Path
    sub_jenis_pelayanan.value = pelayananData.sub__jenis__pelayanan.Nama_Sub_Jenis_Pelayanan
    jenis_pelayanan.value = pelayananData.jenis__pelayanan.Nama_Jenis_Pelayanan
    nama_pelapor.value = pelayananData.Nama_Pelapor
    nama_urgensi.value = pelayananData.urgensi_pelayanan?.Nama_Urgensi || 'Belum Ditetapkan'
    nama_depanUnit.value = pelayananData.unit_pelayanan?.Nama_Depan || 'Belum'
    nama_belakangUnit.value = pelayananData.unit_pelayanan?.Nama_Belakang || 'Ditetapkan'
    nama_depanTeknis.value = pelayananData.teknis_pelayanan?.Nama_Depan || 'Belum'
    nama_belakangTeknis.value = pelayananData.teknis_pelayanan?.Nama_Belakang || 'Ditetapkan'
    perihal.value = pelayananData.Perihal
    src_HasilPemenuhan.value = pelayananData.Hasil_Pemenuhan_Path || '-'
    src_HasilBA.value = pelayananData.BA_Path || '-'
    src_HasilSLA.value = pelayananData.SLA_Path || '-'
    tanggal.value = pelayananData.created_at
    status.value = pelayananData.ID_Status
    rating.value = pelayananData.Rating
    reviewText.value = pelayananData.Isi_Survey
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
    stepsID.value = progressData.map(item => item.ID_Progress_Alur)

    // Set unit data
    unit.value = unitResponse.data.map(item => ({
      id_user: item.ID_User,
      nama_depan: item.Nama_Depan,
      nama_belakang: item.Nama_Belakang
    }))
    idUnitTerpilih.value = ''

    // Set urgensi data
    urgensi.value = urgensiResponse.data.map(item => ({
      id_urgensi: item.ID_Urgensi,
      nama_urgensi: item.Nama_Urgensi,
    }))
    idUrgensiTerpilih.value = ''

    // Cache data
    dataCache.value = {
      id: pelayananId.value,
      deskripsi: deskripsi.value,
      organisasi: organisasi.value,
      surat_dinas: surat_dinas.value,
      lampiran: lampiran.value,
      sub_jenis_pelayanan: sub_jenis_pelayanan.value,
      jenis_pelayanan: jenis_pelayanan.value,
      nama_urgensi: nama_urgensi.value,
      nama_pelapor: nama_pelapor.value,
      nama_depanTeknis: nama_depanTeknis.value,
      nama_belakangTeknis: nama_belakangTeknis.value,
      perihal: perihal.value,
      tanggal: tanggal.value,
      steps: steps.value,
      stepsStatus: stepsStatus.value,
      status: status.value
    }

    SuratDinas_Path.value = '/files' + surat_dinas.value
    Lampiran_Path.value = '/files' + lampiran.value
    HasilPemenuhan_Path.value = '/files' + src_HasilPemenuhan.value
    HasilBA_Path.value = '/files' + src_HasilBA.value
    HasilSLA_Path.value = '/files' + src_HasilSLA.value

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
        Pesan_Pengelola: pesan.value,
        ID_Urgensi: idUrgensiTerpilih.value
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


const rating = ref(0)
const hoverRating = ref(0)
const reviewText = ref('')
const reviewSubmitted = ref(false)

const setRating = (newRating) => {
  rating.value = newRating
}

const submitReview = async () => {
  if (rating.value === 0) {
    alert('Mohon berikan rating bintang terlebih dahulu.')
    return
  }
  try {
    const token = localStorage.getItem('Token')
    await axios.put(`/api/pelayanan/survey/${pelayananId.value}`, {
      Rating: rating.value,
      Isi_Survey: reviewText.value,
      ID_Status: 6
    }, { headers: { Authorization: 'Bearer ' + token } })
    reviewSubmitted.value = true
    router.push('/pelayanan')
  } catch (error) {
    console.error('Gagal mengirim ulasan:', error)
    alert('Gagal mengirim ulasan. Silakan coba lagi.')
  }
}

const isImage = (path) => {
  return /\.(jpg|jpeg|png)$/i.test(path);
};

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
              <!-- Review Section -->
              <div v-if="status === 6" class="review-section">
                <div>
                  <h4 class="review-title">Ulasan Pengguna</h4>
                  <div class="star-rating">
                    <span
                      v-for="star in 5"
                      :key="star"
                      class="star"
                      :class="{ 'filled': star <= (rating) }"
                    >
                      ★
                    </span>
                  </div>
                  <textarea v-model="reviewText" class="review-textarea" placeholder="Belum Ada Ulasan" rows="4" readonly></textarea>
                </div>
              </div>
                
              <div v-else-if="status === 5 && userId != id_user" class="review-section">
                <div>
                  <h4 class="review-title">Ulasan Pengguna</h4>
                  <div class="star-rating">
                    <strong style="font-weight: 500;">Belum Ada Ulasan dari Pengguna</strong>
                  </div>
                  <textarea v-model="reviewText" class="review-textarea" placeholder="Belum Ada Ulasan" rows="4" readonly></textarea>
                </div>
              </div>
              <div class="review-section">
              <div v-if="status === 5 && userId == id_user">
                <h4 class="review-title">Ulasan Pengguna</h4>
                <div class="star-rating">
                  <span
                    v-for="star in 5"
                    :key="star"
                    class="star"
                    :class="{ 'filled': star <= (hoverRating || rating) }"
                    @mouseover="hoverRating = star"
                    @mouseleave="hoverRating = 0"
                    @click="setRating(star)"
                  >
                    ★
                  </span>
                </div>
                <textarea v-model="reviewText" class="review-textarea" placeholder="Bagikan pengalaman pengguna..." rows="4"></textarea>
                <button class="send-btn" @click="submitReview">Kirim Ulasan</button>
              </div>
            </div>
            </div>

            <div class="chat-card">
              <h3>Chat</h3>
              <div class="chat-content view-only-chat">
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
              <div class="alasan-tolak" v-if="status === 3">
                <strong>Alasan Penolakan</strong>
                <div class="textarea-row">
                  <textarea class="input" :value="pelayananData.pesanPengelola" placeholder="Alasan Penolakan" rows="5" readonly></textarea>
                </div>
              </div>
              <div v-if="progress" class="teks-tambahan">
                <h4 class="judul-input-tambahan">Urgensi</h4>
                <div>{{ nama_urgensi }}</div>
                <h4 class="judul-input-tambahan">Nama Unit Pelaksana</h4>
                <div>{{ nama_depanUnit + ' ' + nama_belakangUnit }}</div>
                <h4 class="judul-input-tambahan">Nama Pelaksana Teknis</h4>
                <div>{{ nama_depanTeknis + ' ' + nama_belakangTeknis }}</div>
              </div>

              <div v-if="status === 5 || status === 6" class="document-links">
                <div class="info-row-docs">
                  <h4 class="judul-input-tambahan">Hasil Pemenuhan</h4>
                  <div v-if="HasilPemenuhan_Path">
                    <a :href="HasilPemenuhan_Path" target="_blank" rel="noopener" style="color: #2196f3; text-decoration: underline;">
                      {{ namaFileHasilPemenuhan }}
                    </a>
                  </div>
                  <h4 class="judul-input-tambahan">Hasil BA</h4>
                  <div v-if="HasilBA_Path">
                    <a :href="HasilBA_Path" target="_blank" rel="noopener" style="color: #2196f3; text-decoration: underline;">
                      {{ namaFileHasilBA }}
                    </a>
                  </div>  
                  <h4 class="judul-input-tambahan">Hasil SLA</h4>
                  <div v-if="HasilSLA_Path">
                    <a :href="HasilSLA_Path" target="_blank" rel="noopener" style="color: #2196f3; text-decoration: underline;">
                      {{ namaFileHasilSLA }}
                    </a>
                  </div>
                </div>
              </div>

              <div class="tinjau-card" v-if="status === 1">
                <h3>Tinjau Pelayanan</h3>
                <!-- taro link pdfnya disini -->
                <div class="wrapper-btn">
                  <button class="btn-setuju" @click="handlePilihan('Setuju')">Setuju</button>
                  <button class="btn-tolak" @click="handlePilihan('Tolak')">Tolak</button>
                </div>
                <!-- Setuju  -->
                <div class='wrapper-setuju'v-if='pilihan == "Setuju"'>
                  <h4 class="judul-input-tambahan">Urgensi</h4>
                  <select id="urgensi" v-model="idUrgensiTerpilih">
                    <option value="" disabled>Pilih Urgensi</option>
                    <option
                      v-for="option in urgensi"
                      :key="option.id_urgensi"
                      :value="option.id_urgensi"
                    >
                      {{ option.nama_urgensi }}
                    </option>
                  </select>
                  <h4 class="judul-input-tambahan">Unit Pelaksana</h4>
                  <select id="status" v-model="idUnitTerpilih">
                    <option value="" disabled>Pilih Unit Pelaksana</option>
                    <option v-for="option in unit" :key="option.id_user" :value="option.id_user">
                      {{ option.nama_depan }} {{ option.nama_belakang }}
                    </option>
                  </select>
                  <h4 class="judul-input-tambahan">Pesan untuk Unit Pelaksana</h4>
                  <textarea class="textarea-row-tambahan" v-model="pesan" placeholder="Masukkan pesan"></textarea>
                  <button class="btn-selesai-detail" @click="handleSelesai">Selesai</button>
                </div>
                <!-- Tolak -->
                <div class="wrapper-tolak" v-if='pilihan =="Tolak"'>
                  <h4 class="judul-input-tambahan">Alasan Ditolak</h4>
                  <textarea class="textarea-row-tambahan" v-model="pesan" placeholder="Masukkan alasan"></textarea>
                  <button class="btn-selesai-detail" @click="handleSelesai">Selesai</button>
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
  border-radius: 15px;
  padding: 0.5rem 2.5rem;
  border: none;
  cursor: pointer;
  font-family: 'Poppins';
  font-weight: 500;
  transition: transform 0.2s ease;
}
.btn-setuju:hover{
  background-color: #66BB6A;
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
  border-radius: 15px;
  padding: 0.5rem 2.5rem;
  border: none;
  font-family: 'Poppins';
  font-weight: 500;
  cursor: pointer;
}
.btn-tolak:hover{
  background-color: #E53935;
}
.wrapper-tolak{
  display: flex;
  flex-direction: column;
}

.review-section {
  border-top: 1px solid #eee;
}

.review-title {
  font-size: 1.1rem;
  font-weight: 600;
  margin-bottom: 0.5rem;
  margin-top: 0.2rem;
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
  background-color: #e6e6e6;
  color: black;
  font-family: poppins, sans-serif;
}
</style>