<script setup lang="ts">
import { ref } from 'vue'
import BreadcrumbDefault from '@/js/components/admin/Breadcrumbs/BreadcrumbDefault.vue'
import TableOne from '@/js/components/admin/Tables/TableOne.vue'
import TableTwo from '@/js/components/admin/Tables/TableTwo.vue'
import TableThree from '@/js/components/admin/Tables/TableThree.vue'
import AdminLayout from '@/js/layouts/AdminLayout.vue'

const pageTitle = ref('Tables')
</script>

<template>

    <!-- Breadcrumb Start -->
    <BreadcrumbDefault :pageTitle="pageTitle" />
    <!-- Breadcrumb End -->

    <div class="flex flex-col gap-10">
      <TableOne />
      <TableTwo />
      <TableThree />
    </div>

</template>
