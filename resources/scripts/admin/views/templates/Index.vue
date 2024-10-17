<template>
    <BasePage>
      <BasePageHeader :title="$t('templates.title')">
        <BaseBreadcrumb>
          <BaseBreadcrumbItem :title="$t('general.home')" to="dashboard" />
          <BaseBreadcrumbItem :title="$t('templates.template', 2)" to="#" active />
        </BaseBreadcrumb>
      </BasePageHeader>
  
      <!-- Templates Section  -->
      <div v-if="templateStore.templates">
        <BaseTabGroup class="-mb-5" @change="setStatusFilter">
          <BaseTab :title="$t('general.all')" filter="" />
          <BaseTab :title="$t('templates.installed')" filter="INSTALLED" />
        </BaseTabGroup>
  
        <!-- Templates Card Placeholder  -->
        <div
          v-if="isFetchingTemplate"
          class="
            grid
            mt-6
            w-full
            grid-cols-1
            items-start
            gap-6
            lg:grid-cols-2
            xl:grid-cols-3
          "
        >
        </div>
  
        <!-- Templates Card  -->
        <div v-else>
          <div
            v-if="templates && templates.length"
            class="
              grid
              mt-6
              w-full
              grid-cols-1
              items-start
              gap-6
              lg:grid-cols-2
              xl:grid-cols-3
            "
          >

          </div>
          <div v-else class="mt-24">
            <label class="flex items-center justify-center text-gray-500">
              {{ $t('templates.no_templates_installed') }}
            </label>
          </div>
        </div>
      </div>

    </BasePage>
  </template>
  
  <script setup>
  import { useTemplateStore } from '@/scripts/admin/stores/template'
  import { computed, ref } from 'vue'
  
  const templateStore = useTemplateStore()

  </script>
  