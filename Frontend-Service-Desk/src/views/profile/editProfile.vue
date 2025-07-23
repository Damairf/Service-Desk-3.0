<script setup>
import { ref, reactive, watch, computed } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const router = useRouter()

const UbahPassword = reactive({
  PasswordBaru: '',
  KonfirmasiPassword: '',
  KecocokanPassword: '',
})

const PasswordLama = reactive({
  passwordLama: '',
  konfirmasiPassword: '',
  passwordMatch: '',
})

const showOverlay = ref(false)
const selectedImage = ref(null)
const fileInput = ref(null)

watch(() => UbahPassword.KonfirmasiPassword, (newVal) => {
  UbahPassword.KecocokanPassword = newVal === UbahPassword.PasswordBaru ? 'Cocok' : 'Tidak Cocok'
})

watch(() => PasswordLama.konfirmasiPassword, (newVal) => {
  PasswordLama.passwordMatch = newVal === PasswordLama.passwordLama ? 'Cocok' : 'Tidak Cocok'
})

  const nama_depan = localStorage.getItem('nama_depan')
  const nama_belakang = localStorage.getItem('nama_belakang')

const userID = localStorage.getItem("ID_User");
function saveChanges() {
  if (UbahPassword.PasswordBaru !== UbahPassword.KonfirmasiPassword) {
    alert('Konfirmasi password baru tidak cocok!');
    return;
  }
  if (PasswordLama.passwordLama !== PasswordLama.konfirmasiPassword) {
    alert('Konfirmasi password lama tidak cocok!');
    return;
  }
  const token = localStorage.getItem('Token');
  axios.put('http://127.0.0.1:8000/api/user/profile', {
    ID_User: userID,          
    PasswordLama: PasswordLama.passwordLama, 
    PasswordBaru: UbahPassword.PasswordBaru
  },{
    headers: {
      Authorization: 'Bearer ' + token
    }
  })
  .then(response => {
    alert(response.data.message);
    localStorage.clear();
    router.push('/login')
    cancelChanges(); 
  })
  .catch(error => {
    console.error(error);
    alert(error.response?.data?.message || "Terjadi kesalahan saat mengubah password.");
  });
}



function cancelChanges() {
  UbahPassword.PasswordBaru = ''
  UbahPassword.KonfirmasiPassword = ''
  UbahPassword.KecocokanPassword = ''
  PasswordLama.passwordLama = ''
  PasswordLama.konfirmasiPassword = ''
  PasswordLama.passwordMatch = ''
}

function triggerFileInput() {
  fileInput.value?.click()
}

const gambar = ref(localStorage.getItem('src_gambar'));
const imageSrc = computed(() => `http://localhost:8000/images/${gambar.value}?t=${Date.now()}`);

function handleImageUpload(event) {
  const token = localStorage.getItem('Token');
  const file = event.target.files[0];
  if (file && (file.type === 'image/png' || file.type === 'image/jpeg')) {
    selectedImage.value = URL.createObjectURL(file);

    const formData = new FormData();
    formData.append('Gambar_Path', file);
    formData.append('ID_User', userID); 

    axios.post('http://127.0.0.1:8000/api/user/profilepict', formData, {
      headers: {
        Authorization: 'Bearer ' + token,
        'Content-Type': 'multipart/form-data'
      }
    })
    .then(function(response){
      gambar.value = response.data.nama_file;
      localStorage.setItem('src_gambar', response.data.nama_file);
      selectedImage.value = `http://localhost:8000/images/${response.data.nama_file}?t=${Date.now()}`;
      showOverlay.value = false; // close overlay if you want
    })
    .catch(function(error) {
      console.log(error)
    });
  } else {
    alert('Hanya mendukung gambar PNG atau JPEG')
  }
}

function removeImage() {
  selectedImage.value = ('default.jpeg')
  if (fileInput.value) fileInput.value.value = ('default.jpeg')
}
</script>

<template>
  <div class="container">
    <div class="profile-card">
      <img
        class="profile-image"
        :src="imageSrc"
        alt="Foto Profil"
        @click="showOverlay = true"
      />

      <h2 class="user-name">{{ nama_depan + " " + nama_belakang }}</h2>

      <div class="form-container">
        <div class="form-section">
          <h3>Ubah Password</h3>
          <div class="form-group">
            <label>Password Baru</label>
            <input type="password" v-model="UbahPassword.PasswordBaru" />
          </div>
          <div class="form-group">
            <label>Konfirmasi Password Baru</label>
            <input type="password" v-model="UbahPassword.KonfirmasiPassword" />
          </div>
          <div class="form-group">
            <label>Kecocokan Password Baru</label>
            <input type="text" v-model="UbahPassword.KecocokanPassword" disabled />
          </div>
        </div>

        <div class="form-section">
          <h3>Password Lama</h3>
          <div class="form-group">
            <label>Password</label>
            <input type="password" v-model="PasswordLama.passwordLama" />
          </div>
          <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" v-model="PasswordLama.konfirmasiPassword" />
          </div>
          <div class="form-group">
            <label>Kecocokan Password</label>
            <input type="text" v-model="PasswordLama.passwordMatch" disabled />
          </div>
        </div>
      </div>

      <div class="button-group">
        <button class="btn ubah" @click="saveChanges">Ubah</button>
        <button class="btn batal" @click="cancelChanges">Batal</button>
      </div>

      <div v-if="showOverlay" class="overlay">
        <div class="overlay-content photo-overlay">
          <button class="close-btn" @click="showOverlay = false">×</button>
          <h2 class="overlay-title">Foto profil</h2>
          <p class="overlay-subtext">
            Gambar membantu memberi tahu Anda saat Anda masuk ke akun Anda
          </p>

          <img
            class="photo-preview"
            :src="`http://localhost:8000/images/${gambar}`"
            alt="Preview Foto Profil"
          />

          <input
            type="file"
            ref="fileInput"
            @change="handleImageUpload($event)"
            accept="image/png, image/jpeg"
            style="display: none"
          />

          <div class="action-buttons">
            <button class="btn ubah" @click="triggerFileInput()">
              <i class="fas fa-pen"></i> Ubah
            </button>
            <button class="btn hapus" @click="removeImage">
              <i class="fas fa-trash"></i> Hapus
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<style scoped>
.profile-image,
.photo-preview {
  width: 160px;
  height: 160px;
  object-fit: cover;
  border-radius: 50%;
  margin: 0 auto 1.5rem auto;
  cursor: pointer;
  transition: transform 0.2s;
  background-color: #ccc;
}

