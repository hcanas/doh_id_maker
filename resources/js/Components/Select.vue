<script setup>
  import {onMounted, ref} from 'vue';

  defineProps(['modelValue']);

  defineEmits(['update:modelValue']);

  const input = ref(null);

  onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
      input.value.focus();
    }
  });
</script>

<template>
  <select
    class=""
    :value="modelValue" @change="$emit('update:modelValue', $event.target.value)" ref="select">
    <slot></slot>
  </select>
</template>
