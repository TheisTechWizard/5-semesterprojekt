<template>
    <div class="profile-overview-container">
        <div class="title">
            <h2>Profile</h2>
        </div>
        <div class="user-content" v-if="selectedUser">
            <div class="logo-wrapper"></div>
            <div class="user-name">
                <h3>{{ selectedUser.fname }} {{ selectedUser.lname }}</h3>
            </div>
            <img src="../../../../public/img/svg/gray_line.svg" />
            <div class="user-info">
                <h3>Contact info</h3>
                <a href="">{{ selectedUser.email }}</a>
            </div>
            <img src="../../../../public/img/svg/gray_line.svg" />
            <div class="courses-list">
                <h3>Courses</h3>
                <p v-for="(course, index) in selectedUser.courses" :key="index">
                    {{ course.name }}
                </p>
                <div class="assign-courses">
                    <select v-model="selectedCourse" v-on:click="getAvailableCourses">
                        <option v-for="(course, index) in availableCourses" :key="index" :value="course.id">
                            {{ course.name }}
                        </option>
                    </select>
                    <button v-on:click="assignCourse">Assign Course</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from "axios";
import { ref } from "@vue/reactivity";
// import { nodemailer } from "nodemailer";

// const nodemailer = require("nodemailer");
// var nodemailer = import("nodemailer");
const props = defineProps({
    selectedUser: {
        type: Object,
    },
});

const emit = defineEmits(["user-updated"]);

const availableCourses = ref();
const selectedCourse = ref();


function getAvailableCourses() {
    axios.get("/courses").then((response) => {
        availableCourses.value = response.data.data.filter(course =>
            !props.selectedUser.courses.some(filterCourse =>
                filterCourse.id === course.id))
    });
}

// const sendmail = async (to) => {
//     var subject = "You got mail bro!";
//     var text = "<H1>YOOOO!</H1>";

//     // create reusable transporter object using the default SMTP transport
//     let transporter = nodemailer.createTransport({
//         service: "outlook",
//         auth: {
//             user: "cyknowledge@outlook.com", // generated ethereal user
//             pass: "testerJack", // generated ethereal password
//         },
//     });

//     // send mail with defined transport object
//     let info = await transporter.sendMail({
//         from: '"Fred Foo 👻" <cyknowledge@outlook.com>', // sender address
//         to: to, // list of receivers
//         subject: subject, // Subject line
//         text: text, // html body
//     });

//     console.log("Message sent: %s", info.messageId);
// };

function assignCourse() {
    axios
        .post(
            "/users/" +
            props.selectedUser.id +
            "/" +
            "courses?course_id=" +
            selectedCourse.value
        )
        .then(() => {
            axios.get("/users/" + props.selectedUser.id).then((response) => {
                emit("user-updated", response.data.data[0]);
            });
        });
}
</script>

<style lang="scss">
@import "../../../scss/Components/profileOverview";
</style>
