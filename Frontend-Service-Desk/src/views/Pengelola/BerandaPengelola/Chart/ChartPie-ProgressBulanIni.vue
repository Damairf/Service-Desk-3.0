<script setup>
  import {ref, onMounted, computed, onBeforeMount} from 'vue'
  import axios from 'axios';
  import { Bar, Pie } from 'vue-chartjs';
  import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  CategoryScale,
  LinearScale,
  BarElement,
  ArcElement
} from 'chart.js'
import { color } from 'chart.js/helpers';

// Registrasi komponen Chart.js
ChartJS.register(Title, Tooltip, Legend, CategoryScale, LinearScale, BarElement, ArcElement)

//placeholder untuk diskominfo
// ceritanya backend
const labelProgressBulanIni = ref([]);
const dataProgressBulanIni = ref([]);

onBeforeMount(async () => {
  try {
    const token = localStorage.getItem('Token');
    const response = await axios.get('http://127.0.0.1:8000/api/stsPelayananChartBulanIni', {
      headers: {
        Authorization: 'Bearer ' + token
      }
    });
    const data = response.data;
    labelProgressBulanIni.value = data.map(item => item.status);
    dataProgressBulanIni.value = data.map(item => item.total);
  } catch (error) {
    labelProgressBulanIni.value = ['Baru',  'Disetujui',  'Ditolak', 'Proses', 'Selesai', 'Tutup'];
    dataProgressBulanIni.value = [0, 0, 0, 0, 0, 0];
  }
});

//data fixed jadi cmn ada di FrontEnd
const warnaChart = ['#4264C2', '#F3D13C', '#E74C3C', '#F39C12', '#27AE60', '#8E44AD'];

//presentasi progress bulan ini
const progressBulanIniData = computed(() => ({
  labels: labelProgressBulanIni.value,
  datasets: [
    {
      label: "Presentase Progress",
      data: dataProgressBulanIni.value,
      backgroundColor: warnaChart
    }
  ]
}));

const configProgressBulanIni = {
  maintainAspectRatio: false,
  responsive: true,
  layout: {
    padding: {
      top: 15  // Ganti sesuai kebutuhan, misalnya 0 atau 5
    }
  },
  plugins: {
    legend: {
      position: 'right',
    },
    title: {
      display: true,
      text: "Persentase Progress Bulan Ini",
      color: '#000000',
      font: {
        size: 16,
        weight: 'bold'
      }
    }
  }
}

</script>

<template>
    <div class="chart-container">
        <Pie :data="progressBulanIniData" :options="configProgressBulanIni" />
    </div>
</template>

<style scoped>
.chart-container {
    width: 300px;
    margin: 0;
    height: 300px;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>