<?php

declare(strict_types=1);

namespace App\Asobancaria;

class BatchDetail
{
    public string $someField;

    // Método estático para procesar una línea y crear un detalle
    public static function parseFromLine(string $line): BatchDetail
    {
        $detail = new self();
        // Asume que el campo relevante está en las posiciones 2 a 12 de la línea
        $detail->someField = substr($line, 2, 10);
        return $detail;
    }
}
