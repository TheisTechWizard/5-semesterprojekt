<template>
    <div class="course-overview-container">
        <div class="course-overview-top">
            <h2>Courses</h2>
            <a>View all
                <span>
                    <img src="../../../../public/img/svg/Arrow.svg" alt="arrow" /></span></a>
        </div>
        <div class="courses-list">
            <div class="column-titles">
                <p>Course name</p>
                <p>Importance</p>
                <p>Deadline</p>
            </div>
            <a href="" v-for="(course, index) in courses" :key="index">
                <div class="logo-title-wrapper">
                    <div>
                        <img src="../../../../public/img/svg/Course_icon.svg" alt="Course icon" />
                    </div>
                    <div>
                        <p>{{ course.name }}</p>
                        <p>{{ course.lessons.length }} Lessons</p>
                    </div>
                </div>
                <p>High</p>
                <p>02/05-22</p>
            </a>
        </div>
    </div>
</template>

<script setup>
import routes from './../../router/routes'

const props = defineProps({
    courses: {
        type: Array,
    },
});
</script>

<style lang="scss">
@import "../../../scss/components/courseOverview";
</style>
