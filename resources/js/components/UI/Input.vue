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
      :id="id"
      class="block w-full rounded-md transition duration-500"
      :class="[
        styles,
        errors && errors.length > 0 ? '!border-red-500' : '',
        disabled ? 'cursor-not-allowed' : '',
        readonly ? 'cursor-not-allowed bg-gray-50' : '',
      ]"
      :type="type"
      :name="name"
      :placeholder="placeholder"
      :value="modelValue"
      @input="updateValue"
      @change="changeValue"
      @keyup="keyupValue"
      :accept="accept"
      :min="min"
      :max="max"
      :step="step"
      :disabled="disabled"
      :readonly="readonly"
      :required="required"
    />
    <!-- @keyup="createDebounce(keyupValue($event))" -->
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
  id: {
    type: String,
    default: null,
  },
  type: {
    type: String,
    default: 'text',
  },
  name: {
    type: String,
    default: null,
  },
  accept: {
    type: String,
    default: null,
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
  underlineOnHover: {
    type: Boolean,
    default: false,
  },
  filled: {
    type: Boolean,
    default: false,
  },
  disabled: {
    type: [Boolean, Number],
    default: false,
  },
  readonly: {
    type: [Boolean, Number],
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

const $emit = defineEmits(['update:modelValue', 'change', 'keyup']);

const variants = ref({
  primary:
    'border border-gray-300 focus:border-2 focus:border-blue-500 focus:ring-blue-500 outline-none',
  secondary:
    'border border-gray-300 focus:border-2 focus:border-gray-800 focus:ring-gray-800 outline-none',
  dark: 'bg-slate-800 border border-slate-500 focus:border-2 focus:border-slate-400 focus:ring-slate-400 outline-none text-slate-300',
});

const variantUnderline = ref({
  primary:
    '!border-b-1 border-x-transparent border-t-transparent !rounded-b-none focus:!border-x-transparent focus:!border-t-transparent border-blue-400',
  secondary:
    '!border-b-1 border-x-transparent border-t-transparent !rounded-b-none focus:!border-x-transparent focus:!border-t-transparent border-gray-400',
});

const variantUnderlineOnHover = ref({
  primary:
    '!border-b-1 border-x-transparent border-t-transparent !rounded-b-none focus:!border-x-transparent focus:!border-t-transparent border-gray-100 hover:border-x-transparent hover:border-t-transparent hover:border-gray-400',
  secondary:
    '!border-b-1 border-x-transparent border-t-transparent !rounded-b-none focus:!border-x-transparent focus:!border-t-transparent border-gray-100 hover:border-x-transparent hover:border-t-transparent hover:border-gray-400',
});

const variantFilled = ref({
  primary: 'bg-gray-50 focus:bg-gray-100',
  secondary: '',
  dark: 'bg-slate-800 focus:bg-slate-600',
});

const sizes = ref({
  xs: 'py-1 px-2 text-xs',
  sm: 'py-2 px-2 text-sm',
  md: 'py-3 px-4 text-base',
  lg: '',
});

const styles = computed(() => {
  const styleVariant = variants.value[$props.variant];
  const styleVariantUnderline = $props.underline
    ? variantUnderline.value[$props.variant]
    : '';
  const styleVariantUnderlineOnHover = $props.underlineOnHover
    ? variantUnderlineOnHover.value[$props.variant]
    : '';
  const styleVariantFilled = $props.filled
    ? variantFilled.value[$props.variant]
    : '';
  const styleSize = sizes.value[$props.size];
  return `${styleVariant} ${styleVariantUnderline} ${styleVariantUnderlineOnHover} ${styleVariantFilled} ${styleSize}`;
});

function createDebounce() {
  let timeout = null;
  return function (fnc, delayMs) {
    clearTimeout(timeout);
    timeout = setTimeout(() => {
      fnc();
    }, delayMs || 3000);
  };
}

const updateValue = (event) => {
  $emit('update:modelValue', event.target.value);
};
const changeValue = (event) => {
  if ($props.type === 'file') {
    $emit('change', event);
  } else {
    $emit('change', event.target.value);
  }
};
const keyupValue = (event) => {
  $emit('keyup', event.target.value);
};
</script>