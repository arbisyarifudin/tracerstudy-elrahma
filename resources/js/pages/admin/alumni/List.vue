<template>
  <div>
    <MyTable :columns="columns" :datas="rows" :pagination="pagination">
      <template #header>
        <div class="flex items-center justify-between">
          <div class="text-2xl font-medium text-slate-700 mb-3 flex-1">
            Alumni
          </div>
          <div class="flex items-center space-x-4">
            <Select
              class="md:mb-0"
              placeholder="- Semua Tahun -"
              required
              size="sm"
              v-model="pagination.batch_id"
              :options="batchOptions"
            ></Select>
            <Button
              label="Tambah"
              icon="plus"
              @click="$router.push({ name: 'Alumni Add Page' })"
            />
          </div>
        </div>
      </template>
      <template v-slot:body-cell-no="props">
        <td>
          {{ props.index + 1 }}
        </td>
      </template>
      <template v-slot:body-cell-nim="props">
        <td>
          {{ props.row.nim }}
        </td>
      </template>
      <template v-slot:body-cell-fullname="props">
        <td>
          {{ props.row.fullname }}
        </td>
      </template>
      <template v-slot:body-cell-enter_year="props">
        <td>
          {{ props.row.enter_year }}
        </td>
      </template>
      <template v-slot:body-cell-graduate_year="props">
        <td>
          {{ props.row.graduate_year }}
        </td>
      </template>
      <template v-slot:body-cell-action="props">
        <td>
          <div class="flex">
            <Button
              size="sm"
              label="Edit"
              class="mr-2"
              @click="
                $router.push({
                  name: 'Alumni Edit Page',
                  params: { id: props.row.nim },
                })
              "
            />
            <Button
              variant="danger"
              size="sm"
              icon="trash"
              @click="
                showDialogDelete = true;
                selectedData = { ...props.row };
              "
            />
          </div>
        </td>
      </template>
    </MyTable>
    <Modal
      title="Hapus Program Studi"
      :show="showDialogDelete"
      :loading="loading"
      @close="onCloseDialog"
    >
      <template #content>
        <div class="p-4">
          Apakah anda yakin ingin menghapus alumni {{ selectedData.fullname }}
        </div>
      </template>
      <template #footer>
        <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t">
          <Button
            variant="danger"
            type="submit"
            label="Hapus"
            @click="deleteBatch"
            :disabled="loading"
          />
        </div>
      </template>
    </Modal>
  </div>
</template>

<script setup>
import MyTable from '@/components/UI/Table/MyTable.vue';
import Button from '@/components/UI/Button.vue';
import Modal from '@/components/UI/Modal.vue';
import Input from '@/components/UI/Input.vue';
import Select from '@/components/UI/Select.vue';

import useLoading from '@/composables/loading';
import useAlert from '@/composables/alert';

import { inject, onMounted, ref, watch } from '@vue/runtime-core';
const axios = inject('axios');

const columns = [
  {
    label: 'No',
    name: 'no',
    align: 'left',
    width: 80,
  },
  {
    label: 'NIM',
    name: 'nim',
    align: 'left',
  },
  {
    label: 'Nama Alumni',
    name: 'fullname',
    align: 'left',
  },
  {
    label: 'Th. Masuk',
    name: 'enter_year',
    align: 'left',
  },
  {
    label: 'Th. Lulus',
    name: 'graduate_year',
    align: 'left',
  },
  {
    label: 'Actions',
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
  batch_id: null,
});

const { showLoading } = useLoading();

const getData = () => {
  showLoading(true);
  axios
    .get('api/alumni', {
      params: {
        size: pagination.value.size,
        page: pagination.value.page,
        sortBy: 'created_at',
        sortDir: 'asc',
        batch_id: pagination.value.batch_id,
      },
    })
    .then((response) => {
      console.log('res', response);
      rows.value = response.data.data;
      pagination.value = {
        ...response.data.paginate,
        batch_id: pagination.value.batch_id,
      };
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

/* BATCH DATA */
const batchOptions = ref([]);
const getBatch = () => {
  showLoading(true);
  loading.value = true;
  axios
    .get('api/batch', {
      params: {
        size: 50,
        page: 1,
      },
    })
    .then((response) => {
      console.log('res', response.data);
      batchOptions.value = response.data.data.map((v) => {
        return {
          label: v.year,
          value: v.id,
        };
      });
    })
    .catch((error) => {
      console.log('err', error);
      if (error?.response?.data) {
        showAlert(error.response.message);
      }
    })
    .finally(() => {
      showLoading(false);
      loading.value = false;
    });
};

watch(
  () => pagination.value.batch_id,
  (val) => {
    getData();
  }
);

onMounted(() => {
  getData();
  getBatch();
});

const loading = ref(false);

/* DELETE DATA */
const selectedData = ref({
  id: null,
  year: null,
});

const showDialogDelete = ref(false);
const { showAlert } = useAlert();

const deleteBatch = () => {
  loading.value = true;
  showLoading(true);
  axios
    .delete('api/alumni/' + selectedData.value.id)
    .then((response) => {
      console.log('res', response.data);
      showDialogDelete.value = false;
      getData();
    })
    .catch((error) => {
      console.log('err', error.response.data);
      if (error.response.status !== 422) {
        showAlert(error.response.message);
      } else {
        errors.value = error.response.data.errors;
      }
    })
    .finally(() => {
      showLoading(false);
      loading.value = false;
    });
};

const onCloseDialog = () => {
  showDialogDelete.value = false;
};
</script>

<style>
</style>