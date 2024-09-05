<?php

require __DIR__ . '/vendor/autoload.php';

use App\Asobancaria\TextReceiver;
use App\Asobancaria\TextValidator;
use App\Asobancaria\FileProcessor;

$archivoTexto = 'ejemplos/11JULIO.txt';
$contenidoTexto = file_get_contents($archivoTexto);

// Inicializar el objeto TextFile a través de TextReceiver
$textReceiver = new TextReceiver();
$textFile = $textReceiver->receive($contenidoTexto, $archivoTexto);

// Ejecutar el procesamiento del archivo para extraer los datos
$textValidator = new TextValidator();
$textValidator->validate($textFile);

$fileProcessor = new FileProcessor();
$processingResult = $fileProcessor->process($textFile);

// Verificar si el procesamiento fue exitoso antes de acceder a los datos
if ($processingResult->isSuccessful()) {
    echo "Nombre del archivo: {$textFile->getFileName()}\n";
    echo "Hash del archivo: {$textFile->getFileHash()}\n";
    echo "Fecha de procesamiento: {$textFile->getProcessedAt()}\n";

    // Verificar si el encabezado está inicializado
    if ($textFile->getHeader()) {
        // Mostrar información del encabezado del archivo
        $header = $textFile->getHeader();
        echo "NIT Empresa: {$header->nitEmpresa}\n";
        echo "Fecha del Recaudo: {$header->fechaRecaudo}\n";
        echo "Código Entidad Financiera: {$header->codigoEntidadFinanciera}\n";
        echo "Número de Cuenta: {$header->numeroCuenta}\n";
    } else {
        echo "Encabezado del archivo no encontrado.\n";
    }

    // Iterar entre los lotes (batches)
    foreach ($textFile->getBatches() as $batchIndex => $batch) {
        $loteNum = $batchIndex + 1;
        echo "\n--- Lote {$loteNum} ---\n";

        // Mostrar el encabezado del lote
        $batchHeader = $batch->getHeader();
        echo "Número de Lote: {$batchHeader->numeroLote}\n";
        echo "Código de Servicio: {$batchHeader->codigoServicio}\n";

        // Mostrar los detalles del lote
        foreach ($batch->getDetails() as $detailIndex => $detail) {
            $detalleNum = $detailIndex + 1;
            echo "\n   - Detalle {$detalleNum} -\n";
            echo "Referencia Principal: {$detail->referenciaPrincipal}\n";
            echo "Valor Recaudado: $" . number_format($detail->valorRecaudado, 2) . "\n";
            echo "Procedencia de Pago: {$detail->procedenciaPago}\n";
            echo "Medios de Pago: {$detail->mediosPago}\n";
        }

        // Mostrar el control del lote
        $batchControl = $batch->getControl();
        echo "Total Registros en Lote: {$batchControl->totalRegistrosLote}\n";
        echo "Valor Total Recaudado en Lote: $" . number_format($batchControl->valorTotalRecaudadoLote, 2) . "\n";
    }

    // Mostrar control del archivo
    $control = $textFile->getControl();
    echo "\n--- Control del Archivo ---\n";
    echo "Total de Registros en el Archivo: {$control->totalRegistros}\n";
    echo "Valor Total Recaudado en el Archivo: $" . number_format($control->valorTotalRecaudado, 2) . "\n";
} else {
    echo "Errores durante el procesamiento del archivo.\n";
}
