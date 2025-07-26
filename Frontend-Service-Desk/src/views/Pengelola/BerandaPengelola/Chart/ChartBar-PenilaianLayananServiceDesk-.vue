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

// Registrasi komponen Chart.js
ChartJS.register(Title, Tooltip, Legend, CategoryScale, LinearScale, BarElement, ArcElement)

//Ceritanya Backend
const labelPenilaianLayananServiceDesk = ['Rating 5', 'Rating 4', 'Rating 3', 'Rating 2', 'Rating 1', 'Belum Diisi']
const dataPenilaianLayananServiceDesk = [120,90,150,110, 200, 10]
//data fixed jadi cmn ada di FrontEnd
const warnaChart = ['#449533', '#449533', '#F3A33C', '#F3A33C','#CA4D2D', '#999999']

// data dummy Bar
const penilaianLayananServiceDeskData = {
  labels: labelPenilaianLayananServiceDesk,
  datasets: [
    {
      label: 'Jumlah Penilaian',
      data: dataPenilaianLayananServiceDesk,
      backgroundColor: warnaChart
    }
  ]
}
//bar
const configPenilaianLayananServiceDesk = {
    maintainAspectRatio: false,
  responsive: true,
  layout: {
    padding: {
      top: 15  // Ganti sesuai kebutuhan, misalnya 0 atau 5
    }
  },
  plugins: {
    legend: {
      display: false,
    },
    title: {
      display: true,
      text: "Persentase Berdasarkan Status",
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
<div style="height: 400px">
    <Bar :data="penilaianLayananServiceDeskData" :options="configPenilaianLayananServiceDesk" />
</div>
</template>