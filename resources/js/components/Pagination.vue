<template>
  <nav class="flex items-center justify-end space-x-2">
    <a
      class="p-4 inline-flex items-center gap-2 rounded-md"
      :class="[
        pagination.page > 1
          ? 'text-gray-400 hover:text-blue-800 cursor-pointer'
          : 'pointer-events-none text-gray-400 opacity-50',
      ]"
      @click="pagination.page -= 1"
    >
      <span aria-hidden="true">«</span>
      <span>Previous</span>
    </a>
    <a
      v-for="page in pagination.totalPage"
      :key="page"
      class="
        w-10
        h-10
        p-4
        inline-flex
        items-center
        text-sm
        font-medium
        rounded-full
      "
      :class="[
        page === pagination.page
          ? 'bg-blue-800 text-white'
          : 'text-gray-500 hover:text-blue-800 cursor-pointer',
      ]"
      aria-current="page"
      @click.prevent="pagination.page = page"
      >{{ page }}</a
    >
    <a
      class="p-4 inline-flex items-center gap-2 rounded-md"
      :class="[
        pagination.page < pagination.totalPage
          ? 'text-gray-400 hover:text-blue-800 cursor-pointer'
          : 'pointer-events-none text-gray-400 opacity-50',
      ]"
      @click="pagination.page += 1"
    >
      <span>Next</span>
      <span aria-hidden="true">»</span>
    </a>
  </nav>
</template>

<script setup>
import { watch } from '@vue/runtime-core';

const $props = defineProps({
  pagination: {
    type: Object,
    default: () => {
      return {
        page: 1,
        totalPage: 1,
      };
    },
  },
});

const $emit = defineEmits(['update']);

watch(
  () => $props.pagination.page,
  (val) => {
    $emit('update', val);
  }
);
</script>