import { defineStore } from 'pinia'
import { fetchUsers } from '@/services/userService'
import type { User } from '@/types/user'

interface UserMeta {
  current_page: number
  last_page: number
  per_page: number
  total: number
}

export const useUserStore = defineStore('userStore', {
  state: () => ({
    users: [] as User[],
    meta: null as UserMeta | null,
    loading: false,
    error: '',
  }),

  actions: {
    async loadUsers(params: { name?: string; cpf?: string; page?: number; per_page?: number }) {
      this.loading = true
      this.error = ''

      try {
        const response = await fetchUsers(params)

        this.users = response.data
        this.meta = {
          current_page: response.current_page,
          last_page: response.last_page,
          per_page: response.per_page,
          total: response.total,
        }
      } catch (err) {
        this.error = err instanceof Error ? err.message : 'Erro ao carregar usuários.'
      } finally {
        this.loading = false
      }
    },
  },
})
