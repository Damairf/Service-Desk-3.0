<script setup>
import { RouterLink, RouterView } from 'vue-router'
import navbar from './views/User/Navbar/navbar.vue';
import Sidebar from '../src/views/SideBar/sidebar.vue';
import { useRoute } from 'vue-router'
const route = useRoute()


</script>

<template>
    <div v-if="route.path !== '/login'" class="sidebar-wrapper">
        <Sidebar/>
    </div>
    <div class="main-content"
        :class="{ 'with-sidebar': route.path !== '/login' }">
        <RouterView/>
    </div>
</template>

<style>
    html, body {
        scroll-behavior: smooth;
        height: auto;
        margin: 0;
        padding: 0;
        background-color: #FAF4FF;
    }
</style>

<style scoped>
.sidebar-wrapper {
    overflow-y: auto; /* Scrollable if content overflows */
    z-index: 100;
}

/* .main-content {
    margin-left: 250px; 
    padding: 20px;
    height: 100vh; Full height
} */

.with-sidebar {
    margin-left: 250px; /* Sidebar width */
    padding: 20px;
    height: 100vh;
}
</style>
