
<script>
import Header from "../components/header.vue";

export default {
  name: 'CustomerLayout',
    components: {Header},
  methods: {
    logout() {
      // Implement logout logic here
      console.log('Logout clicked');
      // Example: this.$store.dispatch('logout');
      // Then redirect to login page or home page
      // this.$router.push('/login');
    }
  }
}
</script>

<template>
  <div class="customer-layout">
    <Header />
    <main>
        <router-view/>
    </main>
  </div>
</template>

<style scoped>
.admin-layout {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

.admin-header {
  background-color: #2c3e50;
  color: white;
  padding: 1rem;
}

.admin-header h1 {
  margin: 0;
}

.admin-header nav {
  margin-top: 1rem;
}

.admin-header a {
  color: white;
  text-decoration: none;
  margin-right: 1rem;
}

.admin-content {
  display: flex;
  flex: 1;
}

.admin-sidebar {
  width: 200px;
  background-color: #f4f4f4;
  padding: 1rem;
}

.admin-sidebar ul {
  list-style-type: none;
  padding: 0;
}

.admin-sidebar li {
  margin-bottom: 0.5rem;
}

.admin-main {
  flex: 1;
  padding: 1rem;
}

.admin-footer {
  background-color: #2c3e50;
  color: white;
  text-align: center;
  padding: 1rem;
}
</style>
