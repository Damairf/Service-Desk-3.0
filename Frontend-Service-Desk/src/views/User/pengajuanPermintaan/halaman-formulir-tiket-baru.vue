<script setup>
import { ref } from 'vue'

const layanan = ref('')
const perihal = ref('')
const nip = ref('')
const deskripsi = ref('')
const suratDinas = ref(null)
const lampiran = ref(null)

function handleFileChange(e, field) {
  const file = e.target.files[0]
  const maxSize = 8 * 1024 * 1024 // 8MB

  if (!file) return

  // ❌ Cek tipe file bukan PDF
  if (file.type !== 'application/pdf') {
    alert('❌ Hanya file PDF yang diperbolehkan.')
    e.target.value = ''
    return
  }

  // ❌ Cek ukuran file lebih dari 8MB
  if (file.size > maxSize) {
    alert('❌ Ukuran file melebihi 8MB. Silakan pilih file yang lebih kecil.')
    e.target.value = ''
    return
  }

  // ✅ Simpan file
  if (field === 'suratDinas') {
    suratDinas.value = file
  } else if (field === 'lampiran') {
    lampiran.value = file
  }
}

function handleSubmit() {
  console.log('Form data:', {
    layanan: layanan.value,
    perihal: perihal.value,
    nip: nip.value,
    deskripsi: deskripsi.value,
    suratDinas: suratDinas.value,
    lampiran: lampiran.value,
  })
  alert('Form berhasil dikirim (dummy)')
}
</script>

<template>
  <div class="form-container">
    <div class="form-card">
      <div class="form-title">Formulir Tiket Baru</div>

      <div class="info-box">
      <strong>Persyaratan Pelayanan:</strong> <br />
      <p>Siapkan surat permohonan (khusus untuk layanan infrastruktur), serta gambar atau file pendukung untuk memperjelas pelaporan.</p>
    </div>

      <form @submit.prevent="handleSubmit">
        <label>Layanan</label>
        <select v-model="layanan">
          <option disabled value="">Nama Layanan</option>
          <option>Layanan A</option>
          <option>Layanan B</option>
          <option>Layanan C</option>
        </select>

        <label>Perihal</label>
        <input type="text" v-model="perihal" />

        <label>Nomor NIP</label>
        <input type="text" v-model="nip" />

        <label>Deskripsi</label>
        <textarea v-model="deskripsi" rows="5"></textarea>

        <label>Surat Dinas</label>
        <input type="file" accept=".pdf" @change="handleFileChange($event, 'suratDinas')" />
        <p class="note">(Hanya PDF, maksimum 8MB)</p>

        <label>Lampiran</label>
        <input type="file" accept=".pdf" @change="handleFileChange($event, 'lampiran')" />
        <p class="note">(Hanya PDF, maksimum 8MB)</p>

        <button type="submit">Kirim</button>
      </form>
    </div>
  </div>
</template>

<style scoped>
.form-container {
  background-color: #f4f0fb;
  min-height: 100vh;
  padding: 2rem;
  display: flex;
  justify-content: center;
  align-items: start;
}

.form-card {
  background: white;
  border-radius: 15px;
  width: 100%;
  max-width: 600px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
  overflow: hidden;
}

.form-title {
  background-color: #419A4C;
  color: white;
  padding: 1rem;
  text-align: center;
  font-weight: bold;
  font-size: 1.2rem;
}

form {
  padding: 2rem;
}

label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: 600;
}



input[type="text"],
select,
textarea,
input[type="file"] {
  width: 95%;
  padding: 0.7rem;
  margin-bottom: 1rem;
  border-radius: 5px;
  border: 1px solid #ccc;
}

textarea {
  resize: vertical;
  border: 2px solid #4285f4;
}

.note {
  color: red;
  font-size: 0.75rem;
  margin-top: -0.8rem;
  margin-bottom: 1rem;
}

button {
  background-color: #3ba0f3;
  color: white;
  padding: 0.7rem 2rem;
  border: none;
  border-radius: 999px;
  font-weight: bold;
  font-size: 1rem;
  cursor: pointer;
  display: block;
  margin: 2rem auto 0;
}

.info-box {
  background-color: #fff8b1;
  border: 1px solid #e6cc00;
  padding: 1rem;
  border-radius: 8px;
  margin-bottom: -0.8rem;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.info-box p {
  font-size: small;
  font-weight: 500;
  margin: 2px;
}

</style>
