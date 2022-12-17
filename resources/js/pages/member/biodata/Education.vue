<template>
  <div>
    <MyTable :columns="columns" :datas="rows" :pagination="pagination">
      <template #header>
        <div class="flex items-center justify-between">
          <div class="text-2xl font-medium text-slate-700 mb-3">
            Riwayat Pendidikan
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
      <template v-slot:body-cell-major_name="props">
        <td>
          {{ props.row.major_name }}
        </td>
      </template>
      <template v-slot:body-cell-major_level="props">
        <td>
          {{ props.row.major_level }}
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
      :title="`${isEditMode ? 'Edit' : 'Tambah'} Riwayat Pendidikan`"
      :show="showDialogAdd"
      :loading="loading"
      @close="onCloseDialog"
      @confirm="submitBatch"
    >
      <template #content>
        <div class="p-4">
          <Input
            label="Nama Sekolah/Perguruan/Institusi"
            placeholder=""
            v-model="state.institution_name"
            :errors="errors.institution_name"
            @change="errors.institution_name = null"
          />
          <Textarea
            label="Alamat Sekolah/Perguruan/Institusi"
            v-model="state.institution_address"
            :errors="errors.institution_address"
            @change="errors.institution_address = null"
          />
          <Input
            label="Jurusan / Program Studi"
            placeholder=""
            v-model="state.major_name"
            :errors="errors.major_name"
            @change="errors.major_name = null"
            hint="Kosongkan jika tidak memiliki jurusan / program studi"
          />
          <Select
            label="Jenjang"
            v-model="state.major_level"
            :errors="errors.major_level"
            @change="errors.major_level = null"
            :options="majorLevelOptions"
          />
          <Input
            label="Tahun Masuk"
            type="number"
            v-model="state.enter_year"
            :errors="errors.enter_year"
            @change="errors.enter_year = null"
          />
          <Input
            label="Tahun Lulus"
            type="number"
            hint="Kosongkan jika belum lulus"
            v-model="state.graduate_year"
            :errors="errors.graduate_year"
            @change="errors.graduate_year = null"
          />
        </div>
      </template>
    </Modal>
    <Modal
      title="Hapus Riwayat Pendidikan"
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
    label: 'Sekolah/Perguruan/Institusi',
    name: 'institution_name',
    align: 'left',
  },
  {
    label: 'Jurusan/Prodi',
    name: 'major_name',
    align: 'left',
  },
  {
    label: 'Jenjang',
    name: 'major_level',
    align: 'left',
  },
  {
    label: 'Tahun Masuk',
    name: 'enter_year',
    align: 'left',
  },
  {
    label: 'Tahun Lulus',
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
});

const getData = () => {
  showLoading(true);
  axios
    .get('api/member/education', {
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

/* ADD & EDIT ANGKATAN */
const { showLoading } = useLoading();
const showDialogAdd = ref(false);

const state = ref({
  enter_year: new Date().getFullYear(),
  institution_name: '',
  institution_address: '',
  major_name: '',
  major_level: '',
  enter_year: '',
  graduate_year: '',
});

const errors = ref({
  enter_year: null,
  institution_name: null,
  institution_address: null,
  major_name: null,
  major_level: null,
  enter_year: null,
  graduate_year: null,
});

const majorLevelOptions = ref([
  {
    label: 'SD/Sederajat',
    value: 'SD/Sederajat',
  },
  {
    label: 'SMP/Sederajat',
    value: 'SMP/Sederajat',
  },
  {
    label: 'SMA/Sederajat',
    value: 'SMA/Sederajat',
  },
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
    .post('api/member/education', state.value)
    .then((response) => {
      console.log('res', response.data);
      showDialogAdd.value = false;
      // rows.value.push(response.data.data);
      showAlert('Riwayat Pendidikan berhasil ditambah!', {
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
    .put('api/member/education/' + state.value.id, state.value)
    .then((response) => {
      console.log('res', response.data);
      showDialogAdd.value = false;
      showAlert('Riwayat Pendidikan berhasil diperbarui!', {
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
    .delete('api/member/education/' + selectedData.value.id)
    .then((response) => {
      console.log('res', response.data);
      showDialogDelete.value = false;
      showAlert('Riwayat Pendidikan berhasil dihapus!');
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