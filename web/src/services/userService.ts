import { api } from './api'
import type { PaginatedResponse, User } from '@/types/user'

export interface CompleteRegistrationPayload {
  name: string
  cpf: string
  birth_date: string
}

export interface UserFiltersParams {
  name?: string
  cpf?: string
  page?: number
  per_page?: number
}

export async function completeRegistration(userId: number, payload: CompleteRegistrationPayload) {
  const { data } = await api.put<{ message: string; data: User }>(
    `/users/${userId}/complete-registration`,
    payload
  )

  return data
}

export async function fetchUsers(params: UserFiltersParams) {
  const search = new URLSearchParams()

  if (params.name) search.set('name', params.name)
  if (params.cpf) search.set('cpf', params.cpf)
  if (params.page) search.set('page', String(params.page))
  if (params.per_page) search.set('per_page', String(params.per_page))

  const { data } = await api.get<PaginatedResponse<User>>(`/users?${search.toString()}`)
  return data
}
