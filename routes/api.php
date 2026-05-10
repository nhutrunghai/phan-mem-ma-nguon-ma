<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

function cinemaApiUserResource(User $user): array
{
    return [
        'id' => (string) $user->getKey(),
        'name' => $user->name,
        'email' => $user->email,
        'phone' => $user->phone,
        'role' => $user->role ?? 'user',
        'status' => (bool) ($user->status ?? true),
    ];
}

function cinemaApiUserFromBearer(Request $request): ?User
{
    $authorization = (string) $request->header('Authorization', '');
    $token = preg_replace('/^Bearer\s+/i', '', $authorization);

    if (! is_string($token) || $token === $authorization || $token === '') {
        return null;
    }

    return User::query()
        ->where('api_token_hash', hash('sha256', $token))
        ->where('status', '!=', false)
        ->first();
}

Route::prefix('v1/auth')->group(function (): void {
    Route::post('/login', function (Request $request) {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::query()->where('email', $validated['email'])->first();

        if (! $user || ! Hash::check($validated['password'], (string) $user->password)) {
            return response()->json([
                'message' => 'Email hoặc mật khẩu không đúng.',
            ], 422);
        }

        if (($user->status ?? true) === false) {
            return response()->json([
                'message' => 'Tài khoản đã bị khóa.',
            ], 403);
        }

        $token = 'cinema_' . Str::random(64);
        $user->forceFill([
            'api_token_hash' => hash('sha256', $token),
        ])->save();

        return response()->json([
            'message' => 'Đăng nhập thành công.',
            'data' => [
                'token' => $token,
                'user' => cinemaApiUserResource($user),
            ],
        ]);
    });

    Route::post('/register', function (Request $request) {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160'],
            'password' => ['required', 'string', 'min:6'],
            'phone' => ['nullable', 'string', 'max:40'],
        ]);

        if (User::query()->where('email', $validated['email'])->exists()) {
            return response()->json([
                'message' => 'Email này đã được đăng ký.',
            ], 422);
        }

        $token = 'cinema_' . Str::random(64);
        $user = User::query()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'phone' => $validated['phone'] ?? null,
            'role' => 'user',
            'status' => true,
        ]);

        $user->forceFill([
            'api_token_hash' => hash('sha256', $token),
        ])->save();

        return response()->json([
            'message' => 'Đăng ký thành công.',
            'data' => [
                'token' => $token,
                'user' => cinemaApiUserResource($user),
            ],
        ], 201);
    });

    Route::get('/me', function (Request $request) {
        $user = cinemaApiUserFromBearer($request);

        if (! $user) {
            return response()->json([
                'message' => 'Chưa đăng nhập.',
            ], 401);
        }

        return response()->json([
            'data' => [
                'user' => cinemaApiUserResource($user),
            ],
        ]);
    });

    Route::post('/logout', function (Request $request) {
        $user = cinemaApiUserFromBearer($request);

        if ($user) {
            $user->forceFill(['api_token_hash' => null])->save();
        }

        return response()->json([
            'message' => 'Đã đăng xuất.',
        ]);
    });
});
