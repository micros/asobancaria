<?php

require __DIR__ . '/vendor/autoload.php';

use App\Asobancaria\TextReceiver;
use App\Asobancaria\TextValidator;
use App\Asobancaria\FileProcessor;

// Verificar si el archivo fue proporcionado
if ($argc < 2) {
    echo "Uso: php process_asobancaria.php <archivo_de_texto>\n";
    exit(1);
}

$archivoTexto = $argv[1];

// Verificar si el archivo existe
if (!file_exists($archivoTexto)) {
    echo "El archivo no existe: $archivoTexto\n";
    exit(1);
}

// Leer el contenido del archivo
$contenidoTexto = file_get_contents($archivoTexto);

try {
    // Crear instancias de las clases necesarias
    $textReceiver = new TextReceiver();
    $textValidator = new TextValidator();
    $fileProcessor = new FileProcessor();

    // Recibir y validar el archivo con su contenido y nombre
    $textFile = $textReceiver->receive($contenidoTexto, $archivoTexto); // Pasamos también el nombre del archivo
    $textValidator->validate($textFile);

    // Procesar el archivo si pasa la validación
    $processingResult = $fileProcessor->process($textFile);

    if ($processingResult->isSuccessful()) {
        echo "El archivo ha sido procesado con éxito.\n";
        mostrarResumen($textFile);
    } else {
        echo "Errores durante el procesamiento:\n";
        foreach ($processingResult->getErrors() as $error) {
            echo $error . "\n";
        }
    }
} catch (\Exception $e) {
    // Captura de excepciones
    echo "Error durante la validación: " . $e->getMessage() . "\n";
    exit(1);
}

// Función para mostrar el resumen del archivo procesado
function mostrarResumen($textFile)
{
    echo "Archivo procesado: " . $textFile->getFileName() . "\n";
    echo "Hash del archivo: " . $textFile->getFileHash() . "\n";
    echo "Fecha y hora de procesamiento: " . $textFile->getProcessedAt() . "\n";
    echo "-------------------------------------\n";

    // Mostrar encabezado del archivo
    $header = $textFile->getHeader();
    echo "Encabezado del archivo:\n";
    echo "NIT Empresa: {$header->nitEmpresa}\n";
    echo "Fecha de Recaudo: {$header->fechaRecaudo}\n";
    echo "Código Entidad Financiera: {$header->codigoEntidadFinanciera}\n";
    echo "Número de Cuenta: {$header->numeroCuenta}\n";
    echo "-------------------------------------\n";

    // Mostrar lotes y detalles
    foreach ($textFile->getBatches() as $batch) {
        $batchHeader = $batch->getHeader();
        echo "Lote Número: {$batchHeader->numeroLote}, Código de Servicio: {$batchHeader->codigoServicio}\n";

        // Mostrar detalles del lote con formato de moneda
        foreach ($batch->getDetails() as $detail) {
            $valorRecaudado = number_format($detail->valorRecaudado, 2, '.', ',');
            echo " - Referencia: {$detail->referenciaPrincipal}, Valor Recaudado: \${$valorRecaudado}\n";
        }

        // Mostrar control del lote con formato de moneda
        $batchControl = $batch->getControl();
        $valorTotalLote = number_format($batchControl->valorTotalRecaudadoLote, 2, '.', ',');
        echo "Control del Lote - Total Registros: {$batchControl->totalRegistrosLote}, Valor Total: \${$valorTotalLote}\n";
        echo "-------------------------------------\n";
    }

    // Mostrar control del archivo con formato de moneda
    $control = $textFile->getControl();
    $valorTotalRecaudado = number_format($control->valorTotalRecaudado, 2, '.', ',');
    echo "Control del archivo:\n";
    echo "Total de Registros: {$control->totalRegistros}, Valor Total Recaudado: \${$valorTotalRecaudado}\n";
}
