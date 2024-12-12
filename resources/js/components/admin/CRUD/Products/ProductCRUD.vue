<template>
    <!-- Start block -->
    <section class="p-3 sm:p-5 antialiased h-full w-full">
        <div class="mx-auto max-w-screen-2xl px-4 lg:px-12">
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div
                    class="flex flex-col md:flex-row md:items-center md:justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <div class="flex-1 flex items-center space-x-2">
                        <h5>
                            <span class="text-gray-500">{{ $lang('LBL_ALL_PRODUCT') }}: </span>
                            <span class="dark:text-white">123456</span>
                        </h5>
                        <h5 class="text-gray-500 dark:text-gray-400 ml-1">1-100 (436)</h5>
                        <button type="button" class="group" data-tooltip-target="results-tooltip">
                            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                 class="h-4 w-4 text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                 viewbox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                      clip-rule="evenodd"/>
                            </svg>
                            <span class="sr-only">More info</span>
                        </button>
                        <div id="results-tooltip" role="tooltip"
                             class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                            Showing 1-100 of 436 results
                            <div class="tooltip-arrow" data-popper-arrow=""></div>
                        </div>
                    </div>
                </div>
                <div
                    class="flex flex-col md:flex-row items-stretch md:items-center md:space-x-3 space-y-3 md:space-y-0 justify-between mx-4 py-4 border-t dark:border-gray-700">
                    <div class="w-full md:w-1/2">
                        <form class="flex items-center">
                            <label for="simple-search" class="sr-only">Search</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                         fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"/>
                                    </svg>
                                </div>
                                <input type="text" id="simple-search" placeholder="Search for products" required=""
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            </div>
                        </form>
                    </div>
                    <div
                        class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                        <button v-show="store.getters.hasPermission({'module': moduleName, 'action': 'create'})"
                                type="button" id="createproductButton" data-modal-target="create-product-modal"
                                data-modal-toggle="create-product-modal"
                                class="flex items-center justify-center text-white bg-primary hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary focus:outline-none dark:focus:ring-primary-800">
                            <svg class="h-3.5 w-3.5 mr-1.5 -ml-1" fill="currentColor" viewbox="0 0 20 20"
                                 xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd"
                                      d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"/>
                            </svg>
                            Add product
                        </button>
                        <button id="filterDropdownButton" data-dropdown-toggle="filterDropdown"
                                class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-600 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                                type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true"
                                 class="h-4 w-4 mr-1.5 -ml-1 text-gray-400" viewbox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                                      clip-rule="evenodd"/>
                            </svg>
                            Filter options
                            <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                                 xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd"
                                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                            </svg>
                        </button>
                        <div id="filterDropdown"
                             class="z-10 hidden px-3 pt-1 bg-white rounded-lg shadow w-80 dark:bg-gray-700 right-0">
                            <div class="flex items-center justify-between pt-2">
                                <h6 class="text-sm font-medium text-black dark:text-white">Filters</h6>
                                <div class="flex items-center space-x-3">
                                    <a href="#"
                                       class="flex items-center text-sm font-medium text-primary-600 dark:text-primary-500 hover:underline">Save
                                        view</a>
                                    <a href="#"
                                       class="flex items-center text-sm font-medium text-primary-600 dark:text-primary-500 hover:underline">Clear
                                        all</a>
                                </div>
                            </div>
                            <div class="pt-3 pb-2">
                                <label for="input-group-search" class="sr-only">Search</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                             fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                  d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                                  clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <input type="text" id="input-group-search"
                                           class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                           placeholder="Search keywords...">
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3 w-full md:w-auto">
                            <button id="actionsDropdownButton" data-dropdown-toggle="actionsDropdown"
                                    class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-600 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                                    type="button">
                                Actions
                                <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                                     xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd"
                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                                </svg>
                            </button>
                            <div id="actionsDropdown"
                                 class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                    aria-labelledby="actionsDropdownButton">
                                    <li>
                                        <a href="#"
                                           class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Mass
                                            Edit</a>
                                    </li>
                                </ul>
                                <div class="py-1">
                                    <a href="#"
                                       class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete
                                        all</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="p-4">
                                <div class="flex items-center">
                                    <input id="checkbox-all" type="checkbox"
                                           class="w-4 h-4 text-primary-600 bg-gray-100 rounded border-gray-300 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="checkbox-all" class="sr-only">checkbox</label>
                                </div>
                            </th>
                            <th scope="col" class="p-4">Name</th>
                            <th scope="col" class="p-4">Description</th>
                            <th scope="col" class="p-4">Status</th>
                            <th scope="col" class="p-4">Price</th>
                            <th scope="col" class="p-4">Cost</th>
                            <th scope="col" class="p-4">UP M Price</th>
                            <th scope="col" class="p-4">UP L Price</th>
                            <th scope="col" class="p-4">Is Topping</th>
                            <th scope="col" class="p-4">Created By</th>
                            <th scope="col" class="p-4">Created At</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr
                            v-if="list.length > 0"
                            v-for="(item, index) in list"
                            :key="index"
                            class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700"
                        >
                            <td class="p-4 w-4">
                                <div class="flex items-center">
                                    <input id="checkbox-table-search-1" type="checkbox"
                                           onclick="event.stopPropagation()"
                                           class="w-4 h-4 text-primary-600 bg-gray-100 rounded border-gray-300 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                </div>
                            </td>
                            <td class="p-4">
                                <div class="flex items-center mr-3">
                                    <img v-show="item.image" :src="'http://localhost:8000/storage/' + item.image" :alt=item.name
                                         class="h-8 w-8 mr-3 rounded-full" >
                                    {{ item.name }}
                                </div>
                            </td>
                            <td class="p-4">{{ item.description }}</td>
                            <td class="p-4">{{ item.status }}</td>
                            <td class="p-4">{{ item.price }}</td>
                            <td class="p-4">{{ item.cost }}</td>
                            <td class="p-4">{{ item.up_m_price }}</td>
                            <td class="p-4">{{ item.up_l_price }}</td>
                            <td class="p-4">
                                <div class="rounded-[50%] p-1 w-fit"
                                     :class="{'bg-primary': item.is_topping, 'bg-red-500': !item.is_topping}">
                                    <svg v-if="item.is_topping" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"
                                         class="size-4 text-white">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                                    </svg>
                                    <svg v-if="!item.is_topping" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"
                                         class="size-4 text-white">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                                    </svg>
                                </div>
                            </td>
                            <td class="p-4">{{ item.created_by_name }}</td>
                            <td class="p-4">{{ formatDateTime(item.created_at) }}</td>
                            <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <div class="flex items-center space-x-3 justify-end">
                                    <button
                                        v-show="store.getters.hasPermission({'module': moduleName, 'action': 'edit', 'created_by': item.created_by})"
                                        type="button" @click="openUpdateModal(item.id)"
                                        data-drawer-target="drawer-update-product"
                                        data-drawer-show="drawer-update-product"
                                        class="py-2 px-3 flex items-center text-sm font-medium text-center text-white bg-primary rounded-lg hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary dark:focus:ring-primary-800">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewbox="0 0 20 20"
                                             fill="currentColor" aria-hidden="true">
                                            <path
                                                d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"/>
                                            <path fill-rule="evenodd"
                                                  d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                  clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                    <button
                                        v-show="store.getters.hasPermission({'module': moduleName, 'action': 'delete', 'created_by': item.created_by})"
                                        type="button" @click="openDeleteModal(item.id)"
                                        class="flex items-center text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-2 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewbox="0 0 20 20"
                                             fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                  d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                  clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="store.getters['products/isLoading']">
                            <td colspan="8" class="p-4 text-center">Loading...</td>
                        </tr>
                        <tr v-if="!store.getters['products/isLoading'] && list.length === 0">
                            <td colspan="8" class="p-4 text-center">No data available.</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <nav
                    class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4"
                    aria-label="Table navigation">
                <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                    Showing
                    <span class="font-semibold text-gray-900 dark:text-white">1-10</span>
                    of
                    <span class="font-semibold text-gray-900 dark:text-white">1000</span>
                </span>
                    <ul class="inline-flex items-stretch -space-x-px">
                        <li>
                            <a href="#"
                               class="flex items-center justify-center h-full py-1.5 px-3 ml-0 text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <span class="sr-only">Previous</span>
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                          d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="#"
                               class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">1</a>
                        </li>
                        <li>
                            <a href="#"
                               class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">2</a>
                        </li>
                        <li>
                            <a href="#" aria-current="page"
                               class="flex items-center justify-center text-sm z-10 py-2 px-3 leading-tight text-primary-600 bg-primary-50 border border-primary-300 hover:bg-primary-100 hover:text-blue-600 dark:border-gray-700 dark:bg-gray-700 dark:text-white">3</a>
                        </li>
                        <li>
                            <a href="#"
                               class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">...</a>
                        </li>
                        <li>
                            <a href="#"
                               class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">100</a>
                        </li>
                        <li>
                            <a href="#"
                               class="flex items-center justify-center h-full py-1.5 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <span class="sr-only">Next</span>
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                          d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </section>
    <div id="create-product-modal" tabindex="-1" aria-hidden="true"
         class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-999 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] md:h-full">
        <div class="relative p-4 w-full max-w-3xl h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                <!-- Modal header -->
                <div
                    class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Add Product</h3>
                    <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-toggle="create-product-modal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                  clip-rule="evenodd"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div
                    class="overflow-y-auto h-150 scrollbar scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-gray-100 p-2">
                    <form @submit.prevent="handleCreateProduct">
                        <div class="grid gap-4 mb-4 sm:grid-cols-2">
                            <div>
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Product
                                    Name</label>
                                <input v-model="form.name" type="text" name="name" id="name"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                       placeholder="Type product name" required="">
                            </div>
                            <div>
                                <label for="category"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
                                <Multiselect
                                    :classes="{  tag: 'bg-primary text-white text-sm font-semibold py-0.5 pl-2 rounded mr-1 mb-1 flex items-center whitespace-nowrap min-w-0 rtl:pl-0 rtl:pr-2 rtl:mr-0 rtl:ml-1',}"
                                    v-model="form.categories_id"
                                    :options="options"
                                    :close-on-select="false"
                                    mode="tags"
                                    :searchable="true"
                                />
                            </div>
                            <div>
                                <label for="status"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                                <select v-model="form.status" id="status"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        required="">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                            <div>
                                <label for="is_topping"
                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Is
                                    Topping</label>
                                <select v-model="form.is_topping" id="is_topping"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        required>
                                    <option :value="true">Yes</option>
                                    <option :value="false">No</option>
                                </select>
                            </div>
                            <div class="grid gap-4 sm:col-span-2 md:gap-6 sm:grid-cols-1"
                                 v-show="form.is_topping === false">
                                <div>
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Add
                                        Toppings</label>
                                    <Multiselect
                                        :classes="{  tag: 'bg-primary text-white text-sm font-semibold py-0.5 pl-2 rounded mr-1 mb-1 flex items-center whitespace-nowrap min-w-0 rtl:pl-0 rtl:pr-2 rtl:mr-0 rtl:ml-1',}"
                                        :searchable="true"
                                        v-model="form.toppings_id"
                                        :options="toppingOptions"
                                        :close-on-select="false"
                                        mode="tags"
                                    />
                                </div>
                            </div>
                            <div class="grid gap-4 sm:col-span-2 md:gap-6 " :class="{
                                              'sm:grid-cols-4': form.is_topping === false,
                                              'sm:grid-cols-2': form.is_topping === true}">
                                <div>
                                    <label for="price"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price</label>
                                    <input v-model="form.price" type="number" id="price"
                                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                           placeholder="Price" required>
                                </div>
                                <div>
                                    <label for="price"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cost</label>
                                    <input v-model="form.cost" type="number" id="price"
                                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                           placeholder="Cost" required>
                                </div>
                                <div v-show="form.is_topping === false">
                                    <label for="price"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Size
                                        M</label>
                                    <input v-model="form.up_m_price" type="number" id="price"
                                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                           placeholder="Size M" required>
                                </div>
                                <div v-show="form.is_topping === false">
                                    <label for="price"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Size
                                        L</label>
                                    <input v-model="form.up_l_price" type="number" id="price"
                                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                           placeholder="Size L" required>
                                </div>
                            </div>
                            <div class="sm:col-span-2"><label for="description"
                                                              class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label><textarea
                                id="description" rows="4"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Write product description here"></textarea></div>
                        </div>
                        <div class="mb-4">
                            <label for="images" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Product Images
                            </label>
                            <div
                                class="flex flex-col justify-center items-center w-full h-64 bg-gray-50 rounded-lg border-2 border-gray-300 border-dashed cursor-pointer dark:bg-gray-700 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600"
                            >
                                <input
                                    id="images"
                                    type="file"
                                    class="hidden"
                                    multiple
                                    @change="handleFileChange"
                                />
                                <label for="images" class="cursor-pointer flex flex-col items-center">
                                    <div class="flex flex-col justify-center items-center pt-5 pb-6">
                                        <svg
                                            aria-hidden="true"
                                            class="mb-3 w-10 h-10 text-gray-400"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"
                                            />
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500">
                                            <span class="font-semibold">Click to upload</span> or drag and
                                            drop
                                        </p>
                                        <p class="text-xs text-gray-500">PNG, JPG, or GIF (Max 5MB)</p>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="flex gap-4 mt-4">
                            <div
                                v-for="(image, index) in imagesPreview"
                                :key="index"
                                class="relative"
                            >
                                <img
                                    :src="image"
                                    class="w-24 h-24 object-cover rounded-md border"
                                />
                                <button
                                    @click="removeImage(index)"
                                    type="button"
                                    class="absolute top-0 right-0 bg-red-500 text-white rounded-full w-6 h-6 text-xs"
                                >
                                    ✕
                                </button>
                            </div>
                        </div>
                        <div class="items-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4">
                            <button type="submit"
                                    class="w-full sm:w-auto justify-center text-white inline-flex bg-primary hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary dark:focus:ring-primary-800">
                                Add Product
                            </button>
                            <button data-modal-toggle="create-product-modal" type="button"
                                    class="w-full justify-center sm:w-auto text-gray-500 inline-flex items-center bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                <svg class="mr-1 -ml-1 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                          d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                          clip-rule="evenodd"/>
                                </svg>
                                Discard
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End block -->
    <form action="#" id="drawer-update-product"
          class="fixed top-0 left-0 z-999 w-full h-screen max-w-3xl p-4 overflow-y-auto transition-transform -translate-x-full bg-white dark:bg-gray-800"
          tabindex="-1" aria-labelledby="drawer-update-product-label" aria-hidden="true">
        <h5 id="drawer-label"
            class="inline-flex items-center mb-6 text-sm font-semibold text-gray-500 uppercase dark:text-gray-400">Edit
            Product</h5>
        <button type="button" data-drawer-dismiss="drawer-update-product" aria-controls="drawer-update-product"
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                 xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                      d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                      clip-rule="evenodd"/>
            </svg>
            <span class="sr-only">Close menu</span>
        </button>
        <div class="grid gap-4 sm:grid-cols-1 sm:gap-6 ">
            <div class="grid gap-4 mb-4 sm:grid-cols-2">
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Product
                        Name</label>
                    <input v-model="formEdit.name" type="text" name="name" id="name"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                           placeholder="Type product name" required="">
                </div>
                <div>
                    <label for="category"
                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
                    <Multiselect
                        :classes="{  tag: 'bg-primary text-white text-sm font-semibold py-0.5 pl-2 rounded mr-1 mb-1 flex items-center whitespace-nowrap min-w-0 rtl:pl-0 rtl:pr-2 rtl:mr-0 rtl:ml-1',}"
                        v-model="formEdit.categories_id"
                        :options="options"
                        :close-on-select="false"
                        mode="tags"
                        :searchable="true"
                    />
                </div>
                <div>
                    <label for="status"
                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                    <select v-model="formEdit.status" id="status"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            required="">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div>
                    <label for="is_topping"
                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Is
                        Topping</label>
                    <select v-model="formEdit.is_topping" id="is_topping"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            required>
                        <option :value="true">Yes</option>
                        <option :value="false">No</option>
                    </select>
                </div>
                <div class="grid gap-4 sm:col-span-2 md:gap-6 sm:grid-cols-1"
                     v-show="formEdit.is_topping === false">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Add
                            Toppings</label>
                        <Multiselect
                            :classes="{  tag: 'bg-primary text-white text-sm font-semibold py-0.5 pl-2 rounded mr-1 mb-1 flex items-center whitespace-nowrap min-w-0 rtl:pl-0 rtl:pr-2 rtl:mr-0 rtl:ml-1',}"
                            :searchable="true"
                            v-model="formEdit.toppings_id"
                            :options="toppingOptions"
                            :close-on-select="false"
                            mode="tags"
                        />
                    </div>
                </div>
                <div class="grid gap-4 sm:col-span-2 md:gap-6 " :class="{
                                              'sm:grid-cols-4': formEdit.is_topping === false,
                                              'sm:grid-cols-2': formEdit.is_topping === true}">
                    <div>
                        <label for="price"
                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price</label>
                        <input v-model="formEdit.price" type="number" id="price"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                               placeholder="Price" required>
                    </div>
                    <div>
                        <label for="price"
                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cost</label>
                        <input v-model="formEdit.cost" type="number" id="price"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                               placeholder="Cost">
                    </div>
                    <div v-show="formEdit.is_topping === false">
                        <label for="price"
                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Size
                            M</label>
                        <input v-model="formEdit.up_m_price" type="number" id="price"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                               placeholder="Size M" >
                    </div>
                    <div v-show="formEdit.is_topping === false">
                        <label for="price"
                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Size
                            L</label>
                        <input v-model="formEdit.up_l_price" type="number" id="price"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                               placeholder="Size L">
                    </div>
                </div>
                <div class="sm:col-span-2"><label for="description"
                                                  class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label><textarea
                    id="description" rows="4"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Write product description here"></textarea></div>
            </div>
            <div class="mb-4">
                <label for="imagesEdit" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Product Images
                </label>
                <div
                    class="flex flex-col justify-center items-center w-full h-64 bg-gray-50 rounded-lg border-2 border-gray-300 border-dashed cursor-pointer dark:bg-gray-700 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600"
                >
                    <input
                        id="imagesEdit"
                        type="file"
                        class="hidden"
                        multiple
                        @change="handleFileEditChange"
                    />
                    <label for="imagesEdit" class="cursor-pointer flex flex-col items-center">
                        <div class="flex flex-col justify-center items-center pt-5 pb-6">
                            <svg
                                aria-hidden="true"
                                class="mb-3 w-10 h-10 text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"
                                />
                            </svg>
                            <p class="mb-2 text-sm text-gray-500">
                                <span class="font-semibold">Click to upload</span> or drag and
                                drop
                            </p>
                            <p class="text-xs text-gray-500">PNG, JPG, or GIF (Max 5MB)</p>
                        </div>
                    </label>
                </div>
            </div>
            <div class="flex gap-4 mt-4">
                <div
                    v-for="(image, index) in formEdit.images_list"
                    :key="index"
                    class="relative"
                >
                    <img
                        id="{{image.id}}"
                        :src="image.image_url"
                        class="w-24 h-24 object-cover rounded-md border"
                    />
                    <button
                        @click="removeImageEdit(index)"
                        type="button"
                        class="absolute top-0 right-0 bg-red-500 text-white rounded-full w-6 h-6 text-xs"
                    >
                        ✕
                    </button>
                </div>
                <div
                    v-for="(image, index) in imagesEditPreview"
                    :key="index"
                    class="relative"
                >
                    <img
                        :src="image"
                        class="w-24 h-24 object-cover rounded-md border"
                    />
                    <button
                        @click="removeImageEdit(index)"
                        type="button"
                        class="absolute top-0 right-0 bg-red-500 text-white rounded-full w-6 h-6 text-xs"
                    >
                        ✕
                    </button>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4 mt-6 sm:w-1/2">
            <button @click="updateProduct" type="submit"
                    class="text-white bg-primary hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary dark:focus:ring-primary-800">
                Update Product
            </button>
            <button @click="deleteProduct" type="button"
                    class="text-red-600 inline-flex justify-center items-center hover:text-white border border-red-600 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                <svg aria-hidden="true" class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewbox="0 0 20 20"
                     xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                          d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                          clip-rule="evenodd"/>
                </svg>
                Delete
            </button>
        </div>
    </form>
    <div id="delete-modal" tabindex="-1"
         class="fixed top-0 left-0 right-0 z-999 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full justify-center items-center">
        <div class="relative w-full h-auto max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button"
                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                        data-modal-toggle="delete-modal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                         xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                              clip-rule="evenodd"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-6 text-center">
                    <svg aria-hidden="true" class="mx-auto mb-4 text-gray-400 w-14 h-14 dark:text-gray-200" fill="none"
                         stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to
                        delete this product?</h3>
                    <button data-modal-toggle="delete-modal" type="button" @click="deleteProduct"
                            class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                        Yes, I'm sure
                    </button>
                    <button data-modal-toggle="delete-modal" type="button"
                            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                        No, cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import {reactive, ref, onMounted} from 'vue';
