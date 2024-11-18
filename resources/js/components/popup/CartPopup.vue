<template>
    <div v-if="isVisible" class="overlay fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center" @click="close">
        <div class="bg-white p-5 lg:p-8 rounded-lg shadow-lg max-w-md w-[90%] h-auto lg:w-full relative" @click.stop>
            <div class="flex flex-row items-center justify-center lg:justify-start mb-2">
                <p class="text-black text-2xl font-semibold font-['Inter'] leading-[28.80px]">ORDER</p>
            </div>
            <div class="details_topping flex flex-col justify-between">
                <div v-for="cart in listCart" :key="cart.id" class="flex flex-row items-center justify-between border-b border-gray-300 pb-3 pt-2">
                    <input type="checkbox" class="form-checkbox h-3 w-3 lg:h-4 lg:w-4 border-gray-400 rounded accent-[#4d2f19] text-white w-1/12">
                    <div class="topping_content w-5/12 ml-2">
                        <p class="text-black-2 font-bold">{{cart.name}}</p>
                        <p class="text-[14px] leading-none">{{cart.note}} VND</p>
                    </div>
                    <div class="qnt flex flex-row justify-end w-2/12 mr-3 text-black-2">
                        <div class="">-</div>
                        <div class="ml-1 mr-1 w-[14px] text-center text-black-2">{{cart.qnt}}</div>
                        <div class="">+</div>
                    </div>
                    <div class="price w-3/12 text-right text-black-2 text-[16px] flex justify-end">
                        {{cart.price}}d
                    </div>
                    <div class="trash_icon w-1/12 flex items-center justify-end">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="black" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>

                    </div>
                </div>
            </div>
            <div class="total flex items-center justify-end mt-5 text-black-2 font-bold">
                <div class="">Total:</div>
                <div class="">120.000 VND</div>
            </div>
            <div class="filter_btn flex items-center justify-center lg:justify-end mt-5">
                <button @click="close" class="bg-gray-300 text-gray-700 px-4 py-2 rounded text-black-2 font-bold">Cancel</button>
                <button @click="close" class="active_btn mt-4 bg-gray-300 text-gray-700 px-4 py-2 rounded text-white font-bold">Pay</button>

            </div>
        </div>
    </div>
</template>
<script setup>
import { defineProps, defineEmits } from 'vue';

const listCart = [
    {
        id: 'lc01',
        name: 'Black coffee',
        note: 'M, Hot',
        qnt: '2',
        price: '100.000'
    },
    {
        id: 'lc02',
        name: 'Black coffee',
        note: 'M, Hot',
        qnt: '1',
        price: '100.000'
    },
    {
        id: 'lc03',
        name: 'Black coffee',
        note: 'M, Hot',
        qnt: '1',
        price: '100.000'
    },
    {
        id: 'lc04',
        name: 'Black coffee and tea',
        note: 'M, Hot, Sweet',
        qnt: '2',
        price: '50.000'
    }
]


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
.active_btn {
    display: inline-flex;
    height: 38px;
    justify-content: center;
    align-items: center;
    flex-shrink: 0;
    border-radius: 50px;
    background: #c48d60;
    padding: 14px;
    margin: 5px;

}
.topping_content p {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
@media (max-width: 700px) {
    .active_btn {
        height: 28px;
    }
}

</style>
