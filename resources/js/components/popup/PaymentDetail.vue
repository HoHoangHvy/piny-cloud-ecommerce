<script setup>
import {ref, onMounted} from 'vue';
import {useI18n} from "vue-i18n";
import {defineProps, defineEmits} from 'vue';
import {useStore} from 'vuex';
import {notify} from "notiwind";
import {formatVietnameseCurrency} from "@/js/helpers/currencyFormat.js";

const store = useStore();
const emit = defineEmits(['showPaymentDetail']);
const props = defineProps({
    isVisible: {type: Boolean, required: true},
    index: {type: Number, required: true},
    cart: {type: Object, required: true}
});
const {t} = useI18n();
const voucherModalVisible = ref(false);
const dayAfterTomorrow = ref('');

function openVoucherModal() {
    voucherModalVisible.value = true;
}

function closeVoucherModal() {
    voucherModalVisible.value = false;
}

onMounted(() => {
    const date = new Date();
    date.setDate(date.getDate() + 2);

    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();

    dayAfterTomorrow.value = `${day}/${month}/${year}`;
});

document.addEventListener("DOMContentLoaded", function () {
    const orderList = document.getElementById("order-list");
    const orderItems = orderList.getElementsByClassName("order-item");

    if (orderItems.length >= 3) {
        orderList.classList.add("max-h-32", "overflow-y-auto", "rounded-lg");
    }
});


</script>