import {useStore} from 'vuex';
import {initFlowbite, Drawer, Modal} from 'flowbite';
import {notify} from 'notiwind';
import Multiselect from '@vueform/multiselect';
import {useI18n} from "vue-i18n";
import {formatDateTime} from "../../../../helpers/dateFormat.js";

// Initialize Vuex store
const store = useStore();
const list = ref([]);
const showDrawer = ref(false); // Reactive state for drawer visibility
let updateDrawerInstance = null; // Drawer instance
let deleteModalInstance = null; // Modal instance

const {t} = useI18n();
const moduleName = 'products';
const fetchCategoriesOptions = async () => {
    try {
        await store.dispatch('categories/fetchCategoriesOptions');
        store.getters['categories/allCategoriesOptions'].forEach((category) => {
            options.value[category.id] = t(category.name);
        });
    } catch (error) {
        console.error("Failed to fetch categories:", error);
    }
}
const fetchToppingsOptions = async () => {
    try {
        await store.dispatch('products/fetchToppingOptions');
        store.getters['products/toppingsOption'].forEach((topping) => {
            toppingOptions.value[topping.id] = topping.name;
        });
    } catch (error) {
        console.error("Failed to fetch teams:", error);
    }
}

const options = ref({});
const toppingOptions = ref({}); // Assuming you have a list of topping options

