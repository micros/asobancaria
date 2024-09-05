<?php

declare(strict_types=1);

namespace App\Asobancaria;

class Detail
{
    public string $tipoRegistro;
    public int $referenciaPrincipal;
    public int $valorRecaudado;
    public int $procedenciaPago;
    public int $mediosPago;
    public int $numeroOperacion;
    public int $numeroAutorizacion;
    public int $codigoEntidadFinanciera;
    public int $codigoSucursal;
    public int $secuencia;
    public string $causalDevolucion;

    public static function parseFromLine(string $line): Detail
    {
        $detail = new self();
        $detail->tipoRegistro = substr($line, 0, 2);
        $detail->referenciaPrincipal = (int) substr($line, 2, 48);
        $detail->valorRecaudado = (int) substr($line, 50, 14);
        $detail->procedenciaPago = (int) substr($line, 64, 2);
        $detail->mediosPago = (int) substr($line, 66, 2);
        $detail->numeroOperacion = (int) substr($line, 68, 6);
        $detail->numeroAutorizacion = (int) substr($line, 74, 6);
        $detail->codigoEntidadFinanciera = (int) substr($line, 80, 3);
        $detail->codigoSucursal = (int) substr($line, 83, 4);
        $detail->secuencia = (int) substr($line, 87, 7);
        $detail->causalDevolucion = substr($line, 94, 3);
        return $detail;
    }
}
