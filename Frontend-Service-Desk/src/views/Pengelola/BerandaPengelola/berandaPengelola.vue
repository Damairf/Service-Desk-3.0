<script setup>
import { ref } from 'vue'
import ChartProgressKeseluruhan from './Chart/ChartPie-ProgressKeseluruhan.vue'
import ChartProgressBulanIni from './Chart/ChartPie-ProgressBulanIni.vue'
import ChartPermintaanLayanan from './Chart/ChartPie-PermintaanLayanan.vue'
import ChartBarPermintaanBerdasarkanStatus from './Chart/ChartBar-PermintaanBerdasarkanStatus.vue'
import ChartBarPermintaanBerdasarkanPengelolaTeknis from './Chart/ChartBar-PermintaanBerdasarkanPengelolaTeknis.vue'
import ChartBarPenilaianLayananServiceDesk from './Chart/ChartBar-PenilaianLayananServiceDesk-.vue'
// ceritanya backend
const jumlahPermintaanBaru = ref(100)
const jumlahPenggunaTerdaftar = ref(100)
const jumlahOrganisasiTerdaftar = ref(100)
</script>

<template>
    <h1 class="dashboard-title">Beranda</h1>

<!-- Ringkasan: 3 kotak atas -->
<div class="box-row">
  <div class="summary-box">
    <p class="label">Permintaan Baru</p>
    <div class="summary-content">
      <div class="icon">📄</div>
      <p class="value">{{ jumlahPermintaanBaru }}</p>
    </div>
  </div>
  <div class="summary-box">
    <p class="label">Pengguna Terdaftar</p>
    <div class="summary-content">
      <div class="icon">👤</div>
      <p class="value">{{ jumlahPenggunaTerdaftar }}</p>
    </div>
  </div>
  <div class="summary-box">
    <p class="label">Organisasi Terdaftar</p>
    <div class="summary-content">
      <div class="icon">👥</div>
      <p class="value">{{ jumlahOrganisasiTerdaftar }}</p>
    </div>
  </div>
</div>

<!-- Chart Pie: 3 kotak -->
<div class="box-row">
  <div class="chart-box">
    <div class="chart-container">
      <ChartProgressKeseluruhan />
    </div>
  </div>
  <div class="chart-box">
    <div class="chart-container">
      <ChartProgressBulanIni />
    </div>
  </div>
  <div class="chart-box">
    <ChartPermintaanLayanan/>
  </div>
</div>

<!-- Chart Bar: 3 baris -->
<div class="bar-chart-section">
  <div class="chart-full">
    <ChartBarPermintaanBerdasarkanStatus/>
  </div>

  <div class="chart-full">
    <ChartBarPermintaanBerdasarkanPengelolaTeknis/>
  </div>

  <div class="chart-full">
    <ChartBarPenilaianLayananServiceDesk/>
  </div>
</div>
</template>

<style scoped>
.dashboard {
  padding: 30px;
  background-color: #f5f2fb;
  min-height: 100vh;
}

.dashboard-title {
  text-align: left;
  color: black;
  font-size: 32px;
  font-weight: bold;
  margin-bottom: 24px;
}

.box-row {
  display: flex;
  flex-wrap: wrap;
  gap: 16px;
  margin-bottom: 24px;
}

.summary-box {
  text-align: left;
  flex: 1;
  min-width: 250px;
  background-color: white;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  padding: 16px;
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.label {
  color: black;
  font-weight: 600;
  font-size: 16px;
  margin: 0;
}

.summary-content {
  display: flex;
  align-items: center;
  gap: 16px;
}

.icon {
  font-size: 40px;
}

.value {
  color: black;
  font-size: 36px;
  font-weight: bold;
  margin: 0;
}

.chart-box {
  flex: 1;
  min-width: 250px;
  background-color: white;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  padding-left: 16px;
  padding-right: 16px;
}

.chart-container {
  margin: 0;
  width: 100%;
  height: 100%;
}

.bar-chart-section {
  display: flex;
  flex-direction: column;
  gap: 24px;
  margin-top: 24px;
}

.chart-full {
  width: 100%;
  background-color: white;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  padding: 24px;
  box-sizing: border-box;
}

.chart-title {
  color: black;
  font-weight: 600;
  margin-bottom: 12px;
}
</style>
