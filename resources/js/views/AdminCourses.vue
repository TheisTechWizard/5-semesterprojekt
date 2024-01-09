<template>
    <div class="admin-courses-container">
        <div class="navbar-menu">
            <Navbar />
        </div>
        <div class="menu-content-container">
            <div class="header-menu">
                <Header />
            </div>
            <div class="overviews">
                <div class="course-create-container">
                    <h3>Course</h3>
                    <div class="course-create-inputs">
                        <h4>Course name</h4>
                        <input
                            v-model="name"
                            type="text"
                            placeholder="Course name"
                        />
                        <h4>Description</h4>
                        <input
                            v-model="descr"
                            type="text"
                            placeholder="Description"
                        />
                    </div>
                    <h4>Lessons</h4>
                    <div
                        class="lessons"
                        v-for="(lesson, index) in lessons"
                        :key="index"
                    >
                        <h4>Lesson name</h4>
                        <input
                            v-model="lesson.name"
                            type="text"
                            placeholder="Lesson name"
                        />
                        <h4>Description</h4>
                        <input
                            v-model="lesson.description"
                            type="text"
                            placeholder="Lesson description"
                        />
                    </div>
                    <div class="add-lesson-btn">
                        <button v-on:click="addInputField">Add lesson</button>
                    </div>
                    <div class="save-btn">
                        <button v-on:click="createCourse">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import Header from "./components/Header.vue";
import Navbar from "./components/Navbar.vue";
import { reactive, ref } from "@vue/reactivity";
import axios from "axios";

const name = ref();
const descr = ref();

const lessons = reactive([{ name: "", description: "" }]);

function addInputField() {
    for (let i = 0; i < lessons.length; i++) {
        if (lessons[i].name === "") {
            alert("Please fill in the empty fields");
            return;
        }
    }
    lessons.push({ name: "", description: "" });
}

function createCourse() {
    axios
        .post("/courses", {
            name: name.value,
            description: descr.value,
        })
        .then(createLessons(response));
}

function createLessons(response) {
    for (let i = 0; i < lessons.length; i++) {
        axios.post("/lessons", {
            name: lessons[i].name,
            description: lessons[i].description,
            course_id: response.data.course_id,
        });
        console.log("yessir");
    }
}

// async function createCourse() {
//     const response = await axios.post(baseApi + "courses", {
//         name: name.value,
//         description: descr.value,
//     });
//     for (let i = 0; i < lessons.length; i++) {
//         await axios.post(baseApi + "lessons", {
//             name: lessons[i].name,
//             description: lessons[i].description,
//             course_id: response.data.course_id,
//         });
//     }
// }
</script>

<style lang="scss">
@import "../../scss/views/adminCourses";
</style>
