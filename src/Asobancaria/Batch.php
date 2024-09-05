<?php

declare(strict_types=1);

namespace App\Asobancaria;

class Batch
{
    private BatchHeader $header;
    private ?BatchControl $control = null;
    private array $details = [];

    // Constructor que recibe el BatchHeader
    public function __construct(BatchHeader $header)
    {
        $this->header = $header;
    }

    // Método para agregar un detalle al lote
    public function addDetail(Detail $detail): void
    {
        $this->details[] = $detail;
    }

    // Obtener los detalles del lote
    public function getDetails(): array
    {
        return $this->details;
    }

    // Método para establecer el BatchControl al final del lote
    public function setControl(BatchControl $control): void
    {
        $this->control = $control;
    }

    // Obtener el control del lote
    public function getControl(): ?BatchControl
    {
        return $this->control;
    }

    // Obtener el encabezado del lote
    public function getHeader(): BatchHeader
    {
        return $this->header;
    }

    // Método para cerrar el lote (opcional)
    public function closeBatch(): void
    {
        // Aquí podrías realizar alguna operación cuando se cierra el lote
    }
}
