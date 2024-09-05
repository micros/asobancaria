<?php

declare(strict_types=1);

namespace App\Asobancaria;

class TextReceiver
{
    public function receive(string $text, string $fileName): TextFile
    {
        // Verificar si el texto está vacío
        if (empty($text)) {
            throw new \InvalidArgumentException("Text cannot be empty");
        }

        // Si pasa todas las validaciones, retorna el objeto TextFile con el nombre del archivo
        return new TextFile($text, $fileName);
    }
}
