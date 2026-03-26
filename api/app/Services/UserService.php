<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\Auth\GoogleOAuthService;
use RuntimeException;

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
}
