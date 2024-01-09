<template>
    <div class="main-container">
        <div class="navbar-menu">
            <!-- <Navbar /> -->
        </div>
        <div class="content-container">
            <RouterView />
        </div>
    </div>
</template>

<script setup>
import Navbar from "./components/Navbar.vue";
</script>
