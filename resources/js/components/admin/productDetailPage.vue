<script setup>

</script>

<template>
    <div class="min-h-[94vh] bg-white shadow ">
        <header className=" shadow">
            <link href='https://fonts.googleapis.com/css?family=Kaisei Decol' rel='stylesheet'>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
        </header>
        <main >
            <div className="w-full min-h-[90vh] relative flex">
                <div className="back flex w-[150px] p-[5px] absolute top-[2%] lg:top-[4%] left-[20px]" style="font-family:'Kaisei Decol'">
                    <div className="back-icon">
                        <img src="/resources/assets/images/productdetailpage/back-arrow.svg" alt="">
                    </div>
                    <div className="flex m-auto back-text text-center text-[#3f3f3f] text-sm font-bold  leading-[15px] tracking-tight">BACK TO LIST</div>
                </div>

                <div className="container w-[90%] lg:w-[80%] h-full flex m-auto justify-center items-center">
                       <div class="product-container w-full  col-span-1 lg:col-span-2 grid grid-cols-1 lg:grid-cols-2 gap-0 lg:gap-8 flex">
                           <div class="product-img flex lg:items-center justify-center lg:mt-[0px] mt-[60px]">
                               <img className=" w-[90%] lg:w-[80%] bg-[#fff8e8] rounded-[23px] flex m-auto" src="/resources/assets/images/productdetailpage/salt-coffee.svg" alt="">
                           </div>
                           <div class="product-content-container flex justify-center">
                              <div class="product-content w-[80%] h-[80%] flex mt-[16px] lg:mt-[40px] flex-col ">
                                  <div class="flex lg:flex-col">
                                      <h1 class="product-name w-fit text-black text-1xl lg:text-[40px] font-medium flex lg:mx-0 border-r-[1px] lg:border-none lg:px-0 px-[20px] " style="font-family:'Kaisei Decol'; border-color: #bfbfbf;">SALT COFFEE</h1>
                                      <div class="product-category text-[#513120] text-[12px] lg:text-xl font-medium leading-[15px] tracking-[3.30px] mt-[8px] lg:mt-[28px] flex lg:mx-0 mx-auto">COFFEE</div>
                                  </div>
                                  <div class="product-des mt-[20px]">
                                      <div class="product-des_title text-black text-[15px] font-semibold leading-[15px] tracking-tight hidden lg:block">Description</div>
                                      <div class="product-des_content mt-[12px] ml-[24px] text-black text-[13px] font-light leading-[23.14px] tracking-tight hidden lg:block">Makanan yang lengkap dan seimbang, dengan 41 nutrisi penting.
                                          <br>Mengandung antioksidan (vitamin E dan selenium) untuk sistem kekebalan tubuh yang sehat.</div>
                                  </div>
                                  <div class="product-size flex items-center mt-[8px] lg:justify-start justify-between">
                                      <div class="product-size_title text-black text-[15px] font-semibold tracking-tight  mr-[32px]">Size</div>
                                      <div class="product-size_option flex items-center ">
                                          <div class="btn--active text-sm font-bold w-9 h-7 p-2 bg-[#744227] rounded-[14px] justify-center items-center gap-2.5 inline-flex mr-2">S</div>
                                          <div class="btn--inactive text-sm font-bold w-9 h-7 p-2 bg-[#744227] rounded-[14px] justify-center items-center gap-2.5 inline-flex mr-2">M</div>
                                          <div class="btn--inactive text-sm font-bold w-9 h-7 p-2 bg-[#744227] rounded-[14px] justify-center items-center gap-2.5 inline-flex mr-2">L</div>
                                      </div>
                                  </div>
                                  <div class="product-topping">
                                      <div class="product-topping_title text-black text-[15px] font-semibold leading-[15px] tracking-tight mt-[12px]">Topping</div>
                                      <div class="product-topping_option flex lg:mt-[8px] flex-wrap">
                                          <div class=" btn--active min-w-[100px] h-7 p-2.5 rounded-[14px] justify-center items-center gap-2.5 inline-flex mr-2 mt-2">Bubble</div>
                                          <div class=" btn--inactive min-w-[100px] h-6 p-2.5 rounded-[14px]  justify-center items-center gap-2.5 inline-flex mr-2 mt-2">Cream Cheese</div>
                                          <div class=" btn--inactive min-w-[100px] h-6 p-2.5 rounded-[14px]  justify-center items-center gap-2.5 inline-flex mr-2 mt-2">Flan</div>
                                      </div>
                                  </div>
                                  <div class="product-bottom-container flex items-center lg:ml-0  lg:mt-[8px] mt-[8px] lg:justify-start justify-center">
                                      <div class="quantity text-black text-[15px] font-semibold leading-[15px] tracking-tight mt-[12px] col-span-1 lg:col-span-2 grid grid-cols-1 lg:grid-cols-2 gap-0 lg:gap-0 flex">
                                          <div class=" flex items-center lg:justify-start justify-center">
                                              <div class="quantity-title mr-[8px] leading-[15px] mr-[16px]">Qty:</div>
                                              <div class="quantity-minor w-6 h-6 leading-[15px]  mr-[16px]"><img class="w-6 h-6" src="/resources/assets/images/productdetailpage/minor.svg" alt=""></div>
                                              <div class="quantity-count leading-[15px] h-10 px-[15px] py-2.5 bg-white rounded-[10px] border-2 border-neutral-300 flex-col justify-start items-start gap-2.5 inline-flex mr-[16px]">1</div>
                                              <div class="quantity-plus w-6 h-6 leading-[15px] mr-[16px]"><img src="/resources/assets/images/productdetailpage/plus.svg" alt=""></div>
                                          </div>
                                          <div class="price-tag flex items-center justify-center w-[202px] h-12 p-2.5 rounded-[10px] gap-2.5 inline-flex text-lg font-bold">Price: 55.000</div>
                                      </div>
                                  </div>
                                  <div class="add-cart-btn bg-[#744227] text-white flex items-center justify-center w-[202px] h-12 p-2.5 rounded-[10px] gap-2.5 inline-flex text-sm font-bold mt-[24px] flex lg:mx-0 mx-auto">ADD TO CART</div>
                              </div>
                           </div>

                       </div>
                   </div>

            </div>
        </main>
        <footer>

        </footer>
    </div>
</template>

<style scoped>
    .btn--active {
        color: white;
        border: 2px solid rgba(241, 229, 229, 0.22);
        background-color: #744227;
    }
    .btn--inactive {
        background-color: #F6F6F6;
    }
</style>
