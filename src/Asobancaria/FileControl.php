<?php

declare(strict_types=1);

namespace App\Asobancaria;

class FileControl
{
    public string $recordType;
    public int $totalRegistros;
    public int $valorTotalRecaudado;

    public static function parseFromLine(string $line): FileControl
    {
        $control = new self();
        $control->recordType = substr($line, 0, 2);
        $control->totalRegistros = (int) substr($line, 2, 9);
        $control->valorTotalRecaudado = (int) substr($line, 11, 18);

        return $control;
    }
}
