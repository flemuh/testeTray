<script setup lang="ts">
import type { User } from '@/types/user'

defineProps<{ users: User[] }>()
</script>

<template>
  <div class="table-wrapper">
    <table class="user-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nome</th>
          <th>E-mail</th>
          <th>CPF</th>
          <th>Nascimento</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id">
          <td>{{ user.id }}</td>
          <td>{{ user.name ?? '-' }}</td>
          <td>{{ user.email ?? '-' }}</td>
          <td>{{ user.cpf ?? '-' }}</td>
          <td>{{ user.birth_date ?? '-' }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
