
<template>

  <div class="min-h-fit">
    <header class="bg-white shadow">

        <link href='https://fonts.googleapis.com/css?family=Kaisei Decol' rel='stylesheet'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">



    </header>
    <main>
        <div class="mx-auto w-full lg:w-full min-h-fit">

            <!-- SLIDER -->
            <div class="slider-container mx-auto about_us w-full h-[300px] lg:h-[50vh] relative">
                <!-- Slider images -->
                <div class="slider w-full h-full relative -z-1">
                    <transition name="fade" mode="out-in">
                        <div v-if="images.length" :key="currentIndex">
                            <img
                                :src="images[currentIndex]"
                                class="object-cover w-full h-full absolute inset-0"
                            />
                        </div>
                    </transition>
                </div>

                <!-- Slider navigation buttons -->
                <div class="slider-btn w-full absolute top-1/2 flex justify-between">
                    <div class="prev ml-[30px]" @click="prevSlide">
                        <i class="text-white fa fa-chevron-circle-left" aria-hidden="true"></i>
                    </div>
                    <div class="next mr-[30px]" @click="nextSlide">
                        <i class="text-white fa fa-chevron-circle-right" aria-hidden="true"></i>
                    </div>
                </div>

                <!-- Dots for indicating active slide -->
                <div class="active-dots flex absolute bottom-[18px] right-[47px] py-[8px] px-[4px]">
                    <div
                        v-for="(image, index) in images"
                        :key="index"
                        @click="goToSlide(index)"
                        :class="{
          'bg-[#1e1e1e]': currentIndex === index,
          'bg-white': currentIndex !== index
        }"
                        class="dot w-4 h-4 rounded-full mr-[12px] cursor-pointer"
                    ></div>
                </div>
            </div>

            <!--   ABOUT US      -->
            <div className="container mx-auto about_us w-full lg:h-[600px] lg:mt-[100px] mt-[50px]">

                <div className="w-full lg:w-[1280px] lg:h-[440px] mx-auto relative">
                    <div className="w-full text-center text-black text-3xl lg:text-5xl font-bold capitalize mx-auto lg:left-[340px] lg:top-[-26px] lg:absolute lg:z-1" style="font-family:'Kaisei Decol';">ABOUT US</div>
                    <div className="w-[90%] h-[524px] lg:w-[80%] lg:h-[360px] rounded-[35px] border-l-2 border-t border-[#a7715b] relative mx-auto lg:mt-[60px] mt-[20px]">
                        <div className=" py-[8px] w-full lg:w-full lg:h-[360px] absolute top-[5px] left-[5px] lg:bg-[#996a4c]/70 rounded-[28px] backdrop-blur-sm lg:flex">
                            <div className="lg:w-[413.54px] lg:h-[413.54px] left-[796px] top-[-230px] absolute opacity-80 bg-[#775141] rounded-full blur-[266px]" />
                            <div className="lg:w-[413.54px] lg:h-[413.54px] left-[1003.46px] top-[-188.51px] absolute opacity-80 bg-[#7d5646] rounded-full blur-[266px]" />
                            <div>
                                <img class="w-[353px] lg:w-[400px] lg:h-[344px] h-[264px] object-cover overflow-hidden rounded-[28px] shadow" src="/resources/assets/images/landingpage/aboutus-img.png" alt="">
                            </div>
                            <div className=" lg:w-[502px] w-[324px] h-[240px] overflow-hidden lg:m-auto mx-[12px] text-black text-sm lg:text-lg font-normal capitalize leading-10" >
                                <div className="my-[12px] w-[312px] lg:w-full h-[210px] lg:h-full overflow-hidden text-center lg:text-white text-black text-sm lg:text-lg font-normal capitalize leading-[30.59px]" style="font-family:'Kaisei Decol'">{{$lang('LBL_ABOUT_US_TEXT')}}</div>
                            </div>
                        </div>
                    </div>



                </div>



            </div>


    <!--   BEST SELLERS   -->
            <div className="best_seller w-full lg:mt-[-140px] my-[50px] lg:mb-[88px]">
                <div className="w-full h-[85.70px] text-center text-black text-3xl lg:text-5xl font-bold lg:mb-[0px] mb-[-40px]" style="font-family:'Kaisei Decol'">OUR BEST-SELLERS</div>
                <div className="container w-full  justify-center items-center flex mx-auto">
                    <div class="col-span-12 lg:col-span-9 grid grid-cols-2 lg:grid-cols-4 gap-0 lg:gap-8 ">
                        <div class="p-4 col-span-2 flex justify-start">
                            <div class="relative">
                                <img src="/resources/assets/images/landingpage/best_seller/cup.svg" class="z-1 absolute lg:right-[-220px] lg:bottom-[-60px] h-[180px] right-[-60px] bottom-[0px] lg:w-full lg:h-[320px]">
                                <img src="/resources/assets/images/landingpage/best_seller/try_our_new.svg" alt="Black Coffee" class="z-2 w-full rounded  rounded-lg lg:w-full lg:h-[320px]  ">
                            </div>

                        </div>
                        <div class="p-4">
                            <img src="/resources/assets/images/landingpage/best_seller/item.svg" alt="Black Coffee" class="w-full rounded shadow-lg rounded-lg lg:w-full lg:h-[256px] object-fill">
                            <div class="product_content flex flex-row justify-between">
                                <div class="product_label">
                                    <h3 class="mt-4 font-bold">Black Coffee</h3>
                                    <p class="text-gray-600">55.000 VND</p>
                                </div>
                                <div class="product_btn">
                                    <button class="add_btn flex mt-7 lg:mt-5 justify-center items-center mr-2 w-[24px] h-[24px] lg:w-[30px] lg:h-[30px] bg-[#734226]/90 rounded-full">
                                        <svg class="w-[20px] h-[20px] lg:w-[25px] lg:h-[25px]" viewBox="0 0 22 21" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <rect x="0.487305" y="0.785645" width="21.2651" height="19.5254" fill="url(#pattern0_196_33256)"/>
                                            <defs>
                                                <pattern id="pattern0_196_33256" patternContentUnits="objectBoundingBox" width="1" height="1">
                                                    <use xlink:href="#image0_196_33256" transform="matrix(0.00956449 0 0 0.0104167 0.0409045 0)"/>
                                                </pattern>
                                                <image id="image0_196_33256" width="96" height="96" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGAAAABgCAYAAADimHc4AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAy0lEQVR4nO3TwW0DQAzEwOu/aaYEP+V4ZyoQROx7AAAAAPCl+uD6vp+XAAJMywIEmJYFCDAtCxBgWhYgwLQsQIBpWYAA07IAAaZlAQJMywIEmJYFCDAtCxBgWhYgwLQsQIBpWYAA01pfwKcHrHsC3BLgmADHBDgmwDEBjglw7P261h9wLQEEmJYFCDAtCxBgWhYgwLQsQIBpWYAA07IAAaZlAQJMywIEmJYFCDAtCxBgWhYgwLQsQIBpWYAA07IAAaZlAQAAAAC8/+kPBIPv8eqkg3IAAAAASUVORK5CYII="/>
                                            </defs>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <img src="/resources/assets/images/landingpage/best_seller/item.svg" alt="Black Coffee" class="w-full rounded shadow-lg rounded-lg lg:w-full lg:h-[256px] object-fill">
                            <div class="product_content flex flex-row justify-between">
                                <div class="product_label">
                                    <h3 class="mt-4 font-bold">Black Coffee</h3>
                                    <p class="text-gray-600">55.000 VND</p>
                                </div>
                                <div class="product_btn">
                                    <button class="add_btn flex mt-7 lg:mt-5 justify-center items-center mr-2 w-[24px] h-[24px] lg:w-[30px] lg:h-[30px] bg-[#734226]/90 rounded-full">
                                        <svg class="w-[20px] h-[20px] lg:w-[25px] lg:h-[25px]" viewBox="0 0 22 21" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <rect x="0.487305" y="0.785645" width="21.2651" height="19.5254" fill="url(#pattern0_196_33256)"/>
                                            <defs>
                                                <pattern id="pattern0_196_33256" patternContentUnits="objectBoundingBox" width="1" height="1">
                                                    <use xlink:href="#image0_196_33256" transform="matrix(0.00956449 0 0 0.0104167 0.0409045 0)"/>
                                                </pattern>
                                                <image id="image0_196_33256" width="96" height="96" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGAAAABgCAYAAADimHc4AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAy0lEQVR4nO3TwW0DQAzEwOu/aaYEP+V4ZyoQROx7AAAAAPCl+uD6vp+XAAJMywIEmJYFCDAtCxBgWhYgwLQsQIBpWYAA07IAAaZlAQJMywIEmJYFCDAtCxBgWhYgwLQsQIBpWYAA01pfwKcHrHsC3BLgmADHBDgmwDEBjglw7P261h9wLQEEmJYFCDAtCxBgWhYgwLQsQIBpWYAA07IAAaZlAQJMywIEmJYFCDAtCxBgWhYgwLQsQIBpWYAA07IAAaZlAQAAAAC8/+kPBIPv8eqkg3IAAAAASUVORK5CYII="/>
                                            </defs>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <img src="/resources/assets/images/landingpage/best_seller/item.svg" alt="Black Coffee" class="w-full rounded shadow-lg rounded-lg lg:w-full lg:h-[256px] object-fill">
                            <div class="product_content flex flex-row justify-between">
                                <div class="product_label">
                                    <h3 class="mt-4 font-bold">Black Coffee</h3>
                                    <p class="text-gray-600">55.000 VND</p>
                                </div>
                                <div class="product_btn">
                                    <button class="add_btn flex mt-7 lg:mt-5 justify-center items-center mr-2 w-[24px] h-[24px] lg:w-[30px] lg:h-[30px] bg-[#734226]/90 rounded-full">
                                        <svg class="w-[20px] h-[20px] lg:w-[25px] lg:h-[25px]" viewBox="0 0 22 21" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <rect x="0.487305" y="0.785645" width="21.2651" height="19.5254" fill="url(#pattern0_196_33256)"/>
                                            <defs>
                                                <pattern id="pattern0_196_33256" patternContentUnits="objectBoundingBox" width="1" height="1">
                                                    <use xlink:href="#image0_196_33256" transform="matrix(0.00956449 0 0 0.0104167 0.0409045 0)"/>
                                                </pattern>
                                                <image id="image0_196_33256" width="96" height="96" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGAAAABgCAYAAADimHc4AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAy0lEQVR4nO3TwW0DQAzEwOu/aaYEP+V4ZyoQROx7AAAAAPCl+uD6vp+XAAJMywIEmJYFCDAtCxBgWhYgwLQsQIBpWYAA07IAAaZlAQJMywIEmJYFCDAtCxBgWhYgwLQsQIBpWYAA01pfwKcHrHsC3BLgmADHBDgmwDEBjglw7P261h9wLQEEmJYFCDAtCxBgWhYgwLQsQIBpWYAA07IAAaZlAQJMywIEmJYFCDAtCxBgWhYgwLQsQIBpWYAA07IAAaZlAQAAAAC8/+kPBIPv8eqkg3IAAAAASUVORK5CYII="/>
                                            </defs>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <img src="/resources/assets/images/landingpage/best_seller/item.svg" alt="Black Coffee" class="w-full rounded shadow-lg rounded-lg lg:w-full lg:h-[256px] object-fill">
                            <div class="product_content flex flex-row justify-between">
                                <div class="product_label">
                                    <h3 class="mt-4 font-bold">Black Coffee</h3>
                                    <p class="text-gray-600">55.000 VND</p>
                                </div>
                                <div class="product_btn">
                                    <button class="add_btn flex mt-7 lg:mt-5 justify-center items-center mr-2 w-[24px] h-[24px] lg:w-[30px] lg:h-[30px] bg-[#734226]/90 rounded-full">
                                        <svg class="w-[20px] h-[20px] lg:w-[25px] lg:h-[25px]" viewBox="0 0 22 21" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <rect x="0.487305" y="0.785645" width="21.2651" height="19.5254" fill="url(#pattern0_196_33256)"/>
                                            <defs>
                                                <pattern id="pattern0_196_33256" patternContentUnits="objectBoundingBox" width="1" height="1">
                                                    <use xlink:href="#image0_196_33256" transform="matrix(0.00956449 0 0 0.0104167 0.0409045 0)"/>
                                                </pattern>
                                                <image id="image0_196_33256" width="96" height="96" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGAAAABgCAYAAADimHc4AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAy0lEQVR4nO3TwW0DQAzEwOu/aaYEP+V4ZyoQROx7AAAAAPCl+uD6vp+XAAJMywIEmJYFCDAtCxBgWhYgwLQsQIBpWYAA07IAAaZlAQJMywIEmJYFCDAtCxBgWhYgwLQsQIBpWYAA01pfwKcHrHsC3BLgmADHBDgmwDEBjglw7P261h9wLQEEmJYFCDAtCxBgWhYgwLQsQIBpWYAA07IAAaZlAQJMywIEmJYFCDAtCxBgWhYgwLQsQIBpWYAA07IAAaZlAQAAAAC8/+kPBIPv8eqkg3IAAAAASUVORK5CYII="/>
                                            </defs>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <img src="/resources/assets/images/landingpage/best_seller/item.svg" alt="Black Coffee" class="w-full rounded shadow-lg rounded-lg lg:w-full lg:h-[256px] object-fill">
                            <div class="product_content flex flex-row justify-between">
                                <div class="product_label">
                                    <h3 class="mt-4 font-bold">Black Coffee</h3>
                                    <p class="text-gray-600">55.000 VND</p>
                                </div>
                                <div class="product_btn">
                                    <button class="add_btn flex mt-7 lg:mt-5 justify-center items-center mr-2 w-[24px] h-[24px] lg:w-[30px] lg:h-[30px] bg-[#734226]/90 rounded-full">
                                        <svg class="w-[20px] h-[20px] lg:w-[25px] lg:h-[25px]" viewBox="0 0 22 21" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <rect x="0.487305" y="0.785645" width="21.2651" height="19.5254" fill="url(#pattern0_196_33256)"/>
                                            <defs>
                                                <pattern id="pattern0_196_33256" patternContentUnits="objectBoundingBox" width="1" height="1">
                                                    <use xlink:href="#image0_196_33256" transform="matrix(0.00956449 0 0 0.0104167 0.0409045 0)"/>
                                                </pattern>
                                                <image id="image0_196_33256" width="96" height="96" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGAAAABgCAYAAADimHc4AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAy0lEQVR4nO3TwW0DQAzEwOu/aaYEP+V4ZyoQROx7AAAAAPCl+uD6vp+XAAJMywIEmJYFCDAtCxBgWhYgwLQsQIBpWYAA07IAAaZlAQJMywIEmJYFCDAtCxBgWhYgwLQsQIBpWYAA01pfwKcHrHsC3BLgmADHBDgmwDEBjglw7P261h9wLQEEmJYFCDAtCxBgWhYgwLQsQIBpWYAA07IAAaZlAQJMywIEmJYFCDAtCxBgWhYgwLQsQIBpWYAA07IAAaZlAQAAAAC8/+kPBIPv8eqkg3IAAAAASUVORK5CYII="/>
                                            </defs>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <img src="/resources/assets/images/landingpage/best_seller/item.svg" alt="Black Coffee" class="w-full rounded shadow-lg rounded-lg lg:w-full lg:h-[256px] object-fill">
                            <div class="product_content flex flex-row justify-between">
                                <div class="product_label">
                                    <h3 class="mt-4 font-bold">Black Coffee</h3>
                                    <p class="text-gray-600">55.000 VND</p>
                                </div>
                                <div class="product_btn">
                                    <button class="add_btn flex mt-7 lg:mt-5 justify-center items-center mr-2 w-[24px] h-[24px] lg:w-[30px] lg:h-[30px] bg-[#734226]/90 rounded-full">
                                        <svg class="w-[20px] h-[20px] lg:w-[25px] lg:h-[25px]" viewBox="0 0 22 21" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <rect x="0.487305" y="0.785645" width="21.2651" height="19.5254" fill="url(#pattern0_196_33256)"/>
                                            <defs>
                                                <pattern id="pattern0_196_33256" patternContentUnits="objectBoundingBox" width="1" height="1">
                                                    <use xlink:href="#image0_196_33256" transform="matrix(0.00956449 0 0 0.0104167 0.0409045 0)"/>
                                                </pattern>
                                                <image id="image0_196_33256" width="96" height="96" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGAAAABgCAYAAADimHc4AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAy0lEQVR4nO3TwW0DQAzEwOu/aaYEP+V4ZyoQROx7AAAAAPCl+uD6vp+XAAJMywIEmJYFCDAtCxBgWhYgwLQsQIBpWYAA07IAAaZlAQJMywIEmJYFCDAtCxBgWhYgwLQsQIBpWYAA01pfwKcHrHsC3BLgmADHBDgmwDEBjglw7P261h9wLQEEmJYFCDAtCxBgWhYgwLQsQIBpWYAA07IAAaZlAQJMywIEmJYFCDAtCxBgWhYgwLQsQIBpWYAA07IAAaZlAQAAAAC8/+kPBIPv8eqkg3IAAAAASUVORK5CYII="/>
                                            </defs>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>




                </div>
            </div>


