<?php

declare(strict_types=1);

namespace App\Asobancaria;

class ValidationResult
{
    private bool $isValid;
    private string $message;

    public function __construct(bool $isValid, string $message)
    {
        $this->isValid = $isValid;
        $this->message = $message;
    }

    public function isValid(): bool
    {
        return $this->isValid;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
