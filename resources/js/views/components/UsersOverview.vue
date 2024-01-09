<template>
    <div class="user-overview-container">
        <div class="title">
            <h2>People</h2>
        </div>
        <div class="users-list">
            <div class="column-titles">
                <p></p>
                <p>Name</p>
                <p>Team</p>
                <p>Courses</p>
            </div>
            <div class="user" :class="{ selected: index === selectedIndex }" v-for="(user, index) in users" :key="index"
                v-on:click="selectitem(index)">
                <div class="user-info">
                    <img src="../../../../public/img/svg/person.svg" alt="profile pic" />
                    <p>{{ user.fname }} {{ user.lname }}</p>
                    <p></p>
                    <p>{{ user.courses.length }}</p>
                </div>

                <div class="user-expanded" v-if="index === selectedIndex">
                    <div class="contact-info">
                        <h3>Contact info</h3>
                        <p>{{ user.email }}</p>
                    </div>
                    <div class="courses-list">
                        <h3>Courses</h3>
                        <div class="course" v-for="(course, index) in user.courses" :key="index">
                            <p>{{ course.name }}</p>
                            <p>Is completed {{ course.isCompleted }}</p>
                        </div>
                    </div>
                    <div class="assign-course-btn">
                        <button v-on:click="assignCourse">Assign Course</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script setup>
// v-on:click = "$emit('item-selected', user)"
import { ref } from "@vue/reactivity";

const props = defineProps({
    users: {
        type: Array,
    },
});

const selectedIndex = ref();

function selectitem(index) {
    selectedIndex.value = index
}
</script>

<style lang="scss">
@import "../../../scss/Components/usersOverview";
</style>
