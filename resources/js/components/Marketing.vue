<script setup>

</script>

<template>
    <div class="marketing flex flex-row justify-between items-center w-[90%] h-[200px] lg:w-[1100px] lg:h-[350px] m-auto mt-4 lg:mt-10 ">
        <div class="market_content flex flex-col justify-between h-full pt-5 pl-5 pb-5 lg:pt-10 lg:pl-20 lg:pb-10">
            <button class="market_content_btn w-[130px] h-auto lg:w-[200px] lg:h-[50px] lg:ml-5 ">
                <label class="btn_text text-sm lg:text-xl">{{$lang('LBL_LIMIT')}}</label>
            </button>
            <label class="market_content_label text-sm lg:text-2xl lg:ml-5">{{$lang('LBL_GET_DISCOUNT')}}</label>
            <div class="market_content_percent flex flex-row justify-start items-center lg:ml-20 ml-5">
                <label class="percent_label text-4xl lg:text-8xl">40%</label>
                <button class="percent_claim w-[60px] h-[20px] lg:w-[100px] lg:h-[50px] ml-5 lg:ml-10 ">
                    <label class="btn_text text-sm lg:text-xl">{{$lang('LBL_GET_CLAIM')}}</label>
                </button>
            </div>
            <div class="hidden md:block market_content_label text-sm lg:text-xl lg:ml-5">
                {{$lang('LBL_DURATION_1')}} {{$lang('LBL_DURATION_2')}}
            </div>
            <div class="block lg:hidden market_content_label text-sm lg:text-2xl lg:ml-5">
                {{$lang('LBL_DURATION_1')}}
            </div>
            <div class="block lg:hidden market_content_label text-sm lg:text-2xl lg:ml-5">
                {{$lang('LBL_DURATION_3')}}
            </div>
        </div>
        <div class="market_img">
            <img class="w-[160px] h-[140px] lg:w-[400px] lg:h-[350px]" src="@/assets/images/downloaded_images/counpon_img.png" alt="123"/>
        </div>
    </div>
</template>

<style scoped>
.marketing{
    flex-shrink: 0;
    border-radius: 28px;
    background: linear-gradient(180deg, rgba(153, 125, 108, 0.74) 0%, rgba(49, 31, 21, 0.74) 100%);
    box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
}
.market_content_btn {
    display: flex;
    min-width: 64px;
    justify-content: center;
    align-items: center;
    flex-shrink: 0;
    border-radius: 40px;
    background: #FFF8E8;

    box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25)
}
.btn_text {
    flex: 1 0 0;
    color: black;
    text-align: center;
    font-feature-settings: 'liga' off, 'clig' off;
    font-family: "Kaisei Decol";
    font-style: normal;
    font-weight: 500;
    line-height: 24px; /* 100% */
    letter-spacing: 0.24px;
    text-transform: uppercase;
}
.market_content_label {
    color: #FFF;
    text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
    font-family: "Kaisei Decol";
    font-style: normal;
    font-weight: 700;
    line-height: normal;
}
.percent_label {
    color: #FFF;
    text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
    font-family: "Kaisei Decol";
    font-style: normal;
    font-weight: 700;
    line-height: normal;
}
.percent_claim {
    display: flex;
    min-width: 64px;
    justify-content: center;
    align-items: center;
    flex-shrink: 0;
    border-radius: 40px;
    background: #FFF8E8;
    box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
}
</style>
