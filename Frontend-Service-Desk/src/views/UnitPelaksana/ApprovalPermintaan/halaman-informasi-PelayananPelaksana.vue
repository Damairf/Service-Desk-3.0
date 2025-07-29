<script setup>
import { ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'
const router = useRouter()
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
//pesan dari si pengelola
const pesanPengelola = ref('wowok love owi')

const SuratDinas_Path = ref(null)
const src_SuratDinas = ref(route.query.surat_dinas || '-')
const Lampiran_Path = ref(null)
const src_Lampiran = ref(route.query.lampiran || '-')

const pelaksana = ref([])
const idUnitTerpilih = ref('')
const insiden = ref('')


// === Untuk Tombol Setuju ===
const pilihan = ref('')
function handlePilihan(klik){
  pilihan.value = klik
}

const token = localStorage.getItem('Token');
axios.get('http://127.0.0.1:8000/api/pelayanan/unit', {
  headers: {
    Authorization: 'Bearer ' + token
  }
})
.then(response => {
  pelaksana.value = response.data.map(item => ({
    id_user: item.ID_User,
    nama_depan: item.Nama_Depan,
    nama_belakang: item.Nama_Belakang
  }));  
  idUnitTerpilih.value = '';
})
.catch(error => {
  console.error(error); 
});

function handleSelesai() {
  if (pilihan.value === 'Setuju') {
    
  const token = localStorage.getItem('Token');
  axios.put(`http://127.0.0.1:8000/api/pelayanan/setuju/${pelayananId.value}`, 
  {
    ID_Unit: idUnitTerpilih.value,
    ID_Status: 2,
    Insiden: insiden.value
  }
  , {
    headers: {
      Authorization: 'Bearer ' + token,
    }
  })
  router.push('/pelayanan')

  } else if (pilihan.value === 'Revisi') {


    // mungkin diganti jadi /revisi???
  const token = localStorage.getItem('Token');
  axios.put(`http://127.0.0.1:8000/api/pelayanan/tolak/${pelayananId.value}`, 
  {
    Insiden: insiden.value,
    ID_Status: 3,
    ID_Unit: null
  }
  , {
    headers: {
      Authorization: 'Bearer ' + token,
    }
  })
  router.push('/pelayanan')
  }
}

//  ambil URL dari backend
SuratDinas_Path.value = 'http://localhost:8000/' + src_SuratDinas.value
Lampiran_Path.value = 'http://localhost:8000/' + src_Lampiran.value

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
      </div>
      <div v-if="SuratDinas_Path">
        <a :href="SuratDinas_Path" target="_blank" rel="noopener" style="color: #2196f3; text-decoration: underline;">
          Surat Dinas
        </a>
      </div>
      <div v-if="Lampiran_Path">
        <a :href="Lampiran_Path" target="_blank" rel="noopener" style="color: #2196f3; text-decoration: underline;">
          Lampiran
        </a>
      </div>
      <div class="info-row textarea-row">
        <strong>Pesan dari Pengelola</strong>
        <textarea class="input" v-model="pesanPengelola" placeholder="Pesan dari Pengelola" rows="5" readonly></textarea>
      </div>
    </div>
    <div class="container-kanan">
      <div class="chat-card">
      <h3>Chat</h3>
      <div class="chat-content">
        <div
          v-for="(message, index) in messages"
          :key="index"
          :class="['message-bubble', message.sender === 'User' ? 'sent' : 'received']"
        >
          <span class="message-text">{{ message.text + " " }}</span>
          <span class="message-time">{{ message.time + " " }}</span>
        </div>
      </div>

      <textarea
        v-model="newMessage"
        class="message"
        placeholder="Pesan"
        @keyup.enter="addMessage"
      ></textarea>

      <button class="send-btn" @click="addMessage">Kirim</button>
    </div>

    <div class="tinjau-card">
      <h3>Tinjau Pelayanan</h3>
      <div class='wrapper-setuju'>
        <h4>Unit Pelaksana Teknis</h4>
        <select id="status" v-model="idUnitTerpilih">
          <option value="" disabled>Pilih Unit Pelaksana Teknis</option>
          <option v-for="option in pelaksana" :key="option.id_user" :value="option.id_user">
            {{ option.nama_depan }} {{ option.nama_belakang }}
          </option>
        </select>
        <h4>Pesan untuk Unit Pelaksana Teknis</h4>
        <textarea class="input" v-model="insiden"></textarea>
        <button class="btn-selesai" @click="handleSelesai">Selesai</button>
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
/* container kanan */
.container-kanan{
  display: flex;
  flex-direction: column;
  gap: 2rem;
  width: 40%;
}
.info-card,
.chat-card {
  background-color: white;
  padding: 1.5rem;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
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
  width: 100%;
  margin-top: 0.5rem;
  padding: 0.5rem;
  border-radius: 8px;
  border: 1px solid #ccc;
  resize: vertical;
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

.input{
  background-color: white;
  color: black;
}

/* tinjau */
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
select {
  padding: 0.5rem;
  border-radius: 8px;
  border: 1px solid #ccc;
  color: black;
  background-color: white;
}
.btn-revisi{
  color: white;
  background-color: #9b59b6;
  border-radius: 12px;
  padding: 0.5rem 2.5rem;
  border: none;
  cursor: pointer;
}
.btn-revisi:hover{
  background-color: #8e44ad;
  transform: scale(1.02);
}
.wrapper-setuju {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
  align-self: flex-start;
}
.wrapper-revisi{
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
</style>
