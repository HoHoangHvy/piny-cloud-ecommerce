<template>
    <section class="bg-gray-50 dark:bg-gray-900">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <div class="text-xl font-bold leading-tight tracking-tight text-black md:text-2xl dark:text-white">
                        {{ t('LBL_PINY_CLOUD_BREAD_AND_TEA') }}
                    </div>
                    <form class="space-y-4 md:space-y-6" @submit.prevent="handleSignIn">
                        <div>
                            <label for="phone" class="block mb-2 text-sm font-inter text-black dark:text-white">{{ t('LBL_PHONE_NUMBER') }}</label>
                            <input
                                type="text"
                                name="phone"
                                id="phone"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder=""
                                required=""
                            />
                        </div>
                        <div>
                            <a href="http://127.0.0.1:8000/login-password" class="text-sm font-inter text-black dark:text-gray-400 hover:underline">{{ t('LBL_OR_LOGIN_WITH_PASSWORD') }}</a>
                        </div>
                        <button type="submit" class="w-full text-white bg-[#4D2F19] hover:bg-[#4D2F19] focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-[#4D2F19] dark:hover:bg-[#4D2F19] dark:focus:ring-primary-800">{{ t('LBL_SIGNIN') }}</button>
                        <div class="flex items-center space-x-2">
                            <label for="dont_have_an_account" class="text-sm font-inter text-black dark:text-gray-400">{{ t('LBL_DONT_HAVE_AN_ACCOUNT?') }}</label>
                            <a href="http://127.0.0.1:8000/register" class="hover:underline font-inter text-[#4D2F19]" target="_blank">{{ t('LBL_SIGNUP') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Pop-up cho OTP -->
        <div v-if="showOtpPopup" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50" @click="handleOverlayClick">
            <div class="bg-white rounded-lg shadow-lg p-6 text-center" @click.stop>
                <h2 class="text-sm font-inter text-black dark:text-gray-400">{{ t('LBL_OTP_AUTHENTICATION') }}</h2>
                <div class="flex justify-center">
                    <svg width="309" height="5" viewBox="0 0 309 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 4L309 1" stroke="black" stroke-opacity="0.25" />
                    </svg>
                </div>
                <p class="text-sm font-inter text-black dark:text-gray-400">{{ t('LBL_A_VERIFICATION_CODE_IS_SENT_TO_YOUR_NUMBER') }}</p>

                <!-- Inputs for OTP -->
                <div class="flex justify-between mt-4 mb-4">
                    <input
                        type="text"
                        class="w-[50px] h-12 bg-neutral-100 ml-2 mr-2 text-center border-gray-300 rounded"
                        maxlength="1"
                    />
                    <input
                        type="text"
                        class="w-[50px] h-12 bg-neutral-100 ml-2 mr-2 text-center border-gray-300 rounded"
                        maxlength="1"
                    />
                    <input
                        type="text"
                        class="w-[50px] h-12 bg-neutral-100 ml-2 mr-2 text-center border-gray-300 rounded"
                        maxlength="1"
                    />
                    <input
                        type="text"
                        class="w-[50px] h-12 bg-neutral-100 ml-2 mr-2 text-center border-gray-300 rounded"
                        maxlength="1"
                    />
                    <input
                        type="text"
                        class="w-[50px] h-12 bg-neutral-100 ml-2 mr-2 text-center border-gray-300 rounded"
                        maxlength="1"
                    />
                    <input
                        type="text"
                        class="w-[50px] h-12 bg-neutral-100 ml-2 mr-2 text-center border-gray-300 rounded"
                        maxlength="1"
                    />
                </div>

                <!-- Countdown or Resend link -->
                <p class="text-sm font-inter text-black dark:text-gray-400">
                    <span v-if="countdown > 0">{{t('LBL_YOU_DID_NOT_RECEIVE_THE_CODE_RESEND')}}({{ countdown }}s)</span>
                    <span v-else><a href="#" @click="resendCode">Gửi lại</a></span>
                </p>

                <button class="bg-[#4D2F19] text-white px-4 py-2 rounded-lg" @click="showOtpPopup = false">{{ t('LBL_SIGNIN') }}</button>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();
const showOtpPopup = ref(false); // Control the OTP pop-up visibility
const countdown = ref(60); // Countdown timer

// Function to start the countdown
const startCountdown = () => {
    const interval = setInterval(() => {
        if (countdown.value > 0) {
            countdown.value--;
        } else {
            clearInterval(interval); // Clear the interval when countdown reaches 0
        }
    }, 1000);
};

// Function to handle sign-in (OTP pop-up)
const handleSignIn = () => {
    showOtpPopup.value = true; // Show OTP pop-up
    countdown.value = 30; // Reset countdown
    startCountdown(); // Start countdown
};

// Function to resend code
const resendCode = () => {
    countdown.value = 30; // Reset the countdown
    startCountdown(); // Start the countdown again
    // Here, you can trigger the OTP resend logic (e.g., make an API call)
};

// Function to close OTP pop-up on overlay click
const handleOverlayClick = () => {
    showOtpPopup.value = false; // Hide OTP pop-up
};

onMounted(() => {
    // You can initialize anything here if needed
});
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Kaisei+Decol&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;700&family=Kaisei+Decol:wght@700&display=swap');

/* Apply Inter font for the entire page */
* {
    font-family: 'Inter', sans-serif;
}

/* Apply Kaisei Decol only for the title */
.text-xl {
    font-family: 'Kaisei Decol', sans-serif;
}
</style>
