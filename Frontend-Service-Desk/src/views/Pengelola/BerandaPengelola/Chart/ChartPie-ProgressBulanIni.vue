<script setup>
import { ref, onBeforeMount, computed } from 'vue'
import axios from 'axios'
import { Pie } from 'vue-chartjs'
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

// Register Chart.js components
ChartJS.register(Title, Tooltip, Legend, CategoryScale, LinearScale, BarElement, ArcElement)

// API Data
const labelProgressBulanIni = ref([])
const dataProgressBulanIni = ref([])

onBeforeMount(async () => {
  try {
    const token = localStorage.getItem('Token')
    const response = await axios.get('http://127.0.0.1:8000/api/stsPelayananChartBulanIni', {
      headers: {
        Authorization: 'Bearer ' + token
      }
    })
    const data = response.data
    labelProgressBulanIni.value = data.map(item => item.status)
    dataProgressBulanIni.value = data.map(item => item.total)
  } catch (error) {
    labelProgressBulanIni.value = ['Baru', 'Disetujui', 'Ditolak', 'Proses', 'Selesai', 'Tutup']
    dataProgressBulanIni.value = [0, 0, 0, 0, 0, 0]
  }
})

// Pie chart colors
const warnaChart = ['#4264C2', '#F3D13C', '#E74C3C', '#F39C12', '#27AE60', '#8E44AD']

// Computed chart data
const progressBulanIniData = computed(() => ({
  labels: labelProgressBulanIni.value,
  datasets: [
    {
      label: 'Presentase Progress',
      data: dataProgressBulanIni.value,
      backgroundColor: warnaChart
    }
  ]
}))

// Chart config with percentage tooltip
const configProgressBulanIni = {
  maintainAspectRatio: false,
  responsive: true,
  layout: {
    padding: {
      top: 15
    }
  },
  plugins: {
    legend: {
      position: 'right'
    },
    title: {
      display: true,
      text: 'Persentase Progress Bulan Ini',
      color: '#000000',
      font: {
        size: 16,
        weight: 'bold'
      }
    },
    tooltip: {
      callbacks: {
        label: function (context) {
          const label = context.label || ''
          const value = context.parsed || 0
          const data = context.dataset.data
          const total = data.reduce((sum, val) => sum + val, 0)
          const percentage = total ? ((value / total) * 100).toFixed(2) : 0
          return `${label}: ${percentage}%`
        }
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
