<template>
    <div v-if="isVisible" class="overlay fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center" @click="close">
        <div class="bg-white p-5 lg:p-8 rounded-lg shadow-lg max-w-md h-[50%] w-[65%] lg:h-[70%] lg:w-full relative" @click.stop>
            <div class="flex flex-row items-center justify-between">
                <p class="text-black text-2xl font-semibold font-['Inter'] leading-[28.80px]">DETAILS</p>
            </div>
            <div class="details_size flex flex-row justify-between border-b border-gray-300 pb-5">
                <div class="details_size_label flex justify-between mt-3 mb-1">
                    <div class="details_label_name">Size</div>
                </div>
                <div class="details_size_list">
                    <button class="inactive_btn">S +0d</button>
                    <button class="inactive_btn">M +5.000d</button>
                    <button class="inactive_btn">L +10.000d</button>
                </div>
            </div>
            <div class="details_topping flex flex-col justify-between border-b border-gray-300 pb-5">
                <div class="details_size_label flex justify-between mt-3 mb-1">
                    <div class="details_label_name">Topping</div>
                </div>
                <div class="topping grid grid-cols-2 gap-4 flex flex-row">
                    <div class="flex flex-row">
                        <input type="checkbox">
                        <div class="topping_content">
                            <p>Milk foam</p>
                            <p>10.000 VND</p>
                        </div>
                    </div>
                    <div class="flex flex-row">
                        <input type="checkbox">
                        <div class="topping_content">
                            <p>Milk foam</p>
                            <p>10.000 VND</p>
                        </div>
                    </div>
                    <div class="flex flex-row">
                        <input type="checkbox">
                        <div class="topping_content">
                            <p>Milk foam</p>
                            <p>10.000 VND</p>
                        </div>
                    </div>
                    <div class="flex flex-row">
                        <input type="checkbox">
                        <div class="topping_content">
                            <p>Milk foam</p>
                            <p>10.000 VND</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="total flex items-center justify-end">
                <div class="">Total:</div>
                <div class="">120.000 VND</div>
            </div>
            <div class="filter_btn flex items-center justify-center lg:justify-end mt-15">
                <button @click="close" class="hidden md:block bg-gray-300 text-gray-700 px-4 py-2 rounded">Cancel</button>
                <button @click="close" class="active_btn mt-4 bg-gray-300 text-gray-700 px-4 py-2 rounded">Add to cart</button>

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
    background-color: rgba(0, 0, 0, 0.09); /* Màu đen với độ trong suốt 70% */
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 50; /* Đảm bảo lớp này hiển thị phía trên */
}
.active_btn {
    display: inline-flex;
    height: 38px;
    justify-content: center;
    align-items: center;
    flex-shrink: 0;
    border-radius: 50px;
    background: #4D2F19;
    padding: 14px;
    margin: 5px;

}
.inactive_btn {
    display: inline-flex;
    height: 38px;
    justify-content: center;
    align-items: center;
    flex-shrink: 0;
    border-radius: 50px;
    background: rgba(153, 125, 108, 0.12);
    padding: 14px;
    margin: 5px;

}
@media (max-width: 700px) {
    .active_btn {
        height: 28px;
    }
    .inactive_btn {
        height: 28px;
    }
}

</style>
