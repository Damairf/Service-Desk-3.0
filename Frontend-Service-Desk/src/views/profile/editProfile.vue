<script setup>
import { ref, reactive, computed, onMounted } from 'vue'
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
})

const showOverlay = ref(false)
const selectedImage = ref(null) // for preview
const fileInput = ref(null)
const newImageFile = ref(null) // for upload

const gambar = ref(localStorage.getItem('src_gambar'));
const imageSrc = computed(() => `http://localhost:8000/images/${gambar.value}?t=${Date.now()}`);
const previewSrc = computed(() => selectedImage.value || imageSrc.value);

const userID = localStorage.getItem("ID_User");

function triggerFileInput() {
  fileInput.value?.click()
}

function handleImageSelect(event) {
  const file = event.target.files[0];
  if (file && (file.type === 'image/png' || file.type === 'image/jpeg')) {
    selectedImage.value = URL.createObjectURL(file);
    newImageFile.value = file;
  } else {
    alert('Hanya mendukung gambar PNG atau JPEG')
    selectedImage.value = null;
    newImageFile.value = null;
  }
}

function uploadSelectedImage() {
  if (!newImageFile.value) return;
  const token = localStorage.getItem('Token');
  const formData = new FormData();
  formData.append('Gambar_Path', newImageFile.value);
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
    window.dispatchEvent(new Event('gambar-changed'));
    selectedImage.value = null;
    newImageFile.value = null;
    showOverlay.value = false;
    alert('Foto profil berhasil diubah!');
  })
  .catch(function(error) {
    console.log(error);
    alert(error.response?.data?.message || 'Terjadi kesalahan saat mengupload foto profil.');
  });
}

function cancelImageChange() {
  selectedImage.value = null;
  newImageFile.value = null;
  showOverlay.value = false;
}

function removeImage() {
  const token = localStorage.getItem('Token');
  axios.delete('http://127.0.0.1:8000/api/user/profilepict', {
    data: {
      ID_User: userID
    },
    headers: {
      Authorization: 'Bearer ' + token
    }
  })
  .then(response => {
    gambar.value = response.data.nama_file;
    localStorage.setItem('src_gambar', response.data.nama_file);
    window.dispatchEvent(new Event('gambar-changed'));
    selectedImage.value = null;
    newImageFile.value = null;
    showOverlay.value = false;
    alert('Foto profil berhasil dihapus!');
  })
  .catch(error => {
    console.error(error);
    alert(error.response?.data?.message || 'Terjadi kesalahan saat menghapus foto profil.');
  });
}

