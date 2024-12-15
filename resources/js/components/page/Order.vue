<script setup>
import { ref, onMounted } from 'vue';
import { useI18n } from "vue-i18n";

const { t } = useI18n();
const voucherModalVisible = ref(false);
const dayAfterTomorrow = ref(''); // Biến để lưu trữ giá trị ngày kia

function openVoucherModal() {
    voucherModalVisible.value = true;
}

function closeVoucherModal() {
    voucherModalVisible.value = false;
}

// Tính toán ngày kia khi component được khởi tạo
onMounted(() => {
    const date = new Date();
    date.setDate(date.getDate() + 2); // Cộng thêm 2 ngày

    const day = String(date.getDate()).padStart(2, '0'); // Đảm bảo có 2 chữ số
    const month = String(date.getMonth() + 1).padStart(2, '0'); // Tháng bắt đầu từ 0
    const year = date.getFullYear();

    // Định dạng ngày theo dd/mm/yyyy
    dayAfterTomorrow.value = `${day}/${month}`;
});


//Sử dụng Scroll list cho danh sách sản phẩm
document.addEventListener("DOMContentLoaded", function() {
    const orderList = document.getElementById("order-list");
    const orderItems = orderList.getElementsByClassName("order-item");

    if (orderItems.length >= 3) {
        // Thêm các lớp Tailwind khi có 3 sản phẩm trở lên
        orderList.classList.add("max-h-32", "overflow-y-auto", "rounded-lg");
    }
});

</script>


