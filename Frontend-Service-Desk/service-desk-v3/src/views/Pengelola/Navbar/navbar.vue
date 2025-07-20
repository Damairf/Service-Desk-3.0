<script setup>
  import {ref} from 'vue'

  /*buat collapse */
  const collapse = ref(false)
  function toggleSidebar() {
    collapse.value = !collapse.value
  }

  /* biar ada isi kliknya */
  const menuItem = [
  "Beranda", "Pengajuan Permintaan", 
  "Permintaan Baru", "Lacak Permintaan",
  "Hasil Pemenuhan SLA dan BA", "Riwayat",
  "History"]

  /* biar bisa diklik */
  const selected = ref('Beranda')
  function selectMenu(item) {
    selected.value = item
  }

  /* biar warna hovernya beda */
  const getHoverClass = (item) => {
    if(["Beranda", "Riwayat", "History"].includes(item)){
      return "hover-blue";
    }
    else if(["Pengajuan Permintaan", "Permintaan Baru"].includes(item)){
      return "hover-yellow";
    }
    else{
      return "hover-green";
    }
  }
</script>


<template>
  <div class="wrapperAtas">
    <div class="judul">
      <div>SERVICE</div>
      <div>DESK V3.0</div>
    </div>
    <div class="akun">
      <h4>Nama User</h4>
    </div>
  </div>
  <div class="layout">
    <aside class="sidebar" :class="{collapsed : collapse}">
      <button class="toggle-btn" @click="toggleSidebar">
        {{ collapse ? '→' : '←' }}
      </button>
      <ul>
        <li v-for="item in menuItem" key: item
        :class="[getHoverClass(item),
        {active: item === selected}]"
        @click="selectMenu(item)">
          <span class="menu-text" :class="{ collapsed: collapse }">
              {{ item }}
          </span>
        </li>
      </ul>
    </aside>
    <main class="content">
      <h1>{{ selected }}</h1>
      <p>Konten untuk menu "{{ selected }}" akan ditampilkan di sini.</p>
    </main>
  </div>
</template>

<style scoped>

.menu-text.collapsed {
  opacity: 0;
  width: 0;
  max-width: 0;
}


.sidebar.collapsed {
  width: 60px;
}

.toggle-btn{
  position: relative;
  top: 10px;
  right: -15px;
  width: 30px;
  height: 30px;
  background-color: #1abc9c;
  border: none;
  border-radius: 50%;
  color: white;
  cursor: pointer;
  font-weight: bold;
}

.hover-blue:hover{
  background-color: #EBF7FE;
  border-radius: 5px;
  transform: scale(1.03);
  
}

.hover-yellow:hover{
  background-color: #FBF2AE;
  border-radius: 5px;
  transform: scale(1.03);
}

.hover-green:hover{
  background-color: #E1F6E0;
  border-radius: 5px;
  transform: scale(1.03);
}

.sidebar li{
  padding: 1.1rem 2.1rem;
  box-sizing: border-box;
  cursor: pointer;
  border-radius:20px;
  box-shadow: 0 5px 5px rgba(0, 0, 0, 0.1);
  
  transition: background-color 0.2s ease, border-radius 0.25s ease, padding 0.1s ease;
  
}

/* teksnya */
.sidebar ul {
  list-style: none;
  padding: 0;
  transition: opacity 0.3s ease, width 0.3s ease;
}

.wrapperAtas{
  display: flex;
  z-index: 1000;
  gap: 0 rem;
  position: sticky;
  top: 0;
  text-align: center;
}

.judul{
  /*display: ;*/
  justify-content: center;
  align-content: center;
  background-color: #099D49;
  color: white;
  width: 74rem;
  padding-top: 0;
}

.akun{
  background-color: #0185DA;
  width: 15rem;
  text-align: center;
  color: white;
}

.layout {
  display: flex;
  height: 100vh;
}

.sidebar {
  width: 220px;
  background-color: white;
  color: black;
  padding: 1rem;
  border-top-right-radius: 20px;
  border-bottom-right-radius: 20px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  transition: width 0.2s ease;
  position: sticky;
}

.content {
  flex: 1;
  padding: 2rem;
}
</style>