.profile-image:hover {
  transform: scale(1.1);
}

.container {

  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 1rem;
}

.profile-card {
  background-color: white;
  border-radius: 16px;
  padding: 2rem;
  width: 100%;
  max-width: 800px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  text-align: center;
  position: relative;
}

.profile-image {
  width: 100px;
  height: 100px;
  background-color: #d3d3d3;
  border-radius: 50%;
  margin: 0 auto 1rem;
  cursor: pointer;
  transition: transform 0.2s;
  background-size: cover;
  background-position: center;
}

.profile-image:hover {
  transform: scale(1.1);
}

.user-name {
  font-size: 1.5rem;
  font-weight: bold;
  margin-bottom: 1.5rem;
}

.form-container {
  display: flex;
  justify-content: space-between;
  gap: 2rem;
}

.form-section {
  flex: 1;
  min-width: 300px;
  padding: 1rem;
  border: 1px solid #e0e0e0;
  border-radius: 8px;
}

.form-section h3 {
  font-size: 1.2rem;
  margin-bottom: 1rem;
  font-weight: bold;
}

.form-group {
  margin-bottom: 1rem;
  text-align: left;
  width: 95%;
}

.form-group label {
  display: block;
  font-weight: 500;
  margin-bottom: 0.5rem;
}

.form-group input {
  width: 100%;
  padding: 0.5rem;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 1rem;
  color: black;
  background-color: white;
}

.form-group input:disabled {
  background-color: #f0f0f0;
  color: #666;
}

.button-group {
  margin-top: 2rem;
  display: flex;
  justify-content: center;
  gap: 1rem;
}

.btn {
  padding: 0.75rem 1.5rem;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 500;
}

.ubah {
  background-color: #2196f3;
  color: white;
}

.ubah:hover {
  background-color: #1976d2;
}

.batal,
.btn.hapus {
  background-color: #f44336;
  color: white;
}

.batal:hover,
.btn.hapus:hover {
  background-color: #d32f2f;
}

/* Overlay*/
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

.overlay-content {
  background-color: white;
  padding: 1.5rem;
  border-radius: 12px;
  text-align: center;
  position: relative;
  min-width: 320px;
  max-width: 400px;
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.photo-overlay {
  align-items: center;
  justify-content: center;
  padding: 2rem 1rem;
  text-align: center;
  max-width: 360px;
  width: 100%;
  border-radius: 20px;
}

.overlay-title {
  font-size: 1.75rem;
  font-weight: bold;
  margin-bottom: 0.5rem;
  color: #333;
}

.overlay-subtext {
  font-size: 0.95rem;
  color: #666;
  margin-bottom: 1.5rem;
  line-height: 1.4;
}

.photo-preview {
  width: 160px;
  height: 160px;
  background-color: #ccc;
  border-radius: 50%;
  margin: 0 auto 1.5rem auto;
  background-image: url('https://cdn.pixabay.com/photo/2024/04/19/16/06/ai-generated-8706603_1280.jpg');
  background-size: cover;
  background-position: center;
}

.action-buttons {
  display: flex;
  justify-content: center;
  gap: 1rem;
}

.btn.hapus, .btn.batal{
  padding: 0.75rem 1.25rem;
  border-top-left-radius: 8px;
  border-bottom-left-radius: 8px;
  border-top-right-radius: 50px;
  border-bottom-right-radius: 50px;
  display: flex;
  align-items: center;
  font-weight: 500;
  font-size: 0.95rem;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
}

.btn.ubah {
  padding: 0.75rem 1.25rem;
  border-top-left-radius: 50px;
  border-bottom-left-radius: 50px;
  border-top-right-radius: 8px;
  border-bottom-right-radius: px;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-weight: 500;
  font-size: 0.95rem;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
}

.close-btn {
  position: absolute;
  top: 0.5rem;
  right: 0.5rem;
  background: none;
  border: none;
  font-size: 1.8rem;
  cursor: pointer;
  color: #f44336;
}

.close-btn:hover {
  color: #d32f2f;
  transform: scale(1.1);
}
</style>
