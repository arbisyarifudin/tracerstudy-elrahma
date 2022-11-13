<template>
  <div>
    <MyTable :columns="columns" :datas="rows" :pagination="pagination">
      <template #header>
        <div class="flex items-center justify-between">
          <div class="text-2xl font-medium text-slate-700 mb-3 flex-1">
            Formulir
          </div>
          <div class="flex items-center space-x-4">
            <Button label="Tambah" icon="plus" @click="showDialogAdd = true" />
          </div>
        </div>
      </template>
      <template v-slot:body-cell-no="props">
        <td>
          {{ props.index + 1 }}
        </td>
      </template>
      <template v-slot:body-cell-name="props">
        <td>
          {{ props.row.name }}
        </td>
      </template>
      <template v-slot:body-cell-description="props">
        <td>
          {{ props.row.description }}
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
      :title="`${isEditMode ? 'Edit' : 'Tambah'} Formulir`"
      :show="showDialogAdd"
      :loading="loading"
      @close="onCloseDialog"
      @confirm="submitBatch"
    >
      <template #content>
        <div class="p-4">
          <Input
            label="Nama Formulir"
            placeholder="Tuliskan nama formulir"
            required
            v-model="state.name"
            :errors="errors.name"
            @change="errors.name = null"
          ></Input>
          <Input
            label="Deskripsi"
            placeholder="Tuliskan deskripsi formulir"
            v-model="state.description"
            :errors="errors.description"
            @change="errors.description = null"
          ></Input>
        </div>
      </template>
    </Modal>
    <Modal
      title="Hapus Formulir"
      :show="showDialogDelete"
      :loading="loading"
      @close="onCloseDialog"
    >
      <template #content>
        <div class="p-4">
          Apakah anda yakin ingin menghapus formulir
          <span class="font-semibold">{{ selectedData.name }}</span
          >?
        </div>
      </template>
      <template #footer>
        <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t">
          <Button
            variant="danger"
            type="submit"
            label="Hapus"
            @click="deleteData"
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
    label: 'Nama',
    name: 'name',
    align: 'left',
  },
  // {
  //   label: 'Tag',
  //   name: 'tag',
  //   align: 'left',
  // },
  {
    label: 'Description',
    name: 'description',
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
    .get('api/form', {
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

/* ADD & EDIT Data */
const showDialogAdd = ref(false);

const state = ref({
  name: '',
  tag: '',
  description: '',
});

const errors = ref({
  name: null,
  tag: null,
  description: null,
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
    .post('api/form', state.value)
    .then((response) => {
      console.log('res', response.data);
      showDialogAdd.value = false;
      // rows.value.push(response.data.data);
      showAlert('Form berhasil ditambah!', { type: 'success' });
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
    .put('api/form/' + state.value.id, state.value)
    .then((response) => {
      console.log('res', response.data);
      showDialogAdd.value = false;
      showAlert('Form berhasil diperbarui!', { type: 'success' });
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

/* DELETE DATA */
const selectedData = ref({
  id: null,
  name: null,
});

const showDialogDelete = ref(false);
const { showAlert } = useAlert();

const deleteData = () => {
  loading.value = true;
  showLoading(true);
  axios
    .delete('api/form/' + selectedData.value.id)
    .then((response) => {
      console.log('res', response.data);
      showDialogDelete.value = false;
      showAlert('Form berhasil dihapus!');
      getData();
    })
    .catch((error) => {
      console.log('err', error);
      if (error?.response?.status !== 422) {
        showAlert(error.response.data.message);
      }
    })
    .finally(() => {
      showLoading(false);
      loading.value = false;
    });
};

const onCloseDialog = () => {
  showDialogDelete.value = false;
  showDialogAdd.value = false;
  isEditMode.value = false;
  state.value = {};
};
</script>

<style>
</style>