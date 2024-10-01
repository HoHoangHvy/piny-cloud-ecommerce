<script setup lang="ts">
import { ref } from 'vue'
import BreadcrumbDefault from '@/js/components/admin/Breadcrumbs/BreadcrumbDefault.vue'
import CalendarCard from '@/js/components/admin/CalendarCard.vue'
import AdminLayout from '@/js/layouts/AdminLayout.vue'

const pageTitle = ref('Calender')
</script>

<template>
    <div class="mx-auto max-w-7xl">
      <!-- Breadcrumb Start -->
      <BreadcrumbDefault :pageTitle="pageTitle" />
      <!-- Breadcrumb End -->
      <CalendarCard />
    </div>
</template>
