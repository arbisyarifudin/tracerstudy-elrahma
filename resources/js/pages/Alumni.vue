<template>
  <div class="px-7">
    <TableDark :columns="columns" :datas="rows" :pagination="pagination">
      <template #header>
        <div class="flex items-center justify-between">
          <div class="flex items-center space-x-7">
            <div class="text-2xl font-medium text-slate-300 mb-3 flex-1">
              Daftar Alumni
            </div>
          </div>
          <div class="flex items-center space-x-4">
            <Input
              placeholder="Cari.."
              size="sm"
              class="md:mb-0"
              variant="dark"
              v-model="filter.search"
            />
            <Select
              class="md:mb-0"
              placeholder="- Semua Tahun -"
              required
              size="sm"
              variant="dark"
              v-model="filter.batch_id"
              :options="batchOptions"
            ></Select>
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
      <template v-slot:body-cell-major_name="props">
        <td>{{ props.row.major_level }} {{ props.row.major_name }}</td>
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
              label="Detail"
              class="mr-2"
              @click="openDialogDetail(props.row)"
            />
          </div>
        </td>
      </template>
    </TableDark>
    <Modal
      title="Detail Alumni"
      :show="showDialogDetail"
      :loading="loading"
      @close="onCloseDialog"
    >
      <template #content>
        <div class="p-4">
          <div class="mb-3 bg-yellow-200 rounded-lg p-4 text-sm">
            Beberapa informasi sensitif hanya akan ditampilkan untuk pengguna
            yang sudah login dan terverifikasi.
          </div>
          <table class="mytable table" v-if="detailData">
            <tbody>
              <tr>
                <td width="150" class="font-semibold">Nama</td>
                <td width="50" class="text-center">:</td>
                <td>{{ detailData.fullname }}</td>
              </tr>
              <tr>
                <td width="150" class="font-semibold">NIM</td>
                <td width="50" class="text-center">:</td>
                <td>{{ detailData.nim }}</td>
              </tr>
              <tr>
                <td width="150" class="font-semibold">Program Studi</td>
                <td width="50" class="text-center">:</td>
                <td v-if="detailData.major">
                  {{ detailData.major.level }} {{ detailData.major.name }}
                </td>
              </tr>
              <tr>
                <td width="150" class="font-semibold">No. Telp/HP</td>
                <td width="50" class="text-center">:</td>
                <td>{{ detailData.phone_number }}</td>
              </tr>
              <tr>
                <td width="150" class="font-semibold">No. WA</td>
                <td width="50" class="text-center">:</td>
                <td>{{ detailData.wa_number }}</td>
              </tr>
              <tr>
                <td width="150" class="font-semibold">
                  Tahun Masuk &amp; Lulus
                </td>
                <td width="50" class="text-center">:</td>
                <td v-if="detailData.batch">
                  {{ detailData.batch.year }} - {{ detailData.graduate_year }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </template>
      <template #footer>
        <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t">
          <Button
            variant="secondary"
            label="Tutup"
            @click="showDialogDetail = false"
          />
        </div>
      </template>
    </Modal>
  </div>
</template>

<style lang="scss" scoped>
.mytable {
  tr td {
    padding: 10px 20px;
  }
}
</style>

<script setup>
import TableDark from '@/components/UI/Table/TableDark.vue';
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
    label: 'Program Studi',
    name: 'major_name',
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
    label: '',
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

const filter = ref({
  search: '',
  batch_id: null,
});

const { showLoading, isLoading } = useLoading();

const getData = () => {
  if (isLoading.value == true) return;
  showLoading(true);
  axios
    .get('api/public/alumni', {
      params: {
        search: filter.value.search,
        size: pagination.value.size,
        page: pagination.value.page,
        sortBy: 'created_at',
        sortDir: 'asc',
        batch_id: filter.value.batch_id,
      },
    })
    .then((response) => {
      // console.log('res', response);
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
    .get('api/public/batch', {
      params: {
        size: 50,
        page: 1,
      },
    })
    .then((response) => {
      // console.log('res', response.data);
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
        showAlert(error.response.data.message);
      }
    })
    .finally(() => {
      showLoading(false);
      loading.value = false;
    });
};

watch(
  () => filter.value.batch_id,
  (val) => {
    getData();
  }
);
watch(
  () => filter.value.search,
  (val) => {
    getData();
  }
);

onMounted(() => {
  getData();
  getBatch();
});

const loading = ref(false);

/* DIALOG DATA */
const detailData = ref({
  id: null,
  fullname: null,
  nim: null,
});

const showDialogDetail = ref(false);

const onCloseDialog = () => {
  showDialogDetail.value = false;
};

const openDialogDetail = (rowData) => {
  detailData.value = {
    fullname: '---',
  };
  showDialogDetail.value = true;
  showLoading(true);
  axios
    .get('api/public/alumni/' + rowData.id)
    .then((response) => {
      // console.log('res', response.data);
      detailData.value = response.data?.data;
    })
    .catch((error) => {
      // console.log('err', error);
      if (error?.response?.data) {
        showAlert(error.response.data.message);
      }
    })
    .finally(() => {
      showLoading(false);
    });
};
</script>

<style>
</style>