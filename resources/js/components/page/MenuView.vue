<script setup>
import {useI18n} from 'vue-i18n';
import ButtonDefault from "@/js/components/admin/Buttons/ButtonDefault.vue";

const {t} = useI18n();
import {reactive, ref, computed} from 'vue';
import FilterPopup from '../popup/FilterPopup.vue';
import DetailsProduct from "@/js/components/page/DetailsProduct.vue";
import CartIcon from "@/js/components/admin/CartIcon.vue";
import CartPopup from "@/js/components/popup/CartPopup.vue";
import {FwbButton} from "flowbite-vue";



const currentPopup = ref(null);
const selectedCategory = ref(null);
const searchText = ref('Day la gia tri gan ban dau');
const searchTextInput = ref('')
const isOpen = ref(false)


const listProduct = [
    {
        id: 'sp01',
        name: 'Black coffee',
        price: '20.000',
        category: 'c01',
        img: 'https://thuytinhluminarc.com/wp-content/uploads/2022/08/hinh-tach-ca-phe-2.jpg',
        topping: [
            { name: 'Whipped Cream', price: '5.000' },
            { name: 'Chocolate Sauce', price: '7.000' }
        ]
    },
    {
        id: 'sp02',
        name: 'Capuchino',
        price: '40.000',
        category: 'c02',
        img: 'https://131340465.cdn6.editmysite.com/uploads/1/3/1/3/131340465/s196254156684441514_p1067_i1_w4029.jpeg?width=2560&optimize=medium',
        topping: [
            { name: 'Whipped Cream', price: '5.000' },
            { name: 'Chocolate Sauce', price: '7.000' },
            { name: 'Chocolate Sauce', price: '7.000' }
        ]
    },
    {
        id: 'sp03',
        name: 'Banh mi hoa cuc',
        price: '20.000',
        category: 'c03',
        img: 'https://cdn.tgdd.vn/2021/11/CookDish/banh-mi-hoa-cuc-la-gi-banh-mi-hoa-cuc-mua-o-dau-va-gia-banh-avt-1200x676.jpg',
        topping: [
            { name: 'Whipped Cream', price: '5.000' },
            { name: 'Chocolate Sauce', price: '7.000' },
            { name: 'Chocolate Sauce', price: '7.000' },
            { name: 'Chocolate Sauce', price: '7.000' },
            { name: 'Chocolate Sauce', price: '7.000' }

        ]
    },
    {
        id: 'sp04',
        name: 'Banh mi hoa cuc',
        price: '20.000',
        category: 'c04',
        img: 'https://cdn.tgdd.vn/2021/11/CookDish/banh-mi-hoa-cuc-la-gi-banh-mi-hoa-cuc-mua-o-dau-va-gia-banh-avt-1200x676.jpg',
        topping: [
            { name: 'Whipped Cream', price: '5.000' },
            { name: 'Chocolate Sauce', price: '7.000' },
            { name: 'Chocolate Sauce', price: '7.000' },
            { name: 'Chocolate Sauce', price: '7.000' }
        ]
    }
]

const listCategory = [
    {
        id: 'c01',
        name: 'Banh mi'
    },
    {
        id: 'c02',
        name: 'Tra trai cay nhiet doi'
    },
    {
        id: 'c03',
        name: 'Tra trai cay'
    },
    {
        id: 'c04',
        name: 'Tra dao cam xa'
    },
    {
        id: 'c05',
        name: 'Banh mi nuong kieu phap'
    }
]

// const openPopup = (popupName) => {
//     currentPopup.value = popupName;
// }
const selectedProduct = ref(null); // Biến lưu sản phẩm được chọn

const openPopup = (popupName, product = null) => {
    if (arguments.length === 2 && popupName === 'details' && product) {
        selectedProduct.value = product;
    }
    currentPopup.value = popupName;  // Mở popup theo tên
};

