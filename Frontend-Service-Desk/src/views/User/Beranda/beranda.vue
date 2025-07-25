<script setup>
  import { ref, computed, onBeforeMount, onMounted } from 'vue';
  import axios from 'axios'
  import { useRouter } from 'vue-router'

  
  // biar tombolnya bisa berfungsi
   function handleOK(){
    selectMenu('Permintaan Baru')
  }

const nama_depan = ref('')
const nama_belakang = ref('')
const nip_user = ref('')
const id_role = ref('')
const nama_role = ref('')
const nama_jabatan = ref('')
const nama_organisasi = ref('')
const gambar = ref('')
const router = useRouter()

onMounted(()=> {
  const token = localStorage.getItem('Token');
  if(!token) {
    router.push('/login')
  }
})

onBeforeMount(() => {
  const token = localStorage.getItem('Token');
  axios.get('http://127.0.0.1:8000/api/user/profile', {
    headers: {
      Authorization: 'Bearer ' + token
    }
  })
  .then(response => {
    console.log(response)
    nama_depan.value = response.data.Nama_Depan
    nama_belakang.value = response.data.Nama_Belakang
    nip_user.value = response.data.NIP
    id_role.value = response.data.ID_Role
    gambar.value = response.data.Gambar_Path
    nama_role.value = response.data.user_role.map(item => item.Nama_Role)
    nama_jabatan.value = response.data.user_jabatan.map(item => item.Nama_Jabatan)
    nama_organisasi.value = response.data.user_organisasi.map(item => item.Nama_OPD)
    localStorage.setItem('nama_depan', response.data.Nama_Depan)
    localStorage.setItem('nama_belakang', response.data.Nama_Belakang)
    localStorage.setItem('nip_user', response.data.NIP)
    localStorage.setItem('ID_User', response.data.ID_User)
    localStorage.setItem('src_gambar', response.data.Gambar_Path)
    localStorage.setItem('role_id', response.data.user_role.map(item => item.ID_Role))
    localStorage.setItem('nama_role', response.data.user_role.map(item => item.Nama_Role))
    localStorage.setItem('nama_jabatan', response.data.user_jabatan.map(item => item.Nama_Jabatan))
    localStorage.setItem('nama_organisasi', response.data.user_organisasi.map(item => item.Nama_OPD))
  })
  .catch(error => {
    console.error(error);
  });
});


</script>
  
  <template>
      <div class="container">
        <div class="greet">
        <h1>Selamat datang, {{ nama_depan + " " + nama_belakang }}</h1>
        <p>
          Ada yang bisa kami bantu?
        </p>
      </div>
      <div class="boxHolder">
        <div class="box">
          <h3>Permintaan Baru</h3>
          <p>Mulai permintaan pelayanan pada Diskominfo Jabar</p>
          <button class="tambah" @click="handleOK">Baru</button>
        </div>
        <div class="box">
          <h3>Lacak Permintaan</h3>
          <p>Mulai permintaan pelayanan pada Diskominfo Jabar</p>
          <button class="lacak">Lacak</button>
        </div>
      </div>
      </div>
    </template>
    
    <style>
      html, body {
      height: 100%;
      margin: 0;
      padding: 0;
    }
    </style>
    
    <style scoped>
    
    .container{
      background-color: #FAF4FF;
      min-height: 100vh;
      padding: 1rem;
      position: relative;
    }
    
    .greet h1{
      color: black;
      margin: 0;
      margin-top: 2rem;
      font-size: 37px;
    }
    
    .greet p{
      color: #6B6B6B;
      margin-top: 1rem;
      font-size: 20px;
    }
    
    .boxHolder {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 2rem;
    }

    .box {
      background-color: white;
      width: 100%;
      max-width: 30rem;
      min-width: 250px;
      height: 30rem;
      border-radius: 8px;
      box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1);
      position: relative;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      gap: 0.5rem;
      margin-top: 5rem;
    }

    @media (max-width: 900px) {
      .boxHolder {
        flex-direction: column;
        align-items: center;
        gap: 2rem;
      }
      .box {
        max-width: 90vw;
        height: auto;
        margin-top: 2rem;
      }
    }
    
    .box h3 {
      text-align: left;
      margin: 0;
    }
    .box p {
      margin: 0 1rem; /* supaya gak mepet kiri-kanan */
      color: #333;
      font-size: 0.9rem;
      text-align: left;
      font-weight: lighter;
    }
    
    /*tombol baru & lacak*/
    .tambah, .lacak {
      background-color: #006920;
      border-radius: 100px;
      color: white;
      cursor: pointer;
      margin-top: 1.2rem;
    
      /*text*/
      font-size: 1.25rem;
      font-weight: bold;
      padding: 1rem 3rem;
      border: none;
      min-width: 100px; 
    }
    
    </style>