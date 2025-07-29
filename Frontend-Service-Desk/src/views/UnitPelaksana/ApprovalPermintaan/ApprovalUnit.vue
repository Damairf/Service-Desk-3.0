<script setup>
import { ref, computed, watch , onMounted} from 'vue'
import axios from 'axios';
import { useRouter } from 'vue-router';
const router = useRouter()
function formatDate(dateString) {
  if (!dateString) return '-';
  return new Date(dateString).toLocaleDateString('id-ID');
}

const isLoading = ref(true)
const layananData = ref([]);
const sortKey = ref('') 
const sortOrder = ref(null) 
const steps = ref('')

onMounted(() => {
  const token = localStorage.getItem('Token');
  axios.get('http://127.0.0.1:8000/api/pelayanan', {
    headers: {
      Authorization: 'Bearer ' + token
    }
  })
  .then(response => {
    layananData.value = response.data.map(item => ({
      noTiket: item.ID_Pelayanan,
      jenis: item.ID_Jenis_Pelayanan,
      perihal: item.Perihal,
      tanggal: item.created_at,
      organisasi: item.user.user_organisasi.Nama_OPD,
    }))
    if (layananData.value.length > 0) {
      const jenis = layananData.value[0].jenis;

      // ambil alur berdasarkan jenis
      axios.get(`http://127.0.0.1:8000/api/alur/jenis_pelayanan/${jenis}`, {
        headers: { Authorization: 'Bearer ' + token }
      })
      .then(response => {
        steps.value = response.data.map(a => a.isi_alur?.Isi_Bagian_Alur) || [];
        localStorage.setItem('steps', JSON.stringify(steps.value)) // simpan jika mau
      })
      .catch(error => {
        console.error('Gagal mengambil steps:', error);
      });
    } else {
      console.warn('Data items kosong, tidak bisa ambil jenis pelayanan');
    }
  })
  .catch(error => {
    console.error('Gagal mengambil data pelayanan:', error);
  })
  .finally(() => {
    isLoading.value = false;
  });
});

//ke halaman detail 
function lihatDetail(item){
  const pelayananId = ref(item.noTiket)
  const stepString = JSON.stringify(steps.value);
    router.push({
    name: 'DetailPelayananPelaksana', 
    query: {
      layanan: item.noTiket,
      steps: stepString
    }
  })
    
}

function toggleSort(key) {
  if (sortKey.value !== key) {
    sortKey.value = key
    sortOrder.value = 'asc'
  } else {
    // urutannya: asc -> desc -> unsorted
    if (sortOrder.value === 'asc') {
      sortOrder.value = 'desc'
    } else if (sortOrder.value === 'desc') {
      sortKey.value = ''
      sortOrder.value = null
    } else {
      sortOrder.value = 'asc'
    }
  }
}

// Buat Searching
const search = ref('')
const currentPage = ref(1)
const itemsPerPage = 10

const filteredItems = computed(() => {
  let items = layananData.value.filter(item =>
    item.perihal.toLowerCase().includes(search.value.toLowerCase()) ||
    item.noTiket.toLowerCase().includes(search.value.toLowerCase()) ||
    item.organisasi.toLowerCase().includes(search.value.toLowerCase()) ||
    formatDate(item.tanggal).toLowerCase().includes(search.value.toLowerCase())
  )

  if (sortKey.value && sortOrder.value) {
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

watch(search, () => {
  currentPage.value = 1
})


</script>

<template>
  <div class="container">
    <div class="card">
      <h1 class="title">Persetujuan Pelayanan</h1>
      <input type="text" v-model="search" placeholder="Cari" class="search-bar" />
      
      <table class="rounded-table">
        <thead>
          <tr>
            <th>No. Tiket</th>
            <th>Perihal</th>
            <th>Organisasi</th>
            <th>Tanggal</th>
            <th>Detail Progress</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="isLoading">
            <td colspan="6" style="text-align: center; padding: 1rem;">Memuat data...</td>
          </tr>
          <tr v-else-if="filteredItems.length === 0">
            <td colspan="6" style="text-align: center; padding: 1rem;">Tidak ada permintaan pelayanan</td>
          </tr>
          <tr v-for="(item, index) in paginatedItems" :key="index">
            <td>{{ item.noTiket }}</td>
            <td>{{ item.perihal }}</td>
            <td>{{ item.organisasi }}</td>
            <td>{{ formatDate(item.tanggal) }}</td>
            <td><button class="detail-button" @click="lihatDetail(item)">Lihat</button></td>
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
  color: black;
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

.loading-data {
  text-align: center;
  font-size: 1.1rem;
}
</style>
