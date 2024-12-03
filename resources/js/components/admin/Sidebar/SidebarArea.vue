<script setup lang="ts">
import {useSidebarStore} from '../../../store/sidebar.ts'
import {onClickOutside} from '@vueuse/core'
import {ref} from 'vue'
import SidebarItem from './SidebarItem.vue'
import {useI18n} from 'vue-i18n';
import LanguageSwitcher from '../languageSwitcher.vue';

const {t} = useI18n();
const target = ref(null)

const sidebarStore = useSidebarStore()

onClickOutside(target, () => {
    // sidebarStore.isSidebarOpen = false
})

const menuGroups = ref([
    {
        name: 'LBL_MODULES',
        menuItems: [
            {
                icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                </svg>
                `,
                label: 'LBL_DASHBOARD',
                route: '/admin/',
            },
            {
                icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                </svg>
                `,
                label: 'LBL_CALENDAR',
                route: '/admin/calendar'
            },
            {
                icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
                `,
                label: 'LBL_CUSTOMERS',
                route: '/admin/customers'
            },
            {
                icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                </svg>`,
                label: 'LBL_ORDERS',
                route: '/admin/orders'
            },
            {
                icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                </svg>
                `,
                label: 'LBL_EMPLOYEES',
                route: '/admin/employees'
            },
            {
                icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6.429 9.75 2.25 12l4.179 2.25m0-4.5 5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0 4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0-5.571 3-5.571-3" />
                </svg>
                `,
                label: 'LBL_PRODUCTS',
                route: '/admin/products'
            },
            {
                icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                `,
                label: 'LBL_VOUCHERS',
                route: '/admin/vouchers'
            },
        ]
    },
    {
        name: 'LBL_ADMIN_CONFIG',
        menuItems: [
            {
                icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v3.75c0 .621-.504 1.125-1.125 1.125h-6a1.125 1.125 0 0 1-1.125-1.125v-3.75ZM14.25 8.625c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-8.25ZM3.75 16.125c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-2.25Z" />
                </svg>
                `,
                label: 'LBL_TEAMS',
                route: '/admin/teams',
            },
            {
                icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.416 48.416 0 0 0 12 4.5c-2.291 0-4.545.16-6.75.47m13.5 0c1.01.143 2.01.317 3 .52m-3-.52 2.62 10.726c.122.499-.106 1.028-.589 1.202a5.988 5.988 0 0 1-2.031.352 5.988 5.988 0 0 1-2.031-.352c-.483-.174-.711-.703-.59-1.202L18.75 4.971Zm-16.5.52c.99-.203 1.99-.377 3-.52m0 0 2.62 10.726c.122.499-.106 1.028-.589 1.202a5.989 5.989 0 0 1-2.031.352 5.989 5.989 0 0 1-2.031-.352c-.483-.174-.711-.703-.59-1.202L5.25 4.971Z" />
                </svg>`,
                label: 'LBL_ROLES',
                route: '/admin/roles',
            },
            {
                icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>
                `,
                label: 'LBL_USER_MANAGEMENT',
                route: '/admin/users',
            }
        ]
    }
])
</script>

