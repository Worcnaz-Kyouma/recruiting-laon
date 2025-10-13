<?php

namespace App\Services;

use App\Models\User;

class UserService {
    public function createUserAndAccessToken(UserCreationDTO $userCreationDTO): AuthorizedUserDTO {

    }

    public function login(string $email, string $password): AuthorizedUserDTO {

    }

    public function logout(User $user): void {

    }
}