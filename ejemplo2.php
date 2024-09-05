<?php

use App\Asobancaria\AsobancariaProcessor;

require __DIR__ . '/vendor/autoload.php';

try {
    // Inicializa el procesador
    $processor = new AsobancariaProcessor();

    // Procesa el archivo ASOBANCARIA
    $textFile = $processor->processFile('ejemplos/VARIOS.TXT');

    // Muestra el resumen del archivo procesado
    $processor->mostrarResumen($textFile);
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
