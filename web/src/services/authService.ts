import { api } from './api'

export async function getGoogleLoginUrl(): Promise<string> {
  const { data } = await api.get<{ url: string }>('/auth/google/url')
  return data.url
}