<template>
    <section class="bg-white py-8 antialiased dark:bg-gray-900 md:py-16">
        <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
            <!--Card 1-->
            <div class="mt-6 sm:mt-8 lg:grid lg:grid-cols-2 gap-8">
                <div class="w-full lg:max-w-md h-full divide-y divide-gray-200 overflow-hidden rounded-lg border-2 border-[#6B4226] dark:divide-gray-700 dark:border-gray-700 lg:max-w-xl xl:max-w-2xl">
                    <!--Delivery-->
                    <div class="space-y-1 p-6 pl-10">
                        <div class="flex items-center justify-between">
                            <label class="font-inter font-bold text-black dark:text-white">{{$lang('LBL_DELIVERY')}}</label>
                            </div>
                                <svg width="65" height="5" viewBox="0 0 65 1" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-top: -4px;">
                                    <line y1="0.5" x2="65" y2="0.5" stroke="#6B4226"/>
                                </svg>
                            <div/>
                            <!--Address, Delivery time-->
                            <div>
                                <!--Address-->
                                <div class="">
                                    <div class="">
                                        <span class="font-inter text-black dark:text-gray-400">{{$lang('LBL_ADDRESS')}}</span>
                                    </div>
                                    <div class="">
                                        <input type="text" value="" placeholder="" class="w-full p-1 pl-4 text-black font-inter border-b border-black dark:border-white bg-transparent focus:outline-none" />
                                    </div>
                                </div>
                                <!--Delivery time-->
                                <div class="mt-4">
                                    <div class="">
                                        <span class="font-inter text-black dark:text-gray-400">{{$lang('LBL_DELIVERY_TIME')}}</span>
                                    </div>
                                    <div class="flex gap-4">
                                        <div class="w-1/2">
                                            <select class="w-full h-[43px] p-1 pl-4 text-black font-inter border-b border-black dark:border-white bg-transparent focus:outline-none">
                                                <option value="today">{{$lang('LBL_TODAY')}}</option>
                                                <option value="tomorrow">{{$lang('LBL_TOMORROW')}}</option>
                                                <option value="day-after-tomorrow">{{ t('LBL_DAY_AFTER_TOMORROW') }} - {{ dayAfterTomorrow }}</option>
                                            </select>
                                        </div>
                                        <div class="w-1/2">
                                            <input
                                                type="time"
                                                class="w-full p-2 text-black font-inter border-b border-black dark:border-white "
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="text-black">{{$lang('LBL_RECIPIENT_NAME')}}</label>
                                    <div>
                                        <input type="text" placeholder="" class="w-full p-2 border rounded">
                                        <div class="text-red-500 text-sm mt-1 hidden">Vui lòng nhập tên người nhận</div>
                                    </div>
                            </div>
                            <div>
                                    <label class="text-black">{{$lang('LBL_PHONE_NUMBER')}}</label>
                                    <div>
                                        <input type="text" placeholder="" class="w-full p-2 border rounded">
                                        <div class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 mt-1 hidden">Vui lòng nhập số điện thoại người nhận</div>
                                    </div>
                                </div>
                            <div>
                                    <label class="text-black">{{$lang('LBL_NOTE')}}</label>
                                    <div>
                                        <input type="text" placeholder="" class="w-full p-2 border rounded">
                                    </div>
                                </div>
                        <div/>
                    </div>

                    <!--Order details-->
                    <div class="space-y-1 p-6 pl-10">
                        <div class="flex items-center justify-between">
                            <label class="font-inter font-bold text-black dark:text-white">{{$lang('LBL_ORDER_DETAILS')}}</label>
                        </div>
                        <svg width="65" height="5" viewBox="0 0 65 1" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-top: -4px;">
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
                            <div class="order-item flex justify-between items-center border-b py-2">
                                <div class="flex items-start">
                                    <i class="fa fa-pen mr-3"></i>
                                    <div>
                                        <h5 class="font-inter text-black">1 x Trà Sữa Oolong</h5>
                                        <p class="font-inter text-black">L</p>
                                    </div>
                                </div>
                                <p class="font-inter text-black mr-4">49.000 VND</p>
                            </div>
                            <div class="order-item flex justify-between items-center border-b py-2">
                                <div class="flex items-start">
                                    <i class="fa fa-pen mr-3"></i>
                                    <div>
                                        <h5 class="font-inter text-black">1 x Trà Sữa Oolong</h5>
                                        <p class="font-inter text-black">M</p>
                                    </div>
                                </div>
                                <p class="font-inter text-black mr-4">39.000 VND</p>
                            </div>
                            <div class="order-item flex justify-between items-center border-b py-2">
                                <div class="flex items-start">
                                    <i class="fa fa-pen mr-3"></i>
                                    <div>
                                        <h5 class="font-inter text-black">1 x Trà Sữa Oolong</h5>
                                        <p class="font-inter text-black">M</p>
                                    </div>
                                </div>
                                <p class="font-inter text-black mr-4">39.000 VND</p>
                            </div>
                            <div class="order-item flex justify-between items-center border-b py-2">
                                <div class="flex items-start">
                                    <i class="fa fa-pen mr-3"></i>
                                    <div>
                                        <h5 class="font-inter text-black">1 x Trà Sữa Oolong</h5>
                                        <p class="font-inter text-black">M</p>
                                    </div>
                                </div>
                                <p class="font-inter text-black mr-4">39.000 VND</p>
                            </div>
                            <div class="order-item flex justify-between items-center border-b py-2">
                                <div class="flex items-start">
                                    <i class="fa fa-pen mr-3"></i>
                                    <div>
                                        <h5 class="font-inter text-black">1 x Trà Sữa Oolong</h5>
                                        <p class="font-inter text-black">M</p>
                                    </div>
                                </div>
                                <p class="font-inter text-black mr-4">39.000 VND</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Card 2-->
                <div class="mt-6 grow sm:mt-8 lg:mt-0">
                    <div class="w-full h-full space-y-6 rounded-lg border-2 border-[#6B4226] bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                        <!-- Payment method -->
                        <div class="flex flex-col space-y-3 pl-6 mb-10">
                            <div class="flex items-center justify-between relative">
                                <label class="font-inter font-bold text-black dark:text-white">{{ t('LBL_PAYMENT_METHOD') }}</label>
                            </div>
                            <svg width="65" height="5" viewBox="0 0 65 1" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-top: -4px; margin-bottom: 10px;">
                                <line y1="0.5" x2="65" y2="0.5" stroke="#6B4226"/>
                            </svg>

                            <div class="flex items-center space-x-2">
                                <input id="cash" type="radio" name="payment" class="form-radio" checked>
                                <label for="cash" class="text-black">{{$lang('LBL_CASH')}}</label>
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

                        <!--Line-->
