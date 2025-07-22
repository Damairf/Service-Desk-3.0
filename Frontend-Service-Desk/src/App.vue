<script>
import HelloWorld from './components/HelloWorld.vue'
import Beranda from './views/User/Navbar/navbar.vue';
import LoginPage from './views/loginPage.vue';
import { RouterLink, RouterView } from 'vue-router'

export default {
    data() {
        return {
            token : localStorage.getItem('data')
        }
    },
}

</script>

<template>
<router-view />
</template>

<style scoped>

</style>
