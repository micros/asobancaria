
# ASOBANCARIA Parser

[![Packagist Version](https://img.shields.io/packagist/v/micros/asobancaria.svg)](https://packagist.org/packages/micros/asobancaria)
[![MIT License](https://img.shields.io/github/license/micros/asobancaria.svg)](https://github.com/micros/asobancaria/blob/master/LICENSE)

Esta librería permite procesar archivos de formato ASOBANCARIA, proporcionando un sistema eficiente para recibir, validar y procesar archivos de texto en este formato comúnmente usado por bancos.

## Instalación

Puedes instalar esta librería fácilmente usando Composer:

```bash
composer require micros/asobancaria
```

## Uso

Aquí tienes un ejemplo de cómo usar la clase `AsobancariaProcessor` para procesar un archivo de texto ASOBANCARIA:

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use App\Asobancaria\AsobancariaProcessor;

try {
    // Inicializa el procesador
    $processor = new AsobancariaProcessor();

    // Procesa el archivo ASOBANCARIA
    $textFile = $processor->processFile('ruta/a/tu/archivo.txt');

    // Muestra el resumen del archivo procesado
    $processor->mostrarResumen($textFile);
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
```

### Ejemplo de Salida

```bash
Nombre del archivo: ejemplos/11JULIO.txt
Hash del archivo: a71d95147fcb9bf53713ea9a2bac5f4050ee774eaa3bb26e34a54d14da8a1b20
Fecha de procesamiento: 2024-09-05 04:06:35
NIT Empresa: 1234567890
Fecha del Recaudo: 20230905
Código Entidad Financiera: 001
Número de Cuenta: 12345678901234567
--- Lote 1 ---
Número de Lote: 0001
Código de Servicio: 1234567890123
   - Detalle 1 -
Referencia Principal: 98765432123456789012345678901234567890123456789012
Valor Recaudado: $1,234.56
Procedencia de Pago: 01
Medios de Pago: 02
Total Registros en Lote: 10
Valor Total Recaudado en Lote: $12,345.67
--- Control del Archivo ---
Total de Registros en el Archivo: 100
Valor Total Recaudado en el Archivo: $123,456.78
```

## Funcionalidades

1. **Recepción del archivo**: Recibe un archivo de texto ASOBANCARIA.
2. **Validación**: Verifica que el archivo tenga un formato válido según las reglas establecidas.
3. **Procesamiento**: Extrae la información de encabezados, lotes y detalles de cada archivo.
4. **Resumen del archivo**: Genera un resumen detallado del archivo procesado.

## Requisitos

- PHP >= 7.4
- Composer
