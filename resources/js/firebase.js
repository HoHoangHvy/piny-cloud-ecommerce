import { initializeApp } from 'firebase/app';
import { getAuth, RecaptchaVerifier, signInWithPhoneNumber } from 'firebase/auth';
import configuration from '@/config.js';
const firebaseConfig = {
    apiKey: "AIzaSyA90TCbcgsbMmyFCzmAjPHHFLt9wAngs5U",
    authDomain: "piny-cloud.firebaseapp.com",
    projectId: "piny-cloud",
    storageBucket: "piny-cloud.firebasestorage.app",
    messagingSenderId: "794026433165",
    appId: "1:794026433165:web:d6f06702fdf7680e4b60c4",
    measurementId: "G-EM9BLJCSSB"
};


const app = initializeApp(firebaseConfig);
const auth = getAuth(app);
auth.settings.appVerificationDisabledForTesting = true;

export { auth, RecaptchaVerifier, signInWithPhoneNumber };
