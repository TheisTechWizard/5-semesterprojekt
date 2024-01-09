<template>
    <div class="admin-people-container">
        <div class="navbar-menu">
            <Navbar />
        </div>
        <div class="menu-content-container">
            <div class="header-menu">
                <Header />
            </div>
            <div class="overviews">
                <UsersOverview v-bind:users="users" v-on:item-selected="handleData" />
                <ProfileOverview v-bind:selectedUser="selectedUser" v-on:user-updated="updateUser" />
            </div>
        </div>
    </div>
</template>

<script setup>
import Header from "./components/Header.vue";
import Navbar from "./components/Navbar.vue";
import UsersOverview from "./components/UsersOverview.vue";
import ProfileOverview from "./components/ProfileOverview.vue";
import axios from "axios";
import { ref } from "@vue/reactivity";

const users = ref();
const selectedUser = ref();

axios.get("/users").then((response) => {
    users.value = response.data.data;
    console.log(users)
});


function handleData(item) {
    selectedUser.value = item;
}

function updateUser(user) {
    for (let i = 0; i < users.value.length; i++) {
        if (users.value[i].id == user.id) {
            users.value[i] = user;
        }
    }
    selectedUser.value = user;
}
</script>

<style lang="scss">
@import "../../scss/views/adminPeople";
</style>
