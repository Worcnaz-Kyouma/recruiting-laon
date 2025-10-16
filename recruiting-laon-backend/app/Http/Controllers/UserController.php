<?php

namespace App\Http\Controllers;

use App\Exceptions\ExpectedErrors\ExpectedError;
use App\Exceptions\UnexpectedErrors\AppFailedDatabaseCommunication;
use App\Http\DTO\AuthorizedUserDTO;
use App\Http\DTO\UserCreationDTO;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\LogoutRequest;
use App\Models\User;
use Auth;
use Hash;

// TODO: Make big try catch wrappers, then identify error in catch
class UserController extends Controller {
    private const string TOKEN_IDENTIFIER = "AppUser";

    // TODO: Fix duplicated email
    public function createUser(CreateUserRequest $request) {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $token = $user->createToken(self::TOKEN_IDENTIFIER)->plainTextToken;

        $authorizedUserDTO = new AuthorizedUserDTO($user, $token);
        return response()->json($authorizedUserDTO, 201);
    }

    public function login(LoginRequest $request) {
        $data = $request->validated();
        $email = $data['email'];
        $password = $data['password'];

        $user = User::where('email', $email)->first();
        if(!$user) throw new ExpectedError("", 401, "Usuario nao encontrado");

        $isLoginSuccessful = Auth::attempt([
            'email'=> $email,
            'password'=> $password
        ]);
        if(!$isLoginSuccessful)
            throw new ExpectedError("", 401, "Senha invalida");

        $request->session()->regenerate();
        
        // $user->tokens()->delete();
        $token = $user->createToken(self::TOKEN_IDENTIFIER)->plainTextToken;

        $authorizedUserDTO = new AuthorizedUserDTO($user, $token);

        return response()->json($authorizedUserDTO, 200);
    }

    public function logout(LogoutRequest $request) {
        $data = $request->validated();
        $user = User::find($data['user_id']);

        $user->tokens()->delete();

        return response()->json([], 204);
    }
}
