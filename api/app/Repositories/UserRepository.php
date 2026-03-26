<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository
{
    public function findByGoogleIdOrEmail(?string $googleId, ?string $email): ?User
    {
        return User::query()
            ->when($googleId, fn ($query) => $query->where('google_id', $googleId))
            ->when($email, fn ($query) => $query->orWhere('email', $email))
            ->first();
    }

    public function findById(int $id): ?User
    {
        return User::query()->find($id);
    }

    public function save(User $user): User
    {
        $user->save();

        return $user->refresh();
    }

    public function paginateWithFilters(array $filters, int $perPage): LengthAwarePaginator
    {
        return User::query()
            ->select(['id', 'name', 'email', 'cpf', 'birth_date', 'created_at'])
            ->when(
                ! empty($filters['name']),
                fn ($query) => $query->where('name', 'like', trim($filters['name']) . '%')
            )
            ->when(
                ! empty($filters['cpf']),
                fn ($query) => $query->where('cpf', preg_replace('/\D+/', '', $filters['cpf']))
            )
            ->orderByDesc('id')
            ->paginate($perPage);
    }
}
