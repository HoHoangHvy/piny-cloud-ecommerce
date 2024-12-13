<script setup>
import { initFlowbite, Drawer } from 'flowbite';
import { defineExpose } from 'vue';
import { onMounted, ref, computed } from "vue";
import { useStore } from 'vuex';
import { FwbTab, FwbTabs } from 'flowbite-vue';
import {formatVietnameseCurrency} from "../../helpers/currencyFormat.js";

let updateDrawerInstance = null; // Drawer instance
const isVisible = ref(false); // Visibility state
const store = useStore();
const activeTab = ref('first') // Tab active state

const openDrawer = () => {
    isVisible.value = true; // Set visibility to true
    updateDrawerInstance.show(); // Show drawer
    store.dispatch('cart/fetchOrderDetails'); // Fetch order details from Vuex action
}

defineExpose({
    openDrawer
});

const fetchData = async () => {
    debugger
    await store.dispatch('cart/fetchOrderDetails');
    cartData.value = store.getters['cart/allCart'];
}
onMounted(() => {
    initFlowbite();
    const $updateDrawer = document.getElementById('drawer-update-product');
    const drawerOptions = {
        placement: 'right',
        backdrop: true,
        bodyScrolling: false,
        onHide: () => {},
        onShow: () => {
            console.log('Drawer is shown');
        },
    };
    updateDrawerInstance = new Drawer($updateDrawer, drawerOptions);
    fetchData();
})

const cartData = computed(() => store.getters['cart/allCart']); // Multiple carts
const isLoading = computed(() => store.getters['cart/isLoading']);
const error = computed(() => store.getters['cart/error']);
</script>

<template>
    <div
        id="drawer-update-product"
        v-show="isVisible"
        class="fixed top-0 right-0 z-999 w-full h-screen max-w-3xl p-4 overflow-y-auto transition-transform -translate-x-full bg-white dark:bg-gray-800"
        tabindex="-1"
        aria-labelledby="drawer-update-product-label"
        aria-hidden="true"
    >
        <div class="drawer-header flex justify-between items-center">
            <h2 class="text-xl font-semibold">Order Details</h2>
            <button @click="isVisible = false" class="text-2xl">&times;</button>
        </div>

        <!-- Loading state -->
        <div v-if="isLoading" class="text-center text-gray-500">
            Loading...
        </div>

        <!-- Error state -->
        <div v-if="error" class="text-center text-red-500">
            Error: {{ error }}
        </div>

        <fwb-tabs v-model="activeTab" directive="show" class="p-5">
            <!-- Loop through multiple orders (carts) -->
            <fwb-tab v-for="cart in cartData" :name="cart.order_number" :title="cart.order_number" :key="cart.order_id">
                <!-- Order Details -->
                <div v-if="cart" class="order-summary mt-4">
                    <div class="mb-3">
                        <strong>Order Number:</strong> {{ cart.order_number }}
                    </div>
                    <div class="mb-3">
                        <strong>Order ID:</strong> {{ cart.order_id }}
                    </div>
                </div>

                <!-- Loop through order details -->
                <div v-if="cart.order_detail" class="order-items">
                    <div v-for="(item, index) in cart.order_detail" :key="item.id" class="order-item mb-4">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center">
                                <div class="font-semibold">{{ item.product_name }} ({{ item.size }})</div>
                                <span class="ml-2 text-sm text-gray-500">x{{ item.quantity }}</span>
                            </div>
                            <div class="font-semibold">{{ formatVietnameseCurrency(item.total_price) }}</div>
                        </div>

                        <div class="toppings mt-2">
                            <div v-for="(topping, toppingIndex) in item.toppings" :key="toppingIndex" class="flex justify-between">
                                <div>{{ topping.product_name }} (x{{ topping.quantity }})</div>
                                <div>{{ formatVietnameseCurrency(topping.product_price) }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-if="cart" class="order-total mt-4 flex justify-between font-semibold">
                    <span>Total:</span>
                    <span>{{ formatVietnameseCurrency(cart.total_price) }}</span>
                </div>
            </fwb-tab>
        </fwb-tabs>
    </div>
</template>

<style scoped>
.drawer-header {
    background-color: #f8fafc;
    padding: 15px;
    border-bottom: 1px solid #e0e7ff;
}

.order-summary {
    padding: 10px;
    background-color: #f9fafb;
    border-radius: 5px;
}

.order-item {
    padding: 15px;
    background-color: #f9fafb;
    border-radius: 5px;
}

.order-total {
    margin-top: 20px;
    font-size: 1.2rem;
}
</style>
