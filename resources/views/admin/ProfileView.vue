<script setup lang="ts">
import { ref } from 'vue'
import BreadcrumbDefault from '@/js/components/admin/Breadcrumbs/BreadcrumbDefault.vue'
import ProfileCard from '@/js/components/admin/ProfileCard.vue'
import AdminLayout from '@/js/layouts/AdminLayout.vue'

const pageTitle = ref('Profile')
</script>

<template>

    <div class="mx-auto max-w-242.5">
      <!-- Breadcrumb Start -->
      <BreadcrumbDefault :pageTitle="pageTitle" />
      <!-- Breadcrumb End -->
      <ProfileCard />
    </div>

</template>
