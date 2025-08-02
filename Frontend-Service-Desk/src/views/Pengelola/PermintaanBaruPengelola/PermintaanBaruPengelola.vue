<script setup>
import { ref, computed , onBeforeMount, onMounted , watch} from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router';

// buat push layanan ke halaman formulir tiket baru
const router = useRouter()

const services = ref([])
const isLoading = ref(true)
onBeforeMount(() => {
  const token = localStorage.getItem('Token');
  axios.get('/api/jenispelayanan', {
    headers: {
      Authorization: 'Bearer ' + token
    }
  })
  .then(response => {
    services.value = response.data;
  })
  .catch(error => {
    console.error(error);
  })
  .finally(() => {
    isLoading.value = false;
  });
});

const page = ref(1)
const searchTerm = ref("")
const showModal = ref(false)
const isChecked = ref(false)
const selectedItem = ref("")

watch(searchTerm, () => {
  page.value = 1
})

const filteredServices = computed(() => {
  const term = searchTerm.value.toLowerCase();
  return services.value
    .filter((s) => s.Nama_Jenis_Pelayanan.toLowerCase().includes(term))
    .slice((page.value - 1) * 10, page.value * 10);
})

function prevPage() {
  if (page.value > 1) page.value--
}

function nextPage() {
  if (page.value * 5 < services.value.length) page.value++
}

function openModal(item) {
  selectedItem.value = item
  showModal.value = true
  router.push({
    name: 'FormulirTiketBaruPengelola', query: {layanan: selectedItem.value.Nama_Jenis_Pelayanan , persyaratan: selectedItem.value.Persyaratan}
  })
  localStorage.setItem('ID_Jenis_Pelayanan', item.ID_Jenis_Pelayanan)
  console.log(item)
}
</script>

<template>
  <div class="container">
    <!-- Info box -->
    <div class="info-box">
      <strong>Petunjuk Pelayanan:</strong> <br />
      <p>Siapkan surat permohonan (khusus untuk layanan infrastruktur), serta gambar atau file pendukung untuk memperjelas pelaporan.</p>
      <p>Klik tombol Plus (+) untuk memulai permintaan layanan.</p>
      <p>Pantau perkembangan permintaan/pengaduan melalui notifikasi email dari tim Service Desk.</p>
    </div>

    <!-- Search -->
    <div class="container-pencarian">
      <input type="text" v-model="searchTerm" placeholder="Cari" />
    </div>
    
    <div class="loading-data" v-if="isLoading">Memuat data layanan...</div>
    
    <div v-else>
      <!-- List Pelayanan -->
      <div class="container-pelayanan">
        <div
          class="list-wrapper"
          v-for="(item, index) in filteredServices"
          :key="index"
        >
          <div
            class="list-item"
            :class="index % 2 === 0 ? 'grey-bg' : 'white-bg'"
          >
            {{ item.Nama_Jenis_Pelayanan }}
          </div>
          <button class="tombol-tambah" @click="openModal(item)">+</button>
        </div>
    </div>
    </div>

    <!-- Paging -->
    <div class="paging">
      <button @click="prevPage" :disabled="page === 1"><</button>
      <button :class="{ active: page === 1 }" @click="page = 1">1</button>
      <button :class="{ active: page === 2 }" @click="page = 2">2</button>
      <button @click="nextPage">></button>
    </div>

    <!-- Modal Overlay -->
    

  </div>
</template>

<style scoped>
input[type="checkbox"]{
  cursor: pointer;
}


.container {
  background-color: #faf4ff;
  min-height: 100vh;
  padding: 1rem;
  position: relative;
}

.loading-data {
  margin-top: 2rem;
  text-align: center;
  font-size: 1.1rem;
  font-family: poppins, sans-serif;
}

.info-box {
  background-color: #fff8b1;
  border: 1px solid #e6cc00;
  padding: 1rem;
  border-radius: 8px;
  margin-bottom: 1rem;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  font-family: poppins, sans-serif;
}

.info-box p {
  font-size: small;
  font-weight: 500;
  font-family: poppins, sans-serif;
  margin: 2px;
}

.container-pencarian input {
  background-color: white;
  color: black;
  width: 96%;
  padding: 0.75rem 1rem;
  font-size: 1rem;
  font-family: poppins, sans-serif;
  border-radius: 9999px;
  border: 1px solid #ccc;
  margin-bottom: 1rem;
  outline: none;
}

.container-pelayanan {
  width: 100%;
}

.list-wrapper {
  display: flex;
  align-items: center;
  margin-bottom: 0.5rem;
}

.list-item {
  flex: 1;
  padding: 1rem;
  border-top-right-radius: 5px;
  border-bottom-right-radius: 5px;
  border-top-left-radius: 8px;
  border-bottom-left-radius: 8px;
  font-weight: bold;
  font-family: poppins, sans-serif;
  background-color: #e0f7fa;
}

.grey-bg {
  background-color: #e6e6e6;
}

.white-bg {
  background-color: white;
}

.tombol-tambah {
  background-color: #006920;
  color: white;
  font-size: 2rem;
  width: 3rem;
  height: 3rem;
  border: none;
  cursor: pointer;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
  border-top-right-radius: 20px;
  border-bottom-right-radius: 20px;
  border-top-left-radius: 5px;
  border-bottom-left-radius: 5px;
  margin-left: 0.5rem;
  transition: transform 0.3s ease;
}

.tombol-tambah:hover {
  transform: scale(1.1);
}

.paging {
  margin-top: 2rem;
  display: flex;
  justify-content: center;
  gap: 0.25rem;
}

.paging button {
  background-color: white;
  color: black;
  border: 1px solid #ccc;
  padding: 0.5rem 0.75rem;
  border-radius: 50%;
  cursor: pointer;
  min-width: 2rem;
  text-align: center;
  font-weight: 500;
  font-family: poppins, sans-serif;
}

.paging .active {
  background-color: #2196f3;
  color: white;
  border-color: #2196f3;
}

.paging button:not(.active):hover {
  background-color: #f0f0f0;
}

/* Overlay Persyaratan */
.overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.overlay h3{
  margin-bottom: 3.5rem;
}

.overlay p{
  margin-bottom: 3rem;
}

.overlay label{
  margin: 1rem;
}

.overlay-content {
  background-color: white;
  padding: 1rem;
  border-radius: 18px;
  position: relative;
  min-width: 200px; /*--*/
  max-width: 90%; /* Menyesuaikan isi overlay */
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  text-align: center;
}

.close-btn {
  color: black;
  position: absolute;
  top: 0.5rem;
  right: 0.5rem;
  background: none;
  border: none;
  font-size: 1.5rem;
  font-family: poppins, sans-serif;
  cursor: pointer;
}

.tombol-ok {
  background-color: #cccccc; /* Disable warna by default */
  color: white;
  border: none;
  padding: 0.5rem 1rem;
  border-radius: 4px;
  cursor: pointer;
  margin-top: 2rem;
  transition: background-color 0.3s;
}

.tombol-ok:enabled {
  background-color: #2196f3;
}

.tombol-ok:disabled {
  background-color: #cccccc;
  cursor: not-allowed;
}
</style>