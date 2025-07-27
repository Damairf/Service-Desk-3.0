<script setup>
  import {ref, onMounted , onBeforeMount, computed} from 'vue'
  import { Bar, Pie } from 'vue-chartjs';
  import axios from 'axios';
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
const labelPermintaanLayanan = ref([]);
const dataPermintaanLayanan = ref([]);

onBeforeMount(async () => {
  try {
    const token = localStorage.getItem('Token');
    const response = await axios.get('http://127.0.0.1:8000/api/jnsPelayananChart', {
      headers: {
        Authorization: 'Bearer ' + token
      }
    });
    const data = response.data;
    labelPermintaanLayanan.value = data.map(item => item.Jenis_Pelayanan);
    dataPermintaanLayanan.value = data.map(item => item.total);
  } catch (error) {
  }
});
//data fixed jadi cmn ada di FrontEnd
const warnaChart = ['#4264C2', '#CA4D2D', '#F3A33C', '#449533', '#CC557D', '#A83A2D', '#9845A1', '#51AC9A', '#ABAB3B', '#6137C7', '#601861']
//presentasi progress keseluruhan
const PermintaanLayananData = computed(() => ({
  labels: labelPermintaanLayanan.value,
  datasets: [
    {
      label: "Presentase Layanan",
      data: dataPermintaanLayanan.value,
      backgroundColor: warnaChart
    }
  ]
}));

const configPermintaanLayanan = {
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
      text: "Persentase Permintaan Pelayanan",
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
        <Pie :data="PermintaanLayananData" :options="configPermintaanLayanan" />
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