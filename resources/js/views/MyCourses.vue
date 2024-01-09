<template>
    <div class="my-courses-container">
        <div class="navbar-menu">
            <Navbar />
        </div>
        <div class="menu-content-container">
            <div class="header-menu">
                <Header />
            </div>
            <div class="overviews">
                <MyCoursesOverview :courses="courses" />
                <ProgressOverview />
                <RecomendedCourses />
                <AccomplishmentOverview />
            </div>
        </div>
    </div>
</template>

<script setup>
import Header from "./components/Header.vue";
import Navbar from "./components/Navbar.vue";
import MyCoursesOverview from "./components/MyCoursesOverview.vue";
import ProgressOverview from "./components/ProgressOverview.vue";
import RecomendedCourses from "./components/RecomendedCourses.vue";
import AccomplishmentOverview from "./components/AccomplishmentOverview.vue";
import axios from "axios";
import { ref } from "@vue/reactivity";

const courses = ref();

axios.get("user/courses").then((response) => {
    courses.value = response.data.data;
    console.log(courses);
});
</script>

<style lang="scss">
@import "../../scss/views/myCourses";
</style>
