<script setup>
import { ref, computed, watch, onMounted } from 'vue'
import { useRouter } from 'vue-router';
import axios from 'axios';
const router = useRouter()
const isLoading = ref(true)
// === backend ===

//datanya
const dataOrganisasi = ref([])

//===BACKEND=== (tapi masih murni penggunaPengelola.vue)
const token = localStorage.getItem('Token');
  axios.get('http://127.0.0.1:8000/api/organisasi', {
    headers: {
      Authorization: 'Bearer ' + token
    }
  })
  .then(response => {
    dataOrganisasi.value = response.data.map(item => ({
      id_organisasi: item.ID_Organisasi,
      nama_PerangkatDaerah: item.Nama_OPD,
      id_induk_organisasi: item?.ID_Induk_Organisasi || null,
      induk_PerangkatDaerah: item.induk?.Nama_OPD || '-',
      email: item.Email,
      status: item.Status
    }))
  })
  .catch(error => {
    console.error(error); 
  })
  .finally(() => {
    isLoading.value = false;
  });



// === Search & Sort ===
const search = ref('')
const sortKey = ref('')
const sortOrder = ref('asc')
const currentPage = ref(1)
const itemsPerPage = 10

const filteredItems = computed(() => {
  let items = dataOrganisasi.value.filter(item =>
    item.nama_PerangkatDaerah.toLowerCase().includes(search.value.toLowerCase()) ||
    item.induk_PerangkatDaerah.toLowerCase().includes(search.value.toLowerCase()) ||
    item.email.toLowerCase().includes(search.value.toLowerCase()) ||
    item.status.toLowerCase().includes(search.value.toLowerCase())
  )

  if (sortKey.value) {
    items.sort((a, b) => {
      const valA = a[sortKey.value]?.toString().toLowerCase()
      const valB = b[sortKey.value]?.toString().toLowerCase()
      if (valA < valB) return sortOrder.value === 'asc' ? -1 : 1
      if (valA > valB) return sortOrder.value === 'asc' ? 1 : -1
      return 0
    })
  }

  return items
})

const totalPages = computed(() => Math.ceil(filteredItems.value.length / itemsPerPage))

const paginatedItems = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage
  return filteredItems.value.slice(start, start + itemsPerPage)
})

function prevPage() {
  if (currentPage.value > 1) currentPage.value--
}

function nextPage() {
  if (currentPage.value < totalPages.value) currentPage.value++
}

function goToPage(page) {
  currentPage.value = page
}

watch(search, () => {
  currentPage.value = 1
})



// === Modal Delete ===
const showModal = ref(false)
const idOrganisasiToDelete = ref(null)

function Delete(item) {
  idOrganisasiToDelete.value = item.id_organisasi
  showModal.value = true
}

function cancelDelete() {
  showModal.value = false
  idOrganisasiToDelete.value = null
}

function confirmDelete() {
  const token = localStorage.getItem('Token');
  axios.delete(`http://127.0.0.1:8000/api/organisasi/${idOrganisasiToDelete.value}`, {
  headers: {
      Authorization: 'Bearer ' + token
    }
  })
  .then(() => {
  dataOrganisasi.value = dataOrganisasi.value.filter(
    org => org.id_organisasi !== idOrganisasiToDelete.value
  )
  showModal.value = false
  idOrganisasiToDelete.value = null
})

  .catch(error => {
    console.error(error);
    alert(error.response?.data?.message || 'Terjadi kesalahan saat menghapus organisasi.');
  });
}

const organisasiTerpilih = computed(() =>
  dataOrganisasi.value.find(item => item.ID_Organisasi === idOrganisasiToDelete.value)
)


function editOrganisasi(item) {
  router.push({
    path: '/ubahLembaga',
    query: {
      id_organisasi: item.id_organisasi,
      id_induk_organisasi: item.id_induk_organisasi,
      nama_PerangkatDaerah: item.nama_PerangkatDaerah,
      idOrganisasi: item.induk_PerangkatDaerah,
      email: item.email,
      status: item.status
    }
  })
}
</script>

