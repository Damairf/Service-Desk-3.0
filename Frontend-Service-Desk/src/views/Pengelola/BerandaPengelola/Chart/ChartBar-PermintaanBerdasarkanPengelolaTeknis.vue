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
const labelPermintaanBerdasarkanPengelolaTeknis = ['Ipul1', 'Ipul2', 'Ipul3', 'Ipul4', 'Ipul5', 'Ipul6']
const dataPermintaanBerdasarkanPengelolaTeknis = [120,90,150,110, 200, 20]
//data fixed jadi cmn ada di FrontEnd
const warnaChart = ['#4264C2', '#CA4D2D', '#F3A33C', '#449533', '#CC557D', '#A83A2D', '#9845A1', '#51AC9A', '#ABAB3B', '#6137C7', '#601861']

// data dummy Bar
const permintaanBerdasarkanPengelolaTeknisData = {
  labels: labelPermintaanBerdasarkanPengelolaTeknis,
  datasets: [
    {
      label: 'Jumlah Permintaan',
      data: dataPermintaanBerdasarkanPengelolaTeknis,
      backgroundColor: warnaChart
    }
  ]
}
//bar
const configpermintaanBerdasarkanPengelolaTeknis = {
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
      text: "Persentase Berdasarkan Pengelola Teknis",
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
    <Bar :data="permintaanBerdasarkanPengelolaTeknisData" :options="configpermintaanBerdasarkanPengelolaTeknis" />
</div>
</template>