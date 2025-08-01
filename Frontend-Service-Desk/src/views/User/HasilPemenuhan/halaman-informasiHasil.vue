<script setup>
import { ref, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
const router = useRouter()
import axios from 'axios'
const route = useRoute()

function formatDate(dateString) {
  if (!dateString) return '-';
  return new Date(dateString).toLocaleDateString('id-ID');
}

// === Placeholder variabel backend ===
const pelayananId = ref(route.query.layanan || '-')
const layanan = ref(route.query.jenis_pelayanan || '-')
const noTiket = ref(route.query.layanan || '-')
const nama_depan = ref(route.query.nama_depanPengaju || '-')
const nama_belakang = ref(route.query.nama_belakangPengaju || '-')
const organisasi = ref(route.query.organisasi || '-')
const tanggalLaporan = ref(route.query.tanggal || '-')
const perihal = ref(route.query.perihal || '-')
const deskripsiUser = ref(route.query.deskripsi || '-')

const SuratDinas_Path = ref(null)
const src_SuratDinas = ref(route.query.surat_dinas || '-')
const Lampiran_Path = ref(null)
const src_Lampiran = ref(route.query.lampiran || '-')
const HasilPemenuhan_Path = ref(null)
const src_HasilPemenuhan = ref(route.query.hasil_pemenuhan || '-')
const HasilBA_Path = ref(null)
const src_HasilBA = ref(route.query.hasil_ba || '-')
const HasilSLA_Path = ref(null)
const src_HasilSLA = ref(route.query.hasil_sla || '-')

//  ambil URL dari backend
SuratDinas_Path.value = 'http://localhost:8000/' + src_SuratDinas.value
const namaFileSuratDinas = computed(() => {
  const fileName = src_SuratDinas.value.split('/').pop() 
  const parts = fileName.split('_')
  const tanggal = parts[0]
  const waktu = parts[1]
  return `${tanggal}_${waktu}_Surat_Dinas.pdf`
})

Lampiran_Path.value = 'http://localhost:8000/' + src_Lampiran.value
const namaFileLampiran = computed(() => {
  const fileName = src_Lampiran.value.split('/').pop() 
  const parts = fileName.split('_')
  const tanggal = parts[0]
  const waktu = parts[1]
  return `${tanggal}_${waktu}_Lampiran.pdf`
})

HasilPemenuhan_Path.value = 'http://localhost:8000/' + src_HasilPemenuhan.value
const namaFileHasilPemenuhan = computed(() => {
  const fileName = src_HasilPemenuhan.value.split('/').pop() 
  const parts = fileName.split('_')
  const tanggal = parts[0]
  const waktu = parts[1]
  return `${tanggal}_${waktu}_HasilPemenuhan.pdf`
})

HasilBA_Path.value = 'http://localhost:8000/' + src_HasilBA.value
const namaFileHasilBA = computed(() => {
  const fileName = src_HasilBA.value.split('/').pop() 
  const parts = fileName.split('_')
  const tanggal = parts[0]
  const waktu = parts[1]
  return `${tanggal}_${waktu}_HasilBA.pdf`
})

HasilSLA_Path.value = 'http://localhost:8000/' + src_HasilSLA.value
const namaFileHasilSLA = computed(() => {
  const fileName = src_HasilSLA.value.split('/').pop() 
  const parts = fileName.split('_')
  const tanggal = parts[0]
  const waktu = parts[1]
  return `${tanggal}_${waktu}_HasilSLA.pdf`
})

const messages = ref([
  {
    text: "Halo, bagaimana saya bisa membantu?",
    sender: "Admin",
    time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
  }
])

const rating = ref(0)
const hoverRating = ref(0)
const reviewText = ref('')
const reviewSubmitted = ref(false)

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
    // Assuming an endpoint exists to post reviews
    await axios.post(`http://127.0.0.1:8000/api/pelayanan/${pelayananId.value}/review`, {
      rating: rating.value,
      comment: reviewText.value
    }, { headers: { Authorization: 'Bearer ' + token } })
    reviewSubmitted.value = true
  } catch (error) {
    console.error('Gagal mengirim ulasan:', error)
    alert('Gagal mengirim ulasan. Silakan coba lagi.')
  }
}
</script>

