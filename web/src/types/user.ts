export interface User {
  id: number
  name: string | null
  email: string | null
  cpf: string | null
  birth_date: string | null
  created_at?: string
}

export interface PaginatedResponse<T> {
  data: T[]
  current_page: number
  last_page: number
  per_page: number
  total: number
}
