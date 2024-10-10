<script setup>
import {useI18n} from "vue-i18n";

const {t} = useI18n();
</script>

<template>
    <div class="w-[219px] h-[40px] flex-shrink-0 text-black text-center font-inter text-[25px] font-normal leading-none
     md:w-[180px] md:text-[20px] sm:w-[150px] sm:text-[18px]">
        {{t('LBL_WELCOME_BACK')}}
    </div>
    <div class="w-[607px] h-[72px] flex-shrink-0 text-black text-center font-kaisei-decol text-[35px] font-bold leading-none
     lg:w-[500px] lg:text-[30px] md:w-[400px] md:text-[28px] sm:w-[300px] sm:text-[24px]">
        {{t('LBL_PINY_CLOUD_BREAD_AND_TEA')}}}
    </div>


</template>

<style scoped>

</style>
