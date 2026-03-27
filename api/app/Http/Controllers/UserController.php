<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompleteRegistrationRequest;
use App\Http\Requests\UserIndexRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {}

    public function completeRegistration(CompleteRegistrationRequest $request, int $id): JsonResponse
    {
        $user = $this->userService->completeRegistration($id, $request->validated());

        return response()->json([
            'message' => 'Cadastro concluído com sucesso.',
            'data' => $user,
        ]);
    }

    public function index(UserIndexRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $users = $this->userService->listUsers(
            filters: [
                'name' => $validated['name'] ?? null,
                'cpf' => $validated['cpf'] ?? null,
            ],
            perPage: (int) ($validated['per_page'] ?? 10),
            page: (int) ($validated['page'] ?? 1),
        );

        return response()->json($users);
    }
}
