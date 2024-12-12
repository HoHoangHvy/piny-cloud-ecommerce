<script setup>
import {initFlowbite, Drawer, Modal} from 'flowbite';

const showDrawer = ref(false); // Reactive state for drawer visibility
let updateDrawerInstance = null; // Drawer instance
import Multiselect from "@vueform/multiselect";
import {onMounted, ref} from "vue";


onMounted(() => {
    initFlowbite();
    const $updateDrawer = document.getElementById('drawer-update-product');
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
    updateDrawerInstance = new Drawer($updateDrawer, drawerOptions);
})
</script>

<template>
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
                               placeholder="Size M">
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
</template>

<style scoped>

</style>
