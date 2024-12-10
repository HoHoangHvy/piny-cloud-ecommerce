<template>
    <div
        v-if="isVisible"
        class="overlay fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center"
        @click="close"
    >
        <div
            class="bg-white rounded-lg shadow-lg w-[1300px] h-[600px] relative flex"
            @click.stop
        >
            <div class="w-[600px] h-[600px]">
                <img v-if="selectedProduct.image_url === null" src="@/assets/images/empty-image.jpg"
                     alt="Product Image" class="w-full h-full rounded-s-lg"/>
                <img v-else :src="selectedProduct.image_url" alt="Product"
                     class="w-full h-full shadow-lg rounded-lg aspect-square">
            </div>
            <div class="flex flex-col w-[700px] p-6">
                <div class="flex flex-row items-center justify-between h-[20%]">
                    <div class="w-full lg:w-2/3">
                        <h2 class="text-black text-2xl lg:text-3xl font-semibold mb-2">{{ selectedProduct?.name }}</h2>
                        <p class="text-gray-600 text-lg lg:text-xl mb-4">
                            {{ formatVietnameseCurrency(selectedProduct?.price) }}</p>
                    </div>
                    <div class="h-full">
                        <button @click="close" class="text-gray-500 hover:text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="flex w-full h-[70%]">
                    <div class="w-full flex flex-col justify-start mb-6">
                        <!-- Size Selector -->
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-2">
                                <p class="text-black font-semibold text-lg">Size</p>
                            </div>
                            <div class="flex space-x-2">
                                <button
                                    v-for="size in selectedProduct?.size_list"
                                    :key="size"
                                    :class="['size-button', { 'active': selectedSize.name === size.name }]"
                                    @click="selectedSize = size"
                                >
                                    {{ size.name }} +{{ formatVietnameseCurrency(size.price, false) }}
                                </button>
                            </div>
                        </div>

                        <!-- Topping Selector -->
                        <div class="mb-6">
                            <p class="text-black font-bold text-lg mb-2">Topping</p>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                <button
                                    v-for="(topping) in selectedProduct?.topping_list"
                                    :key="topping.id"
                                    :class="['h-fit', { 'topping-active': selectedToppings.includes(topping) }]"
                                    @click="handleToppingClick(topping)"
                                >
                                    {{ topping.name }} +{{ formatVietnameseCurrency(topping.price, false) }}
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- Buttons -->
                <div class="flex justify-end items-center space-x-4 h-[10%]">
                    <!-- Total -->
                    <div class="">
                        Total: {{ calculateTotal }}
                    </div>
                    <button @click="addToCart" class="bg-[#6B4226] text-white px-4 py-2 rounded-full font-bold">
                        Add to cart
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {defineProps, defineEmits, computed, ref} from 'vue';

const props = defineProps({
    isVisible: {type: Boolean, required: true},
    selectedProduct: {type: Object, required: true}, // Pass the selected product directly
});

const emit = defineEmits(['closePopup']);

const selectedSize = ref('S'); // Default size
const selectedToppings = ref([]); // Default toppings

// Close the popup
const close = () => {
    emit('closePopup');
};

const handleToppingClick = (topping) => {
    const index = selectedToppings.value.findIndex(t => t.id === topping.id);
    if (index === -1) {
        selectedToppings.value.push(topping);
    } else {
        selectedToppings.value.splice(index, 1);
    }
}
// Add to cart logic
const addToCart = () => {
    // Logic to add to cart
    console.log('Added to cart:', {
        product: props.selectedProduct,
        size: selectedSize.value,
        toppings: selectedToppings.value,
    });
    close();
};
const formatVietnameseCurrency = (amount, showD = true) => {
    if (isNaN(amount)) {
        throw new Error("Invalid number");
    }

    // Format the currency
    const formattedCurrency = new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND',
        currencyDisplay: showD ? 'symbol' : 'code' // Use 'đ' if showD is true, otherwise use 'VND'
    }).format(amount);

    // Remove the 'VND' text if showD is false
    return showD ? formattedCurrency : formattedCurrency.replace('VND', '');
};
// Calculate total price
const calculateTotal = computed(() => {
    let total = parseFloat(props.selectedProduct?.price.replace(/[^0-9.-]+/g, "")) || 0;
    if (selectedSize.value && selectedSize.value.price) {
        total += parseFloat(selectedSize.value.price.replace(/[^0-9.-]+/g, ""));
    }
    selectedToppings.value.forEach(topping => {
        total += parseFloat(topping.price.replace(/[^0-9.-]+/g, ""));
    });
    return total.toLocaleString('vi-VN', {style: 'currency', currency: 'VND'});
});
</script>
<style scoped>
.overlay {
    background-color: rgba(0, 0, 0, 0.3); /* Màu đen với độ trong suốt 70% */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 50;
}

.size-button {
    font-size: 14px;
    color: #B2B2B2;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    flex-shrink: 0;
    border-radius: 10px;
    padding: 6px 12px;
    margin: 5px;
    height: 32px;
    border: 2px solid #B2B2B2;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s ease;
}

.size-button.active {
    color: #6B4226;
    border-color: #6B4226;
}
.size-button.topping-active {
    color: white;
    background: #825B32;
    border-color: #825B32;
}

.modal-fade-enter-active, .modal-fade-leave-active {
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.modal-fade-enter-from, .modal-fade-leave-to {
    opacity: 0;
    transform: scale(0.95);
}

.modal-fade-enter-to, .modal-fade-leave-from {
    opacity: 1;
    transform: scale(1);
}
</style>
