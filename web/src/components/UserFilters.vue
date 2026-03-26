<script setup lang="ts">
import { reactive } from 'vue'
import { formatCpf } from '@/utils/format'

const emit = defineEmits<{
  (e: 'search', payload: { name: string; cpf: string }): void
}>()

const filters = reactive({
  name: '',
  cpf: '',
})

function handleCpfInput(event: Event): void {
  const target = event.target as HTMLInputElement
  filters.cpf = formatCpf(target.value)
}

function submitFilters(): void {
  emit('search', {
    name: filters.name.trim(),
    cpf: filters.cpf,
  })
}
</script>

<template>
  <form class="filters-form" @submit.prevent="submitFilters">
    <input v-model="filters.name" type="text" placeholder="Filtrar por nome" />
    <input
      :value="filters.cpf"
      type="text"
      inputmode="numeric"
      maxlength="14"
      placeholder="Filtrar por CPF"
      @input="handleCpfInput"
    />
    <button class="btn-primary" type="submit">Buscar</button>
  </form>
</template>