// Reactive form data
const form = reactive({
    name: '',
    description: '',
    image: '',
    status: 'active',
    price: 0,
    cost: 0,
    up_m_price: 0,
    up_l_price: 0,
    is_topping: false,
    categories_id: [],
    toppings_id: [],
    images: [],
});

const formEdit = reactive({
    name: '',
    description: '',
    image: '',
    status: 'active',
    price: 0,
    cost: 0,
    up_m_price: 0,
    up_l_price: 0,
    is_topping: false,
    team_id: null,
    categories_id: [],
    toppings_id: [],
    images_list: [],
    images_new: [],
});
const imagesPreview = ref([]);
const imagesEditPreview = ref([]);

// File change handler
const handleFileChange = (event) => {
    const files = event.target.files;

    Array.from(files).forEach((file) => {
        // Validate image size (max 5MB)
        if (file.size > 5 * 1024 * 1024) {
            alert("File size must not exceed 5MB");
            return;
        }

        // Validate file type
        if (!["image/jpeg", "image/png", "image/gif"].includes(file.type)) {
            alert("Only JPG, PNG, and GIF files are allowed");
            return;
        }

        // Add to images array
        form.images.push(file);

        // Generate preview
        const reader = new FileReader();
        reader.onload = (e) => {
            imagesPreview.value.push(e.target.result);
        };
        reader.readAsDataURL(file);
    });

    // Reset input value to allow re-adding the same file
    event.target.value = "";
};
const handleFileEditChange = (event) => {

    const files = event.target.files;

    Array.from(files).forEach((file) => {
        // Validate image size (max 5MB)
        if (file.size > 5 * 1024 * 1024) {
            alert("File size must not exceed 5MB");
            return;
        }

        // Validate file type
        if (!["image/jpeg", "image/png", "image/gif"].includes(file.type)) {
            alert("Only JPG, PNG, and GIF files are allowed");
            return;
        }
        // Generate preview
        const reader = new FileReader();
        reader.onload = (e) => {
            imagesEditPreview.value.push(e.target.result);
        };
        reader.readAsDataURL(file);
    });

    // Reset input value to allow re-adding the same file
    event.target.value = "";
};

