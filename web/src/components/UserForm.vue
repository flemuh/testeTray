<script setup lang="ts">
import { reactive, computed } from 'vue'
import { formatCpf, onlyDigits } from '@/utils/format'

const props = defineProps<{ loading?: boolean }>()

const emit = defineEmits<{
  (e: 'submit', payload: { name: string; cpf: string; birth_date: string }): void
}>()

const form = reactive({
  name: '',
  cpf: '',
  birth_date: '',
})

const errors = reactive({
  name: '',
  cpf: '',
  birth_date: '',
})

const maxBirthDate = computed(() => new Date().toISOString().split('T')[0])

function validate(): boolean {
  errors.name = ''
  errors.cpf = ''
  errors.birth_date = ''

  if (!form.name.trim()) {
    errors.name = 'Informe o nome.'
  } else if (form.name.trim().length < 3) {
    errors.name = 'O nome deve ter pelo menos 3 caracteres.'
  }

  if (onlyDigits(form.cpf).length !== 11) {
    errors.cpf = 'Informe um CPF válido.'
  }

  if (!form.birth_date) {
    errors.birth_date = 'Informe a data de nascimento.'
  } else if (form.birth_date >= maxBirthDate.value) {
    errors.birth_date = 'A data deve ser anterior a hoje.'
  }

  return !errors.name && !errors.cpf && !errors.birth_date
}

function handleCpfInput(event: Event): void {
  const target = event.target as HTMLInputElement
  form.cpf = formatCpf(target.value)
}

function handleSubmit(): void {
  if (!validate()) return

  emit('submit', {
    name: form.name.trim(),
    cpf: form.cpf,
    birth_date: form.birth_date,
  })
}
</script>

<template>
  <form class="user-form" @submit.prevent="handleSubmit" novalidate>
    <div class="form-field">
      <label for="name">Nome</label>
      <input id="name" v-model="form.name" type="text" />
      <small v-if="errors.name" class="error-text">{{ errors.name }}</small>
    </div>

    <div class="form-field">
      <label for="cpf">CPF</label>
      <input
        id="cpf"
        :value="form.cpf"
        type="text"
        maxlength="14"
        inputmode="numeric"
        @input="handleCpfInput"
      />
      <small v-if="errors.cpf" class="error-text">{{ errors.cpf }}</small>
    </div>

    <div class="form-field">
      <label for="birth_date">Data de nascimento</label>
      <input id="birth_date" v-model="form.birth_date" :max="maxBirthDate" type="date" />
      <small v-if="errors.birth_date" class="error-text">{{ errors.birth_date }}</small>
    </div>

    <button class="btn-primary" type="submit" :disabled="props.loading">
      {{ props.loading ? 'Salvando...' : 'Concluir cadastro' }}
    </button>
  </form>
</template>
