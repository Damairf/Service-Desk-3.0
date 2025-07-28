<script setup>
import { ref, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'

const router = useRouter()
const route = useRoute() // untuk ambil params ID 

// ambil dari route organisasi
const namaPerangkatDaerah = ref(route.query.nama_PerangkatDaerah || '')
const indukPerangkatDaerah = ref(route.query.induk_PerangkatDaerah || '')
const email = ref(route.query.email || '')
const status = ref(route.query.status || '')
const namaPengelola = ref('') // ambil dari Backend soalnya gk ada di organisasi.vue
// === Ambil data awal ketika halaman dibuka ===
onMounted(() => {
  const orgId = route.params.id // contoh: /edit-organisasi/:id
  console.log('Edit ID:', orgId)

  // === Backend

})

// === Submit handler (kirim data edit) ===
function handleSubmit() {
  // Validasi field wajib
  if (!nama_PerangkatDaerah.value || !email.value || !status.value) {
    alert('Harap isi semua field yang bertanda *')
    return
  }

  // Payload untuk backend
  const payload = {
    namaPerangkatDaerah: namaPerangkatDaerah.value,
    indukPerangkatDaerah: indukPerangkatDaerah.value,
    namaPengelola: namaPengelola.value,
    nomorHP: nomorHP.value,
    email: email.value,
    status: status.value
  }

  console.log('Data yang akan diupdate ke backend:', payload)

  // === Backend: update organisasi by ID ===
  // backend: axios.put(`/api/organisasi/${route.params.id}`, payload)

  alert('Organisasi berhasil diperbarui')
  router.push('/lembaga') // kembali ke daftar lembaga
}

// === Reset form ===
function handleReset() {
  namaPerangkatDaerah.value = ''
  indukPerangkatDaerah.value = ''
  namaPengelola.value = ''
  nomorHP.value = ''
  email.value = ''
  status.value = ''
}
</script>

<template>
  <div class="page-bg">
    <h1 class="main-title">Edit Organisasi</h1>
    <div class="form-card">
      <div class="form-card-header">
        Formulir Ubah Organisasi
      </div>

      <form class="form-content" @submit.prevent="handleSubmit">
        <div class="form-note">
          <span class="required-text">Keterangan <span class="red">*</span> Harus Diisi</span>
        </div>

        <div class="form-group">
          <label>Nama Perangkat Daerah<span class="red">*</span></label>
          <input type="text" placeholder="Nama PD" v-model="namaPerangkatDaerah" />
        </div>

        <div class="form-group">
          <label>Induk Perangkat Daerah</label>
          <select v-model="indukPerangkatDaerah">
            <option value="">--Pilih Induk Organisasi--</option>
            <option value="Diskominfo">Diskominfo</option>
            <option value="BPKAD">BPKAD</option>
            <option value="Setda">Setda</option>
          </select>
        </div>

        <div class="form-group">
          <label>Nama Pengelola</label>
          <input type="text" v-model="namaPengelola" />
        </div>

        <div class="form-group">
          <label>Email <span class="red">*</span></label>
          <input type="email" v-model="email" />
        </div>

        <div class="form-group">
          <label>Status<span class="red">*</span></label>
          <input type="text" v-model="status" />
        </div>

        <div class="form-actions">
          <button type="submit" class="btn simpan">Simpan</button>
          <button type="button" class="btn hapus" @click="handleReset">Hapus</button>
        </div>
      </form>
    </div>
  </div>
</template>

<style scoped>
.page-bg {
  min-height: 100vh;
  background: #f6f0fa;
  padding: 2rem 0;
}
.main-title {
  font-size: 2.4rem;
  font-weight: bold;
  margin: 0 0 1.5rem 2.5rem;
  color: #111;
  letter-spacing: -1px;
}
.form-card {
  background: #fff;
  border-radius: 16px;
  max-width: 700px;
  margin: 0 auto 2rem auto;
  box-shadow: 0 2px 12px rgba(0,0,0,0.07);
  border: 3px solid #bdbdbd;
  overflow: hidden;
}
.form-card-header {
  background: #bdbdbd;
  color: #fff;
  font-size: 1.3rem;
  font-weight: 600;
  text-align: center;
  padding: 1.2rem 0;
  letter-spacing: 1px;
}
.form-content {
  padding: 2rem 2rem 2.5rem 2rem;
  background: #fff;
}
.form-note {
  margin-bottom: 1.2rem;
}
.required-text {
  color: #e60000;
  font-weight: 600;
  font-size: 1.1rem;
}
.red {
  color: #e60000;
}
.form-group {
  margin-bottom: 1.1rem;
  display: flex;
  flex-direction: column;
}
.form-group label {
  font-weight: 500;
  margin-bottom: 0.4rem;
  color: #222;
}
.form-group input,
.form-group select {
  padding: 0.6rem 1rem;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 1rem;
  background: #fafafa;
  transition: border 0.2s;
  color: black;
}
.form-group input:focus,
.form-group select:focus {
  border: 1.5px solid #2196f3;
  outline: none;
}
.form-actions {
  display: flex;
  justify-content: center;
  gap: 1.2rem;
  margin-top: 2.2rem;
}
.btn {
  padding: 0.7rem 2.2rem;
  border: none;
  border-radius: 2rem;
  font-size: 1.2rem;
  font-weight: 500;
  cursor: pointer;
  color: #fff;
  transition: background 0.2s;
}
.btn.simpan {
  background: #2da8e2;
}
.btn.simpan:hover {
  background: #1976d2;
}
.btn.hapus {
  background: #c62828;
}
.btn.hapus:hover {
  background: #a31515;
}
</style>