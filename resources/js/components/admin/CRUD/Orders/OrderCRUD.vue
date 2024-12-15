<template>
    <!-- Start block -->
    <section class="p-3 sm:p-5 antialiased h-full w-full">
        <div class="mx-auto max-w-screen-2xl px-4 lg:px-12">
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <div class="flex-1 flex items-center space-x-2">
                        <h5>
                            <span class="text-gray-500">{{$lang('LBL_ALL_ORDER')}}: </span>
                            <span class="dark:text-white">123456</span>
                        </h5>
                        <h5 class="text-gray-500 dark:text-gray-400 ml-1">1-100 (436)</h5>
                        <button type="button" class="group" data-tooltip-target="results-tooltip">
                            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" viewbox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                            <span class="sr-only">More info</span>
                        </button>
                        <div id="results-tooltip" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                            Showing 1-100 of 436 results
                            <div class="tooltip-arrow" data-popper-arrow=""></div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row items-stretch md:items-center md:space-x-3 space-y-3 md:space-y-0 justify-between mx-4 py-4 border-t dark:border-gray-700">
                    <div class="w-full md:w-1/2">
                        <form class="flex items-center">
                            <label for="simple-search" class="sr-only">Search</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" />
                                    </svg>
                                </div>
                                <input type="text" id="simple-search" placeholder="Search for Orders" required="" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            </div>
                        </form>
                    </div>
                    <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                        <button v-show="store.getters.hasPermission({'module': moduleName, 'action': 'create'})" type="button" id="createOrderButton" data-modal-target="create-Order-modal" data-modal-toggle="create-Order-modal" class="flex items-center justify-center text-white bg-primary hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary focus:outline-none dark:focus:ring-primary-800">
                            <svg class="h-3.5 w-3.5 mr-1.5 -ml-1" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                            </svg>
                            Add Order
                        </button>
                        <button @click="triggerNoti" id="filterDropdownButton" data-dropdown-toggle="filterDropdown" class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-600 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="h-4 w-4 mr-1.5 -ml-1 text-gray-400" viewbox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                            </svg>
                            Filter options
                            <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                            </svg>
                        </button>
                        <div id="filterDropdown" class="z-10 hidden px-3 pt-1 bg-white rounded-lg shadow w-80 dark:bg-gray-700 right-0">
                            <div class="flex items-center justify-between pt-2">
                                <h6 class="text-sm font-medium text-black dark:text-white">Filters</h6>
                                <div class="flex items-center space-x-3">
                                    <a href="#" class="flex items-center text-sm font-medium text-primary-600 dark:text-primary-500 hover:underline">Save view</a>
                                    <a href="#" class="flex items-center text-sm font-medium text-primary-600 dark:text-primary-500 hover:underline">Clear all</a>
                                </div>
                            </div>
                            <div class="pt-3 pb-2">
                                <label for="input-group-search" class="sr-only">Search</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input type="text" id="input-group-search" class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Search keywords...">
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3 w-full md:w-auto">
                            <button id="actionsDropdownButton" data-dropdown-toggle="actionsDropdown" class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-600 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">
                                Actions
                                <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                </svg>
                            </button>
                            <div id="actionsDropdown" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="actionsDropdownButton">
                                    <li>
                                        <a href="#" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Mass Edit</a>
                                    </li>
                                </ul>
                                <div class="py-1">
                                    <a href="#" class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete all</a>
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
                                    <input id="checkbox-all" type="checkbox" class="w-4 h-4 text-primary-600 bg-gray-100 rounded border-gray-300 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="checkbox-all" class="sr-only">checkbox</label>
                                </div>
                            </th>
                            <th scope="col" class="p-4">Order</th>
                            <th scope="col" class="p-4">Customer</th>
                            <th scope="col" class="p-4">Team</th>
                            <th scope="col" class="p-4">Total</th>
                            <th scope="col" class="p-4">Status</th>
                            <th scope="col" class="p-4">Create At</th>
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
                                    <input id="checkbox-table-search-1" type="checkbox" onclick="event.stopPropagation()" class="w-4 h-4 text-primary-600 bg-gray-100 rounded border-gray-300 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                </div>
                            </td>
                            <td class="p-4">{{ item.order_number }}</td>
                            <td class="p-4">{{ item.host_id }}</td>
                            <td class="p-4">{{ item.team_name }}</td>
                            <td class="p-4">{{ item.order_total }}</td>
                            <td class="p-4">{{ item.order_status }}</td>
                            <td class="p-4">{{ formatDateTime(item.created_at) }}</td>
                            <td class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <div class="flex items-center space-x-3 justify-end">
                                    <button v-show="store.getters.hasPermission({'module': moduleName, 'action': 'edit', 'created_by': item.created_by})" type="button" @click="openUpdateModal(item.id)" data-drawer-target="drawer-update-order" data-drawer-show="drawer-update-order"  class="py-2 px-3 flex items-center text-sm font-medium text-center text-white bg-primary rounded-lg hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary dark:focus:ring-primary-800">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewbox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                            <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <button v-show="store.getters.hasPermission({'module': moduleName, 'action': 'delete', 'created_by': item.created_by})" type="button" @click="openDeleteModal(item.id)" class="flex items-center text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-2 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewbox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="store.getters['Orders/isLoading']">
                            <td colspan="8" class="p-4 text-center">Loading...</td>
                        </tr>
                        <tr v-if="!store.getters['Orders/isLoading'] && list.length === 0">
                            <td colspan="8" class="p-4 text-center">No data available.</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4" aria-label="Table navigation">
                <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                    Showing
                    <span class="font-semibold text-gray-900 dark:text-white">1-10</span>
                    of
                    <span class="font-semibold text-gray-900 dark:text-white">1000</span>
                </span>
                    <ul class="inline-flex items-stretch -space-x-px">
                        <li>
                            <a href="#" class="flex items-center justify-center h-full py-1.5 px-3 ml-0 text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <span class="sr-only">Previous</span>
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">1</a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">2</a>
                        </li>
                        <li>
                            <a href="#" aria-current="page" class="flex items-center justify-center text-sm z-10 py-2 px-3 leading-tight text-primary-600 bg-primary-50 border border-primary-300 hover:bg-primary-100 hover:text-blue-600 dark:border-gray-700 dark:bg-gray-700 dark:text-white">3</a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">...</a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">100</a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center justify-center h-full py-1.5 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <span class="sr-only">Next</span>
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </section>
    <!-- End block -->
    <div id="create-Order-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-999 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] md:h-full">
        <div class="relative p-4 w-full max-w-3xl h-full md:h-auto z-9999">
            <!-- Modal content -->
            <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                <!-- Modal header -->
                <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Add Order</h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="create-Order-modal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form @submit.prevent="handleCreateOrder" class="max-h-[calc(100vh-100px)] overflow-y-auto">
                    <div class="grid gap-4 mb-4 sm:grid-cols-2">
                        <div>
                            <label for="customer_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Customer</label>
                            <select v-model="form.customer_id" id="customer_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                <option v-for="customer in store.getters['customers/allCustomers']" :value="customer.id" :key="customer.id">{{ customer.full_name }}</option>
                            </select>
                        </div>
                        <div>
                            <label for="team_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Team</label>
                            <select v-model="form.team_id" id="team_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                <option v-for="team in store.getters['teams/allTeamsOption']" :value="team.id" :key="team.id">{{ team.name }}</option>
                            </select>
                        </div>
                        <div>
                            <label for="receiver_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Receiver Name</label>
                            <input v-model="form.receiver_name" type="text" id="receiver_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Receiver Name" required>
                        </div>
                        <div>
                            <label for="receiver_address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Receiver Address</label>
                            <input v-model="form.receiver_address" type="text" id="receiver_address" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Receiver Address" required>
                        </div>
                        <div>
                            <label for="payment_method" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Payment Method</label>
                            <select v-model="form.payment_method" id="payment_method" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                <option value="Cash">Cash</option>
                                <option value="Bank">Bank</option>
                            </select>
                        </div>
                        <div>
                            <label for="payment_status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Payment Status</label>
                            <select v-model="form.payment_status" id="payment_status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                <option value="pending">Pending</option>
                                <option value="paid">Paid</option>
                            </select>
                        </div>
                        <div>
                            <label for="order_status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Order Status</label>
                            <select v-model="form.order_status" id="order_status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                <option value="Draft">Draft</option>
                                <option value="Wait For Approval">Wait For Approval</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Delivering">Delivering</option>
                                <option value="Delivered">Delivered</option>
                                <option value="Completed">Completed</option>
                                <option value="Cancelled">Cancelled</option>

                            </select>
                        </div>
                        <div>
                            <label for="source" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Source</label>
                            <select v-model="form.source" id="source" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                <option value="Online">Online</option>
                                <option value="Offline">Offline</option>
                            </select>
                        </div>
                        <div>
                            <label for="products" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Products</label>
                            <button type="button" @click="openProductModal" class="w-full justify-center sm:w-auto text-gray-500 inline-flex items-center bg-green hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                Add Product
                            </button>
                        </div>
                        <!-- Add Product Modal -->
                        <div v-if="showProductModal" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75">
                            <div class="bg-white rounded-lg shadow-lg w-4/5 p-6">
                                <h2 class="text-xl font-bold mb-4">Select Product</h2>
                                <div class="mb-4">
                                    <input
                                        v-model="searchQuery"
                                        type="text"
                                        placeholder="Search products..."
                                        class="w-full p-2 border border-gray-300 rounded-lg text-sm focus:ring-primary-500 focus:border-primary-500"
                                    />
                                </div>
                                <!-- Danh sách sản phẩm -->
                                <div class="grid gap-4 mb-4 sm:grid-cols-2">
                                    <div v-for="product in availableProducts" :key="product.id" class="flex items-center space-x-4">
                                        <div>
                                            <input
                                                type="radio"
                                                :value="product.id"
                                                v-model="selectedProduct"
                                                class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500"
                                            />
                                        </div>
                                        <div class="w-full flex items-center space-x-4">
                                            <div class="flex-1">
                                                <p class="font-medium">{{ product.name }}</p>
                                                <p class="text-sm text-gray-500">Price: {{ product.price }}</p>
                                            </div>
                                            <input
                                                type="number"
                                                v-model.number="productQuantities[product.id]"
                                                min="1"
                                                placeholder="Qty"
                                                class="mt-2 w-20 p-1 border border-gray-300 rounded ml-auto"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <!-- Phân trang -->
                                <div class="flex items-center justify-center space-x-4 mt-20">
                                    <button
                                        @click="goToPage(currentPage - 1)"
                                        :disabled="currentPage === 1"
                                        class="w-24 h-10 text-base bg-gray-500 text-white rounded-lg hover:bg-gray-600 disabled:bg-gray-300 disabled:cursor-not-allowed flex justify-center items-center"
                                    >
                                        Previous
                                    </button>
                                    <span class="text-base font-medium">Page {{ currentPage }} of {{ totalPages }}</span>
                                    <button
                                        @click="goToPage(currentPage + 1)"
                                        :disabled="currentPage === totalPages"
                                        class="w-24 h-10 text-base bg-gray-500 text-white rounded-lg hover:bg-gray-600 disabled:bg-gray-300 disabled:cursor-not-allowed flex justify-center items-center"
                                    >
                                        Next
                                    </button>
                                </div>
                                <!-- Nút hành động -->
                                <div class="flex justify-end space-x-4 mt-4">
                                    <button
                                        @click="closeProductModal"
                                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 disabled:opacity-50 disabled:cursor-not-allowed"
                                    >
                                        Cancel
                                    </button>
                                    <button
                                        @click="confirmProductSelection"
                                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 disabled:opacity-50 disabled:cursor-not-allowed"
                                    >
                                        Confirm
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Hiển thị sản phẩm đã chọn ở đây -->
                        <div class="col-span-2 mt-4">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Selected Products:</label>
                            <div v-for="(product, index) in this.selectedProducts" :key="index" class="border rounded p-2 mb-2">
                                <p class="font-medium">{{ product.product.name }} (Quantity: {{ product.quantity }}) x  {{ product.product.price }}</p>
                                <ul>
                                    <li v-for="topping in product.toppings" :key="topping.id" class="text-sm text-gray-700">
                                        Topping: {{ getToppingName(topping.id) }} (Quantity: {{ topping.quantity }}) x {{ getToppingPrice(topping.id) }}
                                    </li>
                                </ul>
                            </div>
                        </div>

