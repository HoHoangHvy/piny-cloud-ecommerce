<script setup lang="ts">
import HeaderArea from '../components/admin/Header/HeaderArea.vue'
import SidebarArea from '../components/admin/Sidebar/SidebarArea.vue'
</script>

<template>
  <!-- ===== Page Wrapper Start ===== -->
  <div class="flex h-screen overflow-hidden">
    <SidebarArea />
    <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">
      <HeaderArea />
      <main>
        <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
          <router-view></router-view>
        </div>
      </main>
    </div>
  </div>
</template>
