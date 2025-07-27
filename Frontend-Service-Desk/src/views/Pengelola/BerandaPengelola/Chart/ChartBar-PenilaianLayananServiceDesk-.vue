<script setup>
  import {ref, onMounted, onBeforeMount, computed} from 'vue'
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

// Registrasi komponen Chart.js
ChartJS.register(Title, Tooltip, Legend, CategoryScale, LinearScale, BarElement, ArcElement)

//Ceritanya Backend
const labelPenilaianLayananServiceDesk = ref([]);
const dataPenilaianLayananServiceDesk = ref([]);

onBeforeMount(async () => {
  try {
    const token = localStorage.getItem('Token');
    const response = await axios.get('http://127.0.0.1:8000/api/ratePelayananChart', {
      headers: {
        Authorization: 'Bearer ' + token
      }
    });
    const data = response.data;
    labelPenilaianLayananServiceDesk.value = data.map(item => item.Rating);
    dataPenilaianLayananServiceDesk.value = data.map(item => item.total);
  } catch (error) {
  }
});
//data fixed jadi cmn ada di FrontEnd
const warnaChart = ['#449533', '#127593', '#F3A33C', '#F3A33C','#CA4D2D', '#999999']

// data dummy Bar
const penilaianLayananServiceDeskData = computed(() => ({
  labels: labelPenilaianLayananServiceDesk.value,
  datasets: [
    {
      label: 'Jumlah Penilaian',
      data: dataPenilaianLayananServiceDesk.value,
      backgroundColor: warnaChart
    }
  ]
}));
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
      text: "Penilaian Service Desk",
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