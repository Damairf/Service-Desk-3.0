<script setup>
import { ref } from 'vue'

// === Placeholder variabel backend ===
const layanan = ref(localStorage.getItem('layanan') || 'Nama Layanan')
const noTiket = ref(localStorage.getItem('no_tiket') || 'Nomor Tiket')
const pic = ref(localStorage.getItem('pic') || 'Nama PIC')
const organisasi = ref(localStorage.getItem('organisasi') || 'Asal Dinas')
const tanggalLaporan = ref(localStorage.getItem('tanggal_laporan') || 'Tanggal / Waktu')
const perihal = ref(localStorage.getItem('perihal') || 'Perihal')
const deskripsiUser = ref(localStorage.getItem('deskripsi') || '')

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
      <div class="info-row"><strong>PIC</strong> <span>{{ pic }}</span></div>
      <div class="info-row"><strong>Organisasi</strong> <span>{{ organisasi }}</span></div>
      <div class="info-row"><strong>Tanggal Laporan</strong> <span>{{ tanggalLaporan }}</span></div>
      <div class="info-row"><strong>Perihal</strong> <span>{{ perihal }}</span></div>
      <div class="info-row textarea-row">
        <strong>Deskripsi User</strong>
        <textarea class="input" v-model="deskripsiUser" placeholder="Deskripsi Pelayanan" rows="5"></textarea>
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
          <span class="message-text">{{ message.text }}</span>
          <span class="message-time">{{ message.time }}</span>
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

</style>
