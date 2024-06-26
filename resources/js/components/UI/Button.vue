<template>
  <button
    class="
      rounded-lg
      transition-all
      flex
      items-center
      disabled:opacity-50 disabled:cursor-not-allowed
    "
    :class="[styles]"
    :title="title"
    :type="type"
  >
    <component
      v-if="icon && iconPosition === 'left'"
      :is="`ph-${iconName}`"
      :size="20"
      :weight="iconWeight"
      :class="[label ? 'mr-2' : '']"
    ></component>
    <span v-text="label"></span>
    <component
      v-if="icon && iconPosition === 'right'"
      :is="`ph-${iconName}`"
      :size="20"
      :weight="iconWeight"
      :class="[label ? 'ml-2' : '']"
    ></component>
    <slot />
  </button>
</template>

<script setup>
import { ref } from '@vue/reactivity';
import { computed } from '@vue/runtime-core';

const $props = defineProps({
  type: {
    type: String,
    default: 'button',
  },
  label: {
    type: String,
    default: null,
  },
  title: {
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
  outline: {
    type: Boolean,
    default: false,
  },
  icon: {
    type: String,
    default: null,
  },
  iconPosition: {
    type: String,
    default: 'left',
  },
});

const variants = ref({
  primary:
    $props.outline === false
      ? 'bg-blue-800 text-white hover:bg-blue-900'
      : 'bg-white border border-blue-800 text-blue-800 hover:bg-blue-800 hover:text-white',
  secondary:
    $props.outline === false
      ? 'bg-slate-500 text-white hover:bg-slate-600'
      : 'bg-white border border-slate-500 text-slate-500 hover:bg-slate-500 hover:text-white',
  danger:
    $props.outline === false
      ? 'bg-red-600 text-white hover:bg-red-700'
      : 'bg-white border border-red-600 text-red-600 hover:bg-red-600 hover:text-white',
  light:
    'bg-transparent text-slate-600 hover:text-slate-800 hover:bg-slate-100',
});

const sizes = ref({
  xs: 'px-2 py-1 text-xs',
  sm: 'px-3 py-2 text-sm',
  md: 'px-4 py-2 text-base',
  lg: 'md:px-5 md:py-3 md:text-lg px-4 py-2',
});

const styles = computed(() => {
  const styleVariant = variants.value[$props.variant];
  const styleSize = sizes.value[$props.size];
  return `${styleVariant} ${styleSize}`;
});

const iconName = computed(() => {
  const name = $props.icon;
  if (name) {
    return name
      .replace('-thin', '')
      .replace('-light', '')
      .replace('-regular', '')
      .replace('-bold', '')
      .replace('-fill', '')
      .replace('-duotone', '');
  }
  return name;
});

const iconWeight = computed(() => {
  const iconName = $props.icon;
  if (iconName) {
    const iconNameSplitted = iconName.split('-');
    if (iconNameSplitted.includes('thin')) {
      return 'thin';
    } else if (iconNameSplitted.includes('light')) {
      return 'light';
    } else if (iconNameSplitted.includes('bold')) {
      return 'bold';
    } else if (iconNameSplitted.includes('fill')) {
      return 'fill';
    } else if (iconNameSplitted.includes('duotone')) {
      return 'duotone';
    }
  }
  return 'regular';
});
</script>