function saveChanges() {
  if (UbahPassword.PasswordBaru !== UbahPassword.KonfirmasiPassword) {
    alert('Konfirmasi password baru tidak cocok!');
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
    router.push('/profileSaya')
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
  router.push('/profileSaya');
}
</script>

<template>
  <div class="edit-profile-container">
    <div class="edit-profile-card">
      <!-- KIRI: FOTO PROFIL -->
      <div class="profile-left">
        <img
          class="profile-image-large"
          :src="imageSrc"
          alt="Foto Profil"
          @click="showOverlay = true"
        />
        <div class="profile-btn-group">
          <button class="btn edit" @click="showOverlay = true">
            <i class="fas fa-pen"></i> Ubah Foto
          </button>
          <button class="btn delete" @click="removeImage">
            <i class="fas fa-trash"></i> Hapus
          </button>
        </div>
      </div>
      <!-- KANAN: FORM PASSWORD -->
      <div class="profile-right">
        <h2 class="form-title">Ubah Password</h2>
        <div class="form-group">
          <label>Password Lama</label>
          <input type="password" v-model="PasswordLama.passwordLama" />
        </div>
        <div class="form-group">
          <label>Password Baru</label>
          <input type="password" v-model="UbahPassword.PasswordBaru" />
        </div>
        <div class="form-group">
          <label>Konfirmasi Password Baru</label>
          <input type="password" v-model="UbahPassword.KonfirmasiPassword" />
        </div>
        <div class="button-group">
          <button class="btn save" @click="saveChanges">Simpan</button>
          <button class="btn cancel" @click="cancelChanges">Batal</button>
        </div>
      </div>
      <!-- Overlay Ubah Foto -->
      <div v-if="showOverlay" class="overlay">
        <div class="overlay-content photo-overlay">
          <button class="close-btn" @click="cancelImageChange">×</button>
          <h2 class="overlay-title">Ubah Foto Profil</h2>
          <img
            class="photo-preview"
            :src="previewSrc"
            alt="Preview Foto Profil"
          />
          <input
            type="file"
            ref="fileInput"
            @change="handleImageSelect($event)"
            accept="image/png, image/jpeg"
            style="display: none"
          />
          <div class="wrapper-btn-edit">
            <button class="btn edit" @click="triggerFileInput()">
              <i class="fas fa-pen"></i> Pilih Foto
            </button>
          </div>
          <div class="action-buttons">
            <button class="btn save" :disabled="!newImageFile" @click="uploadSelectedImage">
              <i class="fas fa-save"></i> Simpan
            </button>
            <button class="btn cancel" @click="cancelImageChange">
              <i class="fas fa-times"></i> Batal
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.edit-profile-container {
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  background: #f7f7f7;
}
.edit-profile-card {
  display: flex;
  flex-direction: row;
  background: #fff;
  border-radius: 18px;
  box-shadow: 0 4px 16px rgba(0,0,0,0.08);
  padding: 2.5rem 2rem;
  gap: 2.5rem;
  max-width: 900px;
  width: 100%;
}
.profile-left {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  min-width: 260px;
  max-width: 320px;
  flex: 1;
}
.profile-image-large {
  width: 200px;
  height: 200px;
  object-fit: cover;
  border-radius: 50%;
  background: #d3d3d3;
  margin-bottom: 1.5rem;
  border: 4px solid #e0e0e0;
}
.profile-btn-group {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  width: 100%;
  align-items: center;
}
.btn {
  padding: 0.7rem 1.5rem;
  border: none;
  border-radius: 8px;
  font-weight: 500;
  font-size: 1rem;
  cursor: pointer;
  transition: background 0.2s, transform 0.2s;
  display: flex;
  align-items: center;
  justify-content: center;
}
.btn.edit {
  background: #2196f3;
  align-items: center;
  color: #fff;
}
.btn.edit:hover {
  background: #1976d2;
}
.btn.delete {
  background: #f44336;
  color: #fff;
}
.btn.delete:hover {
  background: #d32f2f;
}
.profile-right {
  flex: 2;
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
  background: #f8fafc;
  border-radius: 12px;
  padding: 2rem 2rem 1.5rem 2rem;
  min-width: 320px;
  max-width: 420px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}
.form-title {
  font-size: 1.4rem;
  font-weight: bold;
  margin-bottom: 1.5rem;
  color: #222;
  text-align: left;
}
.form-group {
  margin-bottom: 1.1rem;
  text-align: left;
}
.form-group label {
  display: block;
  font-weight: 500;
  margin-bottom: 0.4rem;
  color: #333;
}
.form-group input {
  width: 100%;
  padding: 0.5rem;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 1rem;
  color: #222;
  background: #fff;
}
.form-group input:disabled {
  background: #f0f0f0;
  color: #888;
}
.button-group {
  margin-top: 1.5rem;
  display: flex;
  gap: 1rem;
}
.btn.save {
  background: #006920;
  color: #fff;
}
.btn.save:hover {
  background: #52AE6E;
}
.btn.cancel {
  background: #f44336;
  color: #fff;
}
.btn.cancel:hover {
  background: #d32f2f;
}
/* Overlay (tetap gunakan style lama) */
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
.photo-preview {
  width: 160px;
  height: 160px;
  background-color: #ccc;
  border-radius: 50%;
  margin: 0 auto 1.5rem auto;
  background-size: cover;
  background-position: center;
}
.action-buttons {
  display: flex;
  justify-content: center;
  gap: 1rem;
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
.wrapper-btn-edit{
  display: flex;
  justify-content: center;
  margin-bottom: 2.5rem;
}

@media (max-width: 900px) {
  .edit-profile-card {
    flex-direction: column;
    align-items: center;
    padding: 2rem 0.5rem;
    gap: 1.5rem;
  }
  .profile-right {
    min-width: 0;
    max-width: 100%;
    width: 100%;
    padding: 1.5rem 1rem;
  }
  .profile-left {
    min-width: 0;
    max-width: 100%;
    width: 100%;
  }
}
</style>
