<template>
    <div v-if="isVisible" class="overlay fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center" @click="close">
        <div class="bg-white p-5 lg:p-8 rounded-lg shadow-lg max-w-md h-[50%] w-[65%] lg:h-[70%] lg:w-full relative" @click.stop>
            <div class="flex flex-row items-center justify-between">
                <p class="text-black text-2xl font-semibold font-['Inter'] leading-[28.80px]">ORDER FOR GROUP</p>
                <button class="for_group_order">MMO08724</button>
            </div>
            <div class="details_topping flex flex-col justify-between">
                <div class="flex flex-row items-center justify-between border-b border-gray-300 pb-2">
                    <input type="checkbox">
                    <div class="topping_content">
                        <p>Milk foam</p>
                        <p>10.000 VND</p>
                    </div>
                    <div class="qnt flex flex-row">
                        <div class="">-</div>
                        <div class="">1</div>
                        <div class="">+</div>
                    </div>
                    <div class="price">140.000 VND</div>
                    <div class="trash_icon">
                        <svg width="18" height="32" viewBox="0 0 18 32" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <rect width="18" height="32" fill="url(#pattern0_427_53595)"/>
                            <defs>
                                <pattern id="pattern0_427_53595" patternContentUnits="objectBoundingBox" width="1" height="1">
                                    <use xlink:href="#image0_427_53595" transform="matrix(0.0104167 0 0 0.00585938 0 0.21875)"/>
                                </pattern>
                                <image id="image0_427_53595" width="96" height="96" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGAAAABgCAYAAADimHc4AAAACXBIWXMAAAsTAAALEwEAmpwYAAABr0lEQVR4nO2XMU4DQRAEN+EvwCsJkQAL/mJNG97gDD4CDkFaZMkRIb5T7Z2rpEmR3dW9QGsiIiIiIiIDkeQuST/z7unvccnhdyXw4Xcl8OH31UqYMay+hKPzVwAN3cC4AD6E+ATxQQQ6+gXyCaKhGxgXwIeQS36CRERERERE6H+Mcun/eNEBRQF8SHEBfFDxCVrntdGhA4oC+JDiAvig4hM0zZuamd/sqX8eDh1QFKAAFLqhcQEKQKEbGhegABS6oXEBCkChGxoXoAAUuqFxAQpAoRsaF6AAFLqhcQEKQKEbGhegABS6oXEBCkChGxoXoAAUuqFxAQpAoRsaF6AAFLqhcQEKQKEbGhegABS6oXEBCkChGxoXoAAUuqFxAQpAoRsaF6AAFLqhcQEKQKEbGhegABS6oXEB+To3tIx7n210qupjgKD6HFdV7210kmzooDLfPbTRqarbJD8rbP/3bre7bkugql7owDL9bdpS2O/3V1X1NkBofaJ7PX6ntiROEp6P0x0gwP6fO332zeLC//s7oaqejn9BVNVhAaEfTp/1cbvd3tD5iYiIiIhIWx2/CUGmBOIce/cAAAAASUVORK5CYII="/>
                            </defs>
                        </svg>
                    </div>
                </div>
                <div class="flex flex-row items-center justify-between border-b border-gray-300 pb-2">
                    <input type="checkbox">
                    <div class="topping_content">
                        <p>Milk foam</p>
                        <p>10.000 VND</p>
                    </div>
                    <div class="qnt flex flex-row">
                        <div class="">-</div>
                        <div class="">1</div>
                        <div class="">+</div>
                    </div>
                    <div class="price">140.000 VND</div>
                    <div class="trash_icon">
                        <svg width="18" height="32" viewBox="0 0 18 32" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <rect width="18" height="32" fill="url(#pattern0_427_53595)"/>
                            <defs>
                                <pattern id="pattern0_427_53595" patternContentUnits="objectBoundingBox" width="1" height="1">
                                    <use xlink:href="#image0_427_53595" transform="matrix(0.0104167 0 0 0.00585938 0 0.21875)"/>
                                </pattern>
                                <image id="image0_427_53595" width="96" height="96" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGAAAABgCAYAAADimHc4AAAACXBIWXMAAAsTAAALEwEAmpwYAAABr0lEQVR4nO2XMU4DQRAEN+EvwCsJkQAL/mJNG97gDD4CDkFaZMkRIb5T7Z2rpEmR3dW9QGsiIiIiIiIDkeQuST/z7unvccnhdyXw4Xcl8OH31UqYMay+hKPzVwAN3cC4AD6E+ATxQQQ6+gXyCaKhGxgXwIeQS36CRERERERE6H+Mcun/eNEBRQF8SHEBfFDxCVrntdGhA4oC+JDiAvig4hM0zZuamd/sqX8eDh1QFKAAFLqhcQEKQKEbGhegABS6oXEBCkChGxoXoAAUuqFxAQpAoRsaF6AAFLqhcQEKQKEbGhegABS6oXEBCkChGxoXoAAUuqFxAQpAoRsaF6AAFLqhcQEKQKEbGhegABS6oXEBCkChGxoXoAAUuqFxAQpAoRsaF6AAFLqhcQEKQKEbGhegABS6oXEB+To3tIx7n210qupjgKD6HFdV7210kmzooDLfPbTRqarbJD8rbP/3bre7bkugql7owDL9bdpS2O/3V1X1NkBofaJ7PX6ntiROEp6P0x0gwP6fO332zeLC//s7oaqejn9BVNVhAaEfTp/1cbvd3tD5iYiIiIhIWx2/CUGmBOIce/cAAAAASUVORK5CYII="/>
                            </defs>
                        </svg>
                    </div>
                </div>
                <div class="flex flex-row items-center justify-between border-b border-gray-300 pb-2">
                    <input type="checkbox">
                    <div class="topping_content">
                        <p>Milk foam</p>
                        <p>10.000 VND</p>
                    </div>
                    <div class="qnt flex flex-row">
                        <div class="">-</div>
                        <div class="">1</div>
                        <div class="">+</div>
                    </div>
                    <div class="price">140.000 VND</div>
                    <div class="trash_icon">
                        <svg width="18" height="32" viewBox="0 0 18 32" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <rect width="18" height="32" fill="url(#pattern0_427_53595)"/>
                            <defs>
                                <pattern id="pattern0_427_53595" patternContentUnits="objectBoundingBox" width="1" height="1">
                                    <use xlink:href="#image0_427_53595" transform="matrix(0.0104167 0 0 0.00585938 0 0.21875)"/>
                                </pattern>
                                <image id="image0_427_53595" width="96" height="96" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGAAAABgCAYAAADimHc4AAAACXBIWXMAAAsTAAALEwEAmpwYAAABr0lEQVR4nO2XMU4DQRAEN+EvwCsJkQAL/mJNG97gDD4CDkFaZMkRIb5T7Z2rpEmR3dW9QGsiIiIiIiIDkeQuST/z7unvccnhdyXw4Xcl8OH31UqYMay+hKPzVwAN3cC4AD6E+ATxQQQ6+gXyCaKhGxgXwIeQS36CRERERERE6H+Mcun/eNEBRQF8SHEBfFDxCVrntdGhA4oC+JDiAvig4hM0zZuamd/sqX8eDh1QFKAAFLqhcQEKQKEbGhegABS6oXEBCkChGxoXoAAUuqFxAQpAoRsaF6AAFLqhcQEKQKEbGhegABS6oXEBCkChGxoXoAAUuqFxAQpAoRsaF6AAFLqhcQEKQKEbGhegABS6oXEBCkChGxoXoAAUuqFxAQpAoRsaF6AAFLqhcQEKQKEbGhegABS6oXEB+To3tIx7n210qupjgKD6HFdV7210kmzooDLfPbTRqarbJD8rbP/3bre7bkugql7owDL9bdpS2O/3V1X1NkBofaJ7PX6ntiROEp6P0x0gwP6fO332zeLC//s7oaqejn9BVNVhAaEfTp/1cbvd3tD5iYiIiIhIWx2/CUGmBOIce/cAAAAASUVORK5CYII="/>
                            </defs>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="total flex items-center justify-end">
                <div class="">Total:</div>
                <div class="">120.000 VND</div>
            </div>
            <div class="filter_btn flex items-center justify-center lg:justify-end mt-15">
                <button @click="close" class="hidden md:block bg-gray-300 text-gray-700 px-4 py-2 rounded">Cancel</button>
                <button @click="close" class="active_btn mt-4 bg-gray-300 text-gray-700 px-4 py-2 rounded">Pay</button>

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

    .for_group_order {
        display: flex;
        width: 150px;
        height: 34px;
        padding: 10px 78px;
        justify-content: center;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
        border-radius: 20px;
        background: #FFF;
        box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
    }
}

</style>