<template>
  <div class="layout-container">
    <div class="info-card">
      <h3>Informasi Umum</h3>
      <div class="info-row"><strong>Layanan</strong> <span>{{ layanan }}</span></div>
      <div class="info-row"><strong>No. Tiket</strong> <span>{{ noTiket }}</span></div>
      <div class="info-row"><strong>Pengaju</strong> <span>{{ nama_depan + ' ' + nama_belakang }}</span></div>
      <div class="info-row"><strong>Organisasi</strong> <span>{{ organisasi }}</span></div>
      <div class="info-row"><strong>Tanggal Laporan</strong> <span>{{ formatDate(tanggalLaporan) }}</span></div>
      <div class="info-row"><strong>Perihal</strong> <span>{{ perihal }}</span></div>
      <div class="info-row textarea-row">
        <strong>Deskripsi User</strong>
        <textarea class="input" v-model="deskripsiUser" placeholder="Deskripsi Pelayanan" rows="5" readonly></textarea>
        <strong>Surat Dinas</strong>
        <div v-if="SuratDinas_Path">
        <a :href="SuratDinas_Path" target="_blank" rel="noopener" style="color: #2196f3; text-decoration: underline;">
         {{ namaFileSuratDinas }}
        </a>
      </div>  
      <strong>Lampiran</strong>
      <div v-if="Lampiran_Path">
        <a :href="Lampiran_Path" target="_blank" rel="noopener" style="color: #2196f3; text-decoration: underline;">
          {{ namaFileLampiran }}
        </a>
      </div>
      </div>

      <!-- Review Section -->
      <div class="review-section">
        <div v-if="!reviewSubmitted">
          <h4 class="review-title">Beri Ulasan</h4>
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
          <textarea v-model="reviewText" class="review-textarea" placeholder="Bagikan pengalaman Anda..." rows="4"></textarea>
          <button class="send-btn" @click="submitReview">Kirim Ulasan</button>
        </div>
        <div v-else class="thank-you-message">
          <p>Terima kasih! Ulasan Anda telah kami terima.</p>
        </div>
      </div>
    </div>

    <div class="chat-card">
      <h3>Chat</h3>
      <div class="chat-content">
        <div
          v-for="(message, index) in messages"
          :key="index"
          :class="['message-bubble', message.sender === 'User' ? 'sent' : 'received']"
        >
          <div class="message-text">{{ message.text }}</div>
          <div class="message-time">{{ message.time }}</div>
        </div>
      </div>

      <textarea
        v-model="newMessage"
        class="message"
        placeholder="Pesan"
        @keyup.enter="addMessage"
      ></textarea>

      <button class="send-btn" @click="addMessage">Kirim</button>
      <div class="document-links">
        <div class="info-row">
          <strong>Hasil Pemenuhan</strong>
          <div v-if="HasilPemenuhan_Path">
            <a :href="HasilPemenuhan_Path" target="_blank" rel="noopener" style="color: #2196f3; text-decoration: underline;">
              {{ namaFileHasilPemenuhan }}
            </a>
          </div>
        </div>
        <div class="info-row">
          <strong>Hasil BA</strong>
          <div v-if="HasilBA_Path">
            <a :href="HasilBA_Path" target="_blank" rel="noopener" style="color: #2196f3; text-decoration: underline;">
              {{ namaFileHasilBA }}
            </a>
          </div>
          <div class="info-row">
            <strong>Hasil SLA</strong>
            <div v-if="HasilSLA_Path">
              <a :href="HasilSLA_Path" target="_blank" rel="noopener" style="color: #2196f3; text-decoration: underline;">
                {{ namaFileHasilSLA }}
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.layout-container {
  display: flex;
  gap: 2rem;
  align-items: flex-start;
}

.info-card,
.chat-card {
  background-color: white;
  padding: 1.5rem;
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
  width: 97%;
  margin-top: 0.5rem;
  padding: 0.5rem;
  border-radius: 8px;
  border: 1px solid #ccc;
  resize: vertical;
  background-color: #e6e6e6;
  font-family: poppins, sans-serif;
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

.input{
  background-color: white;
  color: black;
}

.review-section {
  margin-top: 2rem;
  border-top: 1px solid #eee;
  padding-top: 1.5rem;
}

.review-title {
  font-size: 1.1rem;
  font-weight: 600;
  margin-bottom: 1rem;
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
</style>
