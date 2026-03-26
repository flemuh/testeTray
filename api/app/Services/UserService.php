<?php

namespace App\Services;

use App\Jobs\SendRegistrationCompletedEmailJob;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\Auth\GoogleOAuthService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use RuntimeException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly GoogleOAuthService $googleOAuthService,
    ) {
    }

    public function upsertGoogleUserFromCode(string $code): User
    {
        $tokenData = $this->googleOAuthService->fetchAccessToken($code);

        if (isset($tokenData['error'])) {
            throw new RuntimeException('Erro ao obter token do Google.');
        }

        $googleData = $this->googleOAuthService->getGoogleUserDataByAccessToken(
            $tokenData['access_token']
        );

        $user = $this->userRepository->findByGoogleIdOrEmail(
            $googleData['google_id'] ?? null,
            $googleData['email'] ?? null
        ) ?? new User();

        $user->google_id = $googleData['google_id'] ?? $user->google_id;
        $user->google_access_token = $tokenData['access_token'];
        $user->google_refresh_token = $tokenData['refresh_token'] ?? $user->google_refresh_token;
        $user->google_token_expires_at = isset($tokenData['expires_in'])
            ? now()->addSeconds((int) $tokenData['expires_in'])
            : null;

        return $this->userRepository->save($user);
    }

    public function completeRegistration(int $id, array $data): User
    {
        return DB::transaction(function () use ($id, $data): User {
            $user = $this->userRepository->findById($id);

            if (! $user) {
                throw new NotFoundHttpException('Usuário não encontrado.');
            }

            $user->name = trim($data['name']);
            $user->cpf = $data['cpf'];
            $user->birth_date = $data['birth_date'];

            $savedUser = $this->userRepository->save($user);

            if (empty($savedUser->google_access_token)) {
                throw new RuntimeException('Token do Google não encontrado para o usuário.');
            }

            $googleData = $this->googleOAuthService->getGoogleUserDataByAccessToken(
                $savedUser->google_access_token
            );

            $email = $googleData['email'] ?? null;

            if (! $email) {
                throw new RuntimeException('Não foi possível recuperar o e-mail pelo token do Google.');
            }

            if ($savedUser->email !== $email) {
                $savedUser->email = $email;
                $savedUser = $this->userRepository->save($savedUser);
            }

            SendRegistrationCompletedEmailJob::dispatch($savedUser->id, $email);

            return $savedUser;
        });
    }

    public function listUsers(array $filters, int $perPage): LengthAwarePaginator
    {
        return $this->userRepository->paginateWithFilters($filters, $perPage);
    }
}
