<template>
  <div class="mb-3" :class="className">
    <label v-if="label" class="block text-sm font-medium mb-2 dark:text-white">
      {{ label }}
      <span v-show="required" class="text-red-500 small ml-1">*</span>
    </label>
    <div class="text-gray-400 text-sm block -mt-1 mb-3" v-if="hint">
      {{ hint }}
    </div>
    <input
      :type="type"
      class="block w-full rounded-md"
      :class="[styles, errors && errors.length > 0 ? '!border-red-500' : '']"
      :placeholder="placeholder"
      :value="modelValue"
      @input="updateValue"
      @change="changeValue"
      :min="min"
      :max="max"
      :step="step"
      :disabled="disabled"
      :required="required"
    />
    <div
      class="text-xs mt-1 text-red-500"
      v-for="(error, i) in errors"
      :key="i"
    >
      <span v-text="error"></span>
    </div>
  </div>
</template>

<script setup>
import { computed, ref } from '@vue/runtime-core';

const $props = defineProps({
  type: {
    type: String,
    default: 'text',
  },
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
  min: {
    type: Number,
    default: null,
  },
  max: {
    type: Number,
    default: null,
  },
  step: {
    type: Number,
    default: null,
  },
  required: {
    type: Boolean,
    default: false,
  },
  underline: {
    type: Boolean,
    default: false,
  },
  filled: {
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

const variantUnderline = ref({
  primary:
    '!border-b-2 border-x-transparent border-t-transparent !rounded-none focus:!border-x-transparent focus:!border-t-transparent border-gray-400',
  secondary: '',
});

const variantFilled = ref({
  primary: 'bg-gray-50 focus:bg-gray-100',
  secondary: '',
});

const sizes = ref({
  xs: '',
  sm: '',
  md: 'py-3 px-4 text-sm',
  lg: '',
});

const styles = computed(() => {
  const styleVariant = variants.value[$props.variant];
  const styleVariantUnderline = $props.underline
    ? variantUnderline.value[$props.variant]
    : '';
  const styleVariantFilled = $props.filled
    ? variantFilled.value[$props.variant]
    : '';
  const styleSize = sizes.value[$props.size];
  return `${styleVariant} ${styleVariantUnderline} ${styleVariantFilled} ${styleSize}`;
});

const updateValue = (event) => {
  $emit('update:modelValue', event.target.value);
};
const changeValue = (event) => {
  $emit('change', event.target.value);
};
</script>