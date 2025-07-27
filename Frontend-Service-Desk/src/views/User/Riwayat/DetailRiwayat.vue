<script setup>
import { ref } from 'vue'
import { useRoute } from 'vue-router'
const route = useRoute()
const ticketId = ref(route.query.layanan || '')
</script>

<template>
    <div class="detail-container">
      <div class="tab-header">
        <div class="tab active">Informasi</div>
      </div>
      <div class="main-card">
        <h1 class="main-title">Detail Permintaan</h1>
        <div class="content-grid">
          <!-- Left: Informasi Umum -->
          <div class="info-card">
            <h2>Informasi Umum</h2>
            <div class="info-row"><span class="label">Layanan</span><span class="value">"Nama Layanan"</span></div>
            <div class="info-row"><span class="label">No. Tiket</span><span class="value">{{ ticketId }}</span></div>
            <div class="info-row"><span class="label">PIC</span><span class="value">Nama PIC</span></div>
            <div class="info-row"><span class="label">Organisasi</span><span class="value">Asal Dinas</span></div>
            <div class="info-row"><span class="label">Tanggal Laporan</span><span class="value">Tanggal / Waktu</span></div>
            <div class="info-row"><span class="label">Perihal</span><span class="value">"Perihal"</span></div>
            <div class="info-row align-top">
              <span class="label">Deskripsi User</span>
              <textarea class="desc-textarea" readonly>Deskripsi Pelayanan</textarea>
            </div>
          </div>
          <!-- Right: Chat History -->
          <div class="chat-card">
            <h2>Chat History</h2>
            <div class="chat-history"></div>
            <input class="chat-input" type="text" placeholder="Pesan" readonly />
            <div class="attachment-section">
              <span class="attachment-title">Lampiran <span class="attachment-desc">(Diurutkan Berdasarkan Waktu Upload)</span></span>
              <ul>
                <li><a href="#" class="file-link">"Nama File"</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>

<style scoped>
.detail-container {
  background: #f6f0fa;
  min-height: 100vh;
  padding: 2rem 0;
}
.tab-header {
  margin-left: 2rem;
  margin-bottom: 0;
}
.tab {
  display: inline-block;
  background: #fff;
  padding: 0.7rem 2.2rem;
  border-radius: 12px 12px 0 0;
  font-weight: 500;
  color: #222;
  box-shadow: 0 2px 6px rgba(0,0,0,0.07);
}
.tab.active {
  background: #fff;
  color: #222;
}
.main-card {
  background: #fff;
  border-radius: 18px;
  max-width: 1200px;
  margin: 0 auto;
  box-shadow: 0 4px 16px rgba(0,0,0,0.10);
  padding: 2.5rem 2rem;
}
.main-title {
  font-size: 2rem;
  font-weight: bold;
  margin-bottom: 1.5rem;
  color: #111;
}
.content-grid {
  display: flex;
  gap: 2rem;
}
.info-card, .chat-card {
  background: #fafafa;
  border-radius: 14px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.07);
  padding: 2rem 1.5rem;
  flex: 1;
  min-width: 0;
  border: 2px solid #e0e0e0;
  display: flex;
  flex-direction: column;
}
.info-card h2, .chat-card h2 {
  font-size: 1.1rem;
  font-weight: bold;
  margin-bottom: 1.2rem;
}
.info-row {
  display: flex;
  margin-bottom: 1.1rem;
  gap: 1.5rem;
}
.info-row.align-top {
  align-items: flex-start;
}
.label {
  width: 160px;
  font-weight: 500;
  color: #222;
  flex-shrink: 0;
}
.value {
  color: #222;
}
.desc-textarea {
  width: 350px;
  min-height: 90px;
  border-radius: 12px;
  border: 1.5px solid #ccc;
  padding: 0.7rem 1rem;
  background: #ededed;
  color: #222;
  resize: none;
  font-size: 1rem;
}
.chat-card {
  display: flex;
  flex-direction: column;
  align-items: stretch;
}
.chat-history {
  background: #d9d9d9;
  border-radius: 8px;
  min-height: 140px;
  margin-bottom: 1rem;
}
.chat-input {
  border: 1.5px solid #ccc;
  border-radius: 8px;
  padding: 0.7rem 1rem;
  margin-bottom: 1rem;
  font-size: 1rem;
  background: #fff;
  color: #222;
}
.attachment-section {
  background: #fff;
  border-radius: 8px;
  padding: 1rem;
  margin-top: 1rem;
  border: 1px solid #e0e0e0;
}
.attachment-title {
  color: #2196f3;
  font-weight: 600;
}
.attachment-desc {
  color: #888;
  font-size: 0.9rem;
  font-weight: 400;
  margin-left: 0.3rem;
}
.file-link {
  color: #2196f3;
  text-decoration: underline;
  font-weight: 500;
}
@media (max-width: 900px) {
  .content-grid {
    flex-direction: column;
    gap: 1.5rem;
  }
  .desc-textarea {
    width: 100%;
  }
}
</style>