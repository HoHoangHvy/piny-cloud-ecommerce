<script>
import Header from "../components/layouts/Header.vue";
import FooterCustomer from "@/js/components/layouts/Footer.vue";
import CartIcon from "@/js/components/admin/CartIcon.vue";
import CartDrawer from "@/js/components/popup/CartDrawer.vue";
import {Notification, NotificationGroup} from "notiwind";

export default {
    name: 'CustomerLayout',
    components: {NotificationGroup, Notification, CartDrawer, CartIcon, FooterCustomer, Header},
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
            <NotificationGroup group="error" class="z-9999">
                <div
                    class="fixed inset-0 flex items-start justify-end p-6 px-4 py-6 pointer-events-none z-9999"
                >
                    <div class="w-full max-w-sm z-9999">
                        <Notification
                            class="z-9999"
                            v-slot="{ notifications }"
                            enter="transform ease-out duration-300 transition"
                            enter-from="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-4"
                            enter-to="translate-y-0 opacity-100 sm:translate-x-0"
                            leave="transition ease-in duration-500"
                            leave-from="opacity-100"
                            leave-to="opacity-0"
                            move="transition duration-500"
                            move-delay="delay-300"
                        >
                            <div
                                class="flex w-full max-w-sm mx-auto mt-4 overflow-hidden bg-white rounded-lg shadow-md z-9999"
                                v-for="notification in notifications"
                                :key="notification.id"
                            >
                                <div class="flex items-center justify-center w-12 bg-red-500">
                                    <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M20 3.36667C10.8167 3.36667 3.3667 10.8167 3.3667 20C3.3667 29.1833 10.8167 36.6333 20 36.6333C29.1834 36.6333 36.6334 29.1833 36.6334 20C36.6334 10.8167 29.1834 3.36667 20 3.36667ZM19.1334 33.3333V22.9H13.3334L21.6667 6.66667V17.1H27.25L19.1334 33.3333Z"/>
                                    </svg>
                                </div>

                                <div class="px-4 py-2 -mx-3">
                                    <div class="mx-3">
                                        <span class="font-semibold text-red-500">{{ notification.title }}</span>
                                        <p class="text-sm text-gray-600">{{ notification.text }}</p>
                                    </div>
                                </div>
                            </div>
                        </Notification>
                    </div>
                </div>
            </NotificationGroup>

            <NotificationGroup group="foo" class="z-9999">
                <div
                    class="fixed inset-0 flex items-start justify-end p-6 px-4 py-6 pointer-events-none z-9999"
                >
                    <div class="w-full max-w-sm z-9999">
                        <Notification
                            class="z-999999"
                            v-slot="{ notifications }"
                            enter="transform ease-out duration-300 transition"
                            enter-from="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-4"
                            enter-to="translate-y-0 opacity-100 sm:translate-x-0"
                            leave="transition ease-in duration-500"
                            leave-from="opacity-100"
                            leave-to="opacity-0"
                            move="transition duration-500"
                            move-delay="delay-300"
                        >
                            <div
                                class="flex w-full max-w-sm mx-auto mt-4 overflow-hidden bg-white rounded-lg shadow-md z-999999"
                                v-for="notification in notifications"
                                :key="notification.id"
                            >
                                <div class="flex items-center justify-center w-12 bg-green-500 z-9999999">
                                    <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z" />
                                    </svg>
                                </div>

                                <div class="px-4 py-2 -mx-3 z-9999999">
                                    <div class="mx-3">
                                        <span class="font-semibold text-green-500">{{ notification.title }}</span>
                                        <p class="text-sm text-gray-600">{{ notification.text }}</p>
                                    </div>
                                </div>
                            </div>
                        </Notification>
                    </div>
                </div>
            </NotificationGroup>

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
