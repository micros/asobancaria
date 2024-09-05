<?php

declare(strict_types=1);

namespace App\Asobancaria;

class BatchControl
{
    public string $tipoRegistro;
    public int $totalRegistrosLote;
    public int $valorTotalRecaudadoLote;
    public int $numeroLote;

    public static function parseFromLine(string $line): BatchControl
    {
        $control = new self();
        $control->tipoRegistro = substr($line, 0, 2);
        $control->totalRegistrosLote = (int) substr($line, 2, 9);
        $control->valorTotalRecaudadoLote = (int) substr($line, 11, 18);
        $control->numeroLote = (int) substr($line, 29, 4);
        return $control;
    }
}
