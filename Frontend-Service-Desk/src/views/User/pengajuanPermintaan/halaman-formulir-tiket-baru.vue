<script setup>
import { ref, onMounted, onUnmounted  } from 'vue'
import { useRoute , useRouter } from 'vue-router'
const router = useRouter()
import axios from 'axios'

onUnmounted(() => {
  localStorage.removeItem('ID_Jenis_Pelayanan');
});

// nerima dari pengajuanPermintaan.vue
const route = useRoute()
const layanan = ref(route.query.layanan || '')
const persyaratan = ref(route.query.persyaratan || '')
const namaPelapor = [localStorage.getItem('nama_depan'), localStorage.getItem('nama_belakang')].join(' ');
const id_user = localStorage.getItem('ID_User')
const id_jenis_pelayanan = localStorage.getItem('ID_Jenis_Pelayanan')
const id_status = 1

const perihal = ref('')
const deskripsi = ref('')
const suratDinas = ref('')
const lampiran = ref('')
const suratDinasPath = ref(null)
const lampiranPath = ref(null)
const isSubmitted = ref(false)

// Fungsi untuk menangani perubahan file
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

async function uploadFiles() {
if (!suratDinas.value && !lampiran.value) {
  alert('Harap unggah semua keperluan');
  return false;
}

const token = localStorage.getItem('Token');
const formData = new FormData();
formData.append('surat_dinas', suratDinas.value);
formData.append('lampiran', lampiran.value);

try {
  const response = await axios.post('http://localhost:8000/api/uploadKeperluan', formData, {
    headers: {
      Authorization: 'Bearer ' + token,
      'Content-Type': 'multipart/form-data'
    }
  });

  console.log("RESPON DARI UPLOAD:", response.data);
  suratDinasPath.value = response.data.surat_dinas;
  lampiranPath.value = response.data.lampiran;
  return true;

} catch (error) {
  console.log(error);
  alert('Upload gagal: ' + (error.response?.data?.message || error.message));
  return false;
}
}

async function handleSubmit(){
  if (isSubmitted.value) {
    alert('Permintaan sudah dikirim sebelumnya.');
    return;
  }

const confirmSubmit = window.confirm("Apakah Anda yakin ingin mengirim permintaan ini?");
  if (!confirmSubmit) return;
const uploaded = await uploadFiles()

if (!uploaded) return
const token = localStorage.getItem('Token');
axios.post('http://127.0.0.1:8000/api/pelayanan/tambah', {
  "Nama_Pelapor": namaPelapor.value,
  "ID_User": id_user,
  "ID_Jenis_Pelayanan": id_jenis_pelayanan,
  "ID_Status": id_status,
  "Perihal": perihal.value,
  "Deskripsi": deskripsi.value,
  "Surat_Dinas_Path": suratDinasPath.value,
  "Lampiran_Path": lampiranPath.value,
 },{
  headers: {
    Authorization: 'Bearer ' + token
  }
})
.then(response => {
  isSubmitted.value = true;
  router.push('/permintaanDiproses');
})
.catch(error => {
  console.error(error.response?.data || error.message);
});
}
</script>

<template>
  <div class="form-container">
    <div class="form-card">
      <div class="form-title">Formulir Tiket Baru</div>

      <div class="info-box">
      <strong>Persyaratan Pelayanan:</strong> <br />
      <p>{{ persyaratan }}</p>
    </div>

      <form @submit.prevent="handleSubmit">
        <label>Pelapor</label>
        <input type="text" v-model="namaPelapor" maxlength="50"/>

        <label>Layanan</label>
        <p class="display">{{ layanan }}</p>

        <label>Perihal</label>
        <input type="text" v-model="perihal" maxlength="50"/>

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
  font-family: poppins, sans-serif;
}

form {
  padding: 2rem;
}

.display{
  padding: 0.7rem;
  margin-bottom: 1rem;
  background-color: #f0f0f0;
  border-radius: 5px;
  border: 1px solid #ccc;
  width: 95%;
  font-family: poppins, sans-serif;
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
  cursor:pointer;
  width: 95%;
  padding: 0.7rem;
  margin-bottom: 1rem;
  border-radius: 5px;
  border: 1px solid #ccc;
  background-color: white;
  color: black;
  font-family: poppins, sans-serif;
}

textarea {
  resize: vertical;
  border: 2px solid #4285f4;
  font-family: poppins, sans-serif;
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
  padding: 0.7rem 3rem;
  border: none;
  border-radius: 999px;
  font-weight: bold;
  font-size: 1rem;
  cursor: pointer;
  display: block;
  margin: 2rem auto 0;
  transition: all 0.3s ease;
}

button:hover {
  background-color: #53b2ff;
  box-shadow: 0 4px 8px rgba(59, 160, 243, 0.3);
}

button:active {
  box-shadow: 0 2px 4px rgba(51, 141, 214, 0.3);
}

.info-box {
  background-color: #fff8b1;
  border: 1px solid #e6cc00;
  padding: 1rem;
  border-radius: 0px 0px 8px 8px;
  margin-bottom: -0.8rem;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  font-family: poppins, sans-serif;
}

.info-box p {
  font-size: small;
  font-weight: 500;
  margin: 2px;
  font-family: poppins, sans-serif;
}

</style>