<template>
    <aside
        class="absolute left-0 top-0 z-99 flex h-screen w-72.5 flex-col bg-primary duration-300 ease-linear dark:bg-boxdark overflow-visible drop-shadow-3"
        :class="{
      'translate-x-0': sidebarStore.isSidebarOpen,
      '-translate-x-full': !sidebarStore.isSidebarOpen,
      'overflow-y-hidden': !sidebarStore.isSidebarOpen
    }"
        ref="target"
    >
        <!-- SIDEBAR HEADER -->
        <div class="flex items-center justify-center flex-col gap-2 px-6 py-5.5 lg:py-6.5 overflow-visible"
             style="padding-bottom: 0px !important;">
            <router-link to="/admin">
                <svg width="181" height="45" viewBox="0 0 181 45" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M12.5687 11.9422C12.5687 10.5982 11.8807 9.92619 10.5047 9.92619H7.81669V21.1102H10.5047C11.8807 21.1102 12.5687 20.4382 12.5687 19.0942V11.9422ZM0.568691 3.68619H11.4167C14.0087 3.68619 16.0407 4.31019 17.5127 5.55819C19.0167 6.80619 19.7687 8.64619 19.7687 11.0782V19.9582C19.7687 22.3902 19.0167 24.2302 17.5127 25.4782C16.0407 26.7262 14.0087 27.3502 11.4167 27.3502H7.81669V36.9502H0.568691V3.68619ZM26.7156 7.81419C24.0596 7.81419 22.7316 6.56619 22.7316 4.07019C22.7316 1.54219 24.0596 0.278193 26.7156 0.278193C29.4036 0.278193 30.7476 1.54219 30.7476 4.07019C30.7476 6.56619 29.4036 7.81419 26.7156 7.81419ZM23.1156 9.3982H30.3636V36.9502H23.1156V9.3982ZM41.5097 9.87819C43.2057 8.95019 44.9657 8.48619 46.7897 8.48619C48.6137 8.48619 50.0697 8.99819 51.1577 10.0222C52.2777 11.0142 52.8377 12.5182 52.8377 14.5342V36.9502H45.4937V16.3102C45.4937 15.5422 45.0777 15.1582 44.2457 15.1582C43.4137 15.1582 42.6457 15.3662 41.9417 15.7822V36.9502H34.6937V8.63019H41.5097V9.87819ZM68.8164 8.63019H75.7764L69.0564 44.1022H62.0484L63.3924 36.9502H60.8964L55.2324 8.63019H62.3364C63.8724 16.7902 64.7844 22.0542 65.0724 24.4222C65.3604 26.7582 65.5524 29.0302 65.6484 31.2382C65.8084 27.3662 66.3524 22.7902 67.2804 17.5102L68.8164 8.63019ZM86.8543 11.5582C86.8543 8.99819 87.7343 7.01419 89.4943 5.60619C91.2863 4.16619 93.9743 3.44619 97.5583 3.44619C99.9263 3.44619 101.942 3.67019 103.606 4.11819V10.7422C101.814 10.1982 100.038 9.92619 98.2783 9.92619C96.5503 9.92619 95.4303 10.1342 94.9183 10.5502C94.4063 10.9342 94.1503 11.5102 94.1503 12.2782V28.4062C94.1503 29.9422 95.3503 30.7102 97.7503 30.7102C100.182 30.7102 102.182 30.4702 103.75 29.9902V36.4702C102.022 36.9502 99.9263 37.1902 97.4623 37.1902C93.8783 37.1902 91.2063 36.4862 89.4463 35.0782C87.7183 33.6702 86.8543 31.6862 86.8543 29.1262V11.5582ZM107.116 1.09419H114.364V36.9502H107.116V1.09419ZM129.35 16.1182C129.35 14.9022 128.678 14.2942 127.334 14.2942C125.99 14.2942 125.318 14.9022 125.318 16.1182V29.4622C125.318 30.6782 125.99 31.2862 127.334 31.2862C128.678 31.2862 129.35 30.6782 129.35 29.4622V16.1182ZM118.214 15.8782C118.214 13.4462 118.966 11.5582 120.47 10.2142C122.006 8.83819 124.294 8.15019 127.334 8.15019C130.374 8.15019 132.646 8.83819 134.15 10.2142C135.686 11.5582 136.454 13.4462 136.454 15.8782V29.7022C136.454 32.1342 135.686 34.0382 134.15 35.4142C132.646 36.7582 130.374 37.4302 127.334 37.4302C124.294 37.4302 122.006 36.7582 120.47 35.4142C118.966 34.0382 118.214 32.1342 118.214 29.7022V15.8782ZM151.151 8.63019H158.399V36.9502H151.583V35.6542C150.015 36.5182 148.223 36.9502 146.207 36.9502C144.223 36.9502 142.703 36.4062 141.647 35.3182C140.591 34.2302 140.063 32.6622 140.063 30.6142V8.63019H147.407V29.1742C147.407 30.0062 147.871 30.4222 148.799 30.4222C149.727 30.4222 150.511 30.2302 151.151 29.8462V8.63019ZM173.317 15.0622H171.733C170.229 15.0622 169.477 15.8622 169.477 17.4622V29.3182C169.477 30.1502 169.957 30.5662 170.917 30.5662C171.877 30.5662 172.677 30.3742 173.317 29.9902V15.0622ZM173.269 1.09419H180.565V36.9502H173.509V34.9342C172.357 36.4062 170.709 37.1422 168.565 37.1422C166.453 37.1422 164.869 36.5662 163.813 35.4142C162.757 34.2622 162.229 32.6622 162.229 30.6142V17.2222C162.229 14.5342 162.965 12.4382 164.437 10.9342C165.909 9.39819 168.149 8.63019 171.157 8.63019H173.269V1.09419Z"
                        fill="white"/>
                </svg>
            </router-link>
            <button class="block absolute hide-sidebar-btn bg-white drop-shadow-4" @click="sidebarStore.isSidebarOpen = false">
                <svg
                    class="fill-current"
                    width="20"
                    height="18"
                    viewBox="0 0 20 18"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M19 8.175H2.98748L9.36248 1.6875C9.69998 1.35 9.69998 0.825 9.36248 0.4875C9.02498 0.15 8.49998 0.15 8.16248 0.4875L0.399976 8.3625C0.0624756 8.7 0.0624756 9.225 0.399976 9.5625L8.16248 17.4375C8.31248 17.5875 8.53748 17.7 8.76248 17.7C8.98748 17.7 9.17498 17.625 9.36248 17.475C9.69998 17.1375 9.69998 16.6125 9.36248 16.275L3.02498 9.8625H19C19.45 9.8625 19.825 9.4875 19.825 9.0375C19.825 8.55 19.45 8.175 19 8.175Z"
                        fill=""
                    />
                </svg>
            </button>
            <span class="text-white">{{ t('LBL_INTERNAL_MANAGEMENT') }}</span>
        </div>

        <!-- SIDEBAR HEADER -->

        <div class="no-scrollbar flex flex-col h-full overflow-y-auto duration-300 ease-linear">
            <!-- Sidebar Menu -->
            <nav class="mt-5 py-4 px-4 lg:mt-9 lg:px-6" style="margin-top: 0rem !important;">
                <template v-for="menuGroup in menuGroups" :key="menuGroup.name">
                    <div>
                        <h3 class="mb-4 ml-4 text-sm font-medium text-white">{{ t(menuGroup.name) }}</h3>

                        <ul class="mb-6 flex flex-col gap-1.5">
                            <SidebarItem
                                v-for="(menuItem, index) in menuGroup.menuItems"
                                :item="menuItem"
                                :key="index"
                                :index="index"
                            />
                        </ul>
                    </div>
                </template>
            </nav>
        </div>
    </aside>
</template>
<style>
.hide-sidebar-btn {
    border-radius: 50%;
    padding: 14px;
    top: 8.2%;
    right: -20px;
    transform: translateY(-50%)
}
</style>
