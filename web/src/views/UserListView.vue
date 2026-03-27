<script setup lang="ts">
import { computed, onMounted, ref } from 'vue'
import UserFilters from '@/components/UserFilters.vue'
import UserTable from '@/components/UserTable.vue'
import { useUserStore } from '@/stores/userStore'
import { useRouter } from 'vue-router'
import { ArrowLeftIcon } from '@heroicons/vue/24/outline'

const store = useUserStore()
const page = ref(1)
const perPage = 10
const currentFilters = ref({ name: '', cpf: '' })

const router = useRouter()

function goHome() {
  router.push('/')
}

async function loadPage(targetPage: number) {
  if (!store.meta) return
  if (targetPage < 1 || targetPage > store.meta.last_page) return

  page.value = targetPage

  await store.loadUsers({
    ...currentFilters.value,
    page: targetPage,
    per_page: perPage,
  })
}

async function search(filters: { name: string; cpf: string }) {
  currentFilters.value = filters
  page.value = 1

  await store.loadUsers({
    ...filters,
    page: 1,
    per_page: perPage,
  })
}

async function nextPage() {
  await loadPage(page.value + 1)
}

async function previousPage() {
  await loadPage(page.value - 1)
}

const visiblePages = computed<(number | string)[]>(() => {
  if (!store.meta) return []

  const current = store.meta.current_page
  const last = store.meta.last_page

  if (last <= 5) {
    return Array.from({ length: last }, (_, index) => index + 1)
  }

  if (current <= 2) {
    return [1, 2, 3, '...', last]
  }

  if (current >= last - 1) {
    return [1, '...', last - 2, last - 1, last]
  }

  return [1, '...', current - 1, current, current + 1, '...', last]
})

onMounted(async () => {
  await store.loadUsers({ page: 1, per_page: perPage })
})
</script>


<template>
  <main class="users-page">
    <section class="users-card">
      <div class="page-header">
        <button class="btn-secondary btn-with-icon" @click="goHome">
          <ArrowLeftIcon class="icon" />
          Voltar
        </button>

        <div class="users-header">
          <h1>Usuários cadastrados</h1>
        </div>
      </div>

      <UserFilters @search="search" />

      <p v-if="store.loading">Carregando...</p>
      <p v-if="store.error" class="feedback-error">{{ store.error }}</p>

      <template v-if="!store.loading && store.meta">
        <p>
          Total: {{ store.meta.total }} |
          Página {{ store.meta.current_page }} de {{ store.meta.last_page }}
        </p>
      </template>

      <UserTable :users="store.users" />
      <div v-if="store.meta && store.meta.last_page > 1" class="pagination">
        <button
          class="btn-secondary"
          :disabled="store.loading || store.meta.current_page === 1"
          @click="previousPage"
        >
          Anterior
        </button>

        <template v-for="item in visiblePages" :key="`${item}`">
          <span v-if="item === '...'" class="pagination-ellipsis">...</span>

          <button
            v-else
            class="page-number"
            :class="{ active: item === store.meta.current_page }"
            :disabled="store.loading"
            @click="loadPage(Number(item))"
          >
            {{ item }}
          </button>
        </template>

        <button
          class="btn-primary"
          :disabled="store.loading || store.meta.current_page === store.meta.last_page"
          @click="nextPage"
        >
          Próxima
        </button>
      </div>
    </section>
  </main>
</template>