<!--            BLOG       -->
           <div className="blog flex items-center w-full lg:h-[420px] justify-center bg-[url('/resources/assets/images/landingpage/blog/bg.svg')] bg-cover bg-center">
               <div className="blog-container swiper relative bg-[url('/resources/assets/images/landingpage/blog/bg.svg')] bg-cover bg-center content-center">
                   <div className="slider-wrapper overflow-hidden my-[40px] mx-[10px]  lg:mx-[100px] ">
                       <div className="card-list swiper-wrapper  lg:h-[378px] flex items-center">


                           <div className="card-item swiper-slide !w-[340px] !h-[390px] lg:!w-[524px] lg:!h-[350px] bg-[#997d6c] rounded-[28px] backdrop-blur-sm relative">
                               <div className="ml-[32px] mt-[20px] ">
                                   <div className=" text-white lg:text-2xl text-1xl font-normal capitalize" style="font-family:'Kaisei Decol'">how to make a great coffee   </div>
                               </div>
                               <div className="ml-[32px] w-[85%] mt-[20px]">
                                   <div className="text-[#f6e4d9] text-sm lg:text-lg font-normal capitalize leading-loose" style="font-family:'Kaisei Decol'">Making a cup of coffee doesn't have to be complicated. Start by gathering your supplies: coffee grounds, water, and a French press, mug or other vessel. Next, measure out 2 tablespoons of ground coffee per 8 ounces of...</div>
                               </div>
                               <div className="my-[20px] lg:my-[40px] w-[253px] h-[79px] ml-[32px] ">
                                   <img className="w-full h-full " src="/resources/assets/images/landingpage/blog/three_cup.svg" alt="">
                               </div>
                           </div>

                           <div className="card-item swiper-slide !w-[340px] !h-[390px]  lg:!w-[524px] lg:!h-[350px] bg-[#997d6c] rounded-[28px] backdrop-blur-sm relative">
                               <div className="ml-[32px] mt-[20px] ">
                                   <div className=" text-white lg:text-2xl text-1xl font-normal capitalize" style="font-family:'Kaisei Decol'">Why does caffeine make us stay awake?</div>
                               </div>
                               <div className="ml-[32px] w-[85%] mt-[20px]">
                                   <div className="text-[#f6e4d9] text-sm lg:text-lg font-normal capitalize leading-loose" style="font-family:'Kaisei Decol'">Caffeine works by blocking adenosine receptors in the brain, which facilitates energy production and makes us feel more alert. Caffeine also increases adrenaline levels, further boosting your energy and heart rate, as well as other</div>
                               </div>
                               <div className="my-[20px] lg:my-[40px] w-[253px] h-[79px] ml-[32px] ">
                                   <img className="w-full h-full " src="/resources/assets/images/landingpage/blog/percen.svg" alt="">
                               </div>
                           </div>

                           <div className="card-item swiper-slide !w-[340px] !h-[390px]  lg:!w-[524px] lg:!h-[350px] bg-[#997d6c] rounded-[28px] backdrop-blur-sm relative">
                               <div className="ml-[32px] mt-[20px] ">
                                   <div className=" text-white lg:text-2xl text-1xl font-normal capitalize" style="font-family:'Kaisei Decol'">Different types of coffee Explained</div>
                               </div>
                               <div className="ml-[32px] w-[85%] mt-[20px]">
                                   <div className="text-[#f6e4d9] text-sm lg:text-lg font-normal capitalize leading-loose" style="font-family:'Kaisei Decol'">Coffee is a staple in the lives of many and comes in a variety of forms. Whether you prefer hot or iced, espresso-based or filter, you’re spoilt for choice. To help beginners navigate their first foray into the world of coffee,...</div>
                               </div>
                               <div className="my-[20px] lg:my-[40px] w-[253px] h-[79px] ml-[32px] ">
                                   <img className="w-full h-full " src="/resources/assets/images/landingpage/blog/cf_bean.svg" alt="">
                               </div>
                           </div>

                           <div className="card-item swiper-slide !w-[340px] !h-[390px] lg:!w-[524px] lg:!h-[350px] bg-[#997d6c] rounded-[28px] backdrop-blur-sm relative">
                               <div className="ml-[32px] mt-[20px] ">
                                   <div className=" text-white lg:text-2xl text-1xl font-normal capitalize" style="font-family:'Kaisei Decol'">how to make a great coffee   </div>
                               </div>
                               <div className="ml-[32px] w-[85%] mt-[20px]">
                                   <div className="text-[#f6e4d9] text-sm lg:text-lg font-normal capitalize leading-loose" style="font-family:'Kaisei Decol'">Making a cup of coffee doesn't have to be complicated. Start by gathering your supplies: coffee grounds, water, and a French press, mug or other vessel. Next, measure out 2 tablespoons of ground coffee per 8 ounces of...</div>
                               </div>
                               <div className="my-[20px] lg:my-[40px] w-[253px] h-[79px] ml-[32px] ">
                                   <img className="w-full h-full " src="/resources/assets/images/landingpage/blog/three_cup.svg" alt="">
                               </div>
                           </div>

                           <div className="card-item swiper-slide !w-[340px] !h-[390px]  lg:!w-[524px] lg:!h-[350px] bg-[#997d6c] rounded-[28px] backdrop-blur-sm relative">
                               <div className="ml-[32px] mt-[20px] ">
                                   <div className=" text-white lg:text-2xl text-1xl font-normal capitalize" style="font-family:'Kaisei Decol'">Why does caffeine make us stay awake?</div>
                               </div>
                               <div className="ml-[32px] w-[85%] mt-[20px]">
                                   <div className="text-[#f6e4d9] text-sm lg:text-lg font-normal capitalize leading-loose" style="font-family:'Kaisei Decol'">Caffeine works by blocking adenosine receptors in the brain, which facilitates energy production and makes us feel more alert. Caffeine also increases adrenaline levels, further boosting your energy and heart rate, as well as other</div>
                               </div>
                               <div className="my-[20px] lg:my-[40px] w-[253px] h-[79px] ml-[32px] ">
                                   <img className="w-full h-full " src="/resources/assets/images/landingpage/blog/percen.svg" alt="">
                               </div>
                           </div>

                           <div className="card-item swiper-slide !w-[340px] !h-[390px]  lg:!w-[524px] lg:!h-[350px] bg-[#997d6c] rounded-[28px] backdrop-blur-sm relative">
                               <div className="ml-[32px] mt-[20px] ">
                                   <div className=" text-white lg:text-2xl text-1xl font-normal capitalize" style="font-family:'Kaisei Decol'">Different types of coffee Explained</div>
                               </div>
                               <div className="ml-[32px] w-[85%] mt-[20px]">
                                   <div className="text-[#f6e4d9] text-sm lg:text-lg font-normal capitalize leading-loose" style="font-family:'Kaisei Decol'">Coffee is a staple in the lives of many and comes in a variety of forms. Whether you prefer hot or iced, espresso-based or filter, you’re spoilt for choice. To help beginners navigate their first foray into the world of coffee,...</div>
                               </div>
                               <div className="my-[20px] lg:my-[40px] w-[253px] h-[79px] ml-[32px] ">
                                   <img className="w-full h-full " src="/resources/assets/images/landingpage/blog/cf_bean.svg" alt="">
                               </div>
                           </div>







                       </div>

                       <div class="swiper-pagination"></div>
                       <div class="swiper-button-prev"></div>
                       <div class="swiper-button-next"></div>
                   </div>
               </div>
           </div>



