<?php

declare(strict_types=1);

namespace App\Asobancaria;

class BatchHeader
{
    public string $tipoRegistro;
    public int $codigoServicio;
    public int $numeroLote;

    public static function parseFromLine(string $line): BatchHeader
    {
        $header = new self();
        $header->tipoRegistro = substr($line, 0, 2);
        $header->codigoServicio = (int) substr($line, 2, 13);
        $header->numeroLote = (int) substr($line, 15, 4);
        return $header;
    }
}
