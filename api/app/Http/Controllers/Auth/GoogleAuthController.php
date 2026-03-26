<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\GoogleOAuthService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GoogleAuthController extends Controller
{
    public function __construct(
        private readonly GoogleOAuthService $googleOAuthService,
        private readonly UserService $userService,
    ) {
    }

    public function getLoginUrl(): JsonResponse
    {
        return response()->json([
            'url' => $this->googleOAuthService->getAuthUrl(),
        ]);
    }

    public function callback(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => ['required', 'string'],
        ]);

        try {
            $user = $this->userService->upsertGoogleUserFromCode(
                (string) $request->string('code')
            );

            return redirect(
                config('services.google.frontend_url') . '/complete-registration?user_id=' . $user->id
            );
        } catch (\Throwable) {
            return redirect(
                config('services.google.frontend_url') . '/?error=google_auth_failed'
            );
        }
    }
}
