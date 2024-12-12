<script setup>
import FilterPopup from '../popup/FilterPopup.vue';
import DetailProduct from "@/js/components/page/DetailProduct.vue";
import {FwbButton} from "flowbite-vue";
import {useStore} from 'vuex';
import {ref, onMounted, watch} from "vue";
import Marketing from "@/js/components/Marketing.vue";
import {formatVietnameseCurrency} from '@/js/helpers/currencyFormat.js';

const store = useStore();
const currentPopup = ref(null);
const selectedCategory = ref(null);
const listProduct = ref([]);
const listCategory = ref([]);
const searchText = ref('');
const searchTextInput = ref('');
const isOpen = ref(false);
const selectedProduct = ref(null);
const filtersOption = ref([]);
const loading = ref(false);
const loadingCategory = ref(false);
const hasMore = ref(true); // To track if more products are available
const productsVuex = store.state.products;
// Fetch products based on filter criteria and pagination
const fetchData = async (isReload = false) => {
    if (loading.value || !hasMore.value) return;  // Prevent duplicate requests
    loading.value = isReload;
    try {

        await store.dispatch('products/fetchProductsCustomer', {
            searchText: searchText.value,
            category: selectedCategory.value,
            minPrice: filtersOption.value.minPrice,
            maxPrice: filtersOption.value.maxPrice,
            fromDate: filtersOption.value.fromDate,
            toDate: filtersOption.value.toDate,
        });
        const newProducts = productsVuex.products;
        hasMore.value = productsVuex.canLoad;
        if (listProduct.value.length === 0 || isReload) {
            listProduct.value = newProducts;
        } else {
            listProduct.value.forEach((category) => {
                let newProduct = newProducts.find((p) => p.category_id === category.category_id);
                if (newProduct) {
                    category.product_list = category.product_list.concat(newProduct.product_list);
                }
            });
            newProducts.forEach((category) => {
                if (!listProduct.value.some((p) => p.category_id === category.category_id)) {
                    listProduct.value.push(category);
                }
            });
        }
    } catch (error) {
        console.error("Failed to fetch products:", error);
    } finally {
        if (isReload) {
            scrollToDiv();
        }
        loading.value = false;
        loadingCategory.value = false;
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
const openPopup = (popupName, productId = null) => {
    if (popupName === 'details' && productId) {
        // Fetch product details based on the product ID
        store.dispatch('products/fetchCustomerProduct', productId).then(() => {
            // Set the selected product to the fetched product
            selectedProduct.value = store.getters["products/singleProduct"];
            // Open the popup
            currentPopup.value = popupName;
        });
    } else {
        // Open the popup without fetching product details
        currentPopup.value = popupName;
    }
};

// Close popup
const closePopup = () => {
    currentPopup.value = null;
};

// Filter products by category
const filterByCategory = (categoryId) => {
    selectedCategory.value = categoryId;
    store.commit('products/SET_LAST_PRODUCT_ID', null);
    hasMore.value = true;
    fetchData(true); // Re-fetch products with the selected category filter
};

const scrollToDiv = () => {
    window.scrollTo({
        top: 400, // Specify the vertical scroll position in pixels
        behavior: 'smooth' // Smooth scrolling animation
    });
}
// Update search text and trigger fetch
const changeSearchText = () => {
    searchText.value = searchTextInput.value;
    store.commit('products/SET_LAST_PRODUCT_ID', null);
    hasMore.value = true;
    fetchData(true); // Re-fetch products with the updated search text
};

// Load more products when scrolled to the bottom
let isFetching = false; // Flag to prevent duplicate fetch requests
const handleScroll = () => {
    const scrollHeight = document.documentElement.scrollHeight;
    const scrollTop = window.scrollY;
    const clientHeight = window.innerHeight;

    const scrolledToThreshold = (scrollTop + clientHeight) >= (scrollHeight * 0.8);

    if (scrolledToThreshold && !isFetching) {
        isFetching = true; // Set the flag to true before starting fetch
        fetchData().finally(() => {
            isFetching = false; // Reset the flag after fetch completes
        });
    }
};

const handleFilterUpdate = (filters) => {

    store.commit('products/SET_LAST_PRODUCT_ID', null);
    filtersOption.value = filters;
    hasMore.value = true;
    fetchData(true); // Pass the filters to fetchData
};

onMounted(() => {
    loadingCategory.value = true;
    fetchData(true);
    fetchCategory();
    window.addEventListener("scroll", handleScroll);

    //Set lastProductId to null
    store.commit('products/SET_LAST_PRODUCT_ID', null);
});

watch([searchText, selectedCategory], () => {
    listProduct.value = []; // Clear previous products when search or category changes
    fetchData(); // Re-fetch products on filter changes
});

</script>

<template>
    <DetailProduct :isVisible="currentPopup === 'details'" :selectedProduct="selectedProduct" @closePopup="closePopup" id="detail-producy"/>
    <Marketing></Marketing>

    <!-- Search and Filter Section -->
    <div id="divToScroll" class="search flex flex-row items-center justify-center mt-4 mb-0 lg:mt-9 lg:mb-5 lg:ml-[120px]">
        <div class="search_btn flex flex-row lg:w[1000px]">
            <input type="text" v-model="searchTextInput" @keydown.enter="changeSearchText" placeholder="Search"
                   class="search_input h-full ml-4.5 w-[200px] lg:w-[440px] focus:outline-none">
            <img src="https://cdn-icons-png.flaticon.com/512/54/54481.png" alt="Search Icon"
                 class="search-icon w-3 h-3 lg:w-5 lg:h-5 mr-3">
        </div>
        <fwb-button pill @click="openPopup('filter')"
                    class="ml-1 bg-gray-100 border-light-gray text-gray-900 border border-gray-300 focus:outline-none hover:bg-gray-200 focus:ring-4 focus:ring-gray-100 font-medium rounded-full text-sm px-5 py-2.5 me-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 inline-flex items-center">
            <template #prefix>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.25"
                     stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75"/>
                </svg>
            </template>
            <span>{{ $lang('LBL_FILTER') }}</span>
        </fwb-button>
        <!-- Sử dụng component pop-up -->
        <FilterPopup :isVisible="currentPopup === 'filter'" @applyFilters="handleFilterUpdate" @closePopup="closePopup"/>
        <fwb-button pill @click="isOpen = !isOpen"
                    class="bg-gray-100 border-light-gray relative text-gray-900 border border-gray-300 focus:outline-none hover:bg-gray-200 focus:ring-4 focus:ring-gray-100 font-medium rounded-full text-sm px-5 py-2.5 h-full dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 inline-flex items-center">
            <template #prefix>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.25"
                     class="size-6" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z"/>
                </svg>
            </template>
            <span>{{ $lang('LBL_SORT') }}</span>
            <div v-if="isOpen"
                 class="up absolute right-0 top-[120%] z-50 bg-white shadow-lg p-4 rounded-md w-[150px] flex flex-col space-y-2">
                <div class="active flex flex-row items-center justify-between">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="black" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3"/>
                    </svg>
                    <div class="text-black-2 text-right text-sm font-semibold font-['Inter']">Giá: Giảm dần</div>
                </div>
                <div class="inactive flex flex-row items-center justify-between">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="#d0d0d0" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5 12 3m0 0 7.5 7.5M12 3v18"/>
                    </svg>
                    <div class="text-[#d0d0d0] text-right text-sm font-semibold font-['Inter']">Giá: Tang dần</div>
                </div>
            </div>
        </fwb-button>
    </div>

    <!-- Product List -->
    <div class="container min-h-[1000px] max-w-[1200px] mx-auto px-4 lg:px-4 grid grid-cols-12 gap-4 mt-1 lg:mt-5">
        <div class="hidden md:block col-span-3 ml-5 lg:border-r lg:border-gray-400 mr-5">
            <template v-if="loadingCategory">
                <ul>
                    <li v-for="n in 5" :key="n" class="mb-2">
                        <div class="h-5 bg-gray-200 rounded w-3/4 animate-pulse"></div>
                    </li>
                </ul>
            </template>
            <template v-else>
                <ul>
                    <li @click="filterByCategory(null)"
                        class="mb-2 hover:text-[#6B4226] hover:translate-x-[3px] duration-300 cursor-pointer"
                        :class="{ 'font-bold text-title-xsm text-[#6B4226]': selectedCategory === null, 'text-black' : selectedCategory !== null}">
                        All
                    </li>
                    <li v-for="category in listCategory" :key="category.id" @click="filterByCategory(category.id)"
                        class="mb-2 hover:text-[#6B4226] hover:translate-x-[3px] duration-300 cursor-pointer"
                        :class="{ 'font-bold text-title-xsm text-[#6B4226]': selectedCategory === category.id, 'text-black' : selectedCategory !== category.id}">
                        {{ $lang(category.name) }}
                    </li>
                </ul>
            </template>
        </div>

        <div class="col-span-12 lg:col-span-9 grid grid-cols-1 lg:grid-cols-1 gap-0 lg:gap-4">
            <!-- Check if the data is loading -->
            <template v-if="loading">
                <div v-for="n in 3" :key="n" class="mb-6">
                    <div class="h-8 bg-gray-200 rounded w-1/3 ml-4 animate-pulse"></div>
                    <div class="col-span-12 lg:col-span-9 grid grid-cols-2 lg:grid-cols-3 gap-0 lg:gap-4 mt-4">
                        <div v-for="m in 6" :key="m" class="p-4">
                            <div class="w-full bg-gray-200 rounded-lg aspect-square animate-pulse"></div>
                            <div class="product_content flex flex-row justify-between mt-4">
                                <div class="product_label w-full">
                                    <div class="h-4 bg-gray-200 rounded w-3/4 mb-2 animate-pulse"></div>
                                    <div class="h-4 bg-gray-200 rounded w-1/2 animate-pulse"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            <!-- Actual content when not loading -->
            <template v-else>
                <div v-for="category in listProduct" :key="category.category_id">
                    <span class="text-3xl font-bold text-black-2 ml-4">{{ $lang(category.category_name) }}</span>
                    <div class="col-span-12 lg:col-span-9 grid grid-cols-2 lg:grid-cols-3 gap-0 lg:gap-4 mt-4">
                        <div v-for="product in category.product_list" :key="product.product_id"
                             class="p-4 cursor-pointer">
                            <img v-show="product.product_image === null" src="@/assets/images/empty-image.jpg"
                                 alt="Product"
                                 class="w-full shadow-lg rounded-lg aspect-square">
                            <img v-show="product.product_image !== null" :src="product.product_image" alt="Product"
                                 class="w-full shadow-lg rounded-lg aspect-square">
                            <div class="product_content flex flex-row justify-between mt-4">
                                <div class="product_label">
                                    <h3 class="font-bold text-black truncate w-52">{{ product.product_name }}</h3>
                                    <p class="text-gray-600 text-xs lg:text-sm">
                                        {{ formatVietnameseCurrency(product.product_price) }}</p>
                                </div>
                                <div class="flex justify-center items-center mb-3 lg:mb-0">
                                    <button @click="openPopup('details', product.product_id)"
                                            class="add_btn flex justify-center items-center p-1 bg-[#6B4226] hover:bg-[#754c30]">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                             stroke-width="1.5" stroke="white" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M12 4.5v15m7.5-7.5h-15"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
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

.search_btn {
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
