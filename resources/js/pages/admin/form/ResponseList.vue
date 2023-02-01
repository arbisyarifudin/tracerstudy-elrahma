<template>
  <div>
    <MyTable :columns="columns" :datas="rows" :pagination="pagination">
      <template #header>
        <div class="flex items-center justify-between">
          <h3 class="text-2xl font-semibold">
            Responden
            <span class="text-sm text-gray-500">/ {{ detailData.name }}</span>
          </h3>
          <div class="flex items-center">
            <Button size="sm" label="Export Data" icon="upload" class="ml-2" />
            <Button
              size="sm"
              label="Pengaturan"
              outline
              icon="gear"
              class="ml-2"
            />
          </div>
        </div>
      </template>
      <template v-slot:body-cell-no="props">
        <td>
          {{ props.index + 1 }}
        </td>
      </template>
      <template v-slot:body-cell-fullname="props">
        <td>
          {{ props.row.fullname }}
        </td>
      </template>
      <template v-slot:body-cell-nim="props">
        <td>
          {{ props.row.nim }}
        </td>
      </template>
      <template v-slot:body-cell-created_at="props">
        <td>
          {{ formatDate(props.row.created_at, 'DD MMMM YYYY HH:mm:ss') }}
        </td>
      </template>
      <template v-slot:body-cell-updated_at="props">
        <td>
          {{ formatDate(props.row.updated_at, 'DD MMMM YYYY HH:mm:ss') }}
        </td>
      </template>
      <template v-slot:body-cell-action="props">
        <td>
          <div class="flex">
            <Button
              size="sm"
              label="Lihat Detail"
              icon="eye"
              class="mr-2"
              @click="
                $router.push({
                  name: 'Form Response Detail Page',
                  params: {
                    id: $route.params.id,
                    responseId: props.row.id,
                  },
                })
              "
            />
          </div>
        </td>
      </template>
    </MyTable>
  </div>
</template>

<script setup>
import MyTable from '@/components/UI/Table/MyTable.vue';
import Button from '@/components/UI/Button.vue';
import Modal from '@/components/UI/Modal.vue';
import Input from '@/components/UI/Input.vue';

import useLoading from '@/composables/loading';
import useAlert from '@/composables/alert';
import useFormatHelper from '@/helpers/format';

import { inject, onMounted, ref, watch } from '@vue/runtime-core';
import { useRoute, useRouter } from 'vue-router';

const { showLoading } = useLoading();
const { showAlert } = useAlert();
const { formatDate } = useFormatHelper();

const axios = inject('axios');
const $route = useRoute();
const $router = useRouter();

/* DETAIL DATA */
const detailData = ref({
  name: '',
});

const getDetailData = async () => {
  showLoading(true);
  await axios
    .get('api/admin/form/' + $route.params.id)
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

onMounted(async () => {
  if (!$route.params.id) {
    showAlert('Page not found!');
    return $router.replace({ name: 'Form List Page' });
  }
  await getDetailData();
  getData();
});

/* LIST DATA */
const columns = [
  {
    label: 'No',
    name: 'no',
    align: 'left',
    width: 80,
  },
  {
    label: 'Nama',
    name: 'fullname',
    align: 'left',
  },
  {
    label: 'NIM',
    name: 'nim',
    align: 'left',
  },
  {
    label: 'Dikirim pada',
    name: 'created_at',
    align: 'left',
  },
  {
    label: 'Diperbarui pada',
    name: 'updated_at',
    align: 'left',
  },
  {
    label: 'Aksi',
    name: 'action',
    align: 'center',
    width: 150,
  },
];

const rows = ref([]);
const pagination = ref({
  size: 10,
  page: 1,
  totalPage: 1,
  totalData: 1,
});

const getData = () => {
  showLoading(true);
  axios
    .get('api/admin/form-response', {
      params: {
        size: pagination.value.size,
        page: pagination.value.page,
        sortBy: 'created_at',
        sortDir: 'asc',
        form_id: detailData.value.id,
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

watch(
  () => pagination.value.page,
  (newValue) => {
    getData();
  }
);
</script>

<style>
</style>