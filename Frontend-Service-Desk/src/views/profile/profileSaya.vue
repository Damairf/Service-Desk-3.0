<script setup>
  import { ref, computed, onMounted } from 'vue'
  import axios from 'axios'
  // transisi ke edit profile
  import { useRouter } from 'vue-router'
  const router = useRouter()
  function toEdit(){
    router.push('/editProfile')
  }

  const namaDepan = localStorage.getItem('nama_depan')
  const namaBelakang = localStorage.getItem('nama_belakang')
  const nip = localStorage.getItem('nip_user')
  const role = localStorage.getItem('nama_role')
  const jabatan = localStorage.getItem('nama_jabatan')
  const organisasi = localStorage.getItem('nama_organisasi')
  const gambar = localStorage.getItem('src_gambar')
  
</script>


<template>
  <div class="profile-card">
    <h2 class="profile-title">Profil Saya</h2>

    <div class="profile-container">
      <!-- FOTO & NAMA -->
      <div class="left-column">
        <img
          :src="`http://localhost:8000/images/${gambar}`"
          alt="Foto Profil"
          class="profile-img"
        />
        <div class="button-wrapper">
          <button class="btn-edit" @click="toEdit()">
            ✏️ Edit
          </button>
        </div>
      </div>

      <!-- DATA PROFIL -->
      <div class="right-column">
        <div class="info-box green">
          <div class="icon-area">👤</div>
          <div class="info-text">
            <p><strong>Nama Depan</strong> : {{namaDepan}}</p>
            <p><strong>Nama Belakang</strong> : {{namaBelakang}}</p>
            <p><strong>NIP</strong> : {{nip}}</p>
          </div>
        </div>

        <div class="info-box blue">
          <div class="icon-area">📱</div>
          <div class="info-text">
            <p><strong>Role</strong> : {{role}}</p>
            <p><strong>Jabatan</strong> : {{jabatan}}</p>
            <p><strong>Organisasi</strong> : {{organisasi}}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<!-- <style>
html, body {
  height: auto;
  margin: 0;
  padding: 0;
  background-color: #FAF4FF;
}
</style> -->

<style scoped>

.profile-card {
  max-width: 40rem;
  max-height: 60rem;
  margin: 2rem auto;
  padding: 2rem;
  background: white;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  border-radius: 8px;
  font-family: 'Poppins', sans-serif;
}

.profile-title {
  font-size: 2rem;
  font-weight: 550;
  color: black;
  margin-bottom: 2rem;
  display: inline-block;
}

.profile-container {
  display: flex;
  flex-wrap: wrap;
  gap: 2rem;
  align-items: flex-start;
}

.left-column {
  flex: 1;
  min-width: 250px;
  text-align: center;
}

.profile-img {
  width: 200px;
  height: 200px;
  object-fit: cover;
  border-radius: 100%;
  margin-bottom: 0.5rem;
  border: 3px solid #ddd;
}

.button-wrapper {
  align-items: center;
}

.btn-edit {
  background: #4CAF50;
  color: white;
  border: none;
  padding: 1rem 3rem;
  border-radius: 50px;
  font-weight: 600;
  font-size: large;
  cursor: pointer;
  box-shadow: 0 2px 8px rgba(0,0,0,0.25);
  transition: transform 0.2s ease;
}

.btn-edit:hover{
  transform: scale(1.02);
  background-color: #66BB6A;
}

.right-column {
  flex: 2;
  min-width: 300px;
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.info-box {
  display: flex;
  align-items: flex-start;
  border-radius: 1rem;
  padding: 1.2rem;
  gap: 1rem;
}

.info-box.green {
  background: #e6f7e6;
}

.info-box.blue {
  background: #e6f1f9;
}

.icon-area {
  background: #d8ecf0;
  width: 45px;
  height: 45px;
  border-radius: 50%;
  text-align: center;
  font-size: 1.5rem;
  line-height: 45px;
  color: #333;
}

.info-text p {
  margin: 0.3rem 0;
}
</style>