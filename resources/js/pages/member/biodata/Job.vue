<template>
  <div>
    <MyTable :columns="columns" :datas="rows" :pagination="pagination">
      <template #header>
        <div class="flex items-center justify-between">
          <div class="text-2xl font-medium text-slate-700 mb-3">
            Riwayat Pekerjaan
          </div>
          <Button label="Tambah" icon="plus" @click="showDialogAdd = true" />
        </div>
      </template>
      <template v-slot:body-cell-no="props">
        <td>
          {{ props.index + 1 }}
        </td>
      </template>
      <template v-slot:body-cell-institution_name="props">
        <td>
          {{ props.row.institution_name }}
        </td>
      </template>
      <template v-slot:body-cell-job_title="props">
        <td>
          {{ props.row.job_title }}
        </td>
      </template>
      <template v-slot:body-cell-start_year="props">
        <td>
          {{ props.row.start_year }}
        </td>
      </template>
      <template v-slot:body-cell-end_year="props">
        <td>
          {{ props.row.end_year }}
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
      :title="`${isEditMode ? 'Edit' : 'Tambah'} Riwayat Pekerjaan`"
      :show="showDialogAdd"
      :loading="loading"
      @close="onCloseDialog"
      @confirm="onSubmit"
    >
      <template #content>
        <div class="p-4">
          <Input
            label="Nama Tempat Kerja/Usaha/Institusi"
            placeholder=""
            v-model="state.institution_name"
            :errors="errors.institution_name"
            @change="errors.institution_name = null"
          />
          <Textarea
            label="Alamat Tempat Kerja/Usaha/Institusi"
            v-model="state.institution_address"
            :errors="errors.institution_address"
            @change="errors.institution_address = null"
          />
          <Input
            label="Jabatan / Posisi"
            placeholder=""
            v-model="state.job_title"
            :errors="errors.job_title"
            @change="errors.job_title = null"
          />
          <Input
            label="Tahun Masuk/Mulai Usaha"
            type="number"
            v-model="state.start_year"
            :errors="errors.start_year"
            @change="errors.start_year = null"
          />
          <Input
            label="Tahun Keluar/Selesai"
            type="number"
            hint="Kosongkan jika belum keluar/selesai"
            v-model="state.end_year"
            :errors="errors.end_year"
            @change="errors.end_year = null"
          />
        </div>
      </template>
    </Modal>
    <Modal
      title="Hapus Riwayat Pekerjaan"
      :show="showDialogDelete"
      :loading="loading"
      @close="onCloseDialog"
    >
      <template #content>
        <div class="p-4">
          Apakah anda yakin ingin menghapus
          {{ selectedData.institution_name }}
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
import Textarea from '@/components/UI/Textarea.vue';
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
    label: 'Tempat Kerja/Usaha/Institusi',
    name: 'institution_name',
    align: 'left',
  },
  {
    label: 'Jabatan/Posisi',
    name: 'job_title',
    align: 'left',
  },
  {
    label: 'Tahun Masuk/Mulai',
    name: 'start_year',
    align: 'left',
  },
  {
    label: 'Tahun Keluar/Selesai',
    name: 'end_year',
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
    .get('api/member/job', {
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

/* ADD & EDIT DATA */
const { showLoading } = useLoading();
const showDialogAdd = ref(false);

const state = ref({
  institution_name: '',
  institution_address: '',
  institution_contacts: [],
  job_title: '',
  start_year: '',
  end_year: '',
});

const errors = ref({
  institution_name: null,
  institution_address: null,
  job_title: null,
  start_year: null,
  end_year: null,
});

const onSubmit = () => {
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
    .post('api/member/job', state.value)
    .then((response) => {
      console.log('res', response.data);
      showDialogAdd.value = false;
      // rows.value.push(response.data.data);
      showAlert('Riwayat Pekerjaan berhasil ditambah!', {
        type: 'success',
      });
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
    .put('api/member/job/' + state.value.id, state.value)
    .then((response) => {
      console.log('res', response.data);
      showDialogAdd.value = false;
      showAlert('Riwayat Pekerjaan berhasil diperbarui!', {
        type: 'success',
      });
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
  year: null,
});
const showDialogDelete = ref(false);
const { showAlert } = useAlert();

const deleteBatch = () => {
  loading.value = true;
  showLoading(true);
  axios
    .delete('api/member/job/' + selectedData.value.id)
    .then((response) => {
      console.log('res', response.data);
      showDialogDelete.value = false;
      showAlert('Riwayat Pekerjaan berhasil dihapus!');
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