<?php

namespace App\Entities;

class TMDBError extends Entity {
    public const int NOT_FOUND = 34;
    
    private int $statusCode;
    private string $statusMessage;

    
    public function __construct(int $statusCode, string $statusMessage) {
        $this->statusCode = $statusCode;
        $this->statusMessage = $statusMessage;
    }

    public function jsonSerialize(): array {
        return [
            "statusCode" => $this->statusCode,
            "statusMessage" => $this->statusMessage
        ];
    }

    public function getStatusCode(): int {
        return $this->statusCode;
    }

    public function getMessage(): string {
        return $this->statusMessage;
    }
}