<!--        Visit Us -->
        <div className="container mx-auto about_us w-full lg:py-[80px] flex justify-center pb-[60px]">
            <div className="col-span-4 lg:col-span-12 grid grid-cols-1 lg:grid-cols-2 gap-0 lg:gap-4 mx-[5px]">
                <img className="my-[20px] rounded-[28px] lg:shadow" src="/resources/assets/images/landingpage/visit_us.svg" />
                <div className="w-[90%] lg:w-[461px] text-[#37271d] text-1xl lg:text-2xl font-bold m-auto" style="font-family: 'Kaisei Decol'">
                    <span>Visit us at: <br/></span>
                    <span className=" text-[#37271d] text-1xl lg:text-2xl font-normal " >Piny Cloud Bread and Coffee   123 Pine Hill Road, Da Lat City, Vietnam   <br>Phone: +84 123 456 789   <br>Email: contact@pinycloudcfe.com</span>
                </div>
            </div>
        </div>


        </div>
    </main>

     <footer></footer>
  </div>



</template>
<script>
import { ref, onMounted } from "vue";
import { useI18n } from "vue-i18n";
import Swiper from "swiper/bundle";
import "swiper/css/bundle";

import slider1 from "@/assets/images/landingpage/slider/banner.svg";
import slider2 from "@/assets/images/landingpage/slider/banner2.svg";
import slider3 from "@/assets/images/landingpage/slider/banner3.svg";

