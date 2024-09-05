<?php

declare(strict_types=1);

namespace App\Asobancaria;

class ProcessingResult
{
    public bool $isSuccessful;
    public array $errors = [];

    public function __construct(bool $isSuccessful)
    {
        $this->isSuccessful = $isSuccessful;
    }

    public function addError(string $error): void
    {
        $this->errors[] = $error;
        $this->isSuccessful = false; // Si hay errores, el procesamiento no es exitoso
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function isSuccessful(): bool
    {
        return $this->isSuccessful;
    }
}
