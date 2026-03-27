<script setup lang="ts">
import { computed, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import UserForm from '@/components/UserForm.vue'
import { completeRegistration } from '@/services/userService'

const route = useRoute()
const router = useRouter()

const loading = ref(false)
const error = ref('')
const userId = computed(() => Number(route.query.user_id))

async function handleSubmit(payload: { name: string; cpf: string; birth_date: string }) {
  if (!userId.value) {
    error.value = 'Usuário inválido para conclusão do cadastro.'
    return
  }

  loading.value = true
  error.value = ''

  try {
    await completeRegistration(userId.value, payload)
    await router.push('/users')
  } catch (err) {
    error.value = err instanceof Error ? err.message : 'Erro ao concluir cadastro.'
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <main class="complete-registration-page">
    <section class="registration-card">
      <h1>Completar cadastro</h1>
      <p>Preencha os dados abaixo para finalizar seu cadastro.</p>

      <p v-if="error" class="feedback-error">{{ error }}</p>

      <UserForm :loading="loading" @submit="handleSubmit" />
    </section>
  </main>
</template>
