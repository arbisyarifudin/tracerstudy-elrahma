<template>
  <div class="mb-3" :class="className">
    <label for="">
      <input
        type="radio"
        class="block w-full rounded-md"
        :class="[styles]"
        :value="modelValue"
        @input="updateValue"
        @change="changeValue"
        :disabled="disabled"
      />
      {{ label }}
    </label>
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
});

const $emit = defineEmits(['update:modelValue', 'change']);

const variants = ref({
  primary:
    'border border-gray-300 focus:border-2 focus:border-blue-500 focus:ring-blue-500 outline-none',
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