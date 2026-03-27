<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $total = 15000;
        $batchSize = 1000;

        for ($offset = 0; $offset < $total; $offset += $batchSize) {
            $users = [];

            $limit = min($batchSize, $total - $offset);

            for ($i = 0; $i < $limit; $i++) {
                $index = $offset + $i + 1;
                $now = now();

                $users[] = [
                    'google_id' => (string) Str::uuid(),
                    'google_access_token' => hash('sha256', 'access_token_'.$index),
                    'google_refresh_token' => hash('sha256', 'refresh_token_'.$index),
                    'google_token_expires_at' => $now->copy()->addHour(),
                    'email' => "user{$index}@example.com",
                    'email_verified_at' => $now,
                    'name' => "Usuário {$index}",
                    'cpf' => str_pad((string) $index, 11, '0', STR_PAD_LEFT),
                    'birth_date' => fake()->date('Y-m-d', '-18 years'),
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            User::query()->insert($users);

            $this->command->info('Inseridos: '.($offset + $limit).'/'.$total);
        }
    }
}
