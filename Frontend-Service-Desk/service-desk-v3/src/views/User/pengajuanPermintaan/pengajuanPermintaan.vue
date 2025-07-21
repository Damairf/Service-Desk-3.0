<script setup>
import { inject, ref, computed } from 'vue'

const selectMenu = inject('selectMenu')

const services = ref([
  "Pelayanan Email dan Drive Jabarprov",
  "Pelayanan Email dan Drive Jabarprov",
  "Pelayanan Email dan Drive Jabarprov",
  "Pelayanan Email dan Drive Jabarprov",
  "Pelayanan Email dan Drive Jabarprov",
  "Pelayanan Email dan Drive Jabarprov",
  "Pelayanan Email dan Drive Jabarprov",
])

const page = ref(1)
const searchTerm = ref("")
const showModal = ref(false)
const isChecked = ref(false)
const selectedItem = ref("")

const filteredServices = computed(() => {
  const term = searchTerm.value.toLowerCase();
  return services.value
    .filter((s) => s.toLowerCase().includes(term))
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
}

function handleOk() {
  console.log("kontol")
  if (selectMenu) {
    selectMenu('Halaman Formulir Tiket Baru')
  }
  showModal.value = false
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
          {{ item }}
        </div>
        <button class="tombol-tambah" @click="openModal(item)">+</button>
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
    <div v-if="showModal" class="overlay">
      <div class="overlay-content">
        <button class="close-btn" @click="showModal = false">×</button>
        <h3>Pesyaratan</h3>
        <p>{{ selectedItem }}</p>
        <label>
          <input type="checkbox" v-model="isChecked" />
          Persetujuan Sudah Lengkap
        </label>
        <br />
        <button class="tombol-ok" :disabled="!isChecked" @click="handleOk">OK</button>
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

.info-box {
  background-color: #fff8b1;
  border: 1px solid #e6cc00;
  padding: 1rem;
  border-radius: 8px;
  margin-bottom: 1rem;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.info-box p {
  font-size: small;
  font-weight: 500;
  margin: 2px;
}

.container-pencarian input {
  background-color: white;
  color: black;
  width: 96%;
  padding: 0.75rem 1rem;
  font-size: 1rem;
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
  position: absolute;
  top: 0.5rem;
  right: 0.5rem;
  background: none;
  border: none;
  font-size: 1.5rem;
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