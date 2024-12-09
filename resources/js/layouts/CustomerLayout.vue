<script>
import Header from "../components/layouts/Header.vue";
import FooterCustomer from "@/js/components/layouts/Footer.vue";
import CartIcon from "@/js/components/admin/CartIcon.vue";
import CartPopup from "@/js/components/popup/CartPopup.vue";

export default {
    name: 'CustomerLayout',
    components: {CartPopup, CartIcon, FooterCustomer, Header},
    data() {
        return {
            currentPopup: null, // Initialize currentPopup as null
        };
    },
    methods: {
        logout() {
            // Implement logout logic here
            console.log('Logout clicked');
            // Example: this.$store.dispatch('logout');
            // Then redirect to login page or home page
            // this.$router.push('/login');
        },
        openPopup(popup) {
            this.currentPopup = popup; // Set currentPopup to the provided popup value
        },
        closePopup() {
            this.currentPopup = null; // Close the popup by setting currentPopup to null
        }
    },
}
</script>
<template>
    <div class="customer-layout">
        <Header class="floating-header"/>
        <main>
            <router-view/>
        </main>
        <FooterCustomer/>
        <CartIcon/>
    </div>
</template>
<style scoped>
.customer-layout {
    overflow-x: hidden; /* Prevent overflow on the layout level */
    width: 100%;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

html, body {
    margin: 0; /* Remove default margin */
    padding: 0; /* Remove default padding */
    overflow-x: hidden; /* Prevent horizontal scrolling */
    width: 100%; /* Ensure it spans the entire viewport */
    box-sizing: border-box; /* Include padding and border in element's width */
}

.floating-header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%; /* Ensure it spans the entire viewport */
    box-sizing: border-box; /* Prevent padding from exceeding 100% width */
    z-index: 1000;
    background-color: #2c3e50;
    color: white;
    padding: 1rem;
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
