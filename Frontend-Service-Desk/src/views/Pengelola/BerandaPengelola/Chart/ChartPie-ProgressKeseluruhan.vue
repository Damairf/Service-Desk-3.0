<script setup>
  import {ref, onMounted, onBeforeMount, computed} from 'vue'
  import axios from 'axios';
  import { Pie } from 'vue-chartjs';
  import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  ArcElement
} from 'chart.js'

// Registrasi komponen Chart.js yang diperlukan untuk Pie chart
ChartJS.register(Title, Tooltip, Legend, ArcElement)

//placeholder untuk diskominfo
// ceritanya backend
const labelProgressKeseluruhan = ref([]);
const dataProgressKeseluruhan = ref([]);

onBeforeMount(async () => {
  try {
    const token = localStorage.getItem('Token');
    const response = await axios.get('http://127.0.0.1:8000/api/pelayananchart', {
      headers: {
        Authorization: 'Bearer ' + token
      }
    });
    
    console.log(response.data);
    const data = response.data;
    labelProgressKeseluruhan.value = data.map(item => item.status);
    dataProgressKeseluruhan.value = data.map(item => item.total);
  } catch (error) {
    console.error('Error fetching chart data:', error);
    // Fallback data jika API gagal
    labelProgressKeseluruhan.value = ['Baru',  'Disetujui',  'Ditolak', 'Proses', 'Selesai', 'Ditolak'];
    dataProgressKeseluruhan.value = [0, 0, 0, 0];
  }
});

//data fixed jadi cmn ada di FrontEnd
const warnaChart = ['#4264C2', '#CA4D2D', '#F3A33C', '#449533']
//presentasi progress keseluruhan
const progressKeseluruhanData = computed(() => ({
  labels: labelProgressKeseluruhan.value,
  datasets: [
    {
      label: "Presentase Progress",
      data: dataProgressKeseluruhan.value,
      backgroundColor: warnaChart
    }
  ]
}));

const configKeseluruhanData = {
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
      text: "Persentase Progress Keseluruhan",
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
        <Pie :data="progressKeseluruhanData" :options="configKeseluruhanData" />
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