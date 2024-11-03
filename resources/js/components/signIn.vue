<template>
    <section class="bg-gray-50 dark:bg-gray-900">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <form class="space-y-4 md:space-y-6 w-full" @submit.prevent="handleSubmit" style="max-width: 90%; margin: auto;">
                <SignInOTP v-if="showOTP && !showForgotPassword" @toggle="toggleToPassword" />
                <SignInPassword
                    v-else-if="!showOTP && !showForgotPassword"
                    @toggle="toggleToOTP"
                    @forgot-password="toggleToForgotPassword"
                />
                <ForgotPassword v-if="showForgotPassword" @back="toggleToOTP" />
            </form>
        </div>
    </section>
</template>

<script setup>
import { ref } from 'vue';
import { useI18n } from 'vue-i18n';
import SignInOTP from "../components/signInOTP.vue";
import SignInPassword from "../components/signInPassword.vue";
import ForgotPassword from "../components/ForgotPassword.vue"; // Nhập component ForgotPassword

const { t } = useI18n();
const showOTP = ref(true); // Hiển thị OTP ban đầu
const showForgotPassword = ref(false); // Trạng thái cho màn hình quên mật khẩu

// Hàm chuyển sang trang mật khẩu
const toggleToPassword = () => {
    showOTP.value = false;
    showForgotPassword.value = false; // Đảm bảo không hiển thị quên mật khẩu
};

// Hàm quay lại màn hình OTP
const toggleToOTP = () => {
    showOTP.value = true;
    showForgotPassword.value = false; // Đảm bảo không hiển thị quên mật khẩu
};

// Hàm chuyển đến màn hình quên mật khẩu
const toggleToForgotPassword = () => {
    showForgotPassword.value = true;
    showOTP.value = false; // Ẩn màn hình OTP
};

// Hàm xử lý submit
const handleSubmit = () => {
    // Xử lý submit chung cho cả hai form nếu cần
};
</script>
