<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
const router = useRouter()

// === State untuk form ===
const Nama_Depan = ref('')
const Nama_Belakang = ref('')
const NIP = ref('')
const nomorHP = ref('')
const email = ref('')

// === Submit handler (dengan validasi) ===
function handleSubmit() {
  // Validasi field wajib
  if (!Nama_Belakang.value || !Nama_Belakang.value || !NIP.value || !email.value) {
    alert('Harap isi semua field yang bertanda *')
    return
  }

  // Buat payload
  const payload = {
    Nama_Belakang: Nama_Belakang.value,
    Nama_Depan: Nama_Depan.value,
    NIP: NIP.value,
    nomorHP: nomorHP.value,
    email: email.value
  }

  console.log('Data yang akan dikirim ke backend:', payload)

  // Contoh request backend (aktifkan jika sudah ada API)
  // await axios.post('/api/organisasi', payload)
  alert('Pengguna sudah ditambahkan')
  // Redirect setelah submit sukses
  router.push('/pengguna')
}

// === Reset form ===
function handleReset() {
  Nama_Belakang.value = ''
  Nama_Depan.value = ''
  NIP.value = ''
  nomorHP.value = ''
  email.value = ''
}
</script>

<template>
  <div class="page-bg">
    <h1 class="main-title">Tambah Pengguna</h1>
    <div class="form-card">
      <div class="form-card-header">
        Formulir Tambah Pengguna
      </div>

      <!-- Form pakai @submit.prevent supaya tidak reload -->
      <form class="form-content" @submit.prevent="handleSubmit">
        <div class="form-note">
          <span class="required-text">Keterangan <span class="red">*</span> Harus Diisi</span>
        </div>

        <div class="form-group">
          <label>Nama Depan<span class="red">*</span></label>
          <input type="text" placeholder="Nama Depan" v-model="Nama_Depan" />
        </div>

        <div class="form-group">
          <label>Nama Belakang<span class="red">*</span></label>
          <input type="text" placeholder="Nama Belakang" v-model="Nama_Belakang" />
        </div>

        <div class="form-group">
          <label>NIP<span class="red">*</span></label>
          <input type="text" v-model="NIP" />
        </div>

        <div class="form-group">
          <label>Nomor HP.</label>
          <input type="text" v-model="nomorHP" />
        </div>

        <div class="form-group">
          <label>Email <span class="red">*</span></label>
          <input type="email" v-model="email" />
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