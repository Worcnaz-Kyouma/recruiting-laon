<?php

namespace App\Http\DTO;

use App\Entities\Entity;
use Illuminate\Support\Collection;

class UserCreationDTO {
    public readonly string $name;
    public readonly string $email;
    public readonly string $password;
    public readonly string $passwordConfirmation;

    public function __construct(string $name, string $email, string $password, string $passwordConfirmation) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->passwordConfirmation = $passwordConfirmation;
    }
}
