<?php

declare(strict_types=1);

namespace App\Asobancaria;

class TextFile
{
    private string $content;      // Contenido del archivo de texto
    private string $fileName;     // Nombre original del archivo
    private string $fileHash;     // Hash del archivo
    private string $processedAt;  // Fecha y hora de procesamiento

    private FileHeader $header;
    private array $batches = [];  // Almacenará los lotes (batches)
    private FileControl $control;

    // Constructor para inicializar el contenido del archivo, nombre y fecha de procesamiento
    public function __construct(string $content, string $fileName)
    {
        $this->content = $content;
        $this->fileName = $fileName;
        $this->fileHash = hash('sha256', $content); // Generar hash al inicializar
        $this->processedAt = date('Y-m-d H:i:s');   // Almacenar fecha y hora de procesamiento
    }

    // Método para obtener el contenido del archivo de texto
    public function getContent(): string
    {
        return $this->content;
    }

    // Método para obtener el nombre original del archivo
    public function getFileName(): string
    {
        return $this->fileName;
    }

    // Método para obtener el hash del archivo
    public function getFileHash(): string
    {
        return $this->fileHash;
    }

    // Método para obtener la fecha y hora de procesamiento
    public function getProcessedAt(): string
    {
        return $this->processedAt;
    }

    public function setHeader(FileHeader $header): void
    {
        $this->header = $header;
    }

    public function getHeader(): FileHeader
    {
        return $this->header;
    }

    public function addBatch(Batch $batch): void
    {
        $this->batches[] = $batch;
    }

    public function getBatches(): array
    {
        return $this->batches;
    }

    public function setControl(FileControl $control): void
    {
        $this->control = $control;
    }

    public function getControl(): FileControl
    {
        return $this->control;
    }
}
