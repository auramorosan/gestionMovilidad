<?php
// Archivo: gestionVehiculosEMT.php

// Verificar que la solicitud es POST y que se enviaron los datos esperados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matricula = $_POST['matricula'] ?? null;
    $linea = $_POST['linea'] ?? null;

    // Limpieza de los datos
    $matricula = trim($matricula);
    $linea = trim($linea);

    // Validar los datos recibidos
    $errores = [];

    // Validar matrícula
    if (!preg_match('/^[0-9]{4}-[A-Z]{3}$/', $matricula)) {
        $errores[] = "La matrícula no es válida. Debe tener el formato 0000-AAA.";
    }

    // Validar la dirección (linea), debe contener un número y una calle
    // Suponemos que la dirección tiene el formato "Número, Calle"
    if (!preg_match('/^(\d+),\s*([a-zA-Z0-9_ ]+)$/', $linea, $matches)) {
        $errores[] = "La dirección no es válida. Debe estar en el formato 'Número, Calle'.";
    }

    // Si hay errores, mostrar mensaje y detener ejecución
    if (!empty($errores)) {
        echo "Se encontraron errores en el formulario:<br>";
        foreach ($errores as $error) {
            echo "- $error<br>";
        }
        exit;
    }

    // Extraer el número y la calle de la dirección
    $numeroCalle = $matches[1];
    $calle = $matches[2];

    // Formato para guardar la información
    $lineaFormato = sprintf(
        "%s %s,%s\n",
        $matricula,
        $numeroCalle,
        str_replace(' ', '_', $calle) // Reemplazar los espacios por guiones bajos en la calle
    );

    // Guardar en el archivo vehiculosEMT.txt
    $rutaArchivo = 'vehiculosEMT.txt';

    // Abrir el archivo en modo "apéndice" (a), que añade datos al final del archivo
    $archivo = fopen($rutaArchivo, 'a');
    if ($archivo) {
        // Escribir la línea en el archivo
        if (fwrite($archivo, $lineaFormato)) {
            echo "Los datos se han guardado correctamente.";
        } else {
            echo "Hubo un error al escribir los datos.";
        }
        // Cerrar el archivo
        fclose($archivo);
    } else {
        echo "Hubo un error al abrir el archivo.";
    }
}
?>