const closePopup = () => {
    currentPopup.value = null;
}
const filteredProducts = computed(() => {
    if (!selectedCategory.value) {
        return listProduct
    }
    return listProduct.filter(product => product.category === selectedCategory.value)
})
const filterByCategory = (categoryId) => {
    selectedCategory.value = categoryId
}
const changeSearchText = () => {
    searchText.value = searchTextInput.value; //Tất cả ca bi lin quan nh searchText, tag, category se duoc luu trong bien filterSearch o component filterPopup
    //tam thoi render lai san pham
    selectedCategory.value = null;
}
</script>

<template>
    <DetailsProduct :isVisible="currentPopup === 'details'" :selectedProduct="selectedProduct"  @closePopup="closePopup" />
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
            <div class="hidden md:block market_content_label text-sm lg:text-2xl lg:ml-5">
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


    <div class="search flex flex-row items-center justify-center mt-4 mb-0 lg:mt-9 lg:mb-5 lg:ml-[120px]">
        <div class="search_btn flex flex-row lg:w[1000px] h-full">
            <input type="text" v-model="searchTextInput" @keydown.enter="changeSearchText" placeholder="Search" class="search_input h-full ml-4.5 w-[200px] lg:w-[440px] focus:outline-none">
            <img src="https://cdn-icons-png.flaticon.com/512/54/54481.png" alt="Search Icon" class="search-icon w-3 h-3 lg:w-5 lg:h-5 mr-3">
        </div>
        <fwb-button pill @click="openPopup('filter')" class="bg-gray-100 border-light-gray text-gray-900 border border-gray-300 focus:outline-none hover:bg-gray-200 focus:ring-4 focus:ring-gray-100 font-medium rounded-full text-sm px-5 py-2.5 me-2  dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 inline-flex items-center">
            <template #prefix>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                </svg>
            </template>
            <span>{{$lang('LBL_FILTER')}}</span>
        </fwb-button>
        <!-- Sử dụng component pop-up -->
        <FilterPopup :isVisible="currentPopup === 'filter'" :searchText="searchText"  @closePopup="closePopup" />
        <fwb-button pill @click="isOpen = !isOpen" class="bg-gray-100 border-light-gray relative text-gray-900 border border-gray-300 focus:outline-none hover:bg-gray-200 focus:ring-4 focus:ring-gray-100 font-medium rounded-full text-sm px-5 py-2.5 h-full dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 inline-flex items-center">
            <template #prefix>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="size-6" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z" />
                </svg>
            </template>
            <span>{{$lang('LBL_SORT')}}</span>
            <div v-if="isOpen" class="up absolute right-0 top-[120%] z-50 bg-white shadow-lg p-4 rounded-md w-[150px] flex flex-col space-y-2">
                <div class="active flex flex-row items-center justify-between">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="black" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3" />
                    </svg>
                    <div class="text-black-2 text-right text-sm font-semibold font-['Inter']">Giá: Giảm dần</div>
                </div>
                <div class="inactive flex flex-row items-center justify-between">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#d0d0d0" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5 12 3m0 0 7.5 7.5M12 3v18" />
                    </svg>
                    <div class="text-[#d0d0d0] text-right text-sm font-semibold font-['Inter']">Giá: Tang dần</div>
                </div>
            </div>
        </fwb-button>

    </div>

    <div class="container max-w-[1200px] mx-auto px-4 lg:px-4 grid grid-cols-12 gap-4 mt-1 lg:mt-5">
        <div class="hidden md:block col-span-3 ml-5 lg:border-r lg:border-gray-400 mr-5">
            <h2 class="font-bold mb-4 text-black text-2xl">{{$lang('LBL_CATEGORY')}}</h2>
            <ul>
                <li
                    @click="filterByCategory(null)"
                    class="mb-2 text-black hover:text-black-2 hover:translate-x-[3px] duration-300 cursor-pointer hover:font-semibold"
                    :class="{ 'font-semibold': selectedCategory === null}"
                >
                    All
                </li>
                <li
                    v-for="category in listCategory"
                    :key="category.id"
                    class="mb-2 text-black hover:text-black-2 hover:translate-x-[3px] duration-300 cursor-pointer hover:font-semibold"
                    @click="filterByCategory(category.id)"
                    :class="{ 'font-semibold': selectedCategory === category.id}"
                >
                    {{ category.name }}
                </li>
            </ul>
        </div>


        <div class="col-span-12 lg:col-span-9 grid grid-cols-2 lg:grid-cols-3 gap-0 lg:gap-4">
            <div v-for="product in filteredProducts" :key="product.id" class="p-4 cursor-pointer">
                <img :src="product.img" alt="Black Coffee" class="w-full rounded shadow-lg rounded-lg aspect-square">
                <div class="product_content flex flex-row justify-between">
                    <div class="product_label">
                        <h3 class="mt-4 font-bold text-black">{{product.name}}</h3>
                        <p class="text-gray-600 text-xs lg:text-sm">{{product.price}} VND</p>
                    </div>
                    <div class="product_btn mb-3 lg:mb-0">
                        <button @click="openPopup('details',product)" class="add_btn flex mt-7 lg:mt-5 justify-center items-center mr-2 w-[24px] h-[24px] lg:w-[30px] lg:h-[30px]">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>

                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pagination flex flex-row justify-center space-x-6 mt-5 mb-5 lg:mt-10 lg:mb-10">
        <div class="previous flex flex-row items-center lg:space-x-2">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12.6668 8.00016H3.3335M3.3335 8.00016L8.00016 12.6668M3.3335 8.00016L8.00016 3.3335" stroke="black" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <label class="disable_page hidden md:block">Previous</label>
        </div>
        <div class="number flex flex-row space-x-6">
            <button class="active_page">1</button>
            <button class="text-black">2</button>
            <button class="text-black">3</button>
            <button class="text-black">...</button>
            <button class="text-black">12</button>
            <button class="text-black">13</button>
            <button class="text-black">14</button>
        </div>
        <div class="next flex flex-row items-center lg:space-x-2">
            <label class="hidden md:block text-black">Next</label>
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3.3335 8.00016H12.6668M12.6668 8.00016L8.00016 3.3335M12.6668 8.00016L8.00016 12.6668" stroke="black" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
    </div>
