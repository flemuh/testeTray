<script setup lang="ts">
defineProps<{ loading?: boolean }>()
const emit = defineEmits<{ (e: 'click'): void }>()
</script>

<template>
  <button class="google-login-button" :disabled="loading" @click="emit('click')">
    {{ loading ? 'Redirecionando...' : 'Continuar com Google' }}
  </button>
</template>
