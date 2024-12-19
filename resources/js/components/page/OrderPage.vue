<template>
    <div class="m-auto flex items-center justify-center flex-col w-[80%] h-full mt-10">
        <div class="flex p-6 gap-4 w-full h-full justify-center ">
            <div>
                <span class="text-gray-500 text-3xl font-bold ">Order history</span>
                <div class="flex flex-col mb-4 border-b border-gray-200 dark:border-gray-700 mt-6">
                    <ul class="flex flex-wrap flex-col gap-3 -mb-px text-sm font-semibold text-center" id="default-styled-tab" data-tabs-toggle="#default-styled-tab-content" data-tabs-active-classes="text-white bg-[#ABBA7C] dark:text-purple-500 font-semibold dark:hover:text-purple-500 border-purple-600 dark:border-purple-500" data-tabs-inactive-classes="dark:border-transparent bg-white text-gray-500 hover:text-gray-900 dark:text-gray-400 border-gray-100 hover:border-gray-300 dark:border-gray-700 dark:hover:text-gray-300" role="tablist">
                        <li class="me-2 flex justify-end" role="presentation">
                            <button class="shadow-lg inline-flex items-center px-4 py-3 rounded-lg active w-[180px]" id="wait-confirmation-tab" data-tabs-target="#wait-confirmation-content" type="button" role="tab" aria-controls="wait-confirmation-content" aria-selected="false">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4 mr-1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                </svg>
                                Confirmating
                            </button>
                        </li>
                        <li class="me-2 flex justify-end" role="presentation">
                            <button class="shadow-lg inline-flex items-center px-4 py-3 rounded-lg active w-[180px] hover:text-gray-900 hover:border-gray-300 dark:hover:text-gray-300" id="in-progress-tab" data-tabs-target="#in-progress-content" type="button" role="tab" aria-controls="in-progress-content" aria-selected="false">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5 mr-1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                In progress
                            </button>
                        </li>
                        <li class="me-2 flex justify-end" role="presentation">
                            <button class="shadow-lg inline-flex items-center px-4 py-3 rounded-lg active w-[180px] hover:text-gray-900 hover:border-gray-300 dark:hover:text-gray-300" id="delivering-tab" data-tabs-target="#delivering-content" type="button" role="tab" aria-controls="delivering-content" aria-selected="false">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4 mr-1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                                </svg>
                                Delivering
                            </button>
                        </li>
                        <li class="me-2 flex justify-end" role="presentation">
                            <button class="shadow-lg inline-flex items-center px-4 py-3 rounded-lg active w-[180px] hover:text-gray-900 hover:border-gray-300 dark:hover:text-gray-300" id="delivered-tab" data-tabs-target="#delivered-content" type="button" role="tab" aria-controls="delivered-content" aria-selected="false">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4 mr-1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0-3-3m3 3 3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                                </svg>
                                Delivered
                            </button>
                        </li>
                        <li class="me-2 flex justify-end" role="presentation">
                            <button class="shadow-lg inline-flex items-center px-4 py-3 rounded-lg active w-[180px] hover:text-gray-900 hover:border-gray-300 dark:hover:text-gray-300" id="completed-tab" data-tabs-target="#completed-content" type="button" role="tab" aria-controls="completed-content" aria-selected="false">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4 mr-1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                Completed
                            </button>
                        </li>
                        <li class="me-2 flex justify-end" role="presentation">
                            <button class="shadow-lg inline-flex items-center px-4 py-3 rounded-lg active w-[180px] hover:text-gray-900 hover:border-gray-300 dark:hover:text-gray-300" id="cancelled-tab" data-tabs-target="#cancelled-content" type="button" role="tab" aria-controls="cancelled-content" aria-selected="false">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4 mr-1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                Cancelled
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="flex flex-col mt-2 w-full">
                <div id="divToScroll" class="search flex flex-row items-center h-[38px] w-full">
                    <div class="bg-white search_btn flex flex-row w-[71%] p-2 pl-1 h-full shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#ABBA7C" class="size-8 text-gray-400">
                            <path d="M8.25 10.875a2.625 2.625 0 1 1 5.25 0 2.625 2.625 0 0 1-5.25 0Z" />
                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.125 4.5a4.125 4.125 0 1 0 2.338 7.524l2.007 2.006a.75.75 0 1 0 1.06-1.06l-2.006-2.007a4.125 4.125 0 0 0-3.399-6.463Z" clip-rule="evenodd" />
                        </svg>
                        <input type="text" v-model="searchTextInput" @keydown.enter="changeSearchText" placeholder="Search"
                               class="search_input bg-white h-full w-full focus:outline-none">
                    </div>
                    <fwb-button pill @click="openPopup('filter')"
                                class="ml-1 text-white shadow-sm bg-[#ABBA7C] text-gray-500 h-full focus:outline-none hover:bg-gray-200 focus:ring-4 focus:ring-gray-100 font-semibold rounded-full text-sm px-4 py-2.5 me-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 inline-flex items-center">
                        <template #prefix>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.25"
                                 stroke="white" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75"/>
                            </svg>
                        </template>
                        <span class="text-white">{{ $lang('LBL_FILTER') }}</span>
                    </fwb-button>
                    <!-- Sử dụng component pop-up -->
                    <FilterPopup :isVisible="currentPopup === 'filter'" @applyFilters="handleFilterUpdate" @closePopup="closePopup"/>
                    <fwb-button pill @click="isOpen = !isOpen"
                                class="ml-0.5 text-white shadow-sm bg-[#ABBA7C] text-gray-500 h-full focus:outline-none hover:bg-gray-200 focus:ring-4 focus:ring-gray-100 font-semibold rounded-full text-sm px-4 py-2.5 me-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 inline-flex items-center">
                        <template #prefix>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.25"
                                 class="size-5" stroke="white">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z"/>
                            </svg>
                        </template>
                        <span class="text-white">{{ $lang('LBL_SORT') }}</span>
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
                    <fwb-button pill
                                @click="refreshData"
                                class="font-semibold ml-0.5 text-white shadow-sm bg-[#ABBA7C] text-gray-500 h-full focus:outline-none hover:bg-gray-200 focus:ring-4 focus:ring-gray-100 rounded-full text-sm px-4 py-2.5 me-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700 inline-flex items-center">
                        <template #prefix>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="size-6">
                                <path fill-rule="evenodd" d="M4.755 10.059a7.5 7.5 0 0 1 12.548-3.364l1.903 1.903h-3.183a.75.75 0 1 0 0 1.5h4.992a.75.75 0 0 0 .75-.75V4.356a.75.75 0 0 0-1.5 0v3.18l-1.9-1.9A9 9 0 0 0 3.306 9.67a.75.75 0 1 0 1.45.388Zm15.408 3.352a.75.75 0 0 0-.919.53 7.5 7.5 0 0 1-12.548 3.364l-1.902-1.903h3.183a.75.75 0 0 0 0-1.5H2.984a.75.75 0 0 0-.75.75v4.992a.75.75 0 0 0 1.5 0v-3.18l1.9 1.9a9 9 0 0 0 15.059-4.035.75.75 0 0 0-.53-.918Z" clip-rule="evenodd" />
                            </svg>
                        </template>
                        <span class="text-white">Refresh</span>
                    </fwb-button>
                </div>
                <div id="default-styled-tab-content" class="flex mt-4 shadow-lg rounded-lg">
                    <div class="scrollbar-thin h-[700px] w-full gap-4 grid grid-cols-2 overflow-y-auto rounded-lg p-6 bg-gray-50 dark:bg-gray-800" id="wait-confirmation-content" role="tabpanel" aria-labelledby="wait-confirmation-tab">
                        <div
                            v-for="order in orders['Wait For Approval']"
                            :key="order.order_id"

                            class="w-[100%] h-full border flex flex-col justify-between shadow-sm border-gray-200 p-4 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors"
                        >
                            <div class="order-info flex w-full justify-between">
                                <p class="text-lg font-semibold flex items-center gap-2">#{{ order.order_number }} <span class="text-sm font-normal">- {{formatDateTime(order.order_date)}}</span></p>
                                <span class="text-md text-[#6B4226]">{{order.status}}</span>
                            </div>
                            <div class="overflow-y-auto w-full h-full scrollbar-thin mt-2">
                                <div
                                    v-for="(item, itemIndex) in order.order_detail"
                                    :key="item.id"
                                    class="order-item rounded-xl w-full last:pb-4"
                                >
                                    <!-- Product Details -->
                                    <div class="flex h-full pt-2 pl-3 w-full pb-2">
                                        <div class="flex flex-col w-full">
                                            <div class="flex items-center justify-between w-[100%] max-h-[200px] overflow-y-auto scrollbar-thin">
                                                <div class="w-[15%]">
                                                    <img
                                                        v-if="item.image === null"
                                                        src="@/assets/images/empty-image.jpg"
                                                        alt="Product"
                                                        class="w-full shadow-lg rounded-lg aspect-square"
                                                    >
                                                    <img
                                                        v-else
                                                        :src="item.image"
                                                        alt="Product"
                                                        class="w-full shadow-lg rounded-lg aspect-square"
                                                    >
                                                </div>
                                                <div class="flex flex-col w-full h-full pl-2 items-start">
                                                    <span class="text-md text-gray-700">{{ item.product_name }} ({{item.size}})
                                                    <span v-if="item.count_topping !== 0" class="text-xs text-gray-500">- {{
                                                            item.count_topping
                                                        }} toppings</span>
                                                    </span>
                                                    <span class="text-xs">Quantity: {{ item.quantity }} </span>
                                                    <span v-if="item.note !== ''" class="text-xs text-gray-500">Note: {{
                                                            item.note
                                                        }}</span>
                                                </div>
                                                <div class="font-semibold text-sm">{{
                                                        formatVietnameseCurrency(item.total_price)
                                                    }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full flex justify-between">
                                <div>
                                    <button
                                        @click="cancelOrder(order.order_id)"
                                        class="text-sm text-red-500 font-semibold hover:text-red-700 focus:outline-none hover:bg-red-200 px-2 py-1 rounded-full"
                                    >
                                        Cancel
                                    </button>
                                </div>
                                <p class="text-gray-500">Total price ({{order.count_product}} products): <span class="font-semibold">{{ formatVietnameseCurrency(order.total_price) }}</span></p>
                            </div>
                        </div>
                        <span v-if="!orders['Wait For Approval']">Nothing to show</span>
                    </div>
                    <div class="scrollbar-thin h-[700px] w-full gap-4 grid grid-cols-2 overflow-y-auto rounded-lg p-6 bg-gray-50 dark:bg-gray-800" id="in-progress-content" role="tabpanel" aria-labelledby="in-progress-tab">
                        <div
                            v-for="order in orders['In Progress']"
                            :key="order.order_id"

                            class="w-[100%] h-full border flex flex-col justify-between border-gray-200 p-4 rounded-lg shadow-sm cursor-pointer hover:bg-gray-50 transition-colors"
                        >
                            <div class="order-info flex w-full justify-between">
                                <p class="text-lg font-semibold flex items-center gap-2 ">#{{ order.order_number }} <span class="text-sm font-normal">- {{formatDateTime(order.order_date)}}</span></p>
                                <span class="text-md text-[#6B4226]">{{order.status}}</span>
                            </div>
                            <div class="overflow-y-auto w-full h-full scrollbar-thin mt-2">
                                <div
                                    v-for="(item, itemIndex) in order.order_detail"
                                    :key="item.id"
                                    class="order-item rounded-xl w-full last:pb-4"
                                >
                                    <!-- Product Details -->
                                    <div class="flex h-full pt-2 pl-3 w-full pb-2">
                                        <div class="flex flex-col w-full">
                                            <div class="flex items-center justify-between w-[100%] max-h-[200px] overflow-y-auto scrollbar-thin">
                                                <div class="w-[15%]">
                                                    <img
                                                        v-if="item.image === null"
                                                        src="@/assets/images/empty-image.jpg"
                                                        alt="Product"
                                                        class="w-full shadow-lg rounded-lg aspect-square"
                                                    >
                                                    <img
                                                        v-else
                                                        :src="item.image"
                                                        alt="Product"
                                                        class="w-full shadow-lg rounded-lg aspect-square"
                                                    >
                                                </div>
                                                <div class="flex flex-col w-full h-full pl-2 items-start">
                                                    <span class="text-md text-gray-700">{{ item.product_name }} ({{item.size}})
                                                    <span v-if="item.count_topping !== 0" class="text-xs text-gray-500">- {{
                                                            item.count_topping
                                                        }} toppings</span>
                                                    </span>
                                                    <span class="text-xs">Quantity: {{ item.quantity }} </span>
                                                    <span v-if="item.note !== ''" class="text-xs text-gray-500">Note: {{
                                                            item.note
                                                        }}</span>
                                                </div>
                                                <div class="font-semibold text-sm">{{
                                                        formatVietnameseCurrency(item.total_price)
                                                    }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full flex justify-between">
                                <div>
                                </div>
                                <p class="text-gray-500">Total price ({{order.count_product}} products): <span class="font-semibold">{{ formatVietnameseCurrency(order.total_price) }}</span></p>
                            </div>
                        </div>
                        <span v-if="!orders['In Progress']">Nothing to show</span>
                    </div>
                    <div class="scrollbar-thin h-[700px] w-full gap-4 grid grid-cols-2 overflow-y-auto rounded-lg p-6 bg-gray-50 dark:bg-gray-800" id="delivering-content" role="tabpanel" aria-labelledby="delivering-tab">
                        <div
                            v-for="order in orders['Delivering']"
                            :key="order.order_id"

                            class="w-[100%] h-full border flex flex-col justify-between border-gray-200 p-4 rounded-lg shadow-sm cursor-pointer hover:bg-gray-50 transition-colors"
                        >
                            <div class="order-info flex w-full justify-between">
                                <p class="text-lg font-semibold flex items-center gap-2 ">#{{ order.order_number }} <span class="text-sm font-normal">- {{formatDateTime(order.order_date)}}</span></p>
                                <span class="text-md text-[#6B4226]">{{order.status}}</span>
                            </div>
                            <div class="overflow-y-auto w-full h-full scrollbar-thin mt-2">
                                <div
                                    v-for="(item, itemIndex) in order.order_detail"
                                    :key="item.id"
                                    class="order-item rounded-xl w-full last:pb-4"
                                >
                                    <!-- Product Details -->
                                    <div class="flex h-full pt-2 pl-3 w-full pb-2">
                                        <div class="flex flex-col w-full">
                                            <div class="flex items-center justify-between w-[100%] max-h-[200px] overflow-y-auto scrollbar-thin">
                                                <div class="w-[15%]">
                                                    <img
                                                        v-if="item.image === null"
                                                        src="@/assets/images/empty-image.jpg"
                                                        alt="Product"
                                                        class="w-full shadow-lg rounded-lg aspect-square"
                                                    >
                                                    <img
                                                        v-else
                                                        :src="item.image"
                                                        alt="Product"
                                                        class="w-full shadow-lg rounded-lg aspect-square"
                                                    >
                                                </div>
                                                <div class="flex flex-col w-full h-full pl-2 items-start">
                                                    <span class="text-md text-gray-700">{{ item.product_name }} ({{item.size}})
                                                    <span v-if="item.count_topping !== 0" class="text-xs text-gray-500">- {{
                                                            item.count_topping
                                                        }} toppings</span>
                                                    </span>
                                                    <span class="text-xs">Quantity: {{ item.quantity }} </span>
                                                    <span v-if="item.note !== ''" class="text-xs text-gray-500">Note: {{
                                                            item.note
                                                        }}</span>
                                                </div>
                                                <div class="font-semibold text-sm">{{
                                                        formatVietnameseCurrency(item.total_price)
                                                    }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full flex justify-between">
                                <div>
                                </div>
                                <p class="text-gray-500">Total price ({{order.count_product}} products): <span class="font-semibold">{{ formatVietnameseCurrency(order.total_price) }}</span></p>
                            </div>
                        </div>
                        <span v-if="!orders['Delivering']">Nothing to show</span>

                    </div>
                    <div class="scrollbar-thin h-[700px] w-full gap-4 grid grid-cols-2 overflow-y-auto rounded-lg p-6 bg-gray-50 dark:bg-gray-800" id="delivered-content" role="tabpanel" aria-labelledby="delivered-tab">
                        <div
                            v-for="order in orders['Delivered']"
                            :key="order.order_id"
                            class="w-[100%] h-full border flex flex-col justify-between border-gray-200 p-4 rounded-lg shadow-sm cursor-pointer hover:bg-gray-50 transition-colors"
                        >
                            <div class="order-info flex w-full justify-between">
                                <p class="text-lg font-semibold flex items-center gap-2 ">#{{ order.order_number }} <span class="text-sm font-normal">- {{formatDateTime(order.order_date)}}</span></p>
                                <span class="text-md text-[#6B4226]">{{order.status}}</span>
                            </div>
                            <div class="overflow-y-auto w-full h-full scrollbar-thin mt-2">
                                <div
                                    v-for="(item, itemIndex) in order.order_detail"
                                    :key="item.id"
                                    class="order-item rounded-xl w-full last:pb-4"
                                >
                                    <!-- Product Details -->
                                    <div class="flex h-full pt-2 pl-3 w-full pb-2">
                                        <div class="flex flex-col w-full">
                                            <div class="flex items-center justify-between w-[100%] max-h-[200px] overflow-y-auto scrollbar-thin">
                                                <div class="w-[15%]">
                                                    <img
                                                        v-if="item.image === null"
                                                        src="@/assets/images/empty-image.jpg"
                                                        alt="Product"
                                                        class="w-full shadow-lg rounded-lg aspect-square"
                                                    >
                                                    <img
                                                        v-else
                                                        :src="item.image"
                                                        alt="Product"
                                                        class="w-full shadow-lg rounded-lg aspect-square"
                                                    >
                                                </div>
                                                <div class="flex flex-col w-full h-full pl-2 items-start">
                                                    <span class="text-md text-gray-700">{{ item.product_name }} ({{item.size}})
                                                    <span v-if="item.count_topping !== 0" class="text-xs text-gray-500">- {{
                                                            item.count_topping
                                                        }} toppings</span>
                                                    </span>
                                                    <span class="text-xs">Quantity: {{ item.quantity }} </span>
                                                    <span v-if="item.note !== ''" class="text-xs text-gray-500">Note: {{
                                                            item.note
                                                        }}</span>
                                                </div>
                                                <div class="font-semibold text-sm">{{
                                                        formatVietnameseCurrency(item.total_price)
                                                    }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full flex justify-between">
                                <div>
                                </div>
                                <p class="text-gray-500">Total price ({{order.count_product}} products): <span class="font-semibold">{{ formatVietnameseCurrency(order.total_price) }}</span></p>
                            </div>
                        </div>
                        <span v-if="!orders['Delivered']">Nothing to show</span>

                    </div>
                    <div class="scrollbar-thin h-[700px] w-full gap-4 grid grid-cols-2 overflow-y-auto rounded-lg p-6 bg-gray-50 dark:bg-gray-800" id="completed-content" role="tabpanel" aria-labelledby="completed-tab">
                        <div
                            v-for="order in orders['Completed']"
                            :key="order.order_id"

                            class="w-[100%] h-full border flex flex-col justify-between border-gray-200 p-4 rounded-lg shadow-sm cursor-pointer hover:bg-gray-50 transition-colors"
                        >
                            <div class="order-info flex w-full justify-between">
                                <p class="text-lg font-semibold flex items-center gap-2 ">#{{ order.order_number }} <span class="text-sm font-normal">- {{formatDateTime(order.order_date)}}</span></p>
                                <span class="text-md text-[#6B4226]">{{order.status}}</span>
                            </div>
                            <div class="overflow-y-auto w-full h-full scrollbar-thin mt-2">
                                <div
                                    v-for="(item, itemIndex) in order.order_detail"
                                    :key="item.id"
                                    class="order-item rounded-xl w-full last:pb-4 shadow-sm"
                                >
                                    <!-- Product Details -->
                                    <div class="flex h-full pt-2 pl-3 w-full pb-2">
                                        <div class="flex flex-col w-full">
                                            <div class="flex items-center justify-between w-[100%]">
                                                <div class="w-[15%]">
                                                    <img
                                                        v-if="item.image === null"
                                                        src="@/assets/images/empty-image.jpg"
                                                        alt="Product"
                                                        class="w-full shadow-lg rounded-lg aspect-square"
                                                    >
                                                    <img
                                                        v-else
                                                        :src="item.image"
                                                        alt="Product"
                                                        class="w-full shadow-lg rounded-lg aspect-square"
                                                    >
                                                </div>
                                                <div class="flex flex-col w-full h-full pl-2 items-start">
                                                    <span class="text-md text-gray-700">{{ item.product_name }} ({{item.size}})
                                                    <span v-if="item.count_topping !== 0" class="text-xs text-gray-500">- {{
                                                            item.count_topping
                                                        }} toppings</span>
                                                    </span>
                                                    <span class="text-xs">Quantity: {{ item.quantity }} </span>
                                                    <span v-if="item.note !== ''" class="text-xs text-gray-500">Note: {{
                                                            item.note
                                                        }}</span>
                                                </div>
                                                <div class="font-semibold text-sm">{{
                                                        formatVietnameseCurrency(item.total_price)
                                                    }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full flex justify-between">
                                <div>
                                </div>
                                <p class="text-gray-500">Total price ({{order.count_product}} products): <span class="font-semibold">{{ formatVietnameseCurrency(order.total_price) }}</span></p>
                            </div>
                        </div>
                        <span v-if="!orders['Completed']">Nothing to show</span>

                    </div>
                    <div class="scrollbar-thin h-[700px] w-full gap-4 grid grid-cols-2 overflow-y-auto rounded-lg p-6 bg-gray-50 dark:bg-gray-800" id="cancelled-content" role="tabpanel" aria-labelledby="cancelled-tab">
                        <div
                            v-for="order in orders['Cancelled']"
                            :key="order.order_id"

                            class="w-[100%] h-full border flex flex-col justify-between border-gray-200 p-4 rounded-lg shadow-sm cursor-pointer hover:bg-gray-50 transition-colors"
                        >
                            <div class="order-info flex w-full justify-between">
                                <p class="text-lg font-semibold flex items-center gap-2 ">#{{ order.order_number }} <span class="text-sm font-normal">- {{formatDateTime(order.order_date)}}</span></p>
                                <span class="text-md text-[#6B4226]">{{order.status}}</span>
                            </div>
                            <div class="overflow-y-auto w-full h-full scrollbar-thin mt-2">
                                <div
                                    v-for="(item, itemIndex) in order.order_detail"
                                    :key="item.id"
                                    class="order-item rounded-xl w-full last:pb-4 shadow-sm"
                                >
                                    <!-- Product Details -->
                                    <div class="flex h-full pt-2 pl-3 w-full pb-2">
                                        <div class="flex flex-col w-full">
                                            <div class="flex items-center justify-between w-[100%]">
                                                <div class="w-[15%]">
                                                    <img
                                                        v-if="item.image === null"
                                                        src="@/assets/images/empty-image.jpg"
                                                        alt="Product"
                                                        class="w-full shadow-lg rounded-lg aspect-square"
                                                    >
                                                    <img
                                                        v-else
                                                        :src="item.image"
                                                        alt="Product"
                                                        class="w-full shadow-lg rounded-lg aspect-square"
                                                    >
                                                </div>
                                                <div class="flex flex-col w-full h-full pl-2 items-start">
                                                    <span class="text-md text-gray-700">{{ item.product_name }} ({{item.size}})
                                                    <span v-if="item.count_topping !== 0" class="text-xs text-gray-500">- {{
                                                            item.count_topping
                                                        }} toppings</span>
                                                    </span>
                                                    <span class="text-xs">Quantity: {{ item.quantity }} </span>
                                                    <span v-if="item.note !== ''" class="text-xs text-gray-500">Note: {{
                                                            item.note
                                                        }}</span>
                                                </div>
                                                <div class="font-semibold text-sm">{{
                                                        formatVietnameseCurrency(item.total_price)
                                                    }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full flex justify-between">
                                <div>
                                </div>
                                <p class="text-gray-500">Total price ({{order.count_product}} products): <span class="font-semibold">{{ formatVietnameseCurrency(order.total_price) }}</span></p>
                            </div>
                        </div>
                        <span v-if="!orders['Cancelled']">Nothing to show</span>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { initFlowbite } from 'flowbite';
import {ref, onMounted} from 'vue';
import axios from 'axios';
import {formatVietnameseCurrency} from "../../helpers/currencyFormat.js";
import FilterPopup from "@/js/components/popup/FilterPopup.vue";
import {FwbButton} from "flowbite-vue";
import {formatDateTime} from "../../helpers/dateFormat.js";
import {notify} from "notiwind";

// State variables
const orders = ref([]); // Holds the list of orders
const selectedOrder = ref(null); // Holds the currently selected order
// Fetch orders from the backend API
const fetchOrders = async () => {
    try {
        const response = await axios.get('/api/loadCustomerOrders'); // Replace with your API endpoint
        orders.value = response.data.data; // Assuming the API returns an array of orders
    } catch (error) {
        console.error('Error fetching orders:', error);
    }
};

const refreshData = async () => {
    try {
        fetchOrders();
    } catch (error) {
        console.error('Error fetching orders:', error);
    }
};

// Cancel the selected order
const cancelOrder = async (orderId) => {
    if(confirm('Are you sure you want to cancel this order?')) {
        await axios.post(`/api/customer/cancelOrder`, {
            order_id: orderId
        });
        let orderName = orders.value['Wait For Approval'].find(order => order.order_id === orderId).order_number;
        notify({
            group: "foo",
            title: "Success",
            text: `Order #${orderName} has been cancelled successfully!`,
        }, 4000);
        fetchOrders();
    }
};

// Open chat with an employee
const chatWithEmployee = () => {
    alert("Chat with an employee feature is not implemented yet.");
    // Add logic to handle chat with employee
};

// Close the order detail view
const closeDetail = () => {
    selectedOrder.value = null;
};

// Fetch orders when the component is mounted
onMounted(() => {
    initFlowbite(); // Initialize Flowbite components
    fetchOrders();
});
</script>

<style scoped>
/* Fade transition */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

/* Slide-fade transition */
.slide-fade-enter-active,
.slide-fade-leave-active {
    transition: transform 0.5s ease, opacity 0.5s ease;
}

.slide-fade-enter-from,
.slide-fade-leave-to {
    transform: translateX(100%);
    opacity: 0;
}
.search_input:focus {
    outline: none !important;
}

.border-light-gray {
    border: 1px solid rgba(117, 117, 117, 0.28);
}

.search_btn {
    display: inline-flex;
    height: 38px;
    justify-content: center;
    align-items: center;
    flex-shrink: 0;
    border-radius: 50px;
    margin: 4px;
}


.search_input {
    border-style: none;
    outline: none;
    border: none;
}

</style>
