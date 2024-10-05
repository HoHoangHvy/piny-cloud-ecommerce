<script setup lang="ts">
import BreadcrumbDefault from '@/js/components/admin/Breadcrumbs/BreadcrumbDefault.vue'
import ChartOne from '@/js/components/admin/Charts/ChartOne.vue'
import ChartThree from '@/js/components/admin/Charts/ChartThree.vue'
import ChartTwo from '@/js/components/admin/Charts/ChartTwo.vue'
import AdminLayout from '@/js/layouts/AdminLayout.vue'

import { ref } from 'vue'

const pageTitle = ref('Basic Chart')
</script>

<template>

    <!-- Breadcrumb Start -->
    <BreadcrumbDefault :pageTitle="pageTitle" />
    <!-- Breadcrumb End -->

    <div class="grid grid-cols-12 gap-4 md:gap-6 2xl:gap-7.5">
      <!-- ====== Chart One Start -->
      <ChartOne />
      <!-- ====== Chart One End -->

      <!-- ====== Chart Two Start -->
      <ChartTwo />
      <!-- ====== Chart Two End -->

      <!-- ====== Chart Three Start -->
      <ChartThree />
      <!-- ====== Chart Three End -->
    </div>

</template>