<!--                        <div>-->
<!--                            <label for="voucher_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Voucher</label>-->
<!--                            <select v-model="form.voucher_id" id="voucher_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>-->
<!--                                <option v-for="voucher in store.getters['vouchers/allTeamsOption']" :value="voucher.id" :key="voucher.id">{{ voucher.name }}</option>-->
<!--                            </select>-->
<!--                        </div>-->
                        <div
                            id="total"
                            class="text-lg font-semibold text-gray-900 dark:text-white"
                        >
                            Total:
                            <input
                                type="number"
                                id="total"
                                v-model="total"
                                readonly
                            />
                        </div>

                        <!-- Topping Modal -->
                        <div v-if="showToppingModal" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75">
                            <div class="bg-white rounded-lg shadow-lg w-4/5 p-6">
                                <h2 class="text-xl font-bold mb-4">Select Toppings</h2>
                                <div class="grid gap-4 mb-4 sm:grid-cols-2">
                                    <div v-for="topping in paginatedToppings" :key="topping.id" class="flex items-center space-x-4">
                                        <div>
                                            <input
                                                type="checkbox"
                                                :value="topping.id"
                                                v-model="selectedToppings"
                                                class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500"
                                            />
                                        </div>
                                        <div class="w-full flex items-center space-x-4">
                                            <div class="flex-1">
                                                <p class="font-medium">{{ topping.name }}</p>
                                                <p class="text-sm text-gray-500">Price: {{ topping.price }}</p>
                                            </div>
                                            <input
                                                type="number"
                                                v-model.number="toppingQuantities[topping.id]"
                                                min="1"
                                                placeholder="Qty"
                                                class="mt-2 w-20 p-1 border border-gray-300 rounded ml-auto"
                                            />
                                        </div>

                                    </div>
                                </div>

                                <!-- Pagination Controls for Toppings -->
                                <div class="flex items-center justify-center space-x-4 mt-4">
                                    <button
                                        @click="goToToppingPage(currentToppingPage - 1)"
                                        :disabled="currentToppingPage === 1"
                                        class="w-24 h-10 text-base bg-gray-500 text-white rounded-lg hover:bg-gray-600 disabled:bg-gray-300 disabled:cursor-not-allowed flex justify-center items-center"
                                    >
                                        Previous
                                    </button>
                                    <span class="text-base font-medium">Page {{ currentToppingPage }} of {{ totalToppingPages }}</span>
                                    <button
                                        @click="goToToppingPage(currentToppingPage + 1)"
                                        :disabled="currentToppingPage === totalToppingPages"
                                        class="w-24 h-10 text-base bg-gray-500 text-white rounded-lg hover:bg-gray-600 disabled:bg-gray-300 disabled:cursor-not-allowed flex justify-center items-center"
                                    >
                                        Next
                                    </button>
                                </div>

                                <div class="flex justify-end space-x-4 mt-4">
                                    <button
                                        @click="closeToppingModal"
                                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 disabled:opacity-50 disabled:cursor-not-allowed"
                                    >
                                        Cancel
                                    </button>
                                    <button
                                        @click="confirmToppingSelection"
                                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 disabled:opacity-50 disabled:cursor-not-allowed"
                                    >
                                        Confirm
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="items-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4">
                        <button type="submit"
                                class="w-full sm:w-auto justify-center text-white inline-flex bg-primary hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary dark:focus:ring-primary-800">
                            Add order
                        </button>
                        <button data-modal-toggle="create-employee-modal" type="button"
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
    <!-- drawer component -->
    <form action="#" id="drawer-update-order" class="fixed top-0 left-0 z-999 w-full h-screen max-w-3xl p-4 overflow-y-auto transition-transform -translate-x-full bg-white dark:bg-gray-800" tabindex="-1" aria-labelledby="drawer-update-order-label" aria-hidden="true">
        <h5 id="drawer-label" class="inline-flex items-center mb-6 text-sm font-semibold text-gray-500 uppercase dark:text-gray-400">Edit Order</h5>
        <button type="button" data-drawer-dismiss="drawer-update-order" aria-controls="drawer-update-order" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
            <span class="sr-only">Close menu</span>
        </button>
        <div class="grid gap-4 sm:grid-cols-1 sm:gap-6 ">
            <div class="grid gap-4 mb-4 sm:grid-cols-2">
                <div class="grid gap-4 sm:col-span-2 md:gap-6 sm:grid-cols-1">
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Order Name</label>
                        <input v-model="formEdit.name" type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Type Order name" required="">
                    </div>
                    <div>
                        <label for="address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address</label>
                        <input v-model="formEdit.address" type="text" name="brand" id="brand" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Order Address" required="">
                    </div>
                </div>
                <div class="grid gap-4 sm:col-span-2 md:gap-6 sm:grid-cols-3">
                    <div>
                        <label for="ward" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ward</label>
                        <input v-model="formEdit.ward" type="text" name="price" id="price" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Ward" required="">
                    </div>
                    <div>
                        <label for="state" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">State</label>
                        <input v-model="formEdit.state" type="text" name="brand" id="brand" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="State" required="">
                    </div>
                    <div>
                        <label for="city" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">City</label>
                        <input v-model="formEdit.city" type="text" name="price" id="price" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="City" required="">
                    </div>
                </div>
                <div class="sm:col-span-2"><label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label><textarea v-model="formEdit.description" id="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Write Order description here"></textarea></div>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4 mt-6 sm:w-1/2">
            <button @click="updateOrder" type="submit" class="text-white bg-primary hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary dark:focus:ring-primary-800">Update Order</button>
            <button @click="deletOrder" type="button" class="text-red-600 inline-flex justify-center items-center hover:text-white border border-red-600 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                <svg aria-hidden="true" class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                Delete
            </button>
        </div>
    </form>
    <!-- Delete Modal -->
    <div id="delete-modal" tabindex="-1" class="fixed top-0 left-0 right-0 z-999 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full justify-center items-center">
        <div class="relative w-full h-auto max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="delete-modal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-6 text-center">
                    <svg aria-hidden="true" class="mx-auto mb-4 text-gray-400 w-14 h-14 dark:text-gray-200" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete this Order?</h3>
                    <button data-modal-toggle="delete-modal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">Yes, I'm sure</button>
                    <button data-modal-toggle="delete-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No, cancel</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { reactive, ref, onMounted } from 'vue';
