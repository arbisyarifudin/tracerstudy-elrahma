<template>
  <router-view></router-view>
  <LoadingOverlay v-show="isLoading" />
</template>

<script setup>
import LoadingOverlay from '@/components/UI/Loading/Overlay.vue';
import useLoading from '@/composables/loading';
const { isLoading } = useLoading();
</script>

