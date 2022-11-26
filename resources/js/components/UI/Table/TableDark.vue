<template>
  <div
    class="
      mytable
      rounded-xl
      border border-slate-700
      shadow-xl
      p-5
      bg-slate-800
    "
  >
    <slot name="header" />
    <table class="table-auto w-full divide-y divide-gray-300">
      <thead class="divide-y divide-gray-300">
        <tr class="uppercase">
          <th
            v-for="(column, c) in columns"
            :key="c"
            :align="column.align"
            :width="column.width"
            class="p-4 text-sm font-medium text-slate-300"
          >
            {{ column.label }}
          </th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-300">
        <tr v-for="(row, i) in rows" :key="i" class="hover:bg-slate-700">
          <td
            v-for="(column, c) in columns"
            :key="c"
            :align="column.align"
            class="
              px-6
              py-4
              whitespace-nowrap
              text-sm text-slate-400
              dark:text-gray-200
            "
          >
            <slot
              :name="`body-cell-${column.name}`"
              :row="rowsRaw[i]"
              :index="generateIndex(i)"
            />
          </td>
        </tr>
        <tr v-if="rows.length < 1">
          <td
            :colspan="columns.length"
            class="text-center text-slate-300 text-sm py-5"
          >
            No data.
          </td>
        </tr>
      </tbody>
    </table>
    <slot name="pagination">
      <nav class="flex items-center justify-end space-x-2 text-sm">
        <a
          class="p-4 inline-flex items-center gap-2 rounded-md text-slate-200"
          :class="[
            pagination.page > 1
              ? 'hover:text-blue-800 cursor-pointer'
              : 'pointer-events-none opacity-50',
          ]"
          @click="pagination.page -= 1"
        >
          <span aria-hidden="true">«</span>
          <span>Previous</span>
        </a>
        <a
          v-for="page in pagination.totalPage"
          :key="page"
          class="
            w-10
            h-10
            p-4
            inline-flex
            items-center
            text-sm
            font-medium
            rounded-full
          "
          :class="[
            page === pagination.page
              ? 'bg-blue-800 text-white'
              : 'text-slate-200 hover:text-blue-800 cursor-pointer',
          ]"
          aria-current="page"
          @click.prevent="pagination.page = page"
          >{{ page }}</a
        >
        <a
          class="p-4 inline-flex items-center gap-2 rounded-md text-slate-300"
          :class="[
            pagination.page < pagination.totalPage
              ? 'hover:text-blue-800 cursor-pointer'
              : 'pointer-events-none opacity-50',
          ]"
          @click="pagination.page += 1"
        >
          <span>Next</span>
          <span aria-hidden="true">»</span>
        </a>
      </nav>
    </slot>
  </div>
</template>

<script setup>
import { ref } from '@vue/reactivity';
import { watch } from '@vue/runtime-core';

const $props = defineProps({
  title: {
    type: String,
    default: null,
  },
  columns: {
    type: Object,
    default: [],
  },
  datas: {
    type: Object,
    default: [],
  },
  pagination: {
    type: Object,
    default: {
      size: 1,
      page: 1,
      totalPage: 1,
      totalData: 1,
    },
  },
});

const rows = ref([]);
const rowsRaw = ref([]);

const columnNames = $props.columns.map((v) => v.name);
columnNames.push('id');

watch(
  () => $props.datas,
  (newValue) => {
    rows.value = [];
    rowsRaw.value = newValue;
    newValue.forEach((item) => {
      const itemFiltered = Object.keys(item)
        .filter((key) => columnNames.includes(key))
        .reduce((cur, key) => {
          return Object.assign(cur, { [key]: item[key] });
        }, {});
      rows.value.push(itemFiltered);
    });
  }
);

const generateIndex = (currIndex) => {
  const index =
    ($props.pagination.page - 1) * $props.pagination.size + currIndex;
  return index;
};
</script>

<style lang="scss" scoped>
// .mytable {
//   width: 100%;
//   thead {
//     tr {
//       background-color: #ddd;
//     }
//   }
//   tr {
//     th,
//     td {
//       border: 1px solid #ddd;
//       padding: 10px 20px;
//     }
//   }
// }
</style>