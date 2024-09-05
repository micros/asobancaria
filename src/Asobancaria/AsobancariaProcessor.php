<?php

declare(strict_types=1);

namespace App\Asobancaria;

class AsobancariaProcessor
{
    private TextReceiver $textReceiver;
    private TextValidator $textValidator;
    private FileProcessor $fileProcessor;

    public function __construct()
    {
        $this->textReceiver = new TextReceiver();
        $this->textValidator = new TextValidator();
        $this->fileProcessor = new FileProcessor();
    }

    public function processFile(string $filePath): TextFile
    {
        if (!file_exists($filePath)) {
            throw new \InvalidArgumentException("El archivo no existe: $filePath");
        }

        $contenidoTexto = file_get_contents($filePath);
        $textFile = $this->textReceiver->receive($contenidoTexto, $filePath);

        // Validar el archivo
        $this->textValidator->validate($textFile);

        // Procesar el archivo
        $processingResult = $this->fileProcessor->process($textFile);

        if (!$processingResult->isSuccessful()) {
            throw new \RuntimeException("Errores durante el procesamiento del archivo.");
        }

        return $textFile;
    }

    public function mostrarResumen(TextFile $textFile): void
    {
        echo "Nombre del archivo: {$textFile->getFileName()}\n";
        echo "Hash del archivo: {$textFile->getFileHash()}\n";
        echo "Fecha de procesamiento: {$textFile->getProcessedAt()}\n";

        // Verificar si el encabezado está inicializado
        if ($textFile->getHeader()) {
            $header = $textFile->getHeader();
            echo "NIT Empresa: {$header->nitEmpresa}\n";
            echo "Fecha del Recaudo: {$header->fechaRecaudo}\n";
            echo "Código Entidad Financiera: {$header->codigoEntidadFinanciera}\n";
            echo "Número de Cuenta: {$header->numeroCuenta}\n";
        } else {
            echo "Encabezado del archivo no encontrado.\n";
        }

        foreach ($textFile->getBatches() as $batchIndex => $batch) {
            $loteNum = $batchIndex + 1;
            echo "\n--- Lote {$loteNum} ---\n";

            $batchHeader = $batch->getHeader();
            echo "Número de Lote: {$batchHeader->numeroLote}\n";
            echo "Código de Servicio: {$batchHeader->codigoServicio}\n";

            foreach ($batch->getDetails() as $detailIndex => $detail) {
                $detalleNum = $detailIndex + 1;
                echo "\n   - Detalle {$detalleNum} -\n";
                echo "Referencia Principal: {$detail->referenciaPrincipal}\n";
                echo "Valor Recaudado: $" . number_format($detail->valorRecaudado, 2) . "\n";
                echo "Procedencia de Pago: {$detail->procedenciaPago}\n";
                echo "Medios de Pago: {$detail->mediosPago}\n";
            }

            $batchControl = $batch->getControl();
            echo "Total Registros en Lote: {$batchControl->totalRegistrosLote}\n";
            echo "Valor Total Recaudado en Lote: $" . number_format($batchControl->valorTotalRecaudadoLote, 2) . "\n";
        }

        $control = $textFile->getControl();
        echo "\n--- Control del Archivo ---\n";
        echo "Total de Registros en el Archivo: {$control->totalRegistros}\n";
        echo "Valor Total Recaudado en el Archivo: $" . number_format($control->valorTotalRecaudado, 2) . "\n";
    }
}
