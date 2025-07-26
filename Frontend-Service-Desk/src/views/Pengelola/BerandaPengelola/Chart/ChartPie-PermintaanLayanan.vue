<script setup>
  import {ref, onMounted} from 'vue'
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
const labelPermintaanLayanan = ['Layanan1', 'Layanan2', 'Layanan3', 'Layanan4', 'Layanan5', 'Layanan6', 'Layanan7', 'Layanan8', 'Layanan9', 'Layanan10', 'Layanan11']
const dataPermintaanLayanan = [12, 9, 14, 8, 6, 10, 7, 11, 5, 9, 9]

//data fixed jadi cmn ada di FrontEnd
const warnaChart = ['#4264C2', '#CA4D2D', '#F3A33C', '#449533', '#CC557D', '#A83A2D', '#9845A1', '#51AC9A', '#ABAB3B', '#6137C7', '#601861']
//presentasi progress keseluruhan
const PermintaanLayananData = {
  labels: labelPermintaanLayanan,
  datasets: [
    {
      label: "Presentase Layanan",
      data: dataPermintaanLayanan,
      backgroundColor: warnaChart
    }
  ]
} 

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