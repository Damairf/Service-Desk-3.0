<script setup>
import { ref, computed } from 'vue'

const searchQuery = ref('')
const currentPage = ref(1)
const rowsPerPage = 4
const fileName = ref('')

const rows = ref([
  { id: 'XXXX', namaDepan: 'Yapping wok', namaBelakang: 'Wowok', role: 'User', organiasi: 'Yapping', status: 'Aktif' },
  { id: 'XXXX', namaDepan: 'Yapping wok', namaBelakang: 'XXXX', role: 'XXXX', organiasi: 'XXXX', status: 'Aktif' },
  { id: 'XXXX', namaDepan: 'Yapping wok', namaBelakang: 'XXXX', role: 'XXXX', organiasi: 'XXXX', status: 'Aktif' },
  { id: 'XXXX', namaDepan: 'Yapping wok', namaBelakang: 'XXX', role: 'XXXX', organiasi: 'XXXX', status: 'Aktif' },
  // ...add more rows as needed
])

const filteredRows = computed(() =>
  rows.value.filter(row =>
    Object.values(row).some(val =>
      String(val).toLowerCase().includes(searchQuery.value.toLowerCase())
    )
  )
)

const totalPages = computed(() =>
  Math.ceil(filteredRows.value.length / rowsPerPage)
)

const paginatedRows = computed(() => {
  const start = (currentPage.value - 1) * rowsPerPage
  return filteredRows.value.slice(start, start + rowsPerPage)
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

function onFileChange(e) {
  fileName.value = e.target.files[0]?.name || ''
}
function uploadFile() {
  alert('Upload logic here')
}
</script>

<template>
    <div class="page-bg">
      <h1 class="main-title">User</h1>
      <div class="user-card">
        <h2 class="section-title">Daftar Pengguna</h2>
        <div class="top-actions">
          <input type="file" @change="onFileChange" />
          <span class="file-label">{{ fileName || 'Tidak Ada File Terpilih' }}</span>
          <button class="btn upload" @click="uploadFile">Upload</button>
          <button class="btn tambah">
            <i class="fas fa-plus-circle"></i> Tambah
          </button>
        </div>
        <div class="excel-export">
          <img src="https://cdn.jsdelivr.net/gh/twitter/twemoji@14.0.2/assets/72x72/1f4c4.png" alt="Excel" class="excel-icon" />
        </div>
        <div class="search-bar">
          <i class="fas fa-search"></i>
          <input type="text" placeholder="Cari" v-model="searchQuery" />
        </div>
        <table class="data-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nama Depan</th>
              <th>Nama Belakang</th>
              <th>Role</th>
              <th>Organisasi</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(row, idx) in paginatedRows" :key="idx">
              <td>{{ row.id }}</td>
              <td>{{ row.namaDepan }}</td>
              <td>{{ row.namaBelakang }}</td>
              <td>{{ row.role }}</td>
              <td>{{ row.organisasi }}</td>
              <td>{{ row.status }}</td>
              <td>
                <button class="icon-btn" title="Edit"><i class="fas fa-edit"></i></button>
                <button class="icon-btn" title="Delete"><i class="fas fa-trash"></i></button>
                <button class="icon-btn" title="Reset"><i class="fas fa-undo"></i></button>
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
.user-card {
  background: #fff;
  border-radius: 20px;
  padding: 2rem;
  max-width: 1200px;
  margin: 0 auto 2rem auto;
  box-shadow: 0 2px 12px rgba(0,0,0,0.07);
}
.section-title {
  font-size: 1.4rem;
  font-weight: bold;
  margin-bottom: 1.2rem;
}
.top-actions {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  margin-bottom: 1.2rem;
}
.file-label {
  margin: 0 0.5rem;
  color: #333;
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
.btn.upload {
  background: #c14421;
  color: #fff;
}
.btn.tambah {
  background: #009e3c;
  color: #fff;
  margin-left: auto;
}
.btn.tambah i {
  font-size: 1.2rem;
}
.excel-export {
  display: flex;
  justify-content: flex-end;
  margin-bottom: 0.5rem;
}
.excel-icon {
  width: 48px;
  height: 48px;
  cursor: pointer;
}
.search-bar {
  display: flex;
  align-items: center;
  background: #e9eff1;
  border-radius: 2rem;
  padding: 0.5rem 1.2rem;
  margin-bottom: 1.2rem;
  font-size: 1.1rem;
}
.search-bar i {
  margin-right: 0.7rem;
  color: #888;
}
.search-bar input {
  border: none;
  background: transparent;
  outline: none;
  width: 100%;
  font-size: 1.1rem;
}
.data-table {
  width: 100%;
  border-collapse: collapse;
  background: #fff;
  border-radius: 10px;
  overflow: hidden;
  margin-bottom: 1.5rem;
  box-shadow: 0 1px 4px rgba(0,0,0,0.04);
}
.data-table th, .data-table td {
  padding: 0.8rem 1rem;
  text-align: left;
}
.data-table th {
  background: #d3d3d3;
  font-weight: 600;
}
.data-table tr {
  border-bottom: 1px solid #eee;
}
.icon-btn {
  background: #f7f7f7;
  border: 1px solid #ccc;
  border-radius: 6px;
  padding: 0.3rem 0.5rem;
  margin-right: 0.2rem;
  cursor: pointer;
  font-size: 1rem;
  color: #222;
  transition: background 0.2s, color 0.2s;
}
.icon-btn:hover {
  background: #e0e0e0;
  color: #c14421;
}
.pagination {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 0.5rem;
}
.pagination button {
  background: #fff;
  border: 1px solid #ddd;
  border-radius: 8px;
  padding: 0.4rem 1rem;
  font-size: 1rem;
  cursor: pointer;
  transition: background 0.2s, color 0.2s;
}
.pagination button.active, .pagination button:focus {
  background: #2196f3;
  color: #fff;
  border: none;
}
.pagination button:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}
</style>