<template>
    <section v-if="isVisible" class="relative bg-gray-100">
        <div class="mx-auto max-w-screen-xl pr-6 pl-6 bg-gray-100 relative">
            <div class="flex flex-col mt-2 justify-center bg-gray-100 items-center sm:mt-4 gap-4">
                <div class="flex gap-2 bg-gray-100 w-full">
                    <div
                        class="bg-white shadow-lg w-[50%] lg:max-w-md h-full divide-y divide-gray-200 overflow-hidden rounded-lg dark:divide-gray-700 dark:border-gray-700 xl:max-w-2xl">
                        <div class="space-y-1 p-5 pt-4">
                            <div class="flex gap-1 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="#6B4226" class="size-6 mb-[2px]">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/>
                                </svg>
                                <label class="font-bold text-[#6B4226] dark:text-white">
                                    {{
                                        t('LBL_DELIVERY')
                                    }}</label>
                            </div>
                            <div class="mt-4">
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-500  dark:text-white">Province</label>
                                        <select
                                            class="bg-white border border-gray-300 text-gray-500  text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        >
                                            <option value="">Select Province</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-500  =dark:text-white">District</label>
                                        <select
                                            class="bg-white border border-gray-300 text-gray-500  text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        >

                                            <option value="">Select District</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 gap-2">
                                    <div>
                                        <label
                                            class="block mb-2 text-sm font-medium text-gray-500  dark:text-white">Ward</label>
                                        <select
                                            class="bg-white border border-gray-300 text-gray-500  text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        >
                                            <option value="">Select Ward</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-500  dark:text-white">
                                            Street </label>
                                        <input type="text"
                                               class="bg-white border border-gray-300 text-gray-500  text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                               placeholder="Enter Street">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="bg-white w-[50%] shadow-lg lg:max-w-md h-full divide-y divide-gray-200 overflow-hidden rounded-lg dark:divide-gray-700 dark:border-gray-700 xl:max-w-2xl">
                        <div class="space-y-1 p-5 pt-4">
                            <div class="flex gap-1 items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                     stroke="#6B4226" class="size-5 mb-[2px]">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                                </svg>
                                <label class="font-inter font-bold text-[#6B4226] dark:text-white">Receiver</label>
                            </div>
                            <div class="mt-4">
                                <label class="block mb-2 text-sm font-medium text-gray-500  dark:text-white">{{
                                        t('LBL_RECIPIENT_NAME')
                                    }}</label>
                                <input type="text"
                                       class="bg-white border border-gray-300 text-gray-500  text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                       placeholder="Enter Name">
                            </div>
                            <div class="mt-4">
                                <label class="block mb-2 text-sm font-medium text-gray-500  dark:text-white">{{
                                        t('LBL_PHONE_NUMBER')
                                    }}</label>
                                <input type="text"
                                       class="bg-white border border-gray-300 text-gray-500  text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                       placeholder="Enter Phone Number">
                            </div>
                            <div class="mt-4">
                                <label class="block mb-2 text-sm font-medium text-gray-500  dark:text-white">{{
                                        t('LBL_NOTE')
                                    }}</label>
                                <input type="text"
                                       class="bg-white border border-gray-300 text-gray-500  text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                       placeholder="Enter Note">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full bg-white shadow-lg pl-6 pr-6 rounded-lg">
                    <div class="flex gap-1 items-center mt-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                             stroke="#6B4226" class="size-5 mb-[2px]">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"/>
                        </svg>
                        <label class="font-inter font-bold text-[#6B4226] dark:text-white">Order details</label>
                    </div>
                    <div class="overflow-y-auto bg-white w-full h-fit scrollbar-thin ">
                        <div
                            v-for="(item, itemIndex) in cart.order_detail"
                            :key="item.id"
                            class="order-item mb-1 rounded-xl w-full last:pb-4"
                        >
                            <!-- Product Details -->
                            <div class="flex gap-1 h-full pt-2 pl-3 w-full border-b border-gray-400 pb-2">
                                <div class="flex flex-col w-full">
                                    <div class="flex items-center justify-between w-[100%]">
                                        <div class="flex w-full gap-1 items-center">
                                            <span class="text-sm">{{ item.quantity }} x </span>
                                            <span class="font-semibold text-md">{{ item.product_name }} ({{item.size}})</span>
                                            <span v-if="item.note !== ''" class="text-sm text-gray-500">- {{ item.note }}</span>
                                        </div>
                                        <div class="font-semibold text-md">{{
                                                formatVietnameseCurrency(item.total_price)
                                            }}
                                        </div>
                                    </div>
                                    <span
                                        class="text-sm text-gray-500 w-[550px] whitespace-nowrap overflow-hidden text-ellipsis">
                                            <span
                                                v-for="(topping, toppingIndex) in item.toppings"
                                                :key="toppingIndex"
                                                class="text-sm"
                                            >
                                                {{ topping.name }}<span
                                                v-if="toppingIndex !== item.toppings.length - 1">, </span>
                                            </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Payment Section -->
                <div class="mt-6 grow shadow-lg sm:mt-8 rounded-lg bg-white lg:mt-0 w-full flex flex-col gap-2">
                    <div class="flex gap-1 items-center relative p-4 pb-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke-width="1.5" stroke="#6B4226" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z"/>
                        </svg>
                        <label class="font-inter font-bold text-[#6B4226] dark:text-white">Payment
                            Information</label>
                    </div>
                    <div
                        class="w-full h-full flex justify-between dark:border-gray-700 dark:bg-gray-800">
                        <div class="flex flex-col p-4 pt-0 pb-0 space-y-3 w-[60%]">
                            <div class="grid grid-cols-1">
                                <label
                                    class="block mb-2 text-sm font-medium text-gray-500  dark:text-white">Method</label>
                                <div class="flex gap-4">
                                    <div class="flex items-center space-x-2">
                                        <input id="cash" type="radio" name="payment" class="form-radio" checked>
                                        <label for="cash" class="text-gray-500">{{ t('LBL_CASH') }}</label>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <input id="cash" type="radio" name="payment" class="form-radio" checked>
                                        <label for="cash" class="text-gray-500">Online</label>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-2">
                                <div>
                                    <label
                                        class="block mb-2 text-sm font-medium text-gray-500  dark:text-white">Branch</label>
                                    <select
                                        class="bg-white border border-gray-300 text-gray-500  text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    >
                                        <option value="">Select Branch</option>
                                    </select>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-2">
                            </div>
                            <div v-if="voucherModalVisible"
                                 class="fixed inset-0 z-50 bg-gray-900 bg-opacity-50 flex items-center justify-center">
                                <div class="bg-gray-100 p-6 rounded-lg shadow-lg max-w-lg w-full">
                                    <div class="flex justify-between items-center">
                                        <h2 class="font-bold text-gray-500 text-lg mb-4">{{ t('LBL_VOUCHER') }}</h2>
                                        <div class="h-6 w-6 text-gray-500 cursor-pointer"
                                             @click="closeVoucherModal"> >
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 gap-4">
                                        <div class="flex items-center justify-between border p-4 rounded-lg">
                                            <div class="ml-4">
                                                <p class="text-gray-500 font-inter">Freeship</p>
                                            </div>
                                            <button class="bg-[#6B4226] text-white px-4 py-2 rounded-lg">
                                                {{ t('LBL_USE_NOW') }}
                                            </button>
                                        </div>
                                        <!-- Add more vouchers here -->
                                    </div>
                                    <button class="mt-4 text-sm text-gray-500 hover:underline"
                                            @click="closeVoucherModal">{{ t('LBL_CLOSE') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div
                            class="w-full bg-white dark:bg-gray-800 border-gray-700 p-4 pb-0 pt-0 flex flex-col justify-center">
                            <div class="space-y-2">
                                <div
                                    class="border rounded-lg border-gray-300 h-[33px] flex items-center justify-start">
                                    <button @click="openVoucherModal" class="bg-[#6B4226] h-full p-1.5 rounded-l-lg w-fit flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="2" stroke="white" class="size-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" />
                                        </svg>
                                        <span class="text-white text-sm">Voucher</span>
                                    </button>
                                </div>
                                <div class="pt-0">
                                    <dl class="flex items-center justify-between gap-4">
                                        <dt class="block mb-2 text-sm font-medium text-gray-500 dark:text-white">
                                            {{ t('LBL_PRICE') }}
                                        </dt>
                                        <dd class="font-inter text-gray-500 dark:text-white">157.000 VND</dd>
                                    </dl>
                                    <dl class="flex items-center justify-between gap-4">
                                        <dt class="block mb-2 text-sm font-medium text-gray-500  dark:text-white">{{ t('LBL_DISCOUNT') }} </dt>
                                        <dd class="block mb-2 text-sm font-medium text-gray-500  dark:text-white">-20.000 VND</dd>
                                    </dl>
                                    <dl class="flex items-center justify-between gap-4">
                                        <dt class="block mb-2 text-sm font-medium text-gray-500  dark:text-white">{{ t('LBL_DELIVERY_FEE') }}</dt>
                                        <dd class="block mb-2 text-sm font-medium text-gray-500  dark:text-white">20.000 VND
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                    <dl class="flex items-center m-4 mt-0 justify-between gap-4 pl-2 border-t border-gray-200 pt-2 dark:border-gray-700">
                        <dt class="text-lg font-bold text-gray-500 dark:text-white">{{ t('LBL_TOTAL') }}</dt>
                        <dd class="text-lg font-bold text-gray-500 dark:text-white">157.000 VND</dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="flex gap-2 justify-end p-2 mt-4 mr-4 pr-4 sticky bottom-0 right-0 bg-gray-100 w-full">
            <button
                class="w-full justify-center sm:w-auto text-gray-500 inline-flex items-center bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 rounded-full border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-500 "
                @click="emit('showPaymentDetail', index)"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="size-4 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                </svg>
                Go back to cart
            </button>
            <button class="bg-[#6B4226] text-white px-4 py-2 rounded-full font-bold">
                Proceed
            </button>
        </div>
    </section>
</template>

<style scoped>
.form-radio {
    @apply appearance-none w-4 h-4 border-2 border-[#6B4226] rounded-full cursor-pointer transition-all;
    background-color: white;
    position: relative;
}

.form-radio:checked {
    @apply bg-white border-[#6B4226];
}

.form-radio:checked::after {
    content: '';
    @apply block w-2.5 h-2.5 rounded-full bg-[#6B4226];
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
</style>
