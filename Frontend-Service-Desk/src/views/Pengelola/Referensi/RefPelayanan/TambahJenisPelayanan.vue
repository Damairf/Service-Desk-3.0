<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'
const router = useRouter()

// State untuk form
const namaJenisPelayanan = ref('')
const persyaratan = ref('')
const daftarInputPelayanan = ref([
  { namaYangDipilih: '', dropdownTerbuka: false }
])

// Daftar langkah pelayanan yang tersedia untuk dipilih
const daftarLangkahPelayanan = ref([
  'Pendaftaran', 'Verifikasi Dokumen', 'Pemeriksaan', 'Pembayaran', 'Pengambilan'
])

// State untuk organisasi
const namaPerangkatDaerah = ref('')
const namaPengelola = ref('')
const nomorHP = ref('')
const email = ref('')
const status = ref('')
const pilihanInduk = ref([])
const idOrganisasiTerpilih = ref('')

// Fetch data organisasi
const token = localStorage.getItem('Token')
axios.get('http://127.0.0.1:8000/api/organisasi', {
  headers: {
    Authorization: 'Bearer ' + token
  }
})
.then(response => {
  console.log(response.data)
  pilihanInduk.value = response.data.map(item => ({
    id_organisasi: item.ID_Organisasi,
    nama_PerangkatDaerah: item.Nama_OPD
  }))
})
.catch(error => {
  console.error(error)
})

// Fungsi untuk menambah input baru
function tambahKotakInputBaru() {
  daftarInputPelayanan.value.push({ namaYangDipilih: '', dropdownTerbuka: false })
}

// Mencari langkah pelayanan yang sesuai dengan teks yang diketik
function cariLangkahYangCocok(teksYangDiketik) {
  return daftarLangkahPelayanan.value.filter(namaLangkah =>
    namaLangkah.toLowerCase().includes(teksYangDiketik.toLowerCase())
  )
}

// Ketika langkah pelayanan dipilih dari dropdown
function pilihLangkahDariDropdown(urutanInput, namaLangkahYangDipilih) {
  daftarInputPelayanan.value[urutanInput].namaYangDipilih = namaLangkahYangDipilih
  daftarInputPelayanan.value[urutanInput].dropdownTerbuka = false
}

// Menutup dropdown setelah input kehilangan fokus
function tutupDropdownSetelahFokusHilang(urutanInput) {
  setTimeout(() => {
    daftarInputPelayanan.value[urutanInput].dropdownTerbuka = false
  }, 100)
}

// Submit handler
function handleSubmit() {
  // Validasi field wajib
  if (!namaJenisPelayanan.value || !persyaratan.value || !daftarInputPelayanan.value.some(input => input.namaYangDipilih)) {
    alert('Harap isi semua field yang bertanda *')
    return
  }

  if (nomorHP.value && nomorHP.value.length < 10) {
    alert("Nomor HP minimal 10 digit")
    return
  }

  // Buat payload
  const payload = {
    Nama_OPD: namaPerangkatDaerah.value,
    ID_Induk_Organisasi: idOrganisasiTerpilih.value || null,
    Nama_Pengelola: namaPengelola.value,
    No_HP_Pengelola: nomorHP.value,
    Email: email.value,
    Status: status.value,
    Nama_Jenis_Pelayanan: namaJenisPelayanan.value,
    Persyaratan: persyaratan.value,
    Langkah_Pelayanan: daftarInputPelayanan.value.map(input => input.namaYangDipilih).filter(Boolean)
  }

  console.log('Data yang akan dikirim ke backend:', payload)

  axios.post('http://127.0.0.1:8000/api/organisasi', payload, {
    headers: {
      Authorization: 'Bearer ' + token
    }
  })
  .then(response => {
    console.log(response)
    alert('Jenis Pelayanan sudah ditambahkan')
    router.push('/jabatan')
  })
  .catch(error => {
    console.log(error)
    alert('Gagal menambahkan Jenis Pelayanan')
  })
}

// Reset form
function handleReset() {
  namaJenisPelayanan.value = ''
  persyaratan.value = ''
  daftarInputPelayanan.value = [{ namaYangDipilih: '', dropdownTerbuka: false }]
  namaPerangkatDaerah.value = ''
  idOrganisasiTerpilih.value = ''
  namaPengelola.value = ''
  nomorHP.value = ''
  email.value = ''
  status.value = ''
}
</script>

<template>
  <div class="page-bg">
    <h1 class="main-title">Tambah Jenis Pelayanan</h1>
    <div class="form-card">
      <div class="form-card-header">
        Formulir Tambah Jenis Pelayanan
      </div>

      <form class="form-content" @submit.prevent="handleSubmit">
        <div class="form-note">
          <span class="required-text">Keterangan <span class="red">*</span> Harus Diisi</span>
        </div>

        <div class="form-group">
          <label>Nama Jenis Pelayanan<span class="red">*</span></label>
          <input type="text" placeholder="Nama Jenis Pelayanan" v-model="namaJenisPelayanan" />
        </div>

        <div class="form-group">
          <label>Persyaratan<span class="red">*</span></label>
          <input type="text" placeholder="Persyaratan untuk Jenis Pelayanan" v-model="persyaratan" />
        </div>

        <div v-for="(inputPelayanan, urutanInput) in daftarInputPelayanan" :key="urutanInput" class="form-group dropdown-container">
          <label>Langkah Pelayanan<span class="red">*</span></label>
          <input
            v-model="inputPelayanan.namaYangDipilih"
            @focus="inputPelayanan.dropdownTerbuka = true"
            @blur="tutupDropdownSetelahFokusHilang(urutanInput)"
            placeholder="Ketik atau pilih langkah pelayanan..."
          />
          <ul v-if="inputPelayanan.dropdownTerbuka" class="dropdown">
            <li
              v-for="(namaLangkah, urutanLangkah) in cariLangkahYangCocok(inputPelayanan.namaYangDipilih)"
              :key="urutanLangkah"
              @mousedown="pilihLangkahDariDropdown(urutanInput, namaLangkah)"
            >
              {{ namaLangkah }}
            </li>
          </ul>
        </div>

        <button type="button" class="btn tambah" @click="tambahKotakInputBaru">Tambah Langkah</button>

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
.dropdown-container {
  position: relative;
}
.dropdown {
  position: absolute;
  top: 100%;
  left: 0;
  right: 0;
  border: 1px solid #ccc;
  background: white;
  max-height: 120px;
  overflow-y: auto;
  list-style: none;
  padding: 0;
  margin: 0;
  z-index: 99999;
}
.dropdown li {
  padding: 6px;
  cursor: pointer;
}
.dropdown li:hover {
  background: #eee;
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
.btn.tambah {
  background: #4caf50;
  margin-top: 1rem;
  margin: 1rem auto 0 auto; /* ini bikin tombol ke tengah */
  display: block; /* pastikan tombol jadi block element */
}
.btn.tambah:hover {
  background: #388e3c;
}
</style>