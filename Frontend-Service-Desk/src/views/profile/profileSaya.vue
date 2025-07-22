<script setup>
  import { inject, ref, computed, onBeforeMount } from 'vue'
  import axios from 'axios'
  // transisi ke edit profile

  const selectMenu = inject('selectMenu')
  const namaDepan = reff('')
  const namaBelakang = localStorage.getItem('nama_belakang')
  const nip = localStorage.getItem('nip_user')
  const role = localStorage.getItem('nama_role')
  const jabatan = localStorage.getItem('nama_jabatan')
  const organisasi = localStorage.getItem('nama_organisasi')

  const nama_depan = ref('')
const nama_belakang = ref('')
const nip_user = ref('')
const id_role = ref('')
const nama_role = ref('')
const nama_jabatan = ref('')
const nama_organisasi = ref('')
const router = useRouter()

  onBeforeMount(() => {
    const token = localStorage.getItem('Token');
    axios.get('http://127.0.0.1:8000/api/user/profile', {
      headers: {
        Authorization: 'Bearer ' + token
      }
    })
    .then(response => {
      console.log(response);
      nama_depan.value = response.data.Nama_Depan
      nama_belakang.value = response.data.Nama_Belakang
      nip_user.value = response.data.NIP
      id_role.value = response.data.ID_Role
      nama_role.value = response.data.user_role.map(item => item.Nama_Role)
      nama_jabatan.value = response.data.user_jabatan.map(item => item.Nama_Jabatan)
      nama_organisasi.value = response.data.user_organisasi.map(item => item.Nama_OPD)
      localStorage.setItem('nama_depan', response.data.Nama_Depan)
      localStorage.setItem('nama_belakang', response.data.Nama_Belakang)
      // localStorage.setItem('nip_user', response.data.NIP)
      // localStorage.setItem('id_role', response.data.ID_Role)
      // localStorage.setItem('nama_role', response.data.user_role.map(item => item.Nama_Role))
      // localStorage.setItem('nama_jabatan', response.data.user_jabatan.map(item => item.Nama_Jabatan))
      // localStorage.setItem('nama_organisasi', response.data.user_organisasi.map(item => item.Nama_OPD))
    })
    .catch(error => {
      console.error(error);
    });
  });

</script>


<template>
  <div class="profile-card">
    <h2 class="profile-title">Profil saya</h2>

    <div class="profile-container">
      <!-- FOTO & NAMA -->
      <div class="left-column">
        <img
          src="https://via.placeholder.com/200x200.png?text=User+Image"
          alt="Foto Profil"
          class="profile-img"
        />
        <div class="name-button">
          <span class="nama-user">{{namaDepan + " " + namaBelakang}}</span>
          <button class="btn-edit" @click="selectMenu('Edit Profile')">
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

<style>
html, body {
  height: 100%;
  margin: 0;
  padding: 0;
  background-color: #FAF4FF;
}
</style>

<style scoped>

.profile-card {
  max-width: 40rem;
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
  margin-bottom: 1rem;
  border: 3px solid #ddd;
}

.name-button {
  display: flex;
  flex-direction: row;
  gap: 0.5rem;
  align-items: center;
}

.nama-user {
  background: #fdf1a6;
  padding: 0.8rem 1.2rem;
  border-top-right-radius: 8px;
  border-bottom-right-radius: 8px;
  border-top-left-radius: 50px;
  border-bottom-left-radius: 50px;
  font-weight: 600;
}

.btn-edit {
  background: #4CAF50;
  color: white;
  border: none;
  padding: 0.8rem 0.8rem;
  border-top-right-radius: 50px;
  border-bottom-right-radius: 50px;
  border-top-left-radius: 8px;
  border-bottom-left-radius: 8px;
  font-weight: 600;
  cursor: pointer;
  box-shadow: 0 2px 8px rgba(0,0,0,0.25);
  transition: transform 0.2s ease;
}

.btn-edit:hover{
  transform: scale(1.02);
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