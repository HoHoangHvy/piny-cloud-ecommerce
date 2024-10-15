<template>
    <div v-if="isVisible" class="overlay fixed inset-0 bg-gray-800 bg-opacity-75 flex lg:items-center justify-end lg:justify-center" @click="close">
        <div class="bg-white p-5 lg:p-8 lg:rounded-lg shadow-lg max-w-md h-[100%] w-[65%] lg:h-[70%] lg:w-full relative" @click.stop>
            <div class="flex flex-row items-center justify-between">
                <p class="block lg:hidden text-black text-sm font-semibold font-['Inter'] leading-[28.80px]">Cancel</p>
                <p class="text-black text-2xl font-semibold font-['Inter'] leading-[28.80px]">FILTER</p>
                <p class="block lg:hidden text-black text-sm font-semibold font-['Inter'] leading-[28.80px]">Clear all</p>
            </div>
            <div class="tag border-b border-gray-300 pb-5">
                <div class="tag_label flex justify-between mt-3 mb-1">
                    <div class="tag_label_name">Category</div>
                    <div class="tag_label_qnt bg-[#4d2f19] rounded-[20px] pl-2.5 pr-2.5 pt-0.5 pb-0.5 text-white">1</div>
                </div>
                <div class="tag_list">
                    <button class="inactive_btn">Coffee</button>
                    <button class="inactive_btn">Bread</button>
                    <button class="inactive_btn">Tea</button>
                    <button class="inactive_btn">hdjsghggg</button>
                    <button class="inactive_btn">13254</button>
                    <button class="inactive_btn">Suer</button>
                    <button class="active_btn">Spring</button>
                </div>
            </div>
            <div class="tag">
                <div class="tag_label flex justify-between mt-3 mb-1">
                    <div class="tag_label_name">Tag</div>
                    <div class="tag_label_qnt bg-[#4d2f19] rounded-[20px] pl-2.5 pr-2.5 pt-0.5 pb-0.5 text-white">3</div>
                </div>
                <div class="tag_list">
                    <button class="inactive_btn">Coffee</button>
                    <button class="inactive_btn">Bread</button>
                    <button class="inactive_btn">Tea</button>
                    <button class="inactive_btn">hdjsghggg</button>
                    <button class="inactive_btn">13254</button>
                    <button class="inactive_btn">Suer</button>
                    <button class="active_btn">Spring</button>
                </div>
            </div>
            <div class="filter_btn flex items-center justify-center lg:justify-end mt-15">
                <button @click="close" class="hidden md:block bg-gray-300 text-gray-700 px-4 py-2 rounded">Clear all</button>
                <button @click="close" class="active_btn mt-4 bg-gray-300 text-gray-700 px-4 py-2 rounded">Apply</button>

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
