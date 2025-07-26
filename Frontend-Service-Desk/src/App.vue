<script setup>
import { RouterLink, RouterView } from 'vue-router'
import Sidebar from '../src/views/SideBar/sidebar.vue';
import { useRoute } from 'vue-router'
import { ref, onMounted } from 'vue'

const route = useRoute()
const isSidebarCollapsed = ref(false)

// Listen for sidebar state changes
onMounted(() => {
  window.addEventListener('sidebar-toggle', (event) => {
    isSidebarCollapsed.value = event.detail.isCollapsed
  })
})
</script>

<template>
    <div v-if="route.path !== '/login'" class="sidebar-wrapper">
        <Sidebar/>
    </div>
    <div class="main-content"
        :class="{ 
          'with-sidebar': route.path !== '/login',
          'sidebar-collapsed': isSidebarCollapsed && route.path !== '/login'
        }">
        <RouterView/>
    </div>
</template>

<style>
html, body, #app {
  height: 100%;
  min-height: 100%;
  margin: 0;
  padding: 0;
  background: #FAF4FF !important;
}
</style>

<style scoped>
.sidebar-wrapper {
    overflow-y: auto; /* Scrollable if content overflows */
    z-index: 100;
}

.with-sidebar {
    margin-left: 16rem; /* Sidebar width when expanded */
    padding: 20px;
    height: 100vh;
    transition: margin-left 0.2s ease;
}

.sidebar-collapsed {
    margin-left: 50px; /* Sidebar width when collapsed */
}

/* Responsive design for smaller screens */
@media (max-width: 768px) {
    .with-sidebar {
        margin-left: 50px;
    }
}
</style>
