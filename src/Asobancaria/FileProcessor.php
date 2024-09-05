<?php

declare(strict_types=1);

namespace App\Asobancaria;

class FileProcessor
{
    public function process(TextFile $textFile): ProcessingResult
    {
        $lines = explode(PHP_EOL, $textFile->getContent());
        $currentBatch = null;
        $processingResult = new ProcessingResult(true); // Inicialmente asumimos que el procesamiento es exitoso

        foreach ($lines as $lineNumber => $line) {
            $trimmedLine = trim($line);

            try {
                if (substr($trimmedLine, 0, 2) === '01') {
                    // Procesar FileHeader
                    $header = FileHeader::parseFromLine($trimmedLine);
                    $textFile->setHeader($header);
                } elseif (substr($trimmedLine, 0, 2) === '05') {
                    // Procesar BatchHeader y crear un nuevo lote
                    $batchHeader = BatchHeader::parseFromLine($trimmedLine);
                    $currentBatch = new Batch($batchHeader);
                    $textFile->addBatch($currentBatch);
                } elseif (substr($trimmedLine, 0, 2) === '06') {
                    // Procesar Detail y agregarlo al lote actual
                    if ($currentBatch === null) {
                        throw new \InvalidArgumentException("No hay un lote abierto para agregar el detalle.");
                    }
                    $detail = Detail::parseFromLine($trimmedLine);
                    $currentBatch->addDetail($detail);
                } elseif (substr($trimmedLine, 0, 2) === '08') {
                    // Procesar BatchControl y cerrar el lote
                    if ($currentBatch === null) {
                        throw new \InvalidArgumentException("No hay un lote abierto al encontrar el control.");
                    }
                    $batchControl = BatchControl::parseFromLine($trimmedLine);
                    $currentBatch->setControl($batchControl);
                    $currentBatch->closeBatch();
                } elseif (substr($trimmedLine, 0, 2) === '09') {
                    // Procesar FileControl
                    $control = FileControl::parseFromLine($trimmedLine);
                    $textFile->setControl($control);
                }
            } catch (\Exception $e) {
                // Si ocurre algún error durante el procesamiento, lo registramos y marcamos el procesamiento como fallido
                $processingResult->addError("Error en la línea " . ($lineNumber + 1) . ": " . $e->getMessage());
            }
        }

        return $processingResult;
    }
}