import { useStore } from 'vuex';
import { initFlowbite, Drawer, Modal } from 'flowbite';
import { notify } from 'notiwind';
import { formatDateTime } from "@/js/helpers/dateFormat.js";

const store = useStore();
const list = ref([]);
const showDrawer = ref(false); // Reactive state for drawer visibility
let updateDrawerInstance = null; // Drawer instance
let deleteModalInstance = null; // Modal instance

const moduleName = 'orders'; // Module name for the CRUD operations

// Reactive form data
const form = reactive({
    host_id: '',
    team_id: '',
    receiver_name: '',
    receiver_address: '',
    payment_method: '',
    source: '',
    order_total: ''
});
const formEdit = reactive({
    id: null,
    name: '',
    address: '',
    city: '',
    state: '',
    ward: '',
    description: '',
});

const fetchTeamOptions = async () => {
    try {
        await store.dispatch('teams/fetchTeamOptions');
    } catch (error) {
        console.error("Failed to fetch teams:", error);
    }
}
// Fetch Orders data from Vuex store
const fetchData = async () => {
    try {
        await store.dispatch('orders/fetchOrders');

        list.value = store.state.orders.orders; // Adjusted based on the store state
    } catch (error) {
        console.error("Failed to fetch orders:", error);
    }
};

// Handle create Order
const handleCreateOrder = async () => {
    try {php
        await store.dispatch('orders/createOrder', { ...form });
        notify({
            group: "foo",
            title: "Success",
            text: "Order created successfully!",
        }, 4000);
        resetForm();
        fetchData(); // Refresh the list after creating an order
    } catch (error) {
        notify({
            group: "foo",
            title: "Error",
            text: "An error occurred while creating the order.",
        }, 2000);
        console.error(error);
    }
};
 const triggerNoti = () => {
        notify({
            group: "foo",
            title: "Success",
            text: "Order created successfully!",
        }, 4000);
    }
