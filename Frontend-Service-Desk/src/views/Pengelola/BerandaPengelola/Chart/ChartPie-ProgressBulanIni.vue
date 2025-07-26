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
const labelProgressBulanIni = ['Close', 'Selesai']
const dataProgressBulanIni = [60, 20]

//data fixed jadi cmn ada di FrontEnd
const warnaChart = ['#4264C2', '#CA4D2D']
//presentasi progress bulan ini
const progressBulanIniData = {
  labels: labelProgressBulanIni,
  datasets: [
    {
      label: "Presentase Progress",
      data: dataProgressBulanIni,
      backgroundColor: warnaChart
    }
  ]
} 

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