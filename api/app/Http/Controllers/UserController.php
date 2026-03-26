<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompleteRegistrationRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {
    }

    public function completeRegistration(CompleteRegistrationRequest $request, int $id): JsonResponse
    {
        $user = $this->userService->completeRegistration($id, $request->validated());

        return response()->json([
            'message' => 'Cadastro concluído com sucesso.',
            'data' => $user,
        ]);
    }

    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'cpf' => ['nullable', 'string', 'max:14'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        $users = $this->userService->listUsers(
            filters: [
                'name' => $validated['name'] ?? null,
                'cpf' => $validated['cpf'] ?? null,
            ],
            perPage: (int) ($validated['per_page'] ?? 10)
        );

        return response()->json($users);
    }
}
