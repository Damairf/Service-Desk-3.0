<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
import { useReCaptcha } from 'vue-recaptcha-v3'

const router = useRouter()
const { executeRecaptcha } = useReCaptcha()

const NIP = ref('')
const Password = ref('')
const errorMessage = ref('')
const isLoading = ref(false)
const passwordError =ref(false)
const NIPerror = ref(false)
const isEmpty = ref(false)

async function login() {
  
  isEmpty.value = false
  NIPerror.value = false
  passwordError.value = false
  isLoading.value = true

  // Jalankan reCAPTCHA v3
  const tokenRecaptcha = await executeRecaptcha('login')

  axios.post('/api/user/login', {
    NIP: NIP.value,
    Password: Password.value,
    recaptcha_token: tokenRecaptcha // <-- kirim token ke backend
  })
  .then((response) => {
    const token = response.data.token
    const user = response.data.data_user

    localStorage.setItem('Token', token)
    localStorage.setItem('user_id', user.ID_User)
    localStorage.setItem('nama_depan', user.Nama_Depan)
    localStorage.setItem('nama_belakang', user.Nama_Belakang)
    localStorage.setItem('src_gambar', user.Gambar_Path)
    localStorage.setItem('id_role', user.ID_Role)
    localStorage.setItem('nama_role', user.user_role.Nama_Role)

    const role = user.ID_Role
    if (role === 1) router.push('/beranda')
    else if (role === 2) router.push('/beranda-Pengelola')
    else if (role === 3) router.push('/berandaUnit')
    else if (role === 4) router.push('/berandaTeknis')
    else if (role === 5) router.push('/berandaKD')
  })
  .catch((error) => {
    isLoading.value = false
    if (error.response && error.response.status === 401) {
      passwordError.value = true
    } else if (error.response && error.response.status === 404) {
      NIPerror.value = true
    }  else if (error.response && error.response.status === 422) {
      isEmpty.value = true
    } 
  })
}

onMounted(() => {
  const token = localStorage.getItem('Token')
  const role = parseInt(localStorage.getItem('id_role'))

  if (token) {
    if (role === 1) router.push('/beranda')
    else if (role === 2) router.push('/beranda-Pengelola')
    else if (role === 3) router.push('/BerandaUnit')
    else if (role === 4) router.push('/berandaTeknis')
    else if (role === 5) router.push('/berandaKD')
  }
})
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
        <input class="placeholderLgn" v-model="Password" @keyup.enter="login" type="password" placeholder="Password" />
        <!-- Loading State -->
        <div v-if="isLoading" class="loading-container-login">
          <div class="loading-spinner-login"></div>
          <p>Mohon tunggu, sedang masuk...</p>
        </div>
        <button v-if="!isLoading" class="login" @click="login">Login</button>
        <div v-if="isEmpty" class="isEmpty">
          Harap isi NIP dan Password!
        </div>
        <div v-if="NIPerror" class="NotFound">
          NIP tidak ditemukan!
        </div>
        <div v-if="passwordError" class="NotFound">
          Password salah!
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.isEmpty {
  background-color: #fff3cd; /* kuning lembut */
  color: #856404;           /* teks kuning tua */
  border: 1px solid #ffeeba;
  padding: 8px 12px;
  margin-bottom: 10px;
  border-radius: 4px;
  font-size: 14px;
}

.NotFound {
  background-color: #f2babfa6; /* kuning lembut */
  color: #dc3545;           /* teks kuning tua */
  border: 1px solid #ffeeba;
  padding: 8px 12px;
  margin-bottom: 10px;
  border-radius: 4px;
  font-size: 14px;
}

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
  gap: 0rem;
}

.buatLogo {
  width: 200px;
  height: 355px;
  background-color: rgba(183, 197, 255, 0.7);
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
  margin-top: 5rem;
}

.title {
  margin-left: 3rem;
  margin-top: 0rem;
  line-height: 1.2;
}

.loginTitle {
  color: black;
  text-align: center;
  margin-bottom: 45px;
  margin-top: 100px;
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
  margin-bottom: 5%;
}

.placeholderLgn {
  background-color: white;
  color: black;
}

button:hover {
  background-color: #369870;
}

p.error {
  margin-top: 1rem;
  font-weight: bold;
  color: #ef4444;
}

/* Loading States */
.loading-container-login {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 100px;
  width: 100%;
}

.loading-spinner-login {
  width: 30px;
  height: 30px;
  border: 4px solid #0D47A1;
  border-top: 4px solid #64B5F6;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>