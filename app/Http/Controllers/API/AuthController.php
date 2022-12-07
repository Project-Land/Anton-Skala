<?php

namespace App\Http\Controllers\API;

use Throwable;
use App\Models\Role;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'lang' => $request->lang,
                'school' => $request->school,
                'role_id' => Role::STUDENT,
            ]);
            event(new Registered($user));
            $token = $user->createToken('auth')->plainTextToken;
        } catch (Throwable $e) {
            throw new HttpResponseException(response()->json(['message' => __('Došlo je do greške. Pokušajte ponovo.')], 400));
        }
        return response()->json(['message' => __('Korisnički nalog uspešno kreiran'), 'access_token' => $token], 200);
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('username', $request->username)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => __('Neispravni podaci')], 400);
        }

        $token = $user->createToken('auth')->plainTextToken;

        return response()->json([
            'access_token' => $token
        ]);
    }

    public function logout()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => __('Korisnik nije pronađen')], 404);
        }

        $user->currentAccessToken()->delete();
        $user->update(['device_token' => null]);
        return response()->json(['message' => __('Korisnik odjavljen')], 200);
    }

    public function show()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => __('Korisnik nije pronađen')], 404);
        } else {
            return new UserResource($user);
        }
    }
}
