<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()
const idLayanan = ref(route.query.layanan || '')
const currentStep = ref(0) // buat tau 
const steps = ref([])
const fakeLoading = ref(true)

// onUnmounted(() => {
  // if (route.name !== 'HalamanLacak' && route.name !== 'HalamanInformasi') {
    // localStorage.removeItem('steps');
  // }
// });


onMounted(() => {
  // Tampilkan loading segera
  fakeLoading.value = true

  // Proses steps setelah loading ditampilkan
  setTimeout(() => {
    const stepsParam = route.query.steps
    if (stepsParam) {
      try {
        steps.value = JSON.parse(stepsParam)
        console.log('berhasil', steps.value)
      } catch (e) {
        console.error('Gagal parse steps dari query:', e)
      }
    }
    fakeLoading.value = false
  }, 500) // loading ditampilkan selama 0.5 detik
})



// onMounted(() => {
//   setTimeout(() => {
//     fakeLoading.value = false
//   }, 1500)

//   const savedSteps = localStorage.getItem('steps')
//   if (savedSteps) {
//     try {
//       steps.value = JSON.parse(savedSteps)
//     } catch (e) {
//       console.error('Gagal parse steps dari localStorage:', e)
//     }
//   } else {
//     console.warn('Steps belum ada di localStorage')
//   }
// })
</script>

<template>
  <div v-if="fakeLoading" style="text-align: center; padding: 1rem;">
    <h4>Memuat data</h4>
  </div>
  <div v-else>
    <h2 class="card-title">Detail Progress<br>{{ idLayanan }}</h2>
    <div class="step-wrapper">
      <div
        v-for="(step, index) in steps"
        :key="index"
        class="step-row"
      >
        <div
          class="circle"
          :class="index < currentStep ? 'circle-active' : 'circle-inactive'"
        >
          {{ index + 1 }}
        </div>

        <div class="step-label">
          {{ step }}
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.container {
  width: 100%;
  padding: 24px;
  background-color: #f6f0fc;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  padding: 32px;
}

/* Tabs */
.tabs {
  align-self: flex-start;
  display: flex;
  gap: 16px;
  background-color: white;
  padding: 8px 16px;
  border-radius: 8px 8px 0 0;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

.tab {
  padding: 8px 16px;
  border-radius: 8px 8px 0 0;
  font-weight: 600;
  cursor: pointer;
  transition: background-color 0.3s ease, transform 0.2s ease;
}

.tab:hover {
  transform: scale(1.05);
}

.active-tab-info {
  color: black;
  background-color: #fb923c;
}

.active-tab-track {
  background-color: #fb923c;
  color: black;
}

.inactive-tab {
  color: #6b7280;
}

/* Card */
.card {
  width: 100%;
  max-width: 640px;
  background-color: white;
  padding: 32px;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.card-title {
  font-size: 20px;
  font-weight: bold;
  margin-bottom: 32px;
}

/* Steps */
.step-wrapper {
  position: relative;
  padding-left: 36px;
}

.vertical-line {
  position: absolute;
  top: 20px;
  left: 20px;
  bottom: 0;
  width: 2px;
  background-color: #d1d5db;
  z-index: 0;
}

.step-row {
  position: relative;
  display: flex;
  align-items: center;
  margin-bottom: 32px;
  z-index: 10;
}

.circle {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  font-weight: bold;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-right: 16px;
  flex-shrink: 0;
  transition: transform 0.2s ease;
  font-size: 16px;
}

.circle:hover {
  transform: scale(1.1);
}

.circle-active {
  background-color: #22c55e;
  color: white;
}

.circle-inactive {
  background-color: #d1d5db;
  color: white;
}

.step-label {
  font-size: 16px;
  font-weight: 600;
  color: #1f2937;
}
</style>