</template>

<style scoped>
.search_input:focus {
    outline: none !important;
}
body {
    font-family: 'Roboto', sans-serif;
}
    .border-light-gray {
        border: 1px solid rgba(117, 117, 117, 0.28);
    }
    .marketing{
        flex-shrink: 0;
        border-radius: 28px;
        background: linear-gradient(180deg, rgba(153, 125, 108, 0.74) 0%, rgba(49, 31, 21, 0.74) 100%);
        box-shadow: 0px 4px 4px 0px (0, 0, 0, 0.25);
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
    .search_btn{
        display: inline-flex;
        height: 38px;
        justify-content: center;
        align-items: center;
        flex-shrink: 0;
        border-radius: 50px;
        border: 1px solid rgba(117, 117, 117, 0.28);
        background: #f2f5f8;
        margin: 4px;
    }


    .search_input {
        background: #f2f5f8;
        border-style: none;
        outline: none;
        border: none;
    }
    .hoverBtn:hover {
        background-color: rgb(225, 225, 225);
    }
    .add_btn {
        flex-shrink: 0;
        fill: rgba(116, 66, 39, 0.91);
        background: #c48d60;
        border-radius: 30px;
    }
    .active_page {
        min-width: 30px;
        min-height: 30px;
        border: 2px solid;
        border-radius: 10px;
        background-color: #c48d60;
        color: #f2f5f8;
    }
    .disable_page {
        color: rgba(102, 100, 99, 0.5);
    }
    @media (max-width: 700px) {
        .search_btn {
            height: 28px;
        }
    }
</style>