// Remove image
const removeImage = (index) => {
    form.images.splice(index, 1); // Remove from actual image files
    imagesPreview.value.splice(index, 1); // Remove from previews
};
const removeImageEdit = (index) => {
    formEdit.images_list.splice(index, 1); // Remove from actual image files
    imagesEditPreview.value.splice(index, 1); // Remove from previews
};

// Fetch products data from Vuex store
const fetchData = async () => {
    try {
        await store.dispatch('products/fetchProducts');
        list.value = store.state.products.products;
    } catch (error) {
        console.error("Failed to fetch products:", error);
    }
};

// Handle create product
const handleCreateProduct = async () => {
    try {
        // Create FormData to send image files
        const formData = new FormData();

        // Append form fields to FormData (including arrays like categories_id and toppings_id)
        Object.keys(form).forEach((key) => {
            if (key !== "images" && form[key]) {
                if (Array.isArray(form[key])) {
                    form[key].forEach((item) => {
                        formData.append(`${key}[]`, item);  // Append array items individually
                    });
                } else {
                    formData.append(key, form[key]);
                }
            }
        });
        formData.append('is_topping', form.is_topping ? 1 : 0);
        // Append images to FormData
        form.images.forEach((image, index) => {
            formData.append(`images[${index}]`, image);  // Append images with index
        });

        // Debugging: Log the contents of FormData
        for (let [key, value] of formData.entries()) {
            console.log(key, value);
        }

        // Send data using a POST request (using your store action or Axios)
        await store.dispatch('products/createProduct', formData);
        notify({
            group: "foo",
            title: "Success",
            text: "Product created successfully!",
        }, 4000);
        fetchData(); // Refresh the list after creating a product
    } catch (error) {
        notify({
            group: "foo",
            title: "Error",
            text: "An error occurred while creating the product",
        }, 2000);
        console.error(error);
    }
};
// Handle update product
const updateProduct = async () => {
    try {
        // Create FormData to send image files
        let formData2 = new FormData();

        // Append form fields to FormData (including arrays like categories_id and toppings_id)
        Object.keys(formEdit).forEach((key) => {
            if (key !== "images" && formEdit[key]) {
                if (Array.isArray(formEdit[key])) {
                    formEdit[key].forEach((item) => {
                        formData2.append(`${key}[]`, item);  // Append array items individually
                    });
                } else {
                    formData2.append(key, formEdit[key]);
                }
            }
        });
        formData2.append('is_topping', formEdit.is_topping ? 1 : 0);
        // Append images to FormData
        imagesEditPreview.value.forEach((image, index) => {
            formEdit.images_new.push(image);  // Append images with index
        });

        // Debugging: Log the contents of FormData
        for (let [key, value] of formData2.entries()) {
            console.log(key, value);
        }

        // Send data using a POST request (using your store action or Axios)
        await store.dispatch('products/updateProduct', {
            id: formEdit.id,
            productData: formEdit,
        });
        notify({
            group: "foo",
            title: "Success",
            text: "Product created successfully!",
        }, 4000);
        fetchData(); // Refresh the list after creating a product
    } catch (error) {
        notify({
            group: "foo",
            title: "Error",
            text: "An error occurred while updating the product",
        }, 2000);
        console.error(error);
    }
};

