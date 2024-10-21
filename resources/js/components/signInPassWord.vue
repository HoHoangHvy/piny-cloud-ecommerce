<script setup>
import {useI18n} from "vue-i18n";

const {t} = useI18n();

import { ref } from 'vue';

// Biến trạng thái mật khẩu hiển thị/ẩn
const showPassword = ref(false);

// Hàm chuyển đổi trạng thái hiển thị/ẩn mật khẩu
const togglePassword = () => {
    showPassword.value = !showPassword.value;
};
</script>

<template>
    <section class="bg-gray-50 dark:bg-gray-900">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">

            <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <div class="text-xl font-bold leading-tight tracking-tight text-black md:text-2xl dark:text-white">
                        {{t('LBL_PINY_CLOUD_BREAD_AND_TEA')}}
                    </div>
                    <form class="space-y-4 md:space-y-6" action="#">

                        <div>
                            <label for="phone" class="block mb-2 text-sm font-inter text-black dark:text-white">{{t('LBL_PHONE_NUMBER')}}</label>
                            <input type="text" name="phone" id="phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required="">
                        </div>

                        <div class="input-container">
                            <label for="password" class="block mb-2 text-sm font-inter text-black dark:text-white">
                                {{ t('LBL_PASSWORD') }}
                            </label>
                            <div class="flex items-center relative">
                                <input
                                    :type="showPassword ? 'text' : 'password'"
                                    name="password"
                                    id="password"
                                    placeholder=""
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 pr-10 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    required
                                />

                                <!-- SVG biểu tượng mắt -->
                                <span @click="togglePassword" class="input-icon cursor-pointer">
                                    <!-- Biểu tượng SVG đôi mắt -->
                                    <svg v-if="!showPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6 text-gray-700 dark:text-gray-300">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-.739 2.467-2.488 4.573-4.737 5.717a9.956 9.956 0 01-9.622 0C4.946 16.573 3.197 14.467 2.458 12z" />
                                    </svg>
                                    <!-- Biểu tượng SVG mắt mở -->
                                    <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6 text-gray-700 dark:text-gray-300">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5C16.4183 4.5 20.209 7.493 21.542 12C20.2087 16.507 16.418 19.5 12 19.5C7.58172 19.5 3.791 16.507 2.458 12C3.79132 7.493 7.582 4.5 12 4.5Z" />
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9.5C13.3807 9.5 14.5 10.6193 14.5 12C14.5 13.3807 13.3807 14.5 12 14.5C10.6193 14.5 9.5 13.3807 9.5 12C9.5 10.6193 10.6193 9.5 12 9.5Z" />
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <div>
                            <a href="http://127.0.0.1:8000/sign-in-otp" class="text-sm font-inter text-black dark:text-gray-400 hover:underline">{{t('LBL_FORGOT_PASSWORD?')}}</a>
                        </div>

                        <button type="submit" class="w-full text-white bg-[#4D2F19] hover:bg-[#4D2F19] focus:ring-4 focus:outline-none focus:ring-primary-300 font-inter rounded-lg text-sm px-5 py-2.5 text-center dark:bg-[#4D2F19] dark:hover:bg-[#4D2F19] dark:focus:ring-primary-800">{{t('LBL_SIGNIN')}}</button>
                        <div class="flex items-center space-x-2">
                            <label for="dont_have_an_account" class="text-sm font-inter text-black dark:text-gray-400">{{t('LBL_DONT_HAVE_AN_ACCOUNT?')}}</label>
                            <a href="http://127.0.0.1:8000/sign-up" class="hover:underline text-[#4D2F19]" target="_blank">{{t('LBL_SIGNUP')}}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Kaisei+Decol&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;700&family=Kaisei+Decol:wght@700&display=swap');

/* Áp dụng font Inter cho toàn bộ trang */
* {
    font-family: 'Inter', sans-serif;
}
/* Áp dụng Kaisei Decol chỉ cho tiêu đề */
.text-xl {
    font-family: 'Kaisei Decol', sans-serif;
}

.input-container {
    position: relative;
}
.input-icon {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
}
</style>


