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
            <div class="flex flex-col w-[700px] pr-6 pl-6 pt-4 pb-2">
                <div class="flex flex-row items-center justify-between h-[16%]">
                    <div class="w-full lg:w-2/3">
                        <h2 class="text-black text-2xl lg:text-3xl font-semibold mb-2">{{ selectedProduct?.name }}</h2>
                        <p class="text-gray-600 text-lg lg:text-xl">
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
                <div class="flex w-full h-[74%]">
                    <div class="w-full flex flex-col justify-start mb-2">
                        <!-- Size Selector -->
                        <div class="mb-2">
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
                        <div class="mb-2">
                            <p class="text-black font-bold text-lg mb-2">Topping</p>
                            <div class="flex flex-wrap gap-1 scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-gray-100 overflow-hidden overflow-y-auto h-[145px]">
                                <button
                                    v-if="selectedProduct?.topping_list.length !== 0"
                                    v-for="(topping) in selectedProduct?.topping_list"
                                    :key="topping.id"
                                    :class="['topping-button', { 'topping-active': selectedToppings.includes(topping) }]"
                                    @click="handleToppingClick(topping)"
                                >
                                    {{ topping.name }} +{{ formatVietnameseCurrency(topping.price, false) }}
                                </button>
                                <span v-else>No topping available</span>
                            </div>
                        </div>

                        <div class="mb-6">
                            <p class="text-black font-bold text-lg mb-2">Note</p>
                            <div class="flex flex-wrap grid-cols-4 gap-1">
                                <textarea v-model="note" id="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Note something here"></textarea>
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

const selectedSize = ref({
    name: 'S',
    price: '0',
}); // Default size
const selectedToppings = ref([]); // Default toppings
const note = ref(''); // Default toppings

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
    debugger
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
    padding: 12px 6px;
    margin: 5px;
    height: 32px;
    border: 2px solid #B2B2B2;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s ease;
}
.topping-button {
    font-size: 14px;
    color: #B2B2B2;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    flex-shrink: 0;
    border-radius: 10px;
    padding: 12px 6px;
    margin: 5px;
    height: 36px;
    border: 1px solid #B2B2B2;
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
.topping-button.active {
    color: #6B4226;
    border-color: #6B4226;
}
.topping-button.topping-active {
    color: white;
    background: #825B32;
    border-color: #825B32;
}

</style>
