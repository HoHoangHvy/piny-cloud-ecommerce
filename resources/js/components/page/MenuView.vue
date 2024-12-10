<script setup>
import { useI18n } from 'vue-i18n';
import ButtonDefault from "@/js/components/admin/Buttons/ButtonDefault.vue";
import FilterPopup from '../popup/FilterPopup.vue';
import DetailsProduct from "@/js/components/page/DetailsProduct.vue";
import { FwbButton } from "flowbite-vue";
import { useStore } from 'vuex';
import {ref} from "vue";
import {onMounted} from "vue";

const { t } = useI18n();
const store = useStore();
const currentPopup = ref(null);
const selectedCategory = ref(null);
const listProduct = ref([]);
const listCategory = ref([]);
const searchText = ref('');
const searchTextInput = ref('');
const isOpen = ref(false);
const selectedProduct = ref(null);

// Fetch products based on filter criteria
const fetchData = async () => {
    try {
        await store.dispatch('products/fetchProductsCustomer', {
            searchText: searchText.value,
            category: selectedCategory.value
        });
        debugger
        listProduct.value = store.state.products.products;
    } catch (error) {
        console.error("Failed to fetch products:", error);
    }
};

// Fetch categories for the filter sidebar
const fetchCategory = async () => {
    try {
        await store.dispatch('categories/fetchCategoriesOptions');
        listCategory.value = store.state.categories.categories_option;
    } catch (error) {
        console.error("Failed to fetch categories:", error);
    }
};

// Open product details popup
const openPopup = (popupName, product = null) => {
    if (arguments.length === 2 && popupName === 'details' && product) {
        selectedProduct.value = product;
    }
    currentPopup.value = popupName;
};

// Close popup
const closePopup = () => {
    currentPopup.value = null;
};

// Filter products by category
const filterByCategory = (categoryId) => {
    selectedCategory.value = categoryId;
    fetchData(); // Re-fetch products with the selected category filter
};

// Update search text and trigger fetch
const changeSearchText = () => {
    searchText.value = searchTextInput.value;
    fetchData(); // Re-fetch products with the updated search text
};
const formatVietnameseCurrency = (amount) =>  {
    // Ensure the amount is a number
    if (isNaN(amount)) {
        throw new Error("Invalid number");
    }

    // Format the number with commas and append the currency symbol
    return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
}
onMounted(() => {
    fetchData();
    fetchCategory();
});
</script>


<template>
    <DetailsProduct :isVisible="currentPopup === 'details'" :selectedProduct="selectedProduct" @closePopup="closePopup" />

    <!-- Marketing Section -->
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
    <!-- Search and Filter Section -->
    <div class="search flex flex-row items-center justify-center mt-4 mb-0 lg:mt-9 lg:mb-5 lg:ml-[120px]">
        <div class="search_btn flex flex-row lg:w[1000px]">
            <input type="text" v-model="searchTextInput" @keydown.enter="changeSearchText" placeholder="Search" class="search_input h-full ml-4.5 w-[200px] lg:w-[440px] focus:outline-none">
            <img src="https://cdn-icons-png.flaticon.com/512/54/54481.png" alt="Search Icon" class="search-icon w-3 h-3 lg:w-5 lg:h-5 mr-3">
        </div>
        <fwb-button pill @click="openPopup('filter')" class="ml-1 bg-gray-100 border-light-gray text-gray-900 border border-gray-300 focus:outline-none hover:bg-gray-200 focus:ring-4 focus:ring-gray-100 font-medium rounded-full text-sm px-5 py-2.5 me-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 inline-flex items-center">
            <template #prefix>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.25" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                </svg>
            </template>
            <span>{{$lang('LBL_FILTER')}}</span>
        </fwb-button>

        <!-- Filter Popup -->
        <FilterPopup :isVisible="currentPopup === 'filter'" :searchText="searchText" @closePopup="closePopup" />
    </div>

    <!-- Product List -->
    <div class="container max-w-[1200px] mx-auto px-4 lg:px-4 grid grid-cols-12 gap-4 mt-1 lg:mt-5">
        <div class="hidden md:block col-span-3 ml-5 lg:border-r lg:border-gray-400 mr-5">
            <h2 class="font-bold mb-4 text-black text-2xl">{{$lang('LBL_CATEGORY')}}</h2>
            <ul>
                <li @click="filterByCategory(null)" class="mb-2 text-black hover:text-[#6B4226] hover:translate-x-[3px] duration-300 cursor-pointer" :class="{ 'font-semibold text-[#6B4226]': selectedCategory === null}">
                    All
                </li>
                <li v-for="category in listCategory" :key="category.id" @click="filterByCategory(category.id)" class="mb-2 hover:text-[#6B4226] hover:translate-x-[3px] duration-300 cursor-pointer" :class="{ 'font-bold text-title-xsm text-[#6B4226]': selectedCategory === category.id, 'text-black' : selectedCategory !== category.id}">
                    {{ $lang(category.name) }}
                </li>
            </ul>
        </div>

        <div class="col-span-12 lg:col-span-9 grid grid-cols-2 lg:grid-cols-3 gap-0 lg:gap-4">
            <div v-for="product in listProduct" :key="product.id" class="p-4 cursor-pointer">
                <img v-show="product.image_url === null" src="@/assets/images/empty-image.jpg" alt="Product" class="w-full shadow-lg rounded-lg aspect-square">
                <img v-show="product.image_url !== null" :src="product.image_url" alt="Product" class="w-full shadow-lg rounded-lg aspect-square">
                <div class="product_content flex flex-row justify-between mt-4">
                    <div class="product_label">
                        <h3 class="font-bold text-black truncate w-52">{{product.name}}</h3>
                        <p class="text-gray-600 text-xs lg:text-sm">{{formatVietnameseCurrency(product.price)}}</p>
                    </div>
                    <div class="flex justify-center items-center mb-3 lg:mb-0">
                        <button @click="openPopup('details', product.id)" class="add_btn flex justify-center items-center p-1 bg-[#6B4226] hover:bg-[#754c30]">
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
    .border-light-gray {
        border: 1px solid rgba(117, 117, 117, 0.28);
    }
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
    .search_btn{
        display: inline-flex;
        height: 44px;
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
        border-radius: 30px;
    }
    .active_page {
        min-width: 30px;
        min-height: 30px;
        border: 2px solid;
        border-radius: 10px;
        background-color: #6B4226;
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
