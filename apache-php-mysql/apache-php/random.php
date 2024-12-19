<?php
$randomNumber = rand(1,100); // Número aleatorio

$isEven = ($randomNumber % 2 === 0) ? "par" : "impar";

$elements = ["silla", "teclado", "monitor", "altavoces", "ratón"]

// Crear respuesta para enviar como JSON
$response = [
    "numero_aleaorio" = $randomNumber,
    "par_impar" = $isEven,
    "elemento_aleatorio" = $elements
];

// Encabezado para respuesta como JSON
header('Content-Type: application/json')

echo json_encode($response)
?>
