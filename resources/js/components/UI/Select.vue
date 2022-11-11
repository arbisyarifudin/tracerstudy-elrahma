<template>
  <div class="mb-3" :class="className">
    <label v-if="label" class="block text-sm font-medium mb-2 dark:text-white">
      {{ label }}
      <span v-show="required" class="text-red-500 small ml-1">*</span>
    </label>
    <div class="text-gray-400 text-sm block -mt-1 mb-3" v-if="hint">
      {{ hint }}
    </div>
    <select
      class="
        block
        w-full
        rounded-md
        disabled:border-dashed disabled:cursor-not-allowed disabled:bg-gray-100
      "
      :class="[styles, errors && errors.length > 0 ? '!border-red-500' : '']"
      :value="modelValue"
      :disabled="disabled"
      :required="required"
      @input="updateValue"
      @change="changeValue"
    >
      <option value="" v-show="placeholder" v-text="placeholder"></option>
      <option
        v-for="(option, i) in options"
        :key="i"
        v-text="option.label"
        :value="option.value"
      ></option>
    </select>
    <div class="text-sm text-red-500" v-for="(error, i) in errors" :key="i">
      <span v-text="error"></span>
    </div>
  </div>
</template>

<script setup>
import { computed, ref } from '@vue/runtime-core';

const $props = defineProps({
  label: {
    type: String,
    default: null,
  },
  placeholder: {
    type: String,
    default: null,
  },
  hint: {
    type: String,
    default: null,
  },
  variant: {
    type: String,
    default: 'primary',
  },
  size: {
    type: String,
    default: 'md',
  },
  required: {
    type: Boolean,
    default: false,
  },
  disabled: {
    type: Boolean,
    default: false,
  },
  className: {
    type: [String, Object, Array],
    default: null,
  },
  modelValue: {
    type: [String, Number, Object],
  },
  options: {
    type: [Object, Array],
  },
  errors: {
    type: [String, Object, Array],
    default: {},
  },
});

const $emit = defineEmits(['update:modelValue', 'change']);

const variants = ref({
  primary:
    'border border-gray-300 focus:border-2 focus:border-blue-500 focus:ring-blue-500 outline-none',
  secondary: '',
});

const sizes = ref({
  xs: '',
  sm: 'py-2 px-4 text-sm',
  md: 'py-3 px-4 text-sm',
  lg: '',
});

const styles = computed(() => {
  const styleVariant = variants.value[$props.variant];
  const styleSize = sizes.value[$props.size];
  return `${styleVariant} ${styleSize}`;
});

const updateValue = (event) => {
  $emit('update:modelValue', event.target.value);
};
const changeValue = (event) => {
  $emit('change', event.target.value);
};
</script>