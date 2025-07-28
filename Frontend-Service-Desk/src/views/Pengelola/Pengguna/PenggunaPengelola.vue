<script setup>
import { ref, computed, watch } from 'vue'

const isLoading = ref(true)
// === backend ===
const daftarPengguna = ref([
  { id: 'U001', nama: 'Wowok1 Wowok', role: 'User', organisasi: 'Yapping', status: 'Aktif' },
  { id: 'U002', nama: 'Say Full', role: 'Admin', organisasi: 'Yapping', status: 'Aktif' },
  { id: 'U003', nama: 'Joke Oh we', role: 'User', organisasi: 'Yapping', status: 'Nonaktif' },
  { id: 'U004', nama: 'Pro Bro oh', role: 'Kepala Dinas', organisasi: 'Banana', status: 'Aktif' },
  { id: 'U005', nama: 'Banana haTub', role: 'User', organisasi: 'Banana', status: 'Nonaktif' },
])
// === Buat Search ===
const search = ref('')
const sortKey = ref('')
const sortOrder = ref('asc')
const currentPage = ref(1)
const itemsPerPage = 10

const filteredItems = computed(() => {
  let items = daftarPengguna.value.filter(item =>
    item.id.toLowerCase().includes(search.value.toLowerCase()) ||
    item.nama.toLowerCase().includes(search.value.toLowerCase()) ||
    item.role.toLowerCase().includes(search.value.toLowerCase()) ||
    item.organisasi.toLowerCase().includes(search.value.toLowerCase())
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

const totalPages = computed(() => {
  return Math.ceil(filteredItems.value.length / itemsPerPage)
})

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
</script>

<template>
  <div class="page-bg">
    <div class="user-card">
      <h1 class="title">Daftar Pengguna</h1>
      <div class="top-actions">
        <button class="btn tambah">Tambah</button>
      </div>
      <div class="search-bar">
        <i class="fas fa-search"></i>
        <input type="text" placeholder="Cari Pengguna" v-model="search" />
      </div>
      <table class="data-table">
        <thead>
          <tr>
            <th @click="sortKey = 'id'">ID</th>
            <th @click="sortKey = 'nama'">Nama</th>
            <th @click="sortKey = 'role'">Role</th>
            <th @click="sortKey = 'organisasi'">Organisasi</th>
            <th @click="sortKey = 'status'">Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(user, index) in paginatedItems" :key="index">
            <td>{{ user.id }}</td>
            <td>{{ user.nama }}</td>
            <td>{{ user.role }}</td>
            <td>{{ user.organisasi }}</td>
            <td>{{ user.status }}</td>
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

.btn.tambah {
  background: #009e3c;
  color: #fff;
  margin-left: auto;
}

.search-bar {
  display: flex;
  align-items: center;
  background: #e9eff1;
  border-radius: 2rem;
  padding: 0.5rem 1.2rem;
  margin-bottom: 1.2rem;
  font-size: 1.1rem;
  color: black;
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
  box-shadow: 0 1px 4px rgba(0,0,0,0.05);
}
.data-table th, .data-table td {
  padding: 0.8rem 1rem;
  text-align: left;
}
.data-table tr:nth-child(even){
  background-color: #f9f9f9;
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