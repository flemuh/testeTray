<script setup lang="ts">
import { ref } from 'vue'
import GoogleLoginButton from '@/components/GoogleLoginButton.vue'
import { getGoogleLoginUrl } from '@/services/authService'

const loading = ref(false)
const error = ref('')

async function loginWithGoogle() {
  loading.value = true
  error.value = ''

  try {
    const url = await getGoogleLoginUrl()
    window.location.href = url
  } catch (err) {
    error.value = err instanceof Error ? err.message : 'Erro ao iniciar login com Google.'
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <main class="home-page">
    <section class="home-card">
      <h1>Cadastro de usuários</h1>
      <p>Entre com sua conta Google para iniciar o cadastro.</p>

      <GoogleLoginButton :loading="loading" @click="loginWithGoogle" />

      <p v-if="error" class="feedback-error">{{ error }}</p>
    </section>
  </main>
</template>