// Handle delete product
const deleteProduct = async () => {
    try {
        await store.dispatch('products/deleteProduct', formEdit.id);
        notify({
            group: "foo",
            title: "Success",
            text: "Product deleted successfully!",
        }, 4000);
        deleteModalInstance.hide();
        fetchData(); // Refresh the list after deleting a product
    } catch (error) {
        notify({
            group: "foo",
            title: "Error",
            text: "An error occurred while deleting the product",
        }, 2000);
        console.error(error);
    }
};

// Drawer open/close logic
const openUpdateModal = async (voucherId) => {
    await store.dispatch('products/fetchProduct', voucherId);
    if (store.getters["products/singleProduct"]) {
        Object.assign(formEdit, store.getters["products/singleProduct"]);
        formEdit.is_topping = formEdit.is_topping === 1;
        updateDrawerInstance.show();
    }
};

const openDeleteModal = (productId) => {
    deleteModalInstance.show();
    formEdit.id = productId;
};

// Reset form fields
const resetForm = () => {
    form.name = '';
    form.description = '';
    form.image = '';
    form.status = 'active';
    form.price = 0;
    form.cost = 0;
    form.up_m_price = 0;
    form.up_l_price = 0;
    form.is_topping = false;
    form.team_id = null;
    form.categories_id = [];
    form.toppings_id = [];
};

// Initialize the drawer and other dependencies on mount
onMounted(() => {
    fetchData();
    initFlowbite();

    const $updateDrawer = document.getElementById('drawer-update-product');
    const $deleteModal = document.getElementById('delete-modal');
    const drawerOptions = {
        placement: 'left',
        backdrop: true,
        bodyScrolling: false,
        onHide: () => {
            console.log('Drawer is hidden');
            showDrawer.value = false; // Sync state when drawer is hidden
        },
        onShow: () => {
            console.log('Drawer is shown');
        },
    };
    const modalOptions = {
        placement: 'bottom-right',
        backdrop: 'dynamic',
        backdropClasses: 'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
        closable: true,
        onHide: () => {
            console.log('modal is hidden');
        },
        onShow: () => {
            console.log('modal is shown');
        },
        onToggle: () => {
            console.log('modal has been toggled');
        },
    };
    fetchCategoriesOptions();
    fetchToppingsOptions();
    // Initialize Drawer instance
    updateDrawerInstance = new Drawer($updateDrawer, drawerOptions);
    deleteModalInstance = new Modal($deleteModal, modalOptions);
});
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
