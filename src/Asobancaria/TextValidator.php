<?php

declare(strict_types=1);

namespace App\Asobancaria;

class TextValidator
{
    private array $stateTransitions = [
        '01' => ['05'],
        '05' => ['06'],
        '06' => ['06', '08'],
        '08' => ['05', '09'],
        '09' => [] // El estado '09' es terminal, no tiene transiciones permitidas
    ];

    public function validate(TextFile $textFile): void
    {
        // Obtener el contenido del archivo
        $text = $textFile->getContent();
        $lines = explode(PHP_EOL, $text);

        // Validar que el texto no esté vacío
        if (empty($text)) {
            throw new \InvalidArgumentException("El archivo está vacío.");
        }

        // Estado inicial: no hay estado definido
        $currentState = null;

        foreach ($lines as $lineNumber => $line) {
            $trimmedLine = trim($line);

            // Ignorar líneas en blanco
            if (empty($trimmedLine)) {
                continue;
            }

            $prefix = substr($trimmedLine, 0, 2);

            if ($lineNumber === 0) {
                // Verificar que la primera línea sea '01'
                if ($prefix !== '01') {
                    throw new \InvalidArgumentException("La primera línea debe empezar con '01', encontrado '$prefix' en la línea " . ($lineNumber + 1) . ".");
                }
                // Establecer el estado inicial en '01'
                $currentState = '01';
                continue;
            }

            // Verificar que la transición desde el estado actual sea válida
            if (!isset($this->stateTransitions[$currentState])) {
                throw new \InvalidArgumentException("Estado inválido '$currentState' en la línea " . ($lineNumber + 1) . ".");
            }

            if (!in_array($prefix, $this->stateTransitions[$currentState])) {
                throw new \InvalidArgumentException(
                    "Transición inválida desde '$currentState' a '$prefix' en la línea " . ($lineNumber + 1) . "."
                );
            }

            // Actualizar el estado actual
            $currentState = $prefix;
        }

        // Verificar que el estado final sea '09' (o el estado terminal definido)
        if ($currentState !== '09') {
            throw new \InvalidArgumentException("El archivo debe terminar con una línea '09', encontrado '$currentState' en la última línea.");
        }
    }
}
