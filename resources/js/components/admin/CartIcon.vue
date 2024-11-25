<template>
    <div class="relative">
        <button
            @click="toggleMenu"
            class="icon_cart w-16 h-16 bg-brown-600 text-white rounded-full flex items-center justify-center shadow-lg hover:bg-brown-700 transition">
            <span class="text-3xl">+</span>
        </button>

    <!-- Small Buttons -->
        <div
            v-if="isMenuOpen"
            class="fixed bottom-3 right-2 flex flex-col gap-4 transform -translate-x-1/2 -translate-y-1/2">
            <button
                @click="openCartPopup"
                class="w-14 h-14 bg-white text-brown-600 rounded-full shadow-lg flex items-center justify-center hover:bg-gray-200 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                </svg>
            </button>
            <button
                class="w-14 h-14 bg-white text-brown-600 rounded-full shadow-lg flex items-center justify-center hover:bg-gray-200 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
            </button>
            <button
                class="w-14 h-14 bg-white text-brown-600 rounded-full shadow-lg flex items-center justify-center hover:bg-gray-200 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                </svg>
            </button>
        </div>
    </div>
    <CartPopup :isVisible="isCartVisible" @closePopup="closeCartPopup" />
</template>

<script setup>
import { ref } from "vue";
import CartPopup from "@/js/components/popup/CartPopup.vue";

// State variables
const isMenuOpen = ref(false); // Controls small button visibility
const isCartVisible = ref(false); // Controls cart popup visibility

// Methods
const toggleMenu = () => {
    isMenuOpen.value = !isMenuOpen.value;
};

const openCartPopup = () => {
    isCartVisible.value = true;
};

const closeCartPopup = () => {
    isCartVisible.value = false;
};
</script>
<style scoped>
.icon_cart {
    position: fixed;
    bottom: 30px; /* Khoảng cách từ cạnh dưới */
    right: 30px; /* Khoảng cách từ cạnh phải */
    z-index: 2; /* Đảm bảo nằm trên các thành phần khác */
}
.bg-brown-600 { background-color: #6B4226; }
.bg-brown-700 { background-color: #5A3621; }
.text-brown-600 { color: #6B4226; }
.transition {
    transition: transform 0.3s ease, opacity 0.3s ease;
}

</style>
