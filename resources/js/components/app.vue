<script setup>

</script>

<template>
    <h1>Hello app !</h1>
    <ul>
        <li><router-link to="/about">About page</router-link></li>
        <li><router-link to="/">Home page</router-link></li>
    </ul>
    <main>
        <router-view/>
    </main>
</template>

<style scoped>

</style>