<!--                        <div class="flex justify-center">-->
<!--                            <svg width="500" height="1" viewBox="0 0 500 1" fill="none" xmlns="http://www.w3.org/2000/svg" class="mx-auto">-->
<!--                                <line y1="0.5" x2="500" y2="0.5"/>-->
<!--                            </svg>-->
<!--                        </div>-->

                        <!--Payment info-->
                        <div class="pl-6 pt-2 border-t">
                            <div class="flex items-center justify-between relative">
                                <label class="font-inter font-bold text-black dark:text-white">{{$lang('LBL_PAYMENT_INFOMATION')}}</label>
                                <div class="justify-end">
                                </div>
                            </div>
                            <svg width="65" height="5" viewBox="0 0 65 1" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-top: -4px;">
                                <line y1="0.5" x2="65" y2="0.5" stroke="#6B4226"/>
                            </svg>
                        </div>
                        <div class="w-full space-y-4 bg-gray-50 p-6 dark:bg-gray-800 border-gray-700">
                            <div class="space-y-2" style="margin-top: -35px;">
                                <dl class="flex items-center justify-between gap-4">
                                    <dt class="font-inter text-black dark:text-gray-400">{{$lang('LBL_PRICE')}}</dt>
                                    <dd class="font-inter text-black dark:text-white">157.000 VND</dd>
                                </dl>
                                <!--Voucher-->
                                <!-- Trigger Voucher -->
                                <div class="flex">
                                    <dt class="font-bold hover:underline cursor-pointer text-lg text-[#6B4226]" @click="openVoucherModal">{{ t('LBL_VOUCHER')}}</dt>
                                </div>
                                <!-- Voucher Popup Modal -->
                                <div v-if="voucherModalVisible" class="fixed inset-0 z-50 bg-gray-900 bg-opacity-50 flex items-center justify-center">
                                    <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full">
                                        <h2 class="font-bold text-black text-lg mb-4">{{$lang('LBL_VOUCHER')}}</h2>
                                        <div class="grid grid-cols-1 gap-4">
                                            <!-- Voucher item -->
                                            <div class="flex items-center justify-between border p-4 rounded-lg">
                                                <div class="ml-4">
                                                    <p class="text-black font-inter">Freeship</p>
                                                </div>
                                                <button class="bg-[#6B4226] text-white px-4 py-2 rounded-lg">{{$lang('LBL_USE_NOW')}}</button>
                                            </div>
                                            <div class="flex items-center justify-between border p-4 rounded-lg">
                                                <div class="ml-4">
                                                    <p class="text-black font-inter">20% Off</p>
                                                </div>
                                                <button class="bg-[#6B4226] text-white px-4 py-2 rounded-lg">{{$lang('LBL_USE_NOW')}}</button>
                                            </div>
                                            <div class="flex items-center justify-between border p-4 rounded-lg">
                                                <div class="ml-4">
                                                    <p class="text-black font-inter">10% Off + Free ship</p>
                                                </div>
                                                <button class="bg-[#6B4226] text-white px-4 py-2 rounded-lg">{{$lang('LBL_USE_NOW')}}</button>
                                            </div>
                                            <!-- Thêm nhiều Voucher khác tại đây -->
                                        </div>
                                        <button class="mt-4 text-sm text-black hover:underline" @click="closeVoucherModal">{{$lang('LBL_CLOSE')}}</button>
                                    </div>
                                </div>
                                <!--Discount-->
                                <dl class="flex items-center justify-between gap-4">
                                    <dt class="font-inter text-black dark:text-gray-400">{{$lang('LBL_DISCOUNT')}}</dt>
                                    <dd class="font-inter text-black dark:text-gray-400">-20.000 VND</dd>
                                </dl>
                                <!--Delivery fee-->
                                <dl class="flex items-center justify-between gap-4">
                                    <dt class="font-inter text-black dark:text-gray-400">{{$lang('LBL_DELIVERY_FEE')}}</dt>
                                    <dd class="font-inter text-black dark:text-gray-400">20.000 VND</dd>
                                </dl>
                            </div>
                            <!--Total-->
                            <dl class="flex items-center justify-between gap-4 border-t border-gray-200 pt-2 dark:border-gray-700">
                                <dt class="text-lg font-bold text-black dark:text-white">{{$lang('LBL_TOTAL')}}</dt>
                                <dd class="text-lg font-bold text-black dark:text-white">157.000 VND</dd>
                            </dl>
                        </div>
                        <!--Pay button-->
                        <div class="gap-4 sm:flex sm:items-start">
                            <button type="button" class="w-full rounded-lg border border-gray-200 bg-[#6B4226] px-5 py-2.5 text-sm font-inter text-white hover:bg-gray-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700">{{$lang('LBL_PAY')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>

.form-radio {
    @apply appearance-none w-4 h-4 border-2 border-[#6B4226] rounded-full cursor-pointer transition-all;
    background-color: white; /* Nền trắng cho radio button */
    position: relative; /* Để chứa phần ::after */
}
.form-radio:checked {
    @apply bg-white border-[#6B4226]; /* Nền trắng và viền nâu khi được chọn */
}
.form-radio:checked::after {
    content: '';
    @apply block w-2.5 h-2.5 rounded-full bg-[#6B4226]; /* Hình tròn nhỏ màu nâu */
    position: absolute; /* Để căn giữa */
    top: 50%; /* Đưa phần tử xuống giữa theo chiều dọc */
    left: 50%; /* Đưa phần tử sang giữa theo chiều ngang */
    transform: translate(-50%, -50%); /* Dịch chuyển để căn giữa chính xác */
}

#voucherModal {
    display: none;
}
#voucherModal.active {
    display: flex;
}
</style>
