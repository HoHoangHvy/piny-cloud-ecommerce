<script setup lang="ts">
import BreadcrumbDefault from '@/js/components/admin/Breadcrumbs/BreadcrumbDefault.vue'
import CheckboxFive from '@/js/components/admin/Forms/Checkboxes/CheckboxFive.vue'
import CheckboxFour from '@/js/components/admin/Forms/Checkboxes/CheckboxFour.vue'
import CheckboxOne from '@/js/components/admin/Forms/Checkboxes/CheckboxOne.vue'
import CheckboxThree from '@/js/components/admin/Forms/Checkboxes/CheckboxThree.vue'
import CheckboxTwo from '@/js/components/admin/Forms/Checkboxes/CheckboxTwo.vue'
import DatePickerOne from '@/js/components/admin/Forms/DatePicker/DatePickerOne.vue'
import DatePickerTwo from '@/js/components/admin/Forms/DatePicker/DatePickerTwo.vue'
import DefaultCard from '@/js/components/admin/Forms/DefaultCard.vue'
import SwitchFour from '@/js/components/admin/Forms/Switchers/SwitchFour.vue'
import SwitchOne from '@/js/components/admin/Forms/Switchers/SwitchOne.vue'
import SwitchThree from '@/js/components/admin/Forms/Switchers/SwitchThree.vue'
import SwitchTwo from '@/js/components/admin/Forms/Switchers/SwitchTwo.vue'
import AdminLayout from '@/js/layouts/AdminLayout.vue'

import { ref } from 'vue'
import MultiSelect from '@/js/components/admin/Forms/MultiSelect.vue'
import SelectGroupOne from '@/js/components/admin/Forms/SelectGroup/SelectGroupOne.vue'

const pageTitle = ref('Form Elements')
</script>

<template>

    <!-- Breadcrumb Start -->
    <BreadcrumbDefault :pageTitle="pageTitle" />
    <!-- Breadcrumb End -->

    <!-- ====== Form Elements Section Start -->
    <div class="grid grid-cols-1 gap-9 sm:grid-cols-2">
      <div class="flex flex-col gap-9">
        <!-- Input Fields Start -->
        <DefaultCard cardTitle="Input Fields">
          <div class="flex flex-col gap-5.5 p-6.5">
            <div>
              <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                Default Input
              </label>
              <input
                type="text"
                placeholder="Default Input"
                class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
              />
            </div>

            <div>
              <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                Active Input
              </label>
              <input
                type="text"
                placeholder="Active Input"
                class="w-full rounded-lg border-[1.5px] text-black border-primary bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:bg-form-input"
              />
            </div>

            <div>
              <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                Disabled label
              </label>
              <input
                type="text"
                placeholder="Disabled label"
                disabled
                class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary dark:disabled:bg-black"
              />
            </div>
          </div>
        </DefaultCard>
        <!-- Input Fields End -->

        <!-- Toggle switch input Start -->
        <DefaultCard cardTitle="Toggle switch input">
          <div class="flex flex-col gap-5.5 p-6.5">
            <SwitchOne />
            <SwitchTwo />
            <SwitchThree />
            <SwitchFour />
          </div>
        </DefaultCard>
        <!-- Toggle switch input End -->

        <!-- Time and date input Start -->
        <DefaultCard cardTitle="Time and date">
          <div class="flex flex-col gap-5.5 p-6.5">
            <DatePickerOne />

            <DatePickerTwo />
          </div>
        </DefaultCard>
        <!-- Time and date input End -->

        <!-- File upload input Start -->
        <DefaultCard cardTitle="File upload">
          <div class="flex flex-col gap-5.5 p-6.5">
            <div>
              <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                Attach file
              </label>
              <input
                type="file"
                class="w-full cursor-pointer rounded-lg border-[1.5px] border-stroke bg-transparent font-medium outline-none transition file:mr-5 file:border-collapse file:cursor-pointer file:border-0 file:border-r file:border-solid file:border-stroke file:bg-whiter file:py-3 file:px-5 file:hover:bg-primary file:hover:bg-opacity-10 focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:file:border-form-strokedark dark:file:bg-white/30 dark:file:text-white dark:focus:border-primary"
              />
            </div>

            <div>
              <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                Attach file
              </label>
              <input
                type="file"
                class="w-full rounded-md border border-stroke p-3 outline-none transition file:mr-4 file:rounded file:border-[0.5px] file:border-stroke file:bg-[#EEEEEE] file:py-1 file:px-2.5 file:text-sm file:font-normal focus:border-primary file:focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:file:border-strokedark dark:file:bg-white/30 dark:file:text-white"
              />
            </div>
          </div>
        </DefaultCard>
        <!-- File upload input End -->
      </div>

      <div class="flex flex-col gap-9">
        <!-- Textarea Fields Start -->
        <DefaultCard cardTitle="Textarea Fields">
          <div class="flex flex-col gap-5.5 p-6.5">
            <div>
              <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                Default textarea
              </label>
              <textarea
                rows="6"
                placeholder="Default textarea"
                class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
              ></textarea>
            </div>

            <div>
              <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                Active textarea
              </label>
              <textarea
                rows="6"
                placeholder="Active textarea"
                class="w-full rounded-lg border-[1.5px] text-black border-primary bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:bg-form-input"
              ></textarea>
            </div>

            <div>
              <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                Disabled textarea
              </label>
              <textarea
                rows="6"
                disabled
                placeholder="Disabled textarea"
                class="w-full rounded-lg border-[1.5px] text-black border-stroke bg-transparent py-3 px-5 font-normal outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:text-white dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary dark:disabled:bg-black"
              ></textarea>
            </div>
          </div>
        </DefaultCard>
        <!-- Textarea Fields End -->

        <!-- Checkbox and radio -->
        <DefaultCard cardTitle="Checkbox and radio">
          <div class="flex flex-col gap-5.5 p-6.5">
            <CheckboxOne />
            <CheckboxTwo />
            <CheckboxThree />
            <CheckboxFour />
            <CheckboxFive />
          </div>
        </DefaultCard>
        <!-- Checkbox and radio -->

        <!-- Select input Start -->
        <DefaultCard cardTitle="Select input">
          <div class="flex flex-col gap-5.5 p-6.5">
            <SelectGroupOne />

            <MultiSelect />
          </div>
        </DefaultCard>
        <!-- Select input End -->
      </div>
    </div>
    <!-- ====== Form Elements Section End -->

</template>
