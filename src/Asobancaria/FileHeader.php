<?php

declare(strict_types=1);

namespace App\Asobancaria;

class FileHeader
{
    public string $tipoRegistro;
    public string $nitEmpresa;
    public string $fechaRecaudo;
    public string $codigoEntidadFinanciera;
    public string $numeroCuenta;
    public string $fechaArchivo;
    public string $horaGrabacionArchivo;
    public string $modificadorArchivo;
    public string $tipoCuenta;

    public static function parseFromLine(string $line): FileHeader
    {
        $header = new self();
        $header->tipoRegistro = substr($line, 0, 2);
        $header->nitEmpresa = substr($line, 2, 10);
        $header->fechaRecaudo = substr($line, 12, 8);
        $header->codigoEntidadFinanciera = substr($line, 20, 3);
        $header->numeroCuenta = substr($line, 23, 17);
        $header->fechaArchivo = substr($line, 40, 8);
        $header->horaGrabacionArchivo = substr($line, 48, 4);
        $header->modificadorArchivo = substr($line, 52, 1);
        $header->tipoCuenta = substr($line, 53, 2);
        return $header;
    }
}
