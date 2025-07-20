<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
const router = useRouter()

const username = ref('')
const password = ref('')
const message = ref('')

function login() {
  if (username.value === 'admin' && password.value === '1234') {
    message.value = '✅ Login successful!'
    router.push('/beranda')
  } else {
    message.value = '❌ Invalid username or password.'
  }
}
</script>

<template>
  <div class="container">
    <div class="flex-wrapper">
      <div class="buatLogo">
        <h2 class="title">Service Desk <br>V3.0</h2>
      </div>
      <div class="login-box">
        <h2 class="loginTitle">Login</h2>
        <input class="placeholderLgn" v-model="username" type="text" placeholder="Username" />
        <input class="placeholderLgn" v-model="password" type="password" placeholder="Password" />
        <button class= "login" @click="login">Login</button>
        <p class= "invalidLogin">{{ message }}</p>
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
  text-align: center;
  color: black;
  backdrop-filter: blur(10px);
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

.title{
  padding-top: 50%;
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