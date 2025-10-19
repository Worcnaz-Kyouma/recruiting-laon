<?php

namespace App\Http\Controllers;

use App\Exceptions\ExpectedErrors\ExpectedError;
use App\Http\DTO\AuthorizedUserDTO;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\LogoutRequest;
use App\Models\User;
use Auth;
use Hash;

class UserController extends Controller {
    private const string TOKEN_IDENTIFIER = "AppUser";

    public function createUser(CreateUserRequest $request) {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        Auth::attempt([
            'email'=> $data['email'],
            'password'=> $data['password'],
        ]);

        $request->session()->regenerate();

        $token = $user->createToken(self::TOKEN_IDENTIFIER)->plainTextToken;

        $authorizedUserDTO = new AuthorizedUserDTO($user, $token);
        
        return response()->json($authorizedUserDTO, 201);
    }

    public function login(LoginRequest $request) {
        $data = $request->validated();
        $email = $data['email'];
        $password = $data['password'];

        $user = User::where('email', $email)->first();
        if(!$user) throw new ExpectedError(422, "Usuario nao encontrado");

        $isLoginSuccessful = Auth::attempt([
            'email'=> $email,
            'password'=> $password
        ]);
        if(!$isLoginSuccessful)
            throw new ExpectedError(422, "Senha invalida");

        $request->session()->regenerate();
        
        $token = $user->createToken(self::TOKEN_IDENTIFIER)->plainTextToken;

        $authorizedUserDTO = new AuthorizedUserDTO($user, $token);

        return response()->json($authorizedUserDTO, 200);
    }

    public function logout(LogoutRequest $request) {
        $data = $request->validated();
        $user = User::find($data['id']);

        $user->tokens()->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([], 204);
    }
}