<template>
  <div class="page-bg">
    <div class="user-card">
      <h1 class="title">Data Lembaga/Organisasi</h1>
      <div class="top-actions">
        <button class="btn tambah" @click="router.push('/tambahLembaga')">Tambah</button>
      </div>
      <input type="text" v-model="search" placeholder="Cari Lembaga/Organisasi" class="search-bar" />
      <table class="data-table">
        <thead>
          <tr>
            <th @click="sortKey = 'nama_PerangkatDaerah'">Nama Perangkat Daerah</th>
            <th @click="sortKey = 'induk_PerangkatDaerah'">Induk Perangkat Daerah</th>
            <th @click="sortKey = 'email'">Email</th>
            <th @click="sortKey = 'status'">Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="isLoading">
            <td colspan="6" style="text-align: center; padding: 1rem;">Memuat data...</td>
          </tr>
          <tr v-else-if="filteredItems.length === 0">
            <td colspan="6" style="text-align: center; padding: 1rem;">Tidak ada lembaga organisasi</td>
          </tr>
          <tr v-for="(item, index) in paginatedItems" :key="index">
            <td>{{ item.nama_PerangkatDaerah }}</td>
            <td>{{ item.induk_PerangkatDaerah }}</td>
            <td>{{ item.email }}</td>
            <td>{{ item.status }}</td>
            <td>
              <div class="wrapper-aksiBtn">
                <button class="aksiEdit-btn" title="Edit" @click="editOrganisasi(user)">Ubah</button>
                <button class="aksiDelete-btn" title="Delete" @click="Delete(user)">Hapus</button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="pagination">
        <button :disabled="currentPage === 1" @click="prevPage">&#60;</button>
        <button
          v-for="page in totalPages"
          :key="page"
          :class="{ active: currentPage === page }"
          @click="goToPage(page)"
        >{{ page }}</button>
        <button :disabled="currentPage === totalPages" @click="nextPage">&#62;</button>
      </div>
    </div>
  </div>

  <!-- Modal Delete -->
  <div v-if="showModal" class="modal-overlay">
    <div class="modal-box">
      <h3>Konfirmasi Hapus</h3>
      <p>
        Apakah Anda yakin ingin menghapus lembaga/organisasi <strong></strong>?
      </p>
      <div class="modal-actions">
        <button class="btn danger" @click="confirmDelete()">Ya, hapus</button>
        <button class="btn" @click="cancelDelete()">Batal</button>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* (CSS sama persis dari kode asli) */
.page-bg {
  min-height: 100vh;
  background: #f6f0fa;
  padding: 2rem 0;
}
.user-card {
  background: #fff;
  border-radius: 20px;
  padding: 2rem;
  max-width: 1200px;
  margin: 0 auto 2rem auto;
  box-shadow: 0 2px 12px rgba(0,0,0,0.07);
}
.title {
  font-size: 28px;
  font-weight: bold;
  margin-bottom: 20px;
  color: #333;
}
.top-actions {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  margin-bottom: 1.2rem;
}
.btn {
  padding: 0.5rem 1.2rem;
  border: none;
  border-radius: 8px;
  font-weight: 500;
  font-size: 1rem;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}
.btn.tambah {
  background: #009e3c;
  color: #fff;
  margin-left: auto;
}
.search-bar {
  width: 100%;
  padding: 10px;
  margin-bottom: 20px;
  border: none;
  border-radius: 13px;
  background-color: #e0e0e0;
  color: black;
  font-size: 14px;
}
.data-table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
  border-radius: 10px;
  overflow: hidden;
  font-size: 14px;
}
.data-table th, .data-table td {
  padding: 12px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}
.data-table tr:nth-child(even){
  background-color: #f9f9f9;
}
.data-table th {
  background-color: #f1f1f1;
}
.data-table tr {
  border-bottom: 1px solid #eee;
}
/* Tombol aksi */
.wrapper-aksiBtn{
  display: flex;
  gap: 3px;
}
.aksiEdit-btn {
  background: #2196f3;
  border: 1px solid #ccc;
  border-radius: 6px;
  padding: 0.3rem 0.5rem;
  margin-right: 0.2rem;
  cursor: pointer;
  font-size: 1rem;
  color: white;
  transition: background 0.2s;
}
.aksiEdit-btn:hover { background: #1976d2; }
.aksiDelete-btn {
  background: #c14421;
  border: 1px solid #ccc;
  border-radius: 6px;
  padding: 0.3rem 0.5rem;
  cursor: pointer;
  font-size: 1rem;
  color: white;
  transition: background 0.2s;
}
.aksiDelete-btn:hover { background: #a63a1d; }
.pagination {
  display: flex;
  justify-content: center;
  gap: 0.5rem;
  margin-top: 20px;
}
.pagination button {
  background: #fff;
  border: 1px solid #ddd;
  border-radius: 8px;
  padding: 0.4rem 1rem;
  cursor: pointer;
  transition: background 0.2s;
}
.pagination button.active { background: #2196f3; color: #fff; border: none; }
.pagination button:disabled { opacity: 0.5; cursor: not-allowed; }
.modal-overlay {
  position: fixed;
  top: 0; left: 0; width: 100%; height: 100%;
  background: rgba(0,0,0,0.5);
  display: flex; justify-content: center; align-items: center;
}
.modal-box {
  background: white;
  padding: 2rem;
  border-radius: 10px;
  max-width: 400px;
  text-align: center;
  box-shadow: 0 4px 12px rgba(0,0,0,0.3);
}
.modal-actions {
  margin-top: 1.5rem;
  display: flex;
  justify-content: center;
  gap: 1rem;
}
.btn.danger {
  background: #e53935;
  color: white;
}
</style>
