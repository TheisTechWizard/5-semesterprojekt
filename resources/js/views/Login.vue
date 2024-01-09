<template>
    <div class="main">
        <div class="left-login">
            <div class="inner">
                <div class="initial">
                    <h1>CY Knowledge</h1>
                    <p>Login into your account</p>
                </div>
                <div class="login">
                    <div class="credentials">
                        <div class="email">
                            <p>Email</p>
                            <input type="text" placeholder="your@email.com" v-model="email" />
                        </div>
                        <div class="password">
                            <p>Password</p>
                            <input type="password" placeholder="Enter your password" v-model="password" />
                        </div>
                    </div>
                    <div class="login-button">
                        <button @click="handleLogin">Login Now</button>
                    </div>
                    <p></p>
                </div>
            </div>
        </div>
        <div class="right-picture">
            <img src="../../../public/img/login-illustrator.png" alt="" />
        </div>
    </div>
</template>

<script setup>
import axios from "axios";
import { ref } from "vue";

const baseApi = "http://cyknowledge.oo/";

const email = ref();
const password = ref();

var user = null;

function getUser() {
    axios.get("/user").then((response) => {
        user = response.data;
        console.log(user);
    }).then((redirect));
}

function handleLogin() {
    axios
        .post("/login", {
            email: email.value,
            password: password.value,
        })
        .then(getUser())
        .catch((error) => {
            console.log(error);
        });
}

function redirect() {
    setTimeout(() => {
        window.location.replace('https://cyknowledge.oo/my-courses');
    }, 2000)
}
</script>

<style lang="scss">
@import "../../scss/views/login";
</style>
