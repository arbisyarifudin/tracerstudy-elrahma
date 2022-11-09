<template>
  <div>
    <MyTable :columns="columns" :datas="rows" :pagination="pagination">
      <template #header>
        <div class="flex items-center justify-between">
          <div class="text-2xl font-medium text-slate-700 mb-3">Angkatan</div>
          <Button label="Tambah" icon="plus" @click="showDialogAdd = true" />
        </div>
      </template>
      <template v-slot:body-cell-no="props">
        <td>
          {{ props.index + 1 }}
        </td>
      </template>
      <template v-slot:body-cell-year="props">
        <td>
          {{ props.row.year }}
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
      :title="`${isEditMode ? 'Edit' : 'Tambah'} Angkatan`"
      :show="showDialogAdd"
      :loading="loading"
      @close="onCloseDialog"
      @confirm="submitBatch"
    >
      <template #content>
        <div class="p-4">
          <Input
            label="Tahun Angkatan"
            placeholder="Tuliskan tahun angkatan"
            type="number"
            v-model="state.year"
            :max="2050"
            :errors="errors.year"
            @change="errors.year = null"
          ></Input>
        </div>
      </template>
    </Modal>
    <Modal
      title="Hapus Angkatan"
      :show="showDialogDelete"
      :loading="loading"
      @close="onCloseDialog"
    >
      <template #content>
        <div class="p-4">
          Apakah anda yakin ingin menghapus angkatan {{ selectedData.year }}
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
    label: 'Angkatan',
    name: 'year',
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
    .get('api/batch', {
      params: {
        size: pagination.value.size,
        page: pagination.value.page,
        sortBy: 'year',
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

/* ADD & EDIT ANGKATAN */
const { showLoading } = useLoading();
const showDialogAdd = ref(false);

const state = ref({
  year: new Date().getFullYear(),
});

const errors = ref({
  year: null,
});

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
    .post('api/batch', state.value)
    .then((response) => {
      console.log('res', response.data);
      showDialogAdd.value = false;
      // rows.value.push(response.data.data);
      getData();
      onCloseDialog();
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

const updateData = () => {
  axios
    .put('api/batch/' + state.value.id, state.value)
    .then((response) => {
      console.log('res', response.data);
      showDialogAdd.value = false;
      getData();
      onCloseDialog();
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

/* DELETE ANGKATAN */
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
    .delete('api/batch/' + selectedData.value.id)
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