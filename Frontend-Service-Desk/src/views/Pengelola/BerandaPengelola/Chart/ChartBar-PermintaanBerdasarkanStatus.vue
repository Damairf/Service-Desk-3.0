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
const labelPermintaanBerdasarkanStatus = ['Baru', 'Proses', 'Selesai', 'Tutup']
const dataPermintaanBerdasarkanStatus = [120,90,150,110]
//data fixed jadi cmn ada di FrontEnd
const warnaChart = ['#4264C2', '#CA4D2D','#F3A33C', '#449533']

// data dummy Bar
const permintaanBerdasarkanStatusData = {
  labels: labelPermintaanBerdasarkanStatus,
  datasets: [
    {
      label: 'Jumlah Permintaan',
      data: dataPermintaanBerdasarkanStatus,
      backgroundColor: warnaChart
    }
  ]
}
//bar
const configpermintaanBerdasarkanStatus = {
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
      text: "Permintaan Berdasarkan Status",
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
    <Bar :data="permintaanBerdasarkanStatusData" :options="configpermintaanBerdasarkanStatus" />
</div>
</template>