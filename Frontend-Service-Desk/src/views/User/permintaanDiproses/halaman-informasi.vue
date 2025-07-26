<script setup>
import { ref, onMounted } from 'vue'

const activeTab = ref('tracking')
const currentStep = ref(0) // buat tau 
const messages = ref([
  { text: "Halo, bagaimana saya bisa membantu?", sender: "Admin", time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) },
]) // Sample chat
const newMessage = ref('') // Untuk pesan baru
const selectedFile = ref(null) // Untuk file yang diupload
const fileError = ref('') // Untuk error file

const addMessage = () => {
  if (newMessage.value.trim()) {
    messages.value.push({
      text: newMessage.value,
      sender: "User",
      time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
    })
    newMessage.value = '' // Clear input setelah kirim
  }
}

const handleFileChange = (event) => {
  const file = event.target.files[0]
  if (file) {
    // Check file type
    if (!file.type === 'application/pdf') {
      fileError.value = 'Hanya file PDF yang diperbolehkan.'
      selectedFile.value = null
      event.target.value = '' // Clear input
      return
    }
    // Check file size (8MB = 8 * 1024 * 1024 bytes)
    if (file.size > 8 * 1024 * 1024) {
      fileError.value = 'Ukuran file tidak boleh melebihi 8MB.'
      selectedFile.value = null
      event.target.value = '' // Clear input
      return
    }
    // If valid, update selected file and clear error
    selectedFile.value = file
    fileError.value = ''
    // Update file name display
    const fileNameSpan = document.querySelector('.file-name')
    if (fileNameSpan) fileNameSpan.textContent = file.name || '"Nama File"'
  }
}
</script>

<template>
  <div class="container">
    <!-- Tabs -->
    <div class="tabs">
      <div
        :class="['tab', activeTab === 'informasi' ? 'active-tab-info' : 'inactive-tab']"
        @click="activeTab = 'informasi'"
      >
        Informasi
      </div>
      <div
        :class="['tab', activeTab === 'tracking' ? 'active-tab-track' : 'inactive-tab']"
        @click="activeTab = 'tracking'"
      >
        Tracking
      </div>
    </div>

    <!-- Card -->
    <div class="card">
      <h2>Detail Permintaan</h2>
      <div class="main-grid">
        <!-- Left Column -->
        <div class="info-card">
          <h3>Informasi Umum</h3>
          <div class="info-row"><strong>Layanan</strong> <span>"Nama Layanan"</span></div>
          <div class="info-row"><strong>No. Tiket</strong> <span>"Nomor Tiket"</span></div>
          <div class="info-row"><strong>PIC</strong> <span>Nama PIC</span></div>
          <div class="info-row"><strong>Organisasi</strong> <span>Asal Dinas</span></div>
          <div class="info-row"><strong>Tanggal Laporan</strong> <span>Tanggal / Waktu</span></div>
          <div class="info-row"><strong>Perihal</strong> <span>"Perihal"</span></div>
          <div class="info-row textarea-row">
            <strong>Deskripsi User</strong>
            <textarea placeholder="Deskripsi Pelayanan" rows="5"></textarea>
          </div>
        </div>

        <!-- Right Column -->
        <div class="chat-card">
          <h3>Chat</h3>
          <!-- Chat Content (Grey Box) -->
          <div class="chat-content">
            <div v-for="(message, index) in messages" :key="index" :class="['message-bubble', message.sender === 'User' ? 'sent' : 'received']">
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

          <div class="file-upload">
            <label class="file-label">
              <input type="file" accept="application/pdf" @change="handleFileChange" />
            </label>
            <p v-if="fileError" class="error">{{ fileError }}</p>
            <p class="note">(Maximum File size: 8MB)</p>
          </div>

          <button class="send-btn" @click="addMessage">Kirim</button>

          <div class="lampiran">
            <strong>Lampiran</strong>
            <p style="font-size: 0.8rem; color: gray;">(Diurutkan Berdasarkan Waktu Upload)</p>
            <ul>
              <li><a href="#">"Nama File"</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.container {
  width: 100%;
  padding: 24px;
  background-color: #f6f0fc;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  padding: 32px;
  position: relative;
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
  max-width: 800px;
  background-color: white;
  padding: 32px;
  border-radius: 12px;
  border-top-left-radius: 0px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

h2 {
  margin-top: 0;
  margin-bottom: 1rem;
}

.main-grid {
  display: grid;
  grid-template-columns: 1.5fr 1fr;
  gap: 2rem;
}

.info-card,
.chat-card {
  background-color: white;
  padding: 1rem;
  border-radius: 12px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

.info-card h3,
.chat-card h3 {
  margin-top: 0;
  font-weight: bold;
}

.info-row {
  display: flex;
  padding: 0.8rem 0;
}

.info-row strong {
  width: 15rem; /* Fixed width untuk label sebagai tab stop */
  text-align: left;
  flex-shrink: 0; /* Untuk menghindari label dari menyusut */
}

.info-row span {
  text-align: left; /* tab stop*/
  margin-left: 10px; /* Memberi jarak label dan value */
  flex-grow: 1; /* Untuk membuat value dapat mengambil sisa ruang */
}

.textarea-row {
  flex-direction: column;
  align-items: start;
}

.textarea-row textarea {
  width: 94%;
  margin-top: 0.5rem;
  padding: 0.5rem;
  border-radius: 8px;
  border: 1px solid #ccc;
  resize: vertical;
}

.chat-card .message {
  width: 94%;
  border: 1px solid #aaa;
  border-radius: 8px;
  padding: 0.5rem;
  resize: vertical;
  margin-bottom: 1rem;
}

.chat-content {
  background-color: #e0e0e0; /* Grey box untuk chat */
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

.message-text {
  display: block;
}

.message-time {
  display: block;
  font-size: 0.6rem;
  color: #666;
  text-align: right;
  margin-top: 7px;
}

.sent .message-time{
  color: #fff;
  font-size: 0.6rem;
  text-align: right;
  margin-top: 7px;
}

.file-upload {
  display: flex;
  flex-direction: column;
  gap: 0.3rem;
  margin-bottom: 1rem;
}

.file-label {
  background: #eee;
  padding: 0.5rem;
  border-radius: 6px;
  cursor: pointer;
  display: inline-block;
}

.file-name {
  font-style: italic;
}

.note {
  color: red;
  font-size: 0.7rem;
  margin-top: -0.3rem;
}

.error {
  color: red;
  font-size: 0.8rem;
  margin-top: 0.2rem;
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

.lampiran {
  font-size: 0.9rem;
  color: #2196f3;
  margin-top: 1.5rem;
}

.lampiran a {
  color: #2196f3;
  text-decoration: none;
}
</style>