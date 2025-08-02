<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useRouter, useRoute } from 'vue-router'

const router = useRouter()
const route = useRoute()

// === State untuk form ===
const Nama_Depan = ref(route.query.nama_depan || '')
const Nama_Belakang = ref(route.query.nama_belakang || '')
const role = ref(route.query.role || '')
const organisasi = ref(route.query.organisasi || '')
const status = ref(route.query.status || '')
const password = ref('')

const pilihanRole = ref([])
const idRoleTerpilih = ref('')

const pilihanJabatan = ref([])
const idJabatanTerpilih = ref('')

const pilihanInduk = ref([])
const idOrganisasiTerpilih = ref('')

const token = localStorage.getItem('Token')

// === Ambil data Role ===
onMounted(async () => {
  try {
    const response = await axios.get('/api/role', {
      headers: { Authorization: 'Bearer ' + token }
    })
    pilihanRole.value = response.data.map(item => ({
      id_role: item.ID_Role,
      nama_role: item.Nama_Role
    }))
    // Set role name based on id if available
    const match = pilihanRole.value.find(r => r.id_role === route.query.id_role)
    if (match) {
      role.value = match.nama_role
      idRoleTerpilih.value = route.query.id_role || ''
    }
  } catch (error) {
    console.error(error)
  }
})
// === Ambil data Jabatan ===
onMounted(async () => {
  try {
    const response = await axios.get('/api/organisasi', {
      headers: { Authorization: 'Bearer ' + token }
    })
    pilihanInduk.value = response.data.map(item => ({
      id_organisasi: item.ID_Organisasi,
      nama_PerangkatDaerah: item.Nama_OPD
    }))
    // Set organisasi name based on id if available
    const match = pilihanInduk.value.find(o => o.id_organisasi === route.query.id_organisasi)
    if (match) {
      organisasi.value = match.nama_PerangkatDaerah
      idOrganisasiTerpilih.value = route.query.id_organisasi || ''
    }
  } catch (error) {
    console.error(error)
  }
})
// === Ambil data Organisasi ===
axios.get('/api/organisasi', {
  headers: { Authorization: 'Bearer ' + token }
})
.then(response => {
  pilihanInduk.value = response.data.map(item => ({
    id_organisasi: item.ID_Organisasi,
    nama_PerangkatDaerah: item.Nama_OPD
  }))

  // Set default sesuai route.query.organisasi
  const match = pilihanInduk.value.find(o => o.nama_PerangkatDaerah === organisasi.value)
  if (match) {
    idOrganisasiTerpilih.value = match.id_organisasi
  }
})
.catch(error => console.error(error))

// === Set Status langsung (karena tidak butuh fetch) ===
// Status sudah otomatis terisi dari v-model="status"

// === Submit handler ===
function handleSubmit() {
  if (!Nama_Depan.value || !Nama_Belakang.value || !NIP.value || !idRoleTerpilih.value || !idJabatanTerpilih.value || !idOrganisasiTerpilih.value || !status.value || !password.value) {
    alert('Harap isi semua kolom yang bertanda *')
    return
  }

  if (NIP.value.length !== 18) {
    alert('NIP harus 18 digit')
    return
  }

  const payload = {
    Nama_Depan: Nama_Depan.value,
    Nama_Belakang: Nama_Belakang.value,
    NIP: NIP.value,
    ID_Role: idRoleTerpilih.value,
    ID_Jabatan: idJabatanTerpilih.value,
    ID_Organisasi: idOrganisasiTerpilih.value,
    Password: password.value,
    Status: status.value
  }

  axios.post('/api/user', payload, {
    headers: { Authorization: 'Bearer ' + token }
  })
  .then(() => {
    alert('Pengguna sudah ditambahkan')
    router.push('/pengguna')
  })
  .catch(error => console.log(error))
}
</script>


<template>
  <div class="page-bg">
    <h1 class="main-title">Detail Pengguna</h1>
    <div class="form-card">
      <div class="form-card-header">
        Informasi Pengguna
      </div>

      <!-- Form pakai @submit.prevent supaya tidak reload -->
      <form class="form-content" @submit.prevent="handleSubmit">
        <div class="form-note">
          <span class="required-text">Keterangan <span class="red">*</span> Harus Diisi</span>
        </div>
            <strong>Nama Depan</strong>
            <p class="display-info">{{ Nama_Depan }}</p>
            <strong>Nama Belakang</strong>
            <p class="display-info">{{ Nama_Belakang }}</p>
            <strong>NIP</strong>
            <p class="display-info">{{ nip }}</p>
            <strong>Role</strong>
            <p class="display-info">{{ role }}</p>
            <strong>Jabatan</strong>
            <p class="display-info">{{ jabatan }}</p>
            <strong>Organisasi</strong>
            <p class="display-info">{{ organisasi }}</p>
            <strong>Status</strong>
            <p class="display-info">{{ status }}</p>
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

.display-info {
  padding: 0.7rem;
  margin-top: 0.25rem;
  margin-bottom: 0.75rem;
  background-color: #f0f0f0;
  border-radius: 5px;
  border: 1px solid #ccc;
  width: 95%;
  display: inline-block;
}
</style>