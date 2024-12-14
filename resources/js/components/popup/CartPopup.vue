<template>
    <div v-if="isVisible" class="overlay fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center"
         @click="close">
        <div class="bg-white p-4 pb-2 lg:p-4 rounded-lg shadow-lg max-w-md w-[90%] h-auto lg:w-full relative"
             @click.stop>
            <div class="flex flex-row items-center justify-center lg:justify-start mb-2">
                <p class="text-black text-2xl font-semibold font-['Inter'] leading-[28.80px]">Select Cart</p>
            </div>
            <div
                class="details_topping flex scrollbar-thin flex-col justify-between h-125">
                <div v-for="cart in listCart" :key="cart.order_id"
                     @mouseover="hoveredCart = cart.order_id"
                     @mouseleave="hoveredCart = null"
                     @click="selectCart(cart.order_id)"
                     :class="{'bg-gray-200': selectedCart === cart.order_id}"
                     class="flex flex-row items-center justify-between border-b border-gray-300 pb-3 pt-2 relative cursor-pointer transition-all duration-200 ease-in-out">                    <div class="topping_content w-5/12 ml-2">
                        <p class="text-black-2 font-bold">{{ cart.name }}</p>
                        <p class="text-[14px] leading-none">{{ cart.type }}</p>
                    </div>
                    <!-- Show order items only on hover -->
                    <div v-if="hoveredCart === cart.order_id"
                         class="order-items absolute top-0 bg-white shadow-lg rounded-lg p-4">
                        <span v-if="cart.order_detail.length === 0">Empty cart</span>
                        <div v-for="(item, index) in cart.order_detail" :key="item.id" class="order-item mb-4">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <div class="font-semibold">{{ item.product_name }} ({{ item.size }})</div>
                                    <span class="ml-2 text-sm text-gray-500">x{{ item.quantity }}</span>
                                </div>
                            </div>
                            <div class="toppings mt-2">
                                <div v-for="(topping, toppingIndex) in item.toppings" :key="toppingIndex"
                                     class="flex justify-between">
                                    <div>{{ topping.product_name }} (x{{ topping.quantity }})</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="filter_btn flex items-center justify-center lg:justify-end mt-5">
                <button @click="close" class="bg-[#aaa] opacity-50 text-white px-4 py-2 rounded-full font-semibold">
                    Cancel
                </button>
                <button :disabled="!selectedCart"
                        @click="addProductToCart(selectedCart)"
                        class="active_btn mt-4 text-white font-semibold rounded-full"
                        :class="{'opacity-50 cursor-not-allowed': !selectedCart}">
                    Confirm
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps, defineEmits, ref } from 'vue';

const emit = defineEmits();
const props = defineProps({
    isVisible: { type: Boolean, required: true },
    listCart: { type: Array, required: true },
});

const hoveredCart = ref(null); // Tracks the hovered cart line
const selectedCart = ref(null); // Tracks the currently selected cart

const close = () => {
    emit('closePopup');
};

// Handle cart selection
const selectCart = (cartId) => {
    selectedCart.value = selectedCart.value === cartId ? null : cartId; // Toggle selection
};

// Call the confirm function
const addProductToCart = (cartId) => {
    if (cartId) {
        console.log('Selected Cart ID:', cartId); // Replace with your logic
        emit('confirmSelection', cartId);
    }
};
</script>

<style scoped>
.overlay {
    background-color: rgba(0, 0, 0, 0.5); /* Background overlay */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 50; /* Ensure it appears on top */
}

.active_btn {
    display: inline-flex;
    height: 38px;
    justify-content: center;
    align-items: center;
    flex-shrink: 0;
    background: #6B4226;
    padding: 14px;
    margin: 5px;
}

.active_btn:disabled {
    background: #aaa; /* Disabled button background */
    cursor: not-allowed;
}

.topping_content p {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.cursor-pointer {
    cursor: pointer;
}
.order-items {
    position: absolute; /* Ensure it's positioned absolutely */
    top: 0;
    left: 100%; /* Adjust as needed */
    background-color: white;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    padding: 16px;
    z-index: 1000; /* Higher z-index to appear above other elements */
    max-height: 200px;
    overflow-y: auto;
    border: 1px solid #ddd;
    width: 300px;
}
.transition-all {
    transition: all 0.3s;
}

@media (max-width: 700px) {
    .active_btn {
        height: 28px;
    }
}
</style>
