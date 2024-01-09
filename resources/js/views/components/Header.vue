<template>
    <div class="header-container">
        <div class="title-wrapper"></div>
        <div class="search-wrapper">
            <img
                src="../../../../public/img/svg/magnifier.svg"
                alt="magnifier"
            />
            <input type="text" placeholder="Search..." />
        </div>
        <div class="logo-wrapper">
            <button class="notification-bell">
                <img
                    src="../../../../public/img/svg/bell.svg"
                    alt="notification bell"
                />
            </button>
            <button class="profile-pic">
                <img
                    src="../../../../public/img/svg/person.svg"
                    alt="profile pic"
                />
            </button>
        </div>
    </div>
</template>

<script setup></script>

<style lang="scss">
@import "../../../scss/Components/header";
</style>
