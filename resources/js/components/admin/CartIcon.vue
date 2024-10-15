<template>
    <div class="icon_cart cursor-pointer">
        <svg class="w-[70px] h-[70px] lg:w-[100px] lg:h-[100px]" viewBox="0 0 108 108" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g filter="url(#filter0_d_194_33054)">
                <path d="M104 50C104 77.6142 81.6142 100 54 100C26.3858 100 4 77.6142 4 50C4 22.3858 26.3858 0 54 0C81.6142 0 104 22.3858 104 50Z" fill="#513219"/>
                <path d="M104 50C104 77.6142 81.6142 100 54 100C26.3858 100 4 77.6142 4 50C4 22.3858 26.3858 0 54 0C81.6142 0 104 22.3858 104 50Z" fill="#513219"/>
                <path d="M28 34H36.2909L41.8458 57.2052C42.0354 58.003 42.5545 58.7197 43.3124 59.2298C44.0702 59.7399 45.0185 60.0109 45.9913 59.9953H66.1382C67.1109 60.0109 68.0592 59.7399 68.8171 59.2298C69.575 58.7197 70.0941 58.003 70.2836 57.2052L73.6 42.6651H38.3636M46.6545 68.6604C46.6545 69.6175 45.7266 70.3934 44.5818 70.3934C43.4371 70.3934 42.5091 69.6175 42.5091 68.6604C42.5091 67.7033 43.4371 66.9274 44.5818 66.9274C45.7266 66.9274 46.6545 67.7033 46.6545 68.6604ZM69.4545 68.6604C69.4545 69.6175 68.5266 70.3934 67.3818 70.3934C66.2371 70.3934 65.3091 69.6175 65.3091 68.6604C65.3091 67.7033 66.2371 66.9274 67.3818 66.9274C68.5266 66.9274 69.4545 67.7033 69.4545 68.6604Z" stroke="white" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
            </g>
            <defs>
                <filter id="filter0_d_194_33054" x="0" y="0" width="108" height="108" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dy="4"/>
                    <feGaussianBlur stdDeviation="2"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_194_33054"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_194_33054" result="shape"/>
                </filter>
            </defs>
        </svg>

    </div>

</template>
<script setup>


</script>
<style scoped>
.icon_cart {
    position: fixed;
    bottom: 30px; /* Khoảng cách từ cạnh dưới */
    right: 30px; /* Khoảng cách từ cạnh phải */
    z-index: 2; /* Đảm bảo nằm trên các thành phần khác */
}

</style>
