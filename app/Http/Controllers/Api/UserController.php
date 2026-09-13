<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $data = $request->validate([
            'limit' => ['nullable', 'integer', 'min:1', 'max:100'],
            'page' => ['nullable', 'integer', 'min:1'],
        ]);

        $limit = $data['limit'] ?? 20;
        $users = User::query()->orderBy('id')->paginate($limit);

        return response()->json([
            'data' => $users->getCollection()
                ->map(fn (User $user): array => $this->userData($user))
                ->values(),
            'meta' => [
                'total' => $users->total(),
                'limit' => $users->perPage(),
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage(),
            ],
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'login' => ['required', 'string', 'max:255', 'unique:users,login'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:255', 'unique:users,phone'],
            'password' => ['required', 'string', 'min:8', 'max:255'],
        ]);

        $user = User::query()->create([
            'login' => $data['login'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password_hash' => Hash::make($data['password']),
        ]);

        return response()->json(['data' => $this->userData($user)], JsonResponse::HTTP_CREATED);
    }

    /** @return array{id: int, login: string, email: string, phone: string, created_at: string, updated_at: string} */
    private function userData(User $user): array
    {
        return [
            'id' => $user->id,
            'login' => $user->login,
            'email' => $user->email,
            'phone' => $user->phone,
            'created_at' => $user->created_at->toAtomString(),
            'updated_at' => $user->updated_at->toAtomString(),
        ];
    }
}
