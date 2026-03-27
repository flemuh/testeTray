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
    <div class="filters-header">
      <p>Busque por nome ou CPF.</p>
    </div>

    <div class="filters-grid">
      <div class="form-field">
        <label for="filter-name">Nome</label>
        <input
          id="filter-name"
          v-model="filters.name"
          type="text"
          placeholder="Digite o nome"
        />
      </div>

      <div class="form-field">
        <label for="filter-cpf">CPF</label>
        <input
          id="filter-cpf"
          :value="filters.cpf"
          type="text"
          inputmode="numeric"
          maxlength="14"
          placeholder="000.000.000-00"
          @input="handleCpfInput"
        />
      </div>

      <div class="filters-actions">
        <button class="btn-primary" type="submit">Buscar</button>
      </div>
    </div>
  </form>
</template>
