<template>
  <div class="admin-layout">
    <header class="admin-header">
      <h1>Admin Dashboard</h1>
      <nav>
        <router-link to="/admin">Dashboard</router-link> |
        <router-link to="/admin/users">Users</router-link> |
        <router-link to="/admin/settings">Settings</router-link> |
        <a @click="logout" href="#">Logout</a>
      </nav>
    </header>

    <div class="admin-content">
      <aside class="admin-sidebar">
        <!-- Sidebar content goes here -->
        <ul>
          <li><router-link to="/admin">Dashboard</router-link></li>
          <li><router-link to="/admin/users">Manage Users</router-link></li>
          <li><router-link to="/admin/posts">Manage Posts</router-link></li>
          <li><router-link to="/admin/settings">Settings</router-link></li>
        </ul>
      </aside>

      <main class="admin-main">
        <!-- This is where child routes will be rendered -->
        <router-view></router-view>
      </main>
    </div>

    <footer class="admin-footer">
      <p>&copy; 2024 Your Company Name. All rights reserved.</p>
    </footer>
  </div>
</template>

<script>
export default {
  name: 'AdminLayout',
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