export default {
    setup() {
        const { t } = useI18n(); // If translation is needed
        const currentIndex = ref(0); // Active slide index
        const images = ref([slider1, slider2, slider3]);

        // Move to the previous slide
        const prevSlide = () => {
            if (currentIndex.value === 0) {
                currentIndex.value = images.value.length - 1;
            } else {
                currentIndex.value--;
            }
        };

        // Move to the next slide
        const nextSlide = () => {
            if (currentIndex.value === images.value.length - 1) {
                currentIndex.value = 0;
            } else {
                currentIndex.value++;
            }
        };

        // Go to a specific slide
        const goToSlide = (index) => {
            currentIndex.value = index;
        };

        onMounted(() => {
            // Optional: auto slide every 6 seconds
            setInterval(nextSlide, 6000);

            new Swiper(".slider-wrapper", {
                loop: true,
                grabCursor: true,
                spaceBetween: 30,

                // If we need pagination
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                    dynamicBullets: true,
                },

                // Navigation arrows
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },

                breakpoints: {
                    0: {
                        slidesPerView: 1,
                    },
                    620: {
                        slidesPerView: 2,
                    },
                    1024: {
                        slidesPerView: 3,
                    },
                },
            });
        });

        return {
            t, // Exporting for translations if needed
            currentIndex,
            images,
            prevSlide,
            nextSlide,
            goToSlide,
        };
    },
};
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active in <2.1.8 */ {
    opacity: 0;
}




</style>




<script setup>

</script>
