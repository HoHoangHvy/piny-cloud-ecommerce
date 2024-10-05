<script setup lang="ts">
import { ref } from 'vue'
import BreadcrumbDefault from '@/js/components/admin/Breadcrumbs/BreadcrumbDefault.vue'
import SettingsCard from '@/js/components/admin/SettingsCard.vue'
import AdminLayout from '@/js/layouts/AdminLayout.vue'

const pageTitle = ref('Settings Page')
</script>

<template>

    <div class="mx-auto max-w-270">
      <!-- Breadcrumb Start -->
      <BreadcrumbDefault :pageTitle="pageTitle" />
      <!-- Breadcrumb End -->
      <SettingsCard />
    </div>

</template>
