<script>

 function handleOK(){
    selectMenu('Lacak Permintaan')
  }

export default {
  data() {
    return {
      search: '',
      currentPage: 1,
      itemsPerPage: 10,
      items: [
        { id: 1, ticket: 'Nomor', perihal: 'Perihal', date: 'xx-xx-xxxx', pic: 'Nama PIC', progress: 'Progress' },
        { id: 2, ticket: 'Nomor', perihal: 'Perihal', date: 'xx-xx-xxxx', pic: 'Nama PIC', progress: 'Progress' },
        { id: 3, ticket: 'Nomor', perihal: 'Perihal', date: 'xx-xx-xxxx', pic: 'Nama PIC', progress: 'Progress' },
        { id: 4, ticket: 'Nomor', perihal: 'Perihal', date: 'xx-xx-xxxx', pic: 'Nama PIC', progress: 'Progress' }
      ]
    };
  },
  computed: {
    filteredItems() {
      return this.items.filter(item =>
        item.perihal.toLowerCase().includes(this.search.toLowerCase())
      );
    },
    totalPages() {
      return Math.ceil(this.filteredItems.length / this.itemsPerPage);
    },
    paginatedItems() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      const end = start + this.itemsPerPage;
      return this.filteredItems.slice(start, end);
    }
  },
  watch: {
    filteredItems() {
      this.currentPage = 1; // Reset to first page when search changes
    }
  },
  methods: {
    checkProgress(item) {
      // Add your logic here, e.g., alert or navigate to a progress detail page
      alert(`Checking progress for ticket ${item.ticket}`);
    }
  }
};
</script>

<template>
  <div class="container">
    <div class="progress-card">
      <h1>On Progress</h1>
      <input type="text" v-model="search" placeholder="Cari" class="search-bar" />
      <table class="rounded-table">
        <thead>
          <tr>
            <th>No. Tiket</th>
            <th>Perihal</th>
            <th>Tanggal Laporan</th>
            <th>PIC</th>
            <th>Detail Proses</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in paginatedItems" :key="item.id">
            <td>{{ item.ticket }}</td>
            <td>{{ item.perihal }}</td>
            <td>{{ item.date }}</td>
            <td>{{ item.pic }}</td>
            <td><a href="#" @click.prevent="checkProgress(item)" style="color: blue; text-decoration: underline;">Cek Progress</a></td>
          </tr>
        </tbody>
      </table>
      <div class="pagination">
        <button @click="currentPage--" :disabled="currentPage === 1"><</button>
        <button v-for="page in totalPages" :key="page" @click="currentPage = page" :class="{ active: currentPage === page }">
          {{ page }}
        </button>
        <button @click="currentPage++" :disabled="currentPage === totalPages">></button>
      </div>
    </div>
  </div>
</template>

<style scoped>

.container {
  background-color: #faf4ff;
  min-height: 100vh;
  padding: 1rem;
  position: relative;
}

.progress-card {
  background-color: white;
  border-radius: 16px;
  padding: 2rem;
  width: 95%;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  text-align: left;
  position: relative;
}

h1 {
  color: #333;
}
.search-bar {
  width: 97%;
  padding: 10px;
  margin-bottom: 40px;
  border: none;
  border-radius: 13px;
  background-color: #e0e0e0;
}
.rounded-table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
  border-radius: 10px;
  overflow: hidden;
}
.rounded-table th, .rounded-table td {
  padding: 10px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}
.rounded-table th {
  background-color: #e0e0e0;
}
.rounded-table tr:nth-child(even) {
  background-color: #f2f2f2;
}
.rounded-table tr:first-child td {
  border-top-left-radius: 10px;
  border-top-right-radius: 10px;
}
.rounded-table tr:last-child td {
  border-bottom-left-radius: 10px;
  border-bottom-right-radius: 10px;
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
  color: black;
  opacity: 30%;
}
.pagination button.active {
  background-color: #007bff;
  color: white;
}

.pagination button:not(.active):hover {
  background-color: #f0f0f0;
}
</style>