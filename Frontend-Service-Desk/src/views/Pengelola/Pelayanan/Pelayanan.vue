<script setup>
import { ref, computed, watch } from 'vue'

//Backend
const layananData = [
  {
    noTiket: "#091212",
    perihal: "Permintaan akses email dinas",
    organisasi: "Diskominfo",
    tanggal: "2024-05-01",
    agen: "Agus Santoso",
    status: "Buka",
  },
  {
    noTiket: "#091213",
    perihal: "Permintaan reset password",
    organisasi: "Dispenda",
    tanggal: "2024-05-02",
    agen: "Siti Nur",
    status: "Diproses",
  },
  {
    noTiket: "#091214",
    perihal: "Pengajuan akses VPN",
    organisasi: "Bappeda",
    tanggal: "2024-05-03",
    agen: "Joko Widodo",
    status: "Disetujui",
  },
  {
    noTiket: "#091215",
    perihal: "Permintaan install aplikasi",
    organisasi: "BKD",
    tanggal: "2024-05-04",
    agen: "Rina Marlina",
    status: "Ditolak",
  },
]

// Buat Searching
const search = ref('')
const currentPage = ref(1)
const itemsPerPage = 10

const filteredItems = computed(() => {
  return layananData.filter(item =>
    item.perihal.toLowerCase().includes(search.value.toLowerCase()) ||
    item.noTiket.toLowerCase().includes(search.value.toLowerCase()) ||
    item.organisasi.toLowerCase().includes(search.value.toLowerCase()) ||
    item.agen.toLowerCase().includes(search.value.toLowerCase())
  )
})

const totalPages = computed(() => {
  return Math.ceil(filteredItems.value.length / itemsPerPage)
})

const paginatedItems = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage
  return filteredItems.value.slice(start, start + itemsPerPage)
})

watch(search, () => {
  currentPage.value = 1
})
</script>

<template>
  <div class="container">
    <div class="card">
      <h1 class="title">Data Pelayanan</h1>
      <input type="text" v-model="search" placeholder="🔍 Cari" class="search-bar" />
      
      <table class="rounded-table">
        <thead>
          <tr>
            <th>No. Tiket</th>
            <th>Perihal</th>
            <th>Organisasi</th>
            <th>Tanggal</th>
            <th>Agen</th>
            <th>Status</th>
            <th>Detail Progress</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in paginatedItems" :key="index">
            <td>{{ item.noTiket }}</td>
            <td>{{ item.perihal }}</td>
            <td>{{ item.organisasi }}</td>
            <td>{{ item.tanggal }}</td>
            <td>{{ item.agen }}</td>
            <td>
              <span :class="['status', item.status.toLowerCase()]">{{ item.status }}</span>
            </td>
            <td><button class="detail-button">Lihat</button></td>
          </tr>
        </tbody>
      </table>

      <div class="pagination">
        <button @click="currentPage--" :disabled="currentPage === 1">&lt;</button>
        <button v-for="page in totalPages" :key="page"
          :class="{ active: currentPage === page }"
          @click="currentPage = page">
          {{ page }}
        </button>
        <button @click="currentPage++" :disabled="currentPage === totalPages">&gt;</button>
      </div>
    </div>
  </div>
</template>

<style scoped>
.container {
  background-color: #faf4ff;
  min-height: 100vh;
  padding: 2rem;
}

.card {
  background-color: white;
  border-radius: 16px;
  padding: 2rem;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.title {
  font-size: 28px;
  font-weight: bold;
  margin-bottom: 20px;
  color: #333;
}

.search-bar {
  width: 100%;
  padding: 10px;
  margin-bottom: 20px;
  border: none;
  border-radius: 13px;
  background-color: #e0e0e0;
  font-size: 14px;
}

.rounded-table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
  border-radius: 10px;
  overflow: hidden;
  font-size: 14px;
}

.rounded-table th, .rounded-table td {
  padding: 12px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

.rounded-table th {
  background-color: #f1f1f1;
}

.rounded-table tr:nth-child(even) {
  background-color: #f9f9f9;
}

.status {
  padding: 4px 10px;
  border-radius: 12px;
  font-size: 12px;
  font-weight: bold;
  display: inline-block;
}

.status.buka {
  background-color: #e6dcf5;
  color: #6a1b9a;
}

.status.diproses {
  background-color: #f5f5c3;
  color: #aaaa3a;
}

.status.disetujui {
  background-color: #c7f5d9;
  color: #2e7d32;
}

.status.ditolak {
  background-color: #fddede;
  color: #c62828;
}

.detail-button {
  background: none;
  border: none;
  color: #1e88e5;
  cursor: pointer;
  text-decoration: underline;
  font-size: 13px;
}

.pagination {
  margin-top: 20px;
  text-align: center;
}

.pagination button {
  background-color: white;
  color: black;
  border: 1px solid #ccc;
  padding: 0.5rem 0.75rem;
  border-radius: 50%;
  cursor: pointer;
  min-width: 2rem;
  text-align: center;
  font-weight: 500;
}

.pagination button:disabled {
  cursor: not-allowed;
  opacity: 0.3;
}

.pagination button.active {
  background-color: #007bff;
  color: white;
}

.pagination button:not(.active):hover {
  background-color: #f0f0f0;
}
</style>
