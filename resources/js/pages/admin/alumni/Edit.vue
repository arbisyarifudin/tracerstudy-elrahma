<template>
  <div>
    <div class="p-4">
      <Input
        label="NIM"
        placeholder="Tuliskan NIM"
        v-model="state.nim"
        :errors="errors.nim"
        @change="errors.nim = null"
      ></Input>
      <Input
        label="Nama Lengkap"
        placeholder="Tuliskan nama lengkap"
        v-model="state.fullname"
        :errors="errors.fullname"
        @change="errors.fullname = null"
      ></Input>
      <Select
        label="Jenjang"
        v-model="state.level"
        :options="levelOptions"
        :errors="errors.level"
        @change="errors.level = null"
      ></Select>
    </div>
  </div>
</template>

<script setup>
/* ADD & UPDATE DATA */
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
    .put('api/major/' + state.value.id, state.value)
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
</script>