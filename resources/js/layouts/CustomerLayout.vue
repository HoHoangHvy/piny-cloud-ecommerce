<script>
import Header from "../components/layouts/Header.vue";
import FooterCustomer from "@/js/components/layouts/Footer.vue";

export default {
    name: 'CustomerLayout',
    components: {FooterCustomer, Header},
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
        <Header class="floating-header"/>
        <main>
            <router-view/>
        </main>
        <FooterCustomer/>
    </div>
</template>

<style scoped>
.customer-layout {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

.floating-header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000; /* Ensure it stays on top of other content */
    background-color: #2c3e50; /* Match your header background color */
    color: white; /* Match your header text color */
    padding: 1rem; /* Match your header padding */
}

main {
    margin-top: 60px; /* Adjust this value based on your header height to prevent content from being hidden */
    flex: 1;
}

.admin-footer {
    background-color: #2c3e50;
    color: white;
    text-align: center;
    padding: 1rem;
}
</style>
