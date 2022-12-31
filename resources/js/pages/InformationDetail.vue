<template>
  <div class="px-7">
    <div class="text-3xl text-white">{{ detailData.title }}</div>
    <ul class="flex items-center text-xs space-x-2 mt-3">
      <li class="text-white">Kategori:</li>
      <li
        v-for="(category, index) in detailData.categories"
        :key="index"
        class="bg-slate-500 text-white px-2 py-1 rounded-lg"
      >
        {{ category.title }}
      </li>
    </ul>
    <div class="my-3 h-[1px] w-full bg-slate-500" />
    <div class="text-white leading-6 information-content">
      <div v-html="detailData.body"></div>
    </div>
  </div>
</template>

<script setup>
import useLoading from '@/composables/loading';
import useAlert from '@/composables/alert';

import { inject, onMounted, ref } from '@vue/runtime-core';
import { useRoute } from 'vue-router';

const axios = inject('axios');
const $route = useRoute();

const detailData = ref({
  title: '',
  content: '',
});

const { showLoading, isLoading } = useLoading();

const getDetailData = () => {
  showLoading(true);
  axios
    .get('api/public/content/' + $route.params.slug)
    .then((response) => {
      console.log('res', response);
      detailData.value = response.data.data;
    })
    .catch((error) => {
      console.log('err', error);
    })
    .finally(() => {
      showLoading(false);
    });
};

onMounted(() => {
  getDetailData();
});
</script>

<style lang="scss">
.information {
  &-content {
    p {
      margin-bottom: 15px;
    }
  }
}
</style>