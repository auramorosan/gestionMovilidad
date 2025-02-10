<?php
// Archivo: gestionTaxis.php

// Verificar que la solicitud es POST y que se enviaron los datos esperados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matricula = $_POST['matricula'] ?? null;
    $nombre = $_POST['nombre'] ?? null;

    // Validar los datos recibidos
    $errores = [];

    // Validar matrícula
    if (!preg_match('/^[0-9]{4}-[A-Z]{3}$/', $matricula)) {
        $errores[] = "La matrícula no es válida. Debe tener el formato 0000-AAA.";
    }

    // Validar nombre
    if (empty($nombre) || !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $nombre)) {
        $errores[] = "El nombre no es válido. Debe contener solo letras y espacios.";
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
        str_replace(' ', '_', $nombre) // Reemplazar espacios por guiones bajos en el nombre
    );

    // Guardar en el archivo taxis.txt
    $rutaArchivo = 'taxis.txt';

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
