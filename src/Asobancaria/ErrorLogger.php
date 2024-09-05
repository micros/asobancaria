<?php

declare(strict_types=1);

namespace App\Asobancaria;

class ErrorLogger
{
    public function logError(string $message, bool $isBlocking = false): void
    {
        // Aquí se pueden guardar los errores en una base de datos o archivo de log
    }
}
