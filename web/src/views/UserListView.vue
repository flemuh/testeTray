<script setup lang="ts">
import { onMounted, ref } from 'vue'
import UserFilters from '@/components/UserFilters.vue'
import UserTable from '@/components/UserTable.vue'
import { useUserStore } from '@/stores/userStore'

const store = useUserStore()
const page = ref(1)
const currentFilters = ref({ name: '', cpf: '' })

async function search(filters: { name: string; cpf: string }) {
  currentFilters.value = filters
  page.value = 1
  await store.loadUsers({ ...filters, page: 1, per_page: 10 })
}

async function nextPage() {
  page.value++
  await store.loadUsers({ ...currentFilters.value, page: page.value, per_page: 10 })
}

onMounted(async () => {
  await store.loadUsers({ page: 1, per_page: 10 })
})
</script>

<template>
  <main class="users-page">
    <section class="users-card">
      <div class="users-header">
        <h1>Usuários cadastrados</h1>
        <p>Filtre por nome ou CPF.</p>
      </div>

      <UserFilters @search="search" />

      <p v-if="store.loading">Carregando...</p>
      <p v-if="store.error" class="feedback-error">{{ store.error }}</p>
      <p v-if="!store.loading && store.meta">Total: {{ store.meta.total }}</p>

      <UserTable :users="store.users" />

      <button
        v-if="store.meta && store.meta.current_page < store.meta.last_page"
        class="btn-primary"
        @click="nextPage"
      >
        Próxima página
      </button>
    </section>
  </main>
</template>
