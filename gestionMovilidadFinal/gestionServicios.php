<?php
// Archivo: gestionServicios.php

// Verificar que la solicitud es POST y que se enviaron los datos esperados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matricula = $_POST['matricula'] ?? null;
    $tipoVehiculo = $_POST['tipoVehiculo'] ?? null;

    // Limpieza de los datos
    $matricula = trim($matricula);
    $tipoVehiculo = trim($tipoVehiculo);

    // Validar los datos recibidos
    $errores = [];

    // Validar matrícula
    if (!preg_match('/^[0-9]{4}-[A-Z]{3}$/', $matricula)) {
        $errores[] = "La matrícula no es válida. Debe tener el formato 0000-AAA.";
    }

    // Validar tipo de vehículo: una sola palabra con letras y números (sin espacios ni caracteres especiales)
    if (empty($tipoVehiculo) || !preg_match('/^[a-zA-Z0-9]+$/', $tipoVehiculo)) {
        $errores[] = "El tipo de vehículo no es válido. Debe ser una sola palabra, sin espacios ni caracteres especiales, y puede contener letras y números.";
    }

    // Si hay errores, mostrar mensaje y detener ejecución
    if (!empty($errores)) {
        echo "Se encontraron errores en el formulario:<br>";
        foreach ($errores as $error) {
            echo "- $error<br>";
        }
        exit;
    }

    // Formato para guardar la información
    $linea = sprintf(
        "%s %s\n",
        $matricula,
        $tipoVehiculo // Guardamos el tipo de vehículo tal cual, sin modificaciones.
    );

    // Guardar en el archivo servicios.txt
    $rutaArchivo = 'servicios.txt';

    // Abrir el archivo en modo "apéndice" (a), que añade datos al final del archivo
    $archivo = fopen($rutaArchivo, 'a');
    if ($archivo) {
        // Escribir la línea en el archivo
        if (fwrite($archivo, $linea)) {
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
