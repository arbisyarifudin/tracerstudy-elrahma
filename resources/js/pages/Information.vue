<template>
  <div class="px-7">
    <div class="text-2xl text-white">Informasi</div>
    <div class="my-3 h-[1px] w-full bg-slate-500" />
    <ul>
      <li
        class="bg-white px-4 py-5 mb-4 rounded-lg"
        v-for="(row, index) in rows"
        :key="index"
      >
        <div class="text-2xl mb-3">{{ row.title }}</div>
        <div class="text-sm text-gray-500 leading-7">
          <span v-html="row.excerpt + ' ...'"></span>
        </div>
        <div class="flex justify-between mt-2">
          <ul class="flex items-center text-xs space-x-2">
            <li>Kategori:</li>
            <li
              v-for="(category, index2) in row.categories"
              :key="index2"
              class="px-2 py-1 rounded-lg"
              :class="bgCategory(category.id)"
            >
              {{ category.title }}
            </li>
          </ul>
          <router-link
            :to="{
              name: 'Public Information Detail Page',
              params: { slug: row.slug },
            }"
            class="text-sm text-blue-600 hover:underline"
            >&rarr; Baca selengkapnya</router-link
          >
        </div>
      </li>
    </ul>

    <Pagination :pagination="pagination" @update="getData" />
  </div>
</template>

<script setup>
import Pagination from '@/components/Pagination.vue';

import useLoading from '@/composables/loading';
import useAlert from '@/composables/alert';

import { inject, onMounted, ref } from '@vue/runtime-core';
const axios = inject('axios');

const rows = ref([]);
const pagination = ref({
  size: 9,
  page: 1,
  totalPage: 1,
  totalData: 1,
});

const filter = ref({
  search: '',
});

const { showLoading, isLoading } = useLoading();

const getData = () => {
  if (isLoading.value == true) return;
  showLoading(true);
  axios
    .get('api/public/content', {
      params: {
        search: filter.value.search,
        size: pagination.value.size,
        page: pagination.value.page,
        sortBy: 'created_at',
        sortDir: 'asc',
      },
    })
    .then((response) => {
      console.log('res', response);
      rows.value = response.data.data;
      pagination.value = response.data.paginate;
    })
    .catch((error) => {
      console.log('err', error);
    })
    .finally(() => {
      showLoading(false);
    });
};

onMounted(() => {
  getData();
});

/* CATEGORY */
const bgCategory = (id) => {
  switch (id) {
    case 1:
    case id > 5 && id % 2 != 0:
      return 'bg-blue-500 text-white ';
    case 2:
    case id > 6 && id % 2 == 0:
      return 'bg-green-500 text-white ';
    case 3:
      return 'bg-orange-500 text-white ';
    case 4:
      return 'bg-red-500 text-white ';
    default:
      return 'bg-blue-500 text-white ';
      break;
  }
};
</script>