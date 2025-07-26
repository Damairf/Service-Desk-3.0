<template>
    <div class="page-bg">
      <h1 class="main-title">Pelayanan</h1>
      <div class="data-pelayanan-container">
        <h2 class="title">Data Pelayanan</h2>
        <div class="search-bar">
          <i class="fas fa-search"></i>
          <input type="text" placeholder="Cari" v-model="searchQuery" />
        </div>
        <table class="data-table">
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
            <tr v-for="(row, idx) in paginatedRows" :key="idx">
              <td>{{ row.noTiket }}</td>
              <td>{{ row.perihal }}</td>
              <td>{{ row.organisasi }}</td>
              <td>{{ row.tanggal }}</td>
              <td>{{ row.agen }}</td>
              <td>
                <span class="status-proses">Diproses</span>
              </td>
              <td>{{ row.detailProgress }}</td>
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
  
  <script setup>
  import { ref, computed } from 'vue'
  
  const searchQuery = ref('')
  const currentPage = ref(1)
  const rowsPerPage = 4
  
  const rows = ref([
    { noTiket: 'XXXX', perihal: 'Yapping wok', organiasi: 'Instansinya wok', tanggal: 'XX-XX-XXXX', agen: 'Name', detailProgress: 'Yapping' },
    { noTiket: 'XXXX', perihal: 'Yapping wok', organiasi: 'Instansinya wok', tanggal: 'XX-XX-XXXX', agen: 'Name', detailProgress: 'Yapping' },
    { noTiket: 'XXXX', perihal: 'Yapping wok', organiasi: 'Instansinya wok', tanggal: 'XX-XX-XXXX', agen: 'Name', detailProgress: 'Yapping' },
    { noTiket: 'XXXX', perihal: 'Yapping wok', organiasi: 'Instansinya wok', tanggal: 'XX-XX-XXXX', agen: 'Name', detailProgress: 'Yapping' },
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
  </script>
  
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
  .data-pelayanan-container {
    background: #fff;
    border-radius: 20px;
    padding: 2rem;
    max-width: 900px;
    margin: 0 auto 2rem auto;
    box-shadow: 0 2px 12px rgba(0,0,0,0.07);
  }
  .title {
    font-size: 1.6rem;
    font-weight: bold;
    margin-bottom: 1.2rem;
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
    background: #f3f3f3;
    font-weight: 600;
  }
  .data-table tr {
    border-bottom: 1px solid #eee;
  }
  .status-proses {
    background: #b2a100;
    color: #fff;
    border: none;
    border-radius: 1.2rem;
    padding: 0.4rem 1.2rem;
    font-weight: 500;
    font-size: 1rem;
    display: inline-block;
    text-align: center;
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