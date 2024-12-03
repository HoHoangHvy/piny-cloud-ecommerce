<template>
    <div v-if="isVisible" class="overlay fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center" @click="close">
        <div class="bg-white p-5 lg:p-8 rounded-lg shadow-lg max-w-md h-auto w-[90%] lg:w-[65%] lg:w-full relative" @click.stop>
            <div class="flex flex-row items-center justify-between">
                <p class="text-black text-s lg:text-2xl font-semibold font-['Inter'] leading-[28.80px] mb-3 lg:mb-5 m-auto lg:ml-0">ADD TO CART</p>
            </div>
            <div class="details_size flex flex-row justify-between border-b border-gray-300 pd-0 lg:pb-2 items-center">
                <div class="details_size_label flex justify-between mt-3 mb-1">
                    <div class="details_label_name text-black-2 font-semibold">Size</div>
                </div>
                <div class="details_size_list ">
                    <button class="active_size">S +0d</button>
                    <button class="text-[#B2B2B2] inline-flex justify-center items-center flex-shrink-0 rounded-[10px] p-[14px] m-[5px] h-[22px] lg:h-[28px] border-2 border-[#B2B2B2] text-[12px] lg:text-[14px] p-[5px] lg:p-[6px]">M +5.000d</button>
                    <button class="text-[#B2B2B2] inline-flex justify-center items-center flex-shrink-0 rounded-[10px] p-[14px] m-[5px] h-[22px] lg:h-[28px] border-2 border-[#B2B2B2] text-[12px] lg:text-[14px] p-[5px] lg:p-[6px]">L +10.000d</button>
                </div>
            </div>
            <div class="details_topping flex flex-col justify-between border-b border-gray-300 pb-2">
                <div class="details_size_label flex justify-between mt-3 mb-1">
                    <div class="details_label_name text-black-2 font-bold mb-0 lg:mb-2">Topping</div>
                </div>
                <div class="topping grid grid-cols-2 gap-4 flex flex-row">
                    <div v-for="(topping, index) in selectedProduct?.topping" :key="index" class="flex flex-row space-x-2 items-center">
                        <input type="checkbox" :id="'topping-' + index" class="form-checkbox h-4 w-4 lg:h-5 lg:w-5 border-gray-400 rounded accent-[#4d2f19] text-white">
                        <div class="topping_content">
                            <p class="font-semibold text-black-2 text-[14px] lg:text-[16px]">{{topping.name}}</p>
                            <p class="text-14px lg:text-s">{{topping.price}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-[16px] total flex items-center justify-end mt-5 text-black-2 font-bold">
                <div class="">Total: </div>
                <div class="">120.000 VND</div>
            </div>
            <div class="filter_btn flex items-center justify-center lg:justify-end mt-5">
                <button @click="close" class="bg-gray-300 text-gray-700 px-4 py-2 rounded text-black-2 font-bold">Cancel</button>
                <button @click="close" class="bg-[#B38B60] text-[#f2f5f8] px-4 py-2 rounded-full inline-flex lg:h-[38px] justify-center items-center lg:flex-shrink-0 lg:p-[14px] lg:m-[5px] h-[28px] w-auto">Add to cart</button>

            </div>
        </div>
    </div>

</template>
<script setup>
import { defineProps, defineEmits } from 'vue';

const props = defineProps({
    isVisible: {
        type: Boolean,
        required: true
    },
    selectedProduct: {
        type: Object,
        required: true
    }
});

const emit = defineEmits();

const close = () => {
    emit('closePopup');
};

</script>
<style scoped>
.overlay {
    background-color: rgba(0, 0, 0, 0.09); /* Màu đen với độ trong suốt 70% */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 50; /* Đảm bảo lớp này hiển thị phía trên */
}
.active_size {
    font-size: 14px;
    color: #4d2f19;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    flex-shrink: 0;
    border-radius: 10px; /* Full-rounded */
    padding: 6px;
    margin: 5px;
    height: 28px;
    border: 2px solid #4d2f19;
    font-weight: bold;
}
@media (max-width: 700px) {
    .active_size {
        font-size: 12px;
        padding: 5px;
        height: 22px;
    }
}

</style>
