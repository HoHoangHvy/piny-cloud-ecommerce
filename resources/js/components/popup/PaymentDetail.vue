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
    <section v-if="isVisible">
        <div class="mx-auto max-w-screen-xl pr-2 pl-4">
            <div class="flex flex-col mt-6 sm:mt-8 gap-8">
                <!-- Delivery Section -->
                <div
                    class="w-full lg:max-w-md h-full divide-y divide-gray-200 overflow-hidden rounded-lg border-2 border-[#6B4226] dark:divide-gray-700 dark:border-gray-700 lg:max-w-xl xl:max-w-2xl">
                    <div class="space-y-1 p-6 pl-10">
                        <div class="flex items-center justify-between">
                            <label class="font-inter font-bold text-black dark:text-white">{{
                                    t('LBL_DELIVERY')
                                }}</label>
                        </div>
                        <svg width="65" height="5" viewBox="0 0 65 1" fill="none" xmlns="http://www.w3.org/2000/svg"
                             style="margin-top: -4px;">
                            <line y1="0.5" x2="65" y2="0.5" stroke="#6B4226"/>
                        </svg>
                        <div class="mt-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="font-inter text-black dark:text-gray-400">{{
                                            t('LBL_PROVINCE')
                                        }}</label>
                                    <select class="w-full p-2 border rounded">
                                        <option value="">Select Province</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="font-inter text-black dark:text-gray-400">{{
                                            t('LBL_DISTRICT')
                                        }}</label>
                                    <select class="w-full p-2 border rounded">
                                        <option value="">Select District</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="font-inter text-black dark:text-gray-400">{{ t('LBL_WARD') }}</label>
                                    <select class="w-full p-2 border rounded">
                                        <option value="">Select Ward</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="font-inter text-black dark:text-gray-400">{{
                                            t('LBL_STREET')
                                        }}</label>
                                    <input type="text" class="w-full p-2 border rounded" placeholder="Enter Street">
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <label class="font-inter text-black dark:text-gray-400">{{ t('LBL_DELIVERY_TIME') }}</label>
                            <div class="flex gap-4">
                                <div class="w-1/2">
                                    <select class="w-full p-2 border rounded">
                                        <option value="today">{{ t('LBL_TODAY') }}</option>
                                        <option value="tomorrow">{{ t('LBL_TOMORROW') }}</option>
                                        <option value="day-after-tomorrow">{{ t('LBL_DAY_AFTER_TOMORROW') }} -
                                            {{ dayAfterTomorrow }}
                                        </option>
                                    </select>
                                </div>
                                <div class="w-1/2">
                                    <input type="time" class="w-full p-2 border rounded">
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <label class="font-inter text-black dark:text-gray-400">{{
                                    t('LBL_RECIPIENT_NAME')
                                }}</label>
                            <input type="text" class="w-full p-2 border rounded" placeholder="Enter Name">
                        </div>
                        <div class="mt-4">
                            <label class="font-inter text-black dark:text-gray-400">{{ t('LBL_PHONE_NUMBER') }}</label>
                            <input type="text" class="w-full p-2 border rounded" placeholder="Enter Phone Number">
                        </div>
                        <div class="mt-4">
                            <label class="font-inter text-black dark:text-gray-400">{{ t('LBL_NOTE') }}</label>
                            <input type="text" class="w-full p-2 border rounded" placeholder="Enter Note">
                        </div>
                    </div>
                    <!-- Order Details -->
                    <div class="space-y-1 p-6 pl-10">
                        <div class="flex items-center justify-between">
                            <label class="font-inter font-bold text-black dark:text-white">{{
                                    t('LBL_ORDER_DETAILS')
                                }}</label>
                        </div>
                        <svg width="65" height="5" viewBox="0 0 65 1" fill="none" xmlns="http://www.w3.org/2000/svg"
                             style="margin-top: -4px;">
                            <line y1="0.5" x2="65" y2="0.5" stroke="#6B4226"/>
                        </svg>
                        <div class="mt-4" id="order-list">
                            <div class="order-item flex justify-between items-center border-b py-2">
                                <div class="flex items-start">
                                    <i class="fa fa-pen mr-3"></i>
                                    <div>
                                        <h5 class="font-inter text-black">1 x Trà Đen Macchiato</h5>
                                        <p class="font-inter text-black">L, Trân châu đen</p>
                                    </div>
                                </div>
                                <p class="font-inter text-black mr-4">69.000 VND</p>
                            </div>
                            <!-- Add more order items here -->
                        </div>
                    </div>
                </div>

                <!-- Payment Section -->
                <div class="mt-6 grow sm:mt-8 lg:mt-0">
                    <div
                        class="w-full h-full space-y-6 rounded-lg border-2 border-[#6B4226] bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                        <div class="flex flex-col space-y-3 pl-6 mb-10">
                            <div class="flex items-center justify-between relative">
                                <label class="font-inter font-bold text-black dark:text-white">{{
                                        t('LBL_PAYMENT_METHOD')
                                    }}</label>
                            </div>
                            <svg width="65" height="5" viewBox="0 0 65 1" fill="none" xmlns="http://www.w3.org/2000/svg"
                                 style="margin-top: -4px; margin-bottom: 10px;">
                                <line y1="0.5" x2="65" y2="0.5" stroke="#6B4226"/>
                            </svg>
                            <div class="flex items-center space-x-2">
                                <input id="cash" type="radio" name="payment" class="form-radio" checked>
                                <label for="cash" class="text-black">{{ t('LBL_CASH') }}</label>
                            </div>
                            <div class="flex items-center space-x-2">
                                <input id="momo" type="radio" name="payment" class="form-radio">
                                <label for="momo" class="text-black">Momo</label>
                            </div>
                            <div class="flex items-center space-x-2">
                                <input id="zalopay" type="radio" name="payment" class="form-radio">
                                <label for="zalopay" class="text-black">Zalopay</label>
                            </div>
                            <div class="flex items-center space-x-2">
                                <input id="visa" type="radio" name="payment" class="form-radio">
                                <label for="visa" class="text-black">Visa</label>
                            </div>
                            <div class="flex items-center space-x-2">
                                <input id="vnpay" type="radio" name="payment" class="form-radio">
                                <label for="vnpay" class="text-black">VNPAY</label>
                            </div>
                        </div>
                        <div class="pl-6 pt-2 border-t">
                            <div class="flex items-center justify-between relative">
                                <label class="font-inter font-bold text-black dark:text-white">{{
                                        t('LBL_PAYMENT_INFOMATION')
                                    }}</label>
                            </div>
                            <svg width="65" height="5" viewBox="0 0 65 1" fill="none" xmlns="http://www.w3.org/2000/svg"
                                 style="margin-top: -4px;">
                                <line y1="0.5" x2="65" y2="0.5" stroke="#6B4226"/>
                            </svg>
                        </div>
                        <div class="w-full space-y-4 bg-gray-50 p-6 dark:bg-gray-800 border-gray-700">
                            <div class="space-y-2" style="margin-top: -35px;">
                                <dl class="flex items-center justify-between gap-4">
                                    <dt class="font-inter text-black dark:text-gray-400">{{ t('LBL_PRICE') }}</dt>
                                    <dd class="font-inter text-black dark:text-white">157.000 VND</dd>
                                </dl>
                                <div class="flex">
                                    <dt class="font-bold hover:underline cursor-pointer text-lg text-[#6B4226]"
                                        @click="openVoucherModal">{{ t('LBL_VOUCHER') }}
                                    </dt>
                                </div>
                                <div v-if="voucherModalVisible"
                                     class="fixed inset-0 z-50 bg-gray-900 bg-opacity-50 flex items-center justify-center">
                                    <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
                                        <div class="flex justify-between items-center">
                                            <h2 class="font-bold text-black text-lg mb-4">{{ t('LBL_VOUCHER') }}</h2>
                                            <XIcon class="h-6 w-6 text-gray-500 cursor-pointer"
                                                   @click="closeVoucherModal"/>
                                        </div>
                                        <div class="grid grid-cols-1 gap-4">
                                            <div class="flex items-center justify-between border p-4 rounded-lg">
                                                <div class="ml-4">
                                                    <p class="text-black font-inter">Freeship</p>
                                                </div>
                                                <button class="bg-[#6B4226] text-white px-4 py-2 rounded-lg">
                                                    {{ t('LBL_USE_NOW') }}
                                                </button>
                                            </div>
                                            <!-- Add more vouchers here -->
                                        </div>
                                        <button class="mt-4 text-sm text-black hover:underline"
                                                @click="closeVoucherModal">{{ t('LBL_CLOSE') }}
                                        </button>
                                    </div>
                                </div>
                                <dl class="flex items-center justify-between gap-4">
                                    <dt class="font-inter text-black dark:text-gray-400">{{ t('LBL_DISCOUNT') }}</dt>
                                    <dd class="font-inter text-black dark:text-gray-400">-20.000 VND</dd>
                                </dl>
                                <dl class="flex items-center justify-between gap-4">
                                    <dt class="font-inter text-black dark:text-gray-400">{{
                                            t('LBL_DELIVERY_FEE')
                                        }}
                                    </dt>
                                    <dd class="font-inter text-black dark:text-gray-400">20.000 VND</dd>
                                </dl>
                            </div>
                            <dl class="flex items-center justify-between gap-4 border-t border-gray-200 pt-2 dark:border-gray-700">
                                <dt class="text-lg font-bold text-black dark:text-white">{{ t('LBL_TOTAL') }}</dt>
                                <dd class="text-lg font-bold text-black dark:text-white">157.000 VND</dd>
                            </dl>
                        </div>
                        <div class="gap-4 sm:flex sm:items-start">
                            <button type="button"
                                    class="w-full rounded-lg border border-gray-200 bg-[#6B4226] px-5 py-2.5 text-sm font-inter text-white hover:bg-gray-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700">
                                {{ t('LBL_PAY') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex gap-1 justify-end p-2 mt-4">
            <button
                class="w-full justify-center sm:w-auto text-gray-500 inline-flex items-center bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 rounded-full border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900"
                @click="emit('showPaymentDetail')"
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
