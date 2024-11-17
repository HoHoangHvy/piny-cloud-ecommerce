<template>
    <div v-if="isVisible"
         class="overlay fixed inset-0 bg-gray-800 bg-opacity-75 flex lg:items-center justify-end lg:justify-center"
         @click="close">
        <div class="bg-white lg:rounded-lg shadow-lg max-w-md h-fit w-[65%] lg:h-fit lg:w-full relative" @click.stop>
            <div class="flex flex-col items-center justify-center">
                <div
                    class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                        <div
                            class="text-xl font-bold leading-tight tracking-tight text-black md:text-2xl dark:text-white">
                            {{ t('LBL_PINY_CLOUD_BREAD_AND_TEA') }}
                        </div>
                        <form class="space-y-4 md:space-y-6" @submit.prevent="handleSendOTP">
                            <div>
                                <label for="phone" class="block mb-2 text-sm font-inter text-black dark:text-white">{{
                                        t('LBL_PHONE_NUMBER')
                                    }}</label>
                                <input
                                    type="text"
                                    name="phone"
                                    id="phone"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                    placeholder=""
                                    v-model="mobile_phone"
                                    required=""
                                />
                            </div>
                            <div id="recaptcha-container" class="mb-4"></div>
                            <div>
                                <a @click="switchToPopup('sign-in-password')"
                                   class="text-sm font-inter text-black dark:text-gray-400 hover:underline">
                                    {{ t('LBL_OR_LOGIN_WITH_PASSWORD') }}
                                </a>
                            </div>
                            <button type="submit"
                                    class="w-full text-white bg-[#4D2F19] hover:bg-[#4D2F19] focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-[#4D2F19] dark:hover:bg-[#4D2F19] dark:focus:ring-primary-800">
                                {{ t('LBL_SEND_OTP') }}
                            </button>
                            <div class="flex items-center space-x-2">
                                <label for="dont_have_an_account"
                                       class="text-sm font-inter text-black dark:text-gray-400">{{
                                        t('LBL_DONT_HAVE_AN_ACCOUNT?')
                                    }}</label>
                                <a @click="switchToPopup('sign-up')"
                                   class="hover:underline font-inter text-[#4D2F19]" target="_parent">{{
                                        t('LBL_SIGNUP')
                                    }}</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div v-if="showOtpPopup" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50"
                 @click="handleOverlayClick">
                <div class="bg-white rounded-lg shadow-lg p-6 text-center" @click.stop>
                    <h2 class="text-sm font-inter text-black dark:text-gray-400">{{ t('LBL_OTP_AUTHENTICATION') }}</h2>
                    <div class="flex justify-center">
                        <svg width="309" height="5" viewBox="0 0 309 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 4L309 1" stroke="black" stroke-opacity="0.25"/>
                        </svg>
                    </div>
                    <p class="text-sm font-inter text-black dark:text-gray-400">
                        {{ t('LBL_A_VERIFICATION_CODE_IS_SENT_TO_YOUR_NUMBER') }}</p>

                    <div class="flex justify-between mt-4 mb-4">
                        <input
                            type="text"
                            v-for="(digit, index) in otpData"
                            :key="index"
                            v-model="otpData[index]"
                            class="w-[50px] h-12 bg-neutral-100 ml-2 mr-2 text-center border-gray-300 rounded"
                            maxlength="1"
                            @input="autoFocusNext(index)"
                        />
                    </div>

                    <p class="text-sm font-inter text-black dark:text-gray-400">
                        <span v-if="countdown > 0">{{ t('LBL_YOU_DID_NOT_RECEIVE_THE_CODE_RESEND') }}({{
                                countdown
                            }}s)</span>
                        <span v-else><a href="#" @click="resendCode">Gửi lại</a></span>
                    </p>

                    <button class="bg-[#4D2F19] text-white px-4 py-2 rounded-lg mt-1" @click="verifyOTP">
                        {{ t('LBL_SIGNIN') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, defineEmits, defineProps } from 'vue';
import { useI18n } from 'vue-i18n';
import { useStore } from 'vuex';
import { auth, RecaptchaVerifier, signInWithPhoneNumber } from '@/js/firebase.js';

const store = useStore();
const { t } = useI18n();
const showOtpPopup = ref(false); // Control the OTP pop-up visibility
const countdown = ref(60); // Countdown timer
const otpData = ref(['', '', '', '', '', '']); // Store OTP input values
const confirmationResult = ref(null); // Firebase confirmation result for OTP verification
const emit = defineEmits();
const props = defineProps({
    isVisible: {
        type: Boolean,
        required: true,
    },
});
const mobile_phone = ref('');

// Initialize reCAPTCHA verifier
let recaptchaVerifier = null;
const setupRecaptcha = () => {
    window.recaptchaVerifier = new RecaptchaVerifier(auth, 'recaptcha-container', {
        size: 'invisible',
        callback: () => {
            console.log('recaptcha resolved..')
        }
    });
};
const close = () => {
    emit('closePopup');
};

const switchToPopup = (popup) => {
    emit('switchPopup', popup);
};

// Function to start the countdown
const startCountdown = () => {
    countdown.value = 60;
    const interval = setInterval(() => {
        if (countdown.value > 0) {
            countdown.value--;
        } else {
            clearInterval(interval); // Clear the interval when countdown reaches 0
        }
    }, 1000);
};

// Function to send OTP
const handleSendOTP = async () => {
    if (!mobile_phone.value) {
        alert(t('LBL_ENTER_PHONE_NUMBER'));
        return;
    }
    try {
        debugger
        setupRecaptcha();
        const phoneNumber = `+84${mobile_phone.value}`; // Adjust prefix as per your country
        confirmationResult.value = await signInWithPhoneNumber(auth, '+84398168226', window.recaptchaVerifier)
            .then((confirmationResult) => {
                debugger
                // SMS sent. Prompt user to type the code from the message, then sign the
                // user in with confirmationResult.confirm(code).
                window.confirmationResult = confirmationResult;
                // ...
            })
            .catch((error) => {
                debugger
            // Error; SMS not sent
            // ...
        });
        showOtpPopup.value = true; // Show OTP pop-up
        startCountdown(); // Start countdown
    } catch (error) {
        console.error('Error sending OTP:', error);
        alert(t('LBL_OTP_SEND_FAILED'));
    }
};

// Function to verify OTP
const verifyOTP = async () => {
    const otp = otpData.value.join('');
    if (!otp) {
        alert(t('LBL_ENTER_OTP'));
        return;
    }
    try {
        const result = await confirmationResult.value.confirm(otp);
        console.log('User signed in successfully:', result.user);
        alert(t('LBL_OTP_VERIFIED'));
        showOtpPopup.value = false; // Hide OTP pop-up
    } catch (error) {
        console.error('Error verifying OTP:', error);
        alert(t('LBL_INVALID_OTP'));
    }
};

// Function to resend OTP
const resendCode = async () => {
    try {
        handleSendOTP();
    } catch (error) {
        console.error('Failed to resend code:', error);
    }
};

// Function to close OTP pop-up on overlay click
const handleOverlayClick = () => {
    showOtpPopup.value = false; // Hide OTP pop-up
};

// Auto-focus the next input field for OTP
const autoFocusNext = (index) => {
    if (otpData.value[index].length === 1 && index < otpData.value.length - 1) {
        document.querySelectorAll('input')[index + 1].focus();
    }
};

onMounted(() => {
    // Initialization logic
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
#recaptcha-container {
    margin-top: 1rem;
    margin-bottom: 1rem;
}
</style>