// Handle update Order
const handleUpdateOrder = async () => {
    try {
        await store.dispatch('Orders/updateOrder', {
            id: formEdit.id,
            orderData: { ...formEdit },
        });
        notify({
            group: "foo",
            title: "Success",
            text: "Order updated successfully!",
        }, 4000);
        fetchData();
        updateDrawerInstance.hide(); // Close the update drawer
    } catch (error) {
        notify({
            group: "foo",
            title: "Error",
            text: "An error occurred while updating the order.",
        }, 2000);
        console.error(error);
    }
};

// Drawer open/close logic
const openUpdateModal = (order) => {
    formEdit.id = order.id;
    formEdit.name = order.name;
    formEdit.address = order.address;
    formEdit.city = order.city;
    formEdit.state = order.state;
    formEdit.ward = order.ward;
    formEdit.description = order.description;
    if (updateDrawerInstance) {
        updateDrawerInstance.show();
    }
};

// Delete Order
const handleDeleteOrder = async (id) => {
    try {
        await store.dispatch('Orders/deleteOrder', id);
        notify({
            group: "foo",
            title: "Success",
            text: "Order deleted successfully!",
        }, 4000);
        fetchData();
        deleteModalInstance.hide();
    } catch (error) {
        notify({
            group: "foo",
            title: "Error",
            text: "An error occurred while deleting the order.",
        }, 2000);
        console.error(error);
    }
};

