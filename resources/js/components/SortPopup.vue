<template>
    <div v-if="isVisible" class="fixed inset-0 flex justify-center items-center" @click="close">
        <div class="bg-white p-6 rounded shadow-lg w-[200px] h[50px]" @click.stop>
            <div class="up">
                <div class="active flex flex-row items-center justify-center">
                    <svg width="26" height="22" viewBox="0 0 26 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.594 15.6646V1.9712C10.594 1.49805 10.8113 1.10144 11.2458 0.781374C11.6803 0.461304 12.2187 0.30127 12.8611 0.30127C13.5034 0.30127 14.0418 0.461304 14.4763 0.781374C14.9109 1.10144 15.1281 1.49805 15.1281 1.9712V15.6646L21.7026 10.8218C22.1182 10.5157 22.6472 10.3626 23.2896 10.3626C23.9319 10.3626 24.4609 10.5157 24.8765 10.8218C25.2921 11.128 25.4999 11.5176 25.4999 11.9908C25.4999 12.4639 25.2921 12.8536 24.8765 13.1597L14.448 20.8414C13.9946 21.1754 13.4656 21.3424 12.8611 21.3424C12.2565 21.3424 11.7275 21.1754 11.2741 20.8414L0.845611 13.1597C0.429982 12.8536 0.222168 12.4639 0.222168 11.9908C0.222168 11.5176 0.429982 11.128 0.845611 10.8218C1.26124 10.5157 1.79022 10.3626 2.43256 10.3626C3.07489 10.3626 3.60387 10.5157 4.0195 10.8218L10.594 15.6646Z" fill="#4D2F19"/>
                    </svg>
                    <div class="text-right text-sm font-semibold font-['Inter']">Giá: Giảm dần</div>
                </div>
                <div class="inactive flex flex-row items-center justify-center">
                    <svg width="26" height="22" viewBox="0 0 26 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.1282 6.07514V19.7685C15.1282 20.2417 14.9109 20.6383 14.4764 20.9584C14.0419 21.2784 13.5034 21.4385 12.8611 21.4385C12.2188 21.4385 11.6803 21.2784 11.2458 20.9584C10.8113 20.6383 10.594 20.2417 10.594 19.7685V6.07514L4.01956 10.9179C3.60393 11.2241 3.07495 11.3772 2.43261 11.3772C1.79028 11.3772 1.2613 11.2241 0.845667 10.9179C0.430037 10.6118 0.222223 10.2221 0.222223 9.74898C0.222223 9.27583 0.430037 8.88618 0.845667 8.58003L11.2742 0.898359C11.7276 0.564373 12.2566 0.397381 12.8611 0.397381C13.4657 0.397381 13.9946 0.564373 14.4481 0.898359L24.8766 8.58003C25.2922 8.88618 25.5 9.27583 25.5 9.74898C25.5 10.2221 25.2922 10.6118 24.8766 10.9179C24.4609 11.2241 23.9319 11.3772 23.2896 11.3772C22.6473 11.3772 22.1183 11.2241 21.7027 10.9179L15.1282 6.07514Z" fill="#757575" fill-opacity="0.28"/>
                    </svg>
                    <div class="text-right text-sm font-semibold font-['Inter']">Giá: Tang dần</div>
                </div>
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
    }
});

const emit = defineEmits();

const close = () => {
    emit('closePopup');
};

</script>
<style scoped>
.overlay {
    background-color: rgba(0, 0, 0, 0.5); /* Màu đen với độ trong suốt 70% */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 50; /* Đảm bảo lớp này hiển thị phía trên */
}
.active{
    color: #4d2f19;
}
.inactive {
    color: rgba(117, 117, 117, 0.28);
}

</style>
