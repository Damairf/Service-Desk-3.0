<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'

const router = useRouter()

const NIP = ref()
const Password = ref('')

function login(){
  axios.post('http://127.0.0.1:8000/api/user/login', {
    NIP: NIP.value,
    Password: Password.value
    })
  .then(function(response){
    const token = response.data.token;
    const user = response.data.data_user;

    localStorage.setItem('Token', token);
    localStorage.setItem('nama_depan', user.Nama_Depan);
    localStorage.setItem('nama_belakang', user.Nama_Belakang);
    localStorage.setItem('src_gambar', user.Gambar_Path);
    localStorage.setItem('id_role', user.ID_Role);
    localStorage.setItem('nama_role', user.user_role.Nama_Role);
    
    const role = user.ID_Role;

    if (role === 1) {
      router.push('/beranda');
    } else if (role === 2){
      router.push('/beranda-Pengelola');
    } else if (role === 3){
      router.push('/berandaUnit');
    } else if (role === 4){
      router.push('/berandaTeknis')
    }
    })

  .catch(function(error) {
    if (error.response && error.response.status === 401) {
      alert("Password salah!");
    } else if (error.response && error.response.status === 404) {
      alert("NIP tidak ditemukan!");
    } else {
      alert("Terjadi kesalahan server");
    }
});
}

const data = ref(null);

onMounted(() => {
  const token = localStorage.getItem('Token');
  const role = parseInt(localStorage.getItem('id_role'));

  if (token && role === 1) {
    router.push('/beranda');
  } else if (token && role === 2){
    router.push('/beranda-Pengelola');
  } else if (token && role === 3){
    router.push('/BerandaUnit')
  } else if (token && role == 4){
    router.push('/berandaTeknis')
  } else if (token && role == 5){
    router.push('/berandaKD')
  }
});
</script>

<template>
  <div class="container">
    <div class="flex-wrapper">
      <div class="buatLogo">
        <img src="/logo.svg" alt="Logo" class="logo-image" />
        <h2 class="title">SERVICE<br>DESK V3.0</h2>
      </div>

      <div class="login-box">
        <h2 class="loginTitle">Login</h2>
        <input class="placeholderLgn" v-model="NIP" type="text" placeholder="NIP" />
        <input class="placeholderLgn" v-model="Password" type="password" placeholder="Password" />
        <button class= "login" @click="login">Login</button>
      </div>
    </div>
  </div>
</template>

<!-- <style>
html, body {
  height: 100%;
  margin: 0;
  padding: 0;
  overflow: hidden; /* Prevent scrolling */
}
</style> -->

<style scoped>
.container {
  width: 100vw;
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  background-image: url('/BG-login.svg');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
}


.flex-wrapper {
  display: flex;
  gap: 0rem; /* jarak antar box */
}

/* ukuran disamakan */
.buatLogo {
  width: 200px; /* sama dengan login-box */
  height: 300px;
  background-color: rgba(183,197,255, 0.7);
  padding: 5rem;
  border-top-left-radius: 40px;
  border-top-right-radius: 0px;
  border-bottom-right-radius: 0px;
  border-bottom-left-radius: 40px;
  box-shadow: 0 10px 250px rgba(0, 0, 0, 0.1);
  color: black;
  backdrop-filter: blur(10px);
  align-items: center;
}

.logo-image {
  width: 150px;
  height: 150px;
  object-fit: contain;
  margin-left: 2rem;
  margin-top: 2rem;
}

.title {
  margin-left: 3rem;
  margin-top: 0rem;
  line-height: 1.2;
}

.loginTitle{
  color: black;
  text-align: center;        
  margin-bottom: 45px;       
  margin-top: 70px;        
  font-size: 48px;         
  font-weight: bold;        
}

.login-box {
  width: 300px;
  background-color: white;
  padding: 2rem;
  border-top-left-radius: 0px;
  border-top-right-radius: 40px;
  border-bottom-right-radius: 40px;
  border-bottom-left-radius: 0px;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
  text-align: center;
}



input {
  display: block;
  align-items: center;
  width: 80%;
  margin: 1rem auto;
  padding: 0.5rem;
  border: 1px solid #ccc;
  border-radius: 8px;
  text-align: left;
}



.login {
  background-color: #42b983;
  color: white;
  padding: 0.5rem 1rem;
  border: none;
  border-radius: 20px;
  cursor: pointer;
  width: 35%;
}

.placeholderLgn{
  background-color: white;
  color: black;
}

button:hover {
  background-color: #369870;
}

p {
  margin-top: 1rem;
  font-weight: bold;
  color: black;
}
</style>