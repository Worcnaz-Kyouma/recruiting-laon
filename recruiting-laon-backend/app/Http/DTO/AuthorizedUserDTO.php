<?php

namespace App\Http\DTO;

use App\Models\User;

class AuthorizedUserDTO {
    public readonly User $user;
    public readonly string $token;

    public function __construct(User $user, string $token) {
        $this->user = $user;
        $this->token = $token;
    }
}