// Reset form fields
const resetForm = () => {
    form.name = '';
    form.address = '';
    form.city = '';
    form.state = '';
    form.ward = '';
    form.description = '';
};

// Initialize the drawer and modal instances
onMounted(() => {
    fetchTeamOptions();
    fetchData();
    initFlowbite();

    const $updateDrawer = document.getElementById('drawer-update-order');
    const $deleteModal = document.getElementById('delete-modal');
    const drawerOptions = {
        placement: 'left',
        backdrop: true,
        bodyScrolling: false,
        onHide: () => (showDrawer.value = false),
    };
    const modalOptions = {
        backdrop: 'dynamic',
        closable: true,
    };

    updateDrawerInstance = new Drawer($updateDrawer, drawerOptions);
    deleteModalInstance = new Modal($deleteModal, modalOptions);
});
</script>

<script>
export default {
    data() {
        return {
            host_id:'',
            team_id:'',
            receiver_name:'',
            receiver_address:'',
            source:'',
            payment_method:'',
            voucher_id:'',
            total:0,
            showProductModal: false,
            showToppingModal: false,
            availableProducts: [], // Sản phẩm hiển thị trong modal
            selectedProducts: [],
            selectedProduct: null, // Sản phẩm được chọn
            selectedToppings: [], // Danh sách topping được chọn
            productQuantities: {},// Số lượng sản phẩm theo ID
            toppingQuantities: {},
            currentPage: 1, // Trang hiện tại
            totalPages: 1, // Tổng số trang
            itemsPerPage: 10, // Số sản phẩm mỗi trang
            searchQuery: '',
            currentToppingPage: 1,
            itemsPerToppingPage: 10,
        };
    },
    computed: {
        allProducts() {
            return this.$store.getters['products/allProducts'];
        },
        filteredProducts() {
            // Lọc sản phẩm theo từ khóa tìm kiếm
            return this.allProducts.filter(product =>
                product.name.toLowerCase().includes(this.searchQuery.toLowerCase())
            );
        },
        availableProducts() {
            // Lấy sản phẩm hiện có theo phân trang và tìm kiếm
            const start = (this.currentPage - 1) * this.itemsPerPage;
            const end = start + this.itemsPerPage;
            return this.filteredProducts.slice(start, end);
        },
        availableToppings() {
            return this.$store.getters['products/toppingsOption'];
        },
        totalToppingPages() {
            return Math.ceil(this.availableToppings.length / this.itemsPerToppingPage);
        },
        paginatedToppings() {
            const start = (this.currentToppingPage - 1) * this.itemsPerToppingPage;
            return this.availableToppings.slice(start, start + this.itemsPerToppingPage);
        },
        orderTotal() {
            return this.selectedProducts.reduce((total, product) => {
                const productTotal = product.quantity * product.product.price;
                const toppingTotal = product.toppings.reduce((toppingSum, topping) => {
                    const toppingPrice = this.getToppingPrice(topping.id); // Hàm lấy giá topping
                    return toppingSum + topping.quantity * toppingPrice;
                }, 0);
                return total + productTotal + toppingTotal;
            }, 0);
        },
    },
    watch: {
        allProducts: {
            immediate: true,
            handler() {
                this.calculatePagination();
            },
        },
        searchQuery: {
            handler() {
                this.calculatePagination(); // Tính toán lại phân trang khi thay đổi từ khóa tìm kiếm
            },
        },
        selectedProducts: {
            handler() {
                this.total = this.orderTotal; // Cập nhật tổng khi selectedProducts thay đổi
            },
            deep: true,
        },
    },
    methods: {

        calculatePagination() {
            const totalItems = this.filteredProducts.length; // Sử dụng filteredProducts
            this.totalPages = Math.ceil(totalItems / this.itemsPerPage);
            this.currentPage = 1; // Reset về trang 1 khi tìm kiếm
        },
        goToPage(page) {
            if (page < 1 || page > this.totalPages) return;
            this.currentPage = page;
        },
        openProductModal() {
            this.showProductModal = true;
            this.calculatePagination(); // Tính toán phân trang khi mở modal
        },
        closeProductModal() {
            this.showProductModal = false;
        },
        confirmProductSelection() {
            const product = this.$store.getters['products/allProducts'].find(p => p.id === this.selectedProduct);
            const quantity = this.productQuantities[this.selectedProduct] || 1; // Mặc định số lượng là 1 nếu không nhập

            if (product) {
                this.selectedProducts.push({
                    product,
                    quantity,
                    toppings: [] // Khởi tạo danh sách topping cho sản phẩm
                });
                this.openToppingModal(); // Reset modal cho lần chọn tiếp theo
            } else {
                alert('Please select a product before confirming.');
            }
        },
        resetProductModal() {
            this.selectedProduct = null;
            this.productQuantities = {}; // Đặt lại số lượng cho lần chọn tiếp theo
        },
        openToppingModal() {
            this.showToppingModal = true;
        },
        closeToppingModal() {
            this.showToppingModal = false;
        },
        goToToppingPage(page) {
            if (page < 1 || page > this.totalToppingPages) return; // Validate page number
            this.currentToppingPage = page;
        },
        confirmToppingSelection() {
            const selectedProduct = this.selectedProducts[this.selectedProducts.length - 1]; // Lấy sản phẩm cuối cùng đã được thêm
            if (selectedProduct) {
                this.selectedToppings.forEach(toppingId => {
                    const quantity = this.toppingQuantities[toppingId] || 1; // Mặc định số lượng là 1 nếu không nhập
                    selectedProduct.toppings.push({
                        id: toppingId,
                        quantity: quantity
                    });
                });
                this.resetToppingModal();
                this.resetProductModal(); // Reset modal
                this.closeToppingModal();
                this.closeProductModal();
            } else {
                alert('Please select a product before adding toppings.');
            }
        },
        resetToppingModal() {
            this.selectedToppings = [];
            this.toppingQuantities = {}; // Đặt lại số lượng cho topping
            this.showToppingModal = false; // Đóng modal topping
        },
        getToppingName(toppingId) {
            const topping = this.$store.getters['products/toppingsOption'].find(t => t.id === toppingId);
            return topping ? topping.name : 'Unknown Topping';
        },
        getToppingPrice(toppingId) {
            const topping = this.$store.getters['products/allProducts'].find(t => t.id === toppingId);
            return topping ? topping.price : 'Unknown Topping';
        },
    },
};
</script>
