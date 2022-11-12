<template>
  <div>
    <MyTable :columns="columns" :datas="rows" :pagination="pagination">
      <template #header>
        <div class="flex items-center justify-between">
          <div class="text-2xl font-medium text-slate-700 mb-3">
            Program Studi
          </div>
          <Button label="Tambah" icon="plus" @click="showDialogAdd = true" />
        </div>
      </template>
      <template v-slot:body-cell-no="props">
        <td>
          {{ props.index + 1 }}
        </td>
      </template>
      <template v-slot:body-cell-code="props">
        <td>
          {{ props.row.code }}
        </td>
      </template>
      <template v-slot:body-cell-name="props">
        <td>
          {{ props.row.name }}
        </td>
      </template>
      <template v-slot:body-cell-level="props">
        <td>
          {{ props.row.level }}
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
                isEditMode = true;
                showDialogAdd = true;
                state = { ...props.row };
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
      :title="`${isEditMode ? 'Edit' : 'Tambah'} Prodi`"
      :show="showDialogAdd"
      :loading="loading"
      @close="onCloseDialog"
      @confirm="submitBatch"
    >
      <template #content>
        <div class="p-4">
          <Input
            label="Kode Prodi"
            placeholder="Tuliskan kode prodi"
            v-model="state.code"
            :errors="errors.code"
            @change="errors.code = null"
          ></Input>
          <Input
            label="Nama Prodi"
            placeholder="Tuliskan name prodi"
            v-model="state.name"
            :errors="errors.name"
            @change="errors.name = null"
          ></Input>
          <Select
            label="Jenjang"
            v-model="state.level"
            :options="levelOptions"
            :errors="errors.level"
            @change="errors.level = null"
          ></Select>
        </div>
      </template>
    </Modal>
    <Modal
      title="Hapus Program Studi"
      :show="showDialogDelete"
      :loading="loading"
      @close="onCloseDialog"
    >
      <template #content>
        <div class="p-4">
          Apakah anda yakin ingin menghapus prodi {{ selectedData.name }}
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
    label: 'Kode',
    name: 'code',
    align: 'left',
  },
  {
    label: 'Nama Prodi',
    name: 'name',
    align: 'left',
  },
  {
    label: 'Jenjang',
    name: 'level',
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
const isEditMode = ref(false);

/* ADD & UPDATE MAJOR */

const { showLoading } = useLoading();
const showDialogAdd = ref(false);

const state = ref({
  code: '',
  name: '',
  level: 'S1',
});

const errors = ref({
  code: null,
  name: null,
  level: null,
});

const levelOptions = ref([
  {
    label: 'D3',
    value: 'D3',
  },
  {
    label: 'S1',
    value: 'S1',
  },
  {
    label: 'S2',
    value: 'S2',
  },
  {
    label: 'S3',
    value: 'S3',
  },
  {
    label: 'Profesi',
    value: 'Profesi',
  },
]);

const submitBatch = () => {
  loading.value = true;
  showLoading(true);
  if (isEditMode.value === true) {
    updateData();
  } else {
    saveData();
  }
};

const saveData = () => {
  axios
    .post('api/major', state.value)
    .then((response) => {
      console.log('res', response.data);
      showDialogAdd.value = false;
      showAlert('Program Studi berhasil ditambah!', { type: 'success' });
      getData();
      onCloseDialog();
    })
    .catch((error) => {
      console.log('err', error);
      if (error?.response?.status !== 422) {
        showAlert(error.response.data.message);
      } else {
        errors.value = error.response.data.errors;
      }
    })
    .finally(() => {
      showLoading(false);
      loading.value = false;
    });
};

const updateData = () => {
  axios
    .put('api/major/' + state.value.id, state.value)
    .then((response) => {
      console.log('res', response.data);
      showDialogAdd.value = false;
      showAlert('Program Studi berhasil diperbarui!', { type: 'success' });
      getData();
      onCloseDialog();
    })
    .catch((error) => {
      console.log('err', error);
      if (error?.response?.status !== 422) {
        showAlert(error.response.data.message);
      } else {
        errors.value = error.response.data.errors;
      }
    })
    .finally(() => {
      showLoading(false);
      loading.value = false;
    });
};

/* DELETE PRODI */
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
      showAlert('Program Studi berhasil dihapus!');
      getData();
    })
    .catch((error) => {
      console.log('err', error);
      if (error?.response?.status !== 422) {
        showAlert(error.response.data.message);
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