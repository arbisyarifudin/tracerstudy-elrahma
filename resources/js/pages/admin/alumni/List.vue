<template>
  <div>
    <MyTable :columns="columns" :datas="rows" :pagination="pagination">
      <template #header>
        <div class="flex items-center justify-between">
          <div class="text-2xl font-medium text-slate-700 mb-3">Alumni</div>
          <Button
            label="Tambah"
            icon="plus"
            @click="$router.push({ name: 'Alumni Add Page' })"
          />
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
      <template v-slot:body-cell-name="props">
        <td>
          {{ props.row.name }}
        </td>
      </template>
      <template v-slot:body-cell-entered_year="props">
        <td>
          {{ props.row.entered_year }}
        </td>
      </template>
      <template v-slot:body-cell-graduated_year="props">
        <td>
          {{ props.row.graduated_year }}
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
    name: 'name',
    align: 'left',
  },
  {
    label: 'Th. Masuk',
    name: 'entered_year',
    align: 'left',
  },
  {
    label: 'Th. Lulus',
    name: 'graduated_year',
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
});

const { showLoading } = useLoading();

const getData = () => {
  showLoading(true);
  axios
    .get('api/major', {
      params: {
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

watch(
  () => pagination.value.page,
  (newValue) => {
    getData();
  }
);

onMounted(() => {
  getData();
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
    .delete('api/major/' + selectedData.value.id)
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
  showDialogAdd.value = false;
  showDialogDelete.value = false;
  isEditMode.value = false;
  state.value = {};
  errors.value = {};
};
</script>

<style>
</style>