<template>
  <router-view></router-view>
  <LoadingOverlay v-show="isLoading" />
</template>

<script setup>
import LoadingOverlay from '@/components/UI/Loading/Overlay.vue';
import Notification from '@/components/UI/Notification.vue';
import useLoading from '@/composables/loading';
const { isLoading } = useLoading();
